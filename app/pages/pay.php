<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<section class="profile">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <article class="profile__order">
                    <div class="row">
                        <div class="col-md-12">
                        <?php if(isset($_GET['success'])) { ?>
                            <h2>Ваш заказ оплачен</h2>
                            <br>
                            <? 
                                if(authuser()) {
                                    ?>
                                        <p>Вы можете следить за выполнением своего заказа в <a href="/profile" data-pjax="content">личном кабинете</a> в разделе «<a href="/profile/orders" data-pjax="content">Мои заказы</a>».</p>
                                    <?
                                } else {
                                    ?>
                                        <p>Вы можете следить за выполнением своего заказа в <a href="/profile" data-pjax="content">личном кабинете</a> в разделе «<a href="/profile/orders" data-pjax="content">Мои заказы</a>». Обратите внимание, что для входа в этот раздел вам необходимо будет пройти регистрацию. </p>
                                    <?
                                }
                            ?>
                        <?php } else { ?>
                            <h2>Ошибка</h2>
                            <br>
                            <p>Ваш заказ не был оплачен</p>
                        <?php } ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>