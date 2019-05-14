@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="all-lecturers">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Lecturers
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="/admin/lecturers/new" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span> New Lecturer </span>
                                </span>
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
                                    <th> Modules </th>
                                    <th> Added Date </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(lecturer, index) in lecturers" class="pointer" style="width:100%">
                                    <td style="width:10%"> @{{ index + 1 }} </td>
                                    <td style="width:10%"> @{{ lecturer.name }}<br><small> @{{ lecturer.email }} </small> </td>
                                    <td class="pointer"  style="width:22%">
                                        <span v-for="(module, index) in lecturer.modules" >
                                            @{{ module.course.shortName + '-' + module.id }} (@{{ module.name }})<br>
                                        </span>
                                    </td>
                                    <td style="width:10%"> @{{ lecturer.created_at }} </td>
                                    <td style="width:10%">
                                        <button @click="deleteLecturer(lecturer.id, index);" class="btn btn-sm btn-danger">
                                            <i class="la la-trash"></i>
                                        </button>
                                        <button @click="window.location='/admin/lecturers/' + lecturer.id" class="btn btn-sm btn-accent">
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
        el: '#all-lecturers',
        data: () => ({
            lecturers: {!! $lecturers !!}
        }),
        mounted () {
        },
        methods: {
            deleteLecturer (lecturerId, index) {
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
                        axios.post('/admin/deleteLecturer', {
                            id: lecturerId
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.lecturers.splice(index, 1)
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
