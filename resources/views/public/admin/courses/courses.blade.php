@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="all-courses">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Courses
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="/admin/courses/new" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span><i class="la la-plus"></i><span> New Course </span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section">
                    <span class="m-section__sub">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </span>
                    <div class="m-section__content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Name </th>
                                    <th> Added Date </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(course, index) in courses" class="pointer">
                                    <td> @{{ index + 1 }} </td>
                                    <td> @{{ course.name + "(" + course.shortName + ")" }} </td>
                                    <td> @{{ course.created_at }} </td>
                                    <td >
                                        <button @click="deleteCourse(course.id, index);" class="btn btn-sm btn-danger">
                                            <i class="la la-trash"></i>
                                        </button>
                                        <button @click="window.location='/admin/courses/' + course.id" class="btn btn-sm btn-accent">
                                            <i class="la la-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#all-courses',
        data: () => ({
            courses: {!! $courses !!}
        }),
        mounted () {
        },
        methods: {
            deleteCourse (courseId, index) {
                var self = this
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        axios.post('/admin/deleteCourse', {
                            id: courseId
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.courses.splice(index, 1)
                                swal({ type: 'success', title: 'Success', text: response.data.message })
                            }
                            else {
                                swal({ type: 'error', title: 'Error', text: response.data.message })
                            }
                        });
                    }
                })
            }
        }
    })
    </script>
@stop
