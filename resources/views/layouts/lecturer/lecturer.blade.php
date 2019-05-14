<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title> Aston | Exams </title>
        <link rel="shortcut icon" href="/assets/demo/demo3/media/img/logo/favicon.png" />
        {{-- JS Libraries --}}
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script src="/js/lodash.js"></script>
        <script>
        WebFont.load({
            google: {
                "families": ["Montserrat:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
        </script>
        <script src="/js/vue.min.js"></script>
        <script src="/js/axios.min.js"></script>
        {{-- CSS Libraries --}}
        <link href="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />
        <link href="/assets/demo/demo3/base/style.bundle.css" rel="stylesheet" type="text/css" />
        {{-- Custom JS & CSS --}}
        <link rel="stylesheet" href="/css/style.css" type="text/css"/>
    </head>
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('layouts/lecturer/components/header')
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true" m-menu-dropdown="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow">
                            <li class="m-menu__item  m-menu__item{{ Request::is('dashboard') || Request::is('new_lecturer') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/dashboard" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                                    <span class="m-menu__link-text"> Dashboard </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('modules') || Request::is('modules/*') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/modules" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-interface"></i>
                                    <span class="m-menu__link-text"> Modules </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('new_question') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/new_question" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-plus"></i>
                                    <span class="m-menu__link-text"> New Question </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('new_exam') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/new_exam" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-plus"></i>
                                    <span class="m-menu__link-text"> New Exam </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="m-grid__item m-grid__item--fluid m-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>
        <script src="/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
        <script src="/assets/demo/demo3/base/scripts.bundle.js" type="text/javascript"></script>
        <script src="/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
        <script src="/assets/app/js/dashboard.js" type="text/javascript"></script>
    </body>
</html>
