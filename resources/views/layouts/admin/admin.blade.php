<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title> Aston | Exams </title>
        <link rel="shortcut icon" href="/assets/demo/demo3/media/img/logo/favicon.png" />
        {{-- JS Libraries --}}
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
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
            @include('layouts/admin/components/header')
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
                    <i class="la la-close"></i>
                </button>
                <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
                    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark m-aside-menu--dropdown " data-menu-vertical="true" m-menu-dropdown="1" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
                        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow">
                            <li class="m-menu__item  m-menu__item{{ Request::is('admin') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/admin" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                                    <span class="m-menu__link-text"> Dashboard </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('admin/lecturers') || Request::is('admin/lecturers/*') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/admin/lecturers" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-users"></i>
                                    <span class="m-menu__link-text"> Lecturers </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('admin/admins') || Request::is('admin/admins/*') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/admin/admins" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-user-settings"></i>
                                    <span class="m-menu__link-text"> Admins </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('admin/courses') || Request::is('admin/courses/*') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/admin/courses" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-layer"></i>
                                    <span class="m-menu__link-text"> Courses </span>
                                </a>
                            </li>
                            <li class="m-menu__item  m-menu__item{{ Request::is('admin/modules') || Request::is('admin/modules/*') ? '--active' : ''}}" aria-haspopup="true">
                                <a href="/admin/modules" class="m-menu__link ">
                                    <span class="m-menu__item-here"></span>
                                    <i class="m-menu__link-icon flaticon-interface"></i>
                                    <span class="m-menu__link-text"> Modules </span>
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
