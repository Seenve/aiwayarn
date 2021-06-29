<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<?
    $user_arr = array();
    if(authuser()) {
        $user_uid = authuser();
        $user_arr = user($user_uid);
    } else {
        $user_uid = guest();
    }
    $arr_sale = array();
    $arr_sale = $_SESSION['promocode'];

    $orderId = isset($_GET[$page]) ? $_GET[$page] : '';
    $orderId = preg_replace("/[^0-9]/", '', $orderId);
?>

<section class="profile">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <article class="profile__order">
                    <div class="row">
                        <div class="col-md-12">
            <?
                $order_arr = order_check($orderId);
                if(is_array($order_arr)) {
                    ?>
                        <h2>Заказ №<? echo $orderId; ?></h2>
                        <br>
                    <?
                    $order_status = $order_arr['status'];
                    if($order_arr['type_pay'] == 1) {
                        $order_id = $order_arr['id'];
                        $order_summ = $order_arr['total_summ'];
                        $order_delivery = $order_arr['delivery'];
                        $payment_id = $order_arr['payment_id'];

                        if($payment_id) {
                            mysqli_query($GLOBALS['db'], "UPDATE `pays` SET `order_id`='$order_id' WHERE `id`='$payment_id'");

                            //mysqli_query($GLOBALS['db'], "UPDATE `order` SET `status`='2' WHERE `id`='$pay_order'");
                        } else {
                            //mysqli_query($GLOBALS['db'], "UPDATE `order` SET `payment_id`='$pay_id' WHERE `id`='$order_id'");
                        }
                        
                        ?>

                        <?
                            if($order_status == 2) {
                                if($order_delivery) {
                                    ?>
                                        <p>Ваш заказ <b>№<? echo $orderId; ?></b> от <? $date = strtotime($order_arr['reg_date']); echo date("d.m.y H:i", $date); ?> оплачен и готовиться к отправке.<br>
                                    <?
                                } else {
                                    ?>
                                        <p>Ваш заказ <b>№<? echo $orderId; ?></b> от <? $date = strtotime($order_arr['reg_date']); echo date("d.m.y H:i", $date); ?> оплачен.<br>
                                    <?
                                }
                            } else {

                                // регистрационная информация (логин, пароль #1)
                                // registration info (login, password #1)
                                // z3sz4Sz6Q0qb6hZwydjx
                                $mrh_login = "Aiwayarn";
                                $mrh_pass1 = "o9IADT9lluOi3x27qSex";
                                
                                // номер заказа
                                // number of order
                                $inv_id = pay($payment_id)['id'];

                                // описание заказа
                                // order description
                                $inv_desc = "Оплата заказа";

                                // сумма заказа
                                // sum of order
                                $out_summ = pay($payment_id)['summ'];

                                // тип товара
                                // code of goods
                                $shp_item = pay($payment_id)['order_id'];

                                // предлагаемая валюта платежа
                                // default payment e-currency
                                $in_curr = "";

                                $IsTest = "1";

                                // язык
                                // language
                                $culture = "ru";

                                // формирование подписи
                                // generate signature
                                $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");

                                // форма оплаты товара
                                // payment form


                        ?>  
                            <p>Ваш заказ <b>№<? echo $orderId; ?></b> от <? $date = strtotime($order_arr['reg_date']); echo date("d.m.y H:i", $date); ?> успешно создан.<br>
                            <p>Сумма к оплате: <b><? echo $order_arr['total_summ']; ?> руб.</b></p>
                            <div class="buttons" style="width: 180px;">
                                <br>
                                <?

                                    print "<form class='max' action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
                                    "<input type=hidden name=MrchLogin value=$mrh_login>".
                                    "<input type=hidden name=OutSum value=$out_summ>".
                                    "<input type=hidden name=InvId value=$inv_id>".
                                    "<input type=hidden name=Desc value='$inv_desc'>".
                                    "<input type=hidden name=SignatureValue value=$crc>".
                                    "<input type=hidden name=Shp_item value='$shp_item'>".
                                    "<input type=hidden name=IncCurrLabel value=$in_curr>".
                                    //"<input type=hidden name=IsTest value=$IsTest>".
                                    "<input type=hidden name=Culture value=$culture>";
                                    echo '<button type="submit" class="btn btn-blue btn-size_default">Оплатить</button></form>';

                                ?>
                            </div>
                            <br><br>
                            Если заказ не будет оплачен, он будет отменен в течении дня.
                        <?
                            }
                    } else {
                        ?>
                            <p>Ваш заказ <b>№<? echo $orderId; ?></b> от <? $date = strtotime($order_arr['reg_date']); echo date("d.m.y H:i", $date); ?> успешно создан.</p>
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
                        <?
                    }
                } else {
                    ?>
                        <h2>Заказ</h2>
                        <p class="status">Ошибка! Данный заказ не существует</p>
                    <?
                }
            ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>