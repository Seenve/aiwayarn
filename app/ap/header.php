<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Админ панель</title>

    <meta name="robots" content="noindex">

    <link type="text/css" href="assets/vendor/perfect-scrollbar.css" rel="stylesheet">
    <link type="text/css" href="assets/css/material-icons.css" rel="stylesheet">
    <link type="text/css" href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="assets/css/animate.css" rel="stylesheet">
    <link type="text/css" href="assets/css/quill.css" rel="stylesheet">
    <link type="text/css" href="assets/css/sweetalert.css" rel="stylesheet">
    <link type="text/css" href="assets/css/nestable.css" rel="stylesheet">
    <link type="text/css" href="assets/css/app.css" rel="stylesheet">

    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">

</head>
<body class=" layout-fluid">

    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>

    <div class="mdk-header-layout js-mdk-header-layout">
        <div id="header" data-fixed class="mdk-header js-mdk-header mb-0">
            <div class="mdk-header__content">

                <nav id="default-navbar" class="navbar navbar-expand navbar-dark bg-primary m-0">
                    <div class="container-fluid">

                        <button class="navbar-toggler d-block" data-toggle="sidebar" type="button">
                            <span class="material-icons">menu</span>
                        </button>

                        <a href="/" class="navbar-brand">
                        </a>

                        <div class="flex"></div>

                        <ul class="nav navbar-nav flex-nowrap">

                            <li class="nav-item dropdown ml-1 ml-md-3" id="dropdown-toggle">
                                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"><img src="/ap/assets/images/no-avatar.jpg" alt="Avatar" class="rounded-circle" width="40"></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/ap/?page=profile" data-pjax="content">
                                        <i class="material-icons">person</i> Мой профиль
                                    </a>
                                    <a class="dropdown-item logout" href="#">
                                        <i class="material-icons">lock</i> Выйти
                                    </a>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="mdk-header-layout__content">
            <!--  data-responsive-width="992px" -->
            <div data-push  data-responsive-width="992px" class="mdk-drawer-layout js-mdk-drawer-layout">
                <div class="mdk-drawer-layout__content page ">

                    <div class="container-fluid page__container" id="content">