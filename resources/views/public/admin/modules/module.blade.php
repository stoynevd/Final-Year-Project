@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="update_module">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Update Module
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button @click="updateModule()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span><i class="la la-pencil"></i><span> Update </span></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <a href="/admin/modules" class="btn btn-primary"> <i class="fa fa-arrow-left"></i> Go Back </a><br><br>
                <div class="m-section">
                    <span class="m-section__sub">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </span>
                    <br>
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <h4> Course: </h4>
                                    <select v-model="module.course_id" class="form-control m-input m-input--solid">
                                        <option v-for="course in courses" :value="course.id"> @{{ course.name }} </option>
                                    </select>
                                </div>
                                <br>
                                <h4> Name </h4>
                                <input v-model="module.name" type="text" class="form-control m-input m-input--solid"/>
                                <br>
                                <h4> Year </h4>
                                <select v-model="module.year" class="form-control m-input m-input--solid">
                                    <option v-for="year in 4" :value="year"> @{{ year }} </option>
                                </select>
                                <br>
                                <h4> Lecturer ID </h4>
                                <select v-model="module.lecturer_id" class="form-control m-input m-input--solid">
                                    <option v-for="lecturer in lecturers" :value="lecturer.id"> @{{ lecturer.name }} </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#update_module',
        data: () => ({
            courses: {!! $courses !!},
            lecturers: {!! $lecturers !!},
            module: {!! $module !!}
        }),
        mounted () {
        },
        methods: {
            updateModule () {
                var self = this
                axios.post('/admin/updateModule', self.module)
                .then(function (response){
                    if(response.data.success) {
                        swal({ type: 'success', title: 'Success', text: response.data.message })
                    }
                    else {
                        swal({ type: 'error', title: 'Error', text: response.data.message })
                    }
                });
            }
        }
    })
    </script>
@stop
