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
    <link type="text/css" href="assets/css/app.css" rel="stylesheet">

    <link rel="shortcut icon" href="/ap/assets/images/favicon.ico" type="image/x-icon">

</head>
<body class="login">

    <div class="preloader">
        <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce1"></div>
            <div class="sk-child sk-double-bounce2"></div>
        </div>
    </div>

    <div class="d-flex align-items-center" style="min-height: 100vh">
        <div class="col-sm-8 col-md-6 col-lg-4 mx-auto" style="min-width: 300px;">
            <div class="card navbar-shadow">
                <div class="card-header text-center">
                    <h4 class="card-title">Авторизация</h4>
                    <p class="card-subtitle">Доступ к админ панели</p>
                </div>
                <div class="card-body">

                    <form action="/ap/ajax-auth.php" class="ajax" novalidate method="POST">
                        <input type="hidden" name="auth" value="1">
                        <div class="form-group">
                            <label class="form-label" for="email">Ваша E-mail:</label>
                            <div class="input-group input-group-merge">
                                <input id="email" type="text" name="username" required="" class="form-control form-control-prepended" placeholder="Введите E-mail">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password">Ваш пароль:</label>
                            <div class="input-group input-group-merge">
                                <input id="password" type="password" name="password" required="" class="form-control form-control-prepended" placeholder="Введите пароль">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <span class="far fa-key"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <button type="submit" class="btn btn-primary btn-block">Войти</button>
                        </div>
                        <div class="result alert alert-dismissible bg-light border-0 fade show" role="alert"></div>
                        <div class="result_error alert bg-danger text-white border-0" role="alert"></div>
                        <div class="result_success alert bg-success text-white border-0" role="alert"></div>
                        <div class="text-center">
                            <a href="https://vucs.ru/contacts" target="_blank" class="text-black-70" style="text-decoration: underline;">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center text-black-50">
                    Разработка сайтов – <a href="https://seenve.ru" target="_blank">Seenve</a>
                    <!--Нет аккаунта? <a href="https://vucs.ru/contacts" target="_blank">Зарегистрировать</a>-->
                </div>
            </div>
        </div>
    </div>

    <div id="result"></div>


    <script src="assets/vendor/jquery.min.js"></script>
    <script src="assets/js/jquery.pjax.js"></script>
    <script src="assets/js/nprogress.js"></script>
    <script src="assets/js/ajaxupload.3.5.js"></script>
    <script src="assets/js/jquery.maskedinput.min.js"></script>
    <script src="assets/ckeditor/ckeditor.js"></script>
    <script src="assets/vendor/popper.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>
    <script src="assets/vendor/perfect-scrollbar.min.js"></script>
    <script src="assets/vendor/dom-factory.js"></script>
    <script src="assets/vendor/material-design-kit.js"></script>

    <!-- App JS -->
    <script src="assets/js/app.js"></script>

    <!--<script src="assets/vendor/quill.min.js"></script>-->
    <!--<script src="assets/js/quill.js"></script>-->
    <!-- Highlight.js -->
    <!--<script src="assets/js/hljs.js"></script>-->

    <!-- App Settings (safe to remove) -->
    <!--<script src="assets/js/app-settings.js"></script>-->

    <!-- Global Settings -->
    <!--<script src="assets/js/settings.js"></script>-->

    <!-- Moment.js -->
    <!--<script src="assets/vendor/moment.min.js"></script>
    <script src="assets/vendor/moment-range.min.js"></script>-->

    <!-- Chart.js -->
    <!--<script src="assets/vendor/Chart.min.js"></script>
    <script src="assets/js/chartjs-rounded-bar.js"></script>
    <script src="assets/js/chartjs.js"></script>-->

    <script src="assets/js/common.js"></script>


</body>
</html>