@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="all-modules">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Modules
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="/admin/modules/new" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span><i class="la la-plus"></i><span> New Module </span></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section">
                    <span class="m-section__sub">
                        Text
                    </span>
                    <div class="m-section__content">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th> ID </th>
                                    <th> Code </th>
                                    <th> Name </th>
                                    <th> Course </th>
                                    <th> Year </th>
                                    <th> Lecturer </th>
                                    <th> Added Date </th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="(module, index) in modules" class="pointer" style="width:100%">
                                        <td> @{{ index + 1 }} </td>
                                        <td> @{{ module.course.shortName }}-@{{ module.id }} </td>
                                        <td> @{{ module.name }} </td>
                                        <td> @{{ module.course.name }} </td>
                                        <td> @{{ module.year }} </td>
                                        <td> @{{ module.lecturer.name }} </td>
                                        <td> @{{ module.created_at }} </td>
                                        <td>
                                            <button @click="deleteModule(module.id, index);" class="btn btn-sm btn-danger">
                                                <i class="la la-trash"></i>
                                            </button>
                                            <button @click="window.location='/admin/modules/' + module.id" class="btn btn-sm btn-accent">
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
        el: '#all-modules',
        data: () => ({
            modules: {!! $modules !!}
        }),
        mounted () {
        },
        methods: {
            deleteModule (courseId, index) {
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
                        axios.post('/admin/deleteModule', {
                            id: courseId
                        })
                        .then(function (response){
                            if(response.data.success) {
                                self.modules.splice(index, 1)
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
