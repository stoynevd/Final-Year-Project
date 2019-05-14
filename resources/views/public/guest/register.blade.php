<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> ExamIT </title>
    <link rel="shortcut icon" href="/assets/demo/demo3/media/img/logo/favicon.png" />
    <link rel="shortcut icon" href="/assets/demo/demo3/media/img/logo/favicon.ico" />
    {{-- JS Libraries --}}
    <script src="/js/vue.min.js"></script>
    <script src="/js/axios.min.js"></script>
    <script src="/js/lodash.js"></script>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/moment.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    {{-- CSS Libraries --}}
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css">
    <link href="/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css">
    {{-- Custom JS & CSS --}}
    <link rel="stylesheet" href="/css/style.css" type="text/css"/>
</head>
<body>
    <div class="m-grid m-grid--hor m-grid--root m-page" id="register">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(/assets/app/media/img//bg/bg-1.jpg);">
            <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
                <div class="m-login__container">
                    <div class="m-login__logo">
                        <a href="/">
                            <img src="/assets/app/media/img/logos/gradHat.png" @click="window.location='/'" style="width:120px; height: 70px">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title"> Register </h3>
                        </div>
                        <form class="m-login__form m-form" @submit.prevent="register()">
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off" v-model="userDetails.email">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" name="password" v-model="userDetails.password">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="password" v-model="userDetails.password_confirmation">
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="Full Name" name="name" autocomplete="off" v-model="userDetails.name">
                            </div>
                            <br>
                            {!! NoCaptcha::display() !!}
                            <br>
                            <a href="/login" style="font-size:20px; color: white"> Already have an account? Login</a>
                            <div class="m-login__form-action">
                                <button class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary"> Register </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
    <script src="/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
</body>
</html>
{!! NoCaptcha::renderJs() !!}
<script>
new Vue ({
    el: '#register',
    data: () => ({
        userDetails: {
            email: '',
            password: '',
            password_confirmation: '',
            name: '',
            grecaptcha: ''
        }
    }),
    mounted () {
    },
    methods: {
        register () {
            var self = this
            self.userDetails.grecaptcha = grecaptcha.getResponse()
            if(self.userDetails.grecaptcha.length == 0) {
                swal({ type: 'error', title: 'Error', text: 'Please, verify that you are not a robot.' });
                return;
            }
            axios.post('/user/register', self.userDetails)
            .then(function (response){
                if(response.data.success) {
                    window.location = '/dashboard'
                }
                else {
                    grecaptcha.reset()
                    swal({ type: 'error', title: 'Error', text: response.data.message });
                }
            });
        }
    }
})
</script>
