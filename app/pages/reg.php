<?
    if (authuser()) {
        ?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><?php echo $title_page; ?></div>
                    <ul class="pageIndicate">
                        <li><a data-pjax="content" href="/">Главная</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page ?>"><?php echo $title_page; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="regArea">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="checkTitle"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Вы уже авторизованы. <a data-pjax="content" href="/account">Перейти в личный кабинет</a></div>
            </div>
        </div>
    </div>
</section>
<script language="text/JavaScript"> 
    if($.support.pjax) {
        $.pjax({
            url: '/account', 
            container: '#content',
            "push": true,
            "replace": false,
            "timeout": 10000,
            "scrollTo": false,
        });
    } else {
        window.location.href = "/account";
    }
</script>
        <?
    } else {
?>
<div class="pageTitleArea animated">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pageTitle">
                    <div class="h2"><?php echo $title_page; ?></div>
                    <ul class="pageIndicate">
                        <li><a data-pjax="content" href="/">Главная</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>"><?php echo $title_page; ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="cartArea secPdngB">
    <div class="container">
        <form action="/engine/regauth.php" method="POST" class="row ajax">
            <input type="hidden" name="reg" value="1">
            <div class="col-md-12 animated">
                <div class="checkTitle">Уже есть аккаунт? <a href="#" id="auth-open">Авторизуйтесь</a></div>
            </div>
            <div class="col-lg-6 animated">
                <div class="checkoutWrep">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Все поля обязательны к заполнению</p>
                        </div>
                        <div class="col-md-6">
                            <span class="inputTitle">Имя:</span>
                            <input type="text" name="firstname" placeholder="Иван">
                        </div>
                        <div class="col-md-6">
                            <span class="inputTitle">Фамилия:</span>
                            <input type="text" name="lastname" placeholder="Иванов">
                        </div>
                        <div class="col-md-6">
                            <span class="inputTitle">Эл.почта:</span>
                            <input type="email" name="email" placeholder="user@example.com">
                        </div>
                        <div class="col-md-6">
                            <span class="inputTitle">Телефон:</span>
                            <input type="phone" name="phone" placeholder="+7 (9__) ___-__-__">
                        </div>
                        <div class="col-md-12">
                            <span class="inputTitle">Придумайте пароль:</span>
                            <div class="pass">
                                <input type="password" name="password" class="pass-control" autocomplete="off">
                                <div class="pass-hide" data-tooltip="Показать/скрыть пароль"><i class="fa fa-eye-slash"></i></div>
                                <div class="pass-gen js-active" data-tooltip="Сгенерировать пароль"><i class="fa fa-key"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 animated">
                <div class="cartTotal">
                    <div class="captcha">
                        <img title="Нажмите для генерации нового кода" id="captcha_img" alt="Код" src="/engine/captcha/index.php" onclick="this.src='/engine/captcha/index.php?id=' + (+new Date());">
                        <input type="text" name="captcha" placeholder="Введите код с картинки">       
                    </div>
                    <div class="result"></div>
                    <div class="result_success"></div>
                    <div class="result_error"></div>
                    <button type="submit" class="totalBtn">Регистрация <i class="icofont icofont-long-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="sectionBar"></div>
<script>
    function rand_pass() {
        var resultrr       = '';
        var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
        var max_position = words.length - 1;
            for( i = 0; i < 10; ++i ) {
                position = Math.floor ( Math.random() * max_position );
                resultrr = resultrr + words.substring(position, position + 1);
            }
        return resultrr;
    }
</script>
<? } ?>