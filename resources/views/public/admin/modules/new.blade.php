@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="new_module">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            New Module
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button @click="createModule()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
                                <span><i class="la la-plus"></i><span> Create </span></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
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
                                    <select v-model="moduleDetails.course_id" class="form-control m-input m-input--solid">
                                        <option value=""> Please, select a course </option>
                                        <option v-for="course in courses" :value="course.id"> @{{ course.name }} </option>
                                    </select>
                                </div>
                                <br>
                                <h4> Name </h4>
                                <input v-model="moduleDetails.name" type="text" class="form-control m-input m-input--solid"/>
                                <br>
                                <h4> Year </h4>
                                <select v-model="moduleDetails.year" class="form-control m-input m-input--solid">
                                    <option value=""> Please, select a year. </option>
                                    <option v-for="year in 4" :value="year"> @{{ year }} </option>
                                </select>
                                <br>
                                <h4> Lecturer ID </h4>
                                <select v-model="moduleDetails.lecturer_id" class="form-control m-input m-input--solid">
                                    <option value=""> Please, select a lecturer. </option>
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
        el: '#new_module',
        data: () => ({
            courses: {!! $courses !!},
            lecturers: {!! $lecturers !!},
            moduleDetails: {
                course_id: '',
                year: '',
                name: '',
                lecturer_id: ''
            }
        }),
        mounted () {
        },
        methods: {
            createModule () {
                var self = this
                axios.post('/admin/createModule', self.moduleDetails)
                .then(function (response){
                    if(response.data.success) {
                        window.location = '/admin/modules'
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
