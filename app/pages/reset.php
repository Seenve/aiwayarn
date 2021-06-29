<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?
    if (authuser()) {
        ?>
            <script language="JavaScript"> 
                window.location.href = "/profile";
            </script>
        <?
    } else {
?>

<div class="cont maincont">
    <h1 class="maincont-ttl">Восстановление доступа</h1>
    <ul class="b-crumbs">
        <li><a href="/" data-pjax="content">Главная</a></li>
        <li>Восстановление доступа</li>
    </ul>                                     
    <article class="page-cont">
        <div class="page-styling">
        

            <div class="auth-wrap">
                <div class="auth-col">
                    <h6>Укажите телефон, который Вы использовали для входа на сайт.</h6>
                    <form method="post" class="ajax-reg">
                        <input type="hidden" name="reset">
                        <p>
                            <label for="username">Телефон <span class="required">*</span></label>
                            <input type="phone" name="phone" onfocus="this.removeAttribute('readonly')" readonly>
                        </p>
                        <p>
                            <label for="password">Новый пароль <span class="required">*</span></label>
                            <input type="password" name="password" onfocus="this.removeAttribute('readonly')" readonly>
                        </p>
                        <p class="auth-submit" id="reg_button">
                            <input type="submit" value="Отправить">
                        </p>
                        <div id="verify_phone">
                            <h6>На ваш телефон отправлено смс с кодом</h6>
                            <label>Введите проверочный код <span class="required">*</span></label>
                            <input type="text" name="code" onfocus="this.removeAttribute('readonly')" readonly>
                            <input type="submit" value="Восстановить">
                        </div>
                    </form>
                    <p>Если у вас возникли проблемы с восстановлением, обратитесь в службу поддержки.</p>
                </div>
                <div class="auth-col">

                </div>
            </div>

        </div>
    </article>
    <br>
</div>

<? 
	}
?>
