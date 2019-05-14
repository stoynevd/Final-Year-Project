@extends('layouts/admin/admin')

@section('content')
    <div class="m-content" id="new_admin">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            New Admin
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button @click="createAdmin()" class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
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
                    <div class="m-section__content">
                        <div class="row">
                            <div class="col-6">
                                <h4> Admin Name </h4>
                                <input v-model="adminDetails.name" type="text" class="form-control m-input m-input--solid"/>
                                <br><br>
                                <h4> E-mail </h4>
                                <input v-model="adminDetails.email" type="text" class="form-control m-input m-input--solid"/>
                                <br><br>
                                <h4> Password </h4>
                                <input v-model="adminDetails.password" type="text" class="form-control m-input m-input--solid"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    new Vue ({
        el: '#new_admin',
        data: () => ({
            adminDetails: {
                name: '',
                email: '',
                password: ''
            }
        }),
        mounted () {
        },
        methods: {
            createAdmin () {
                var self = this
                axios.post('/admin/createAdmin', self.adminDetails)
                .then(function (response){
                    if(response.data.success) {
                        window.location = '/admin/admins'
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
