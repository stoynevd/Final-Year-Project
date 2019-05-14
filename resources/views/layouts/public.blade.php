<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title> ExamIT </title>
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
        <link href="/css/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        {{-- Custom JS & CSS --}}
        <link rel="stylesheet" href="/css/style.css" type="text/css"/>
    </head>
    <body>
        <div class="header">
            <h2 class="main-header"> examIT <img class="layoutImg" src="/images/gradhat.jpg" alt="" /> </h2>
        </div>
        <div class="container-fluid">
            @yield('content')
        </div>
    </body>
</html>
