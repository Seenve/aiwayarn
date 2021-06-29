<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<?
    $user_arr = array();
    $user_arr = user($user_uid);

    $arr_sale = array();
    $arr_sale = $_SESSION['promocode'];

    $arrForm = $_GET;
    $cashDisabled = false;

    if($arrForm['delivery'] == 1 || $arrForm['delivery'] == 2 || $arrForm['delivery'] == 3 || $arrForm['delivery'] == 4) {
        $cashDisabled = true;
        $cashKey = 0;
        $arrForm['pay'] = 1;
    }

    if(!$arrForm['post']) {
        if($user_arr['post']) {
            $arrForm['post'] = $user_arr['post'];
        }
    }

    if(!$arrForm['delivery']) {
        $arrForm['delivery'] = 0;
    }
    if(!$arrForm['pay']) {
        $arrForm['pay'] = 0;
    }

    if(!$arrForm['firstname']) {
        $arrForm['firstname'] = $user_arr['firstname'];
    }
    if(!$arrForm['lastname']) {
        $arrForm['lastname'] = $user_arr['lastname'];
    }
    if(!$arrForm['phone']) {
        $arrForm['phone'] = $user_arr['phone'];
    }
    if(!$arrForm['email']) {
        $arrForm['email'] = $user_arr['email'];
    }
    if(!$arrForm['post_value']) {
        $arrForm['post_value'] = $user_arr['post'];
    }
    if(!$arrForm['city']) {
        $arrForm['city'] = $user_arr['city'];
    }
    if(!$arrForm['city_value']) {
        $arrForm['city_value'] = $user_arr['city'];
    }
    if(!$arrForm['address']) {
        $arrForm['address'] = $user_arr['address'];
    }
    if(!$arrForm['address_value']) {
        $arrForm['address_value'] = $user_arr['address'];
    }

    if($arrForm['post']) {
        $arrForm['post_value'] = $arrForm['post'];
    } else {
        if($arrForm['post_value']) {
            $arrForm['post'] = $arrForm['post_value'];
        } else {
            $arrForm['post'] = $user_arr['post'];
            $arrForm['post_value'] = $user_arr['post'];
        }
    }

    $index = $arrForm['post'];

    //echo '<pre>';
    //echo json_encode($arrForm, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    //echo '</pre>';


    //echo phoneDecode($_GET['phone']);
    //echo '<br>';
    //echo phone(phoneDecode($_GET['phone']), true);


?>
<section class="checkout">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <h1><? echo $title_page; ?></h1>
            </div>
        </div>
        <div class="row">
            <?
                $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 60"); 
                if(mysqli_num_rows($query) > 0) {
                    $positionsArr = array();
                    $summ = 0;
                    $weight = 0;
                    $deliverySumm = 0;
                    $i = 0;
                    while($row_products_top = mysqli_fetch_assoc($query)) {
                        $idstr = $row_products_top['product_id'];
                        $postrow = array();
                        $postrow[0] = products_id($idstr);
                        $modArr = products_mod($GLOBALS['city'], $row_products_top['mod_id']);
                        $in = 0;   
                        if(stock($postrow[$in], $modArr)['result']) {
                            $summ += $postrow[$in]['price']*$row_products_top['nums'];
                            if($postrow[0]['type']) {
                                $weight += $row_products_top['nums'];
                            } else {
                                $weight += $postrow[$in]['weight']*$row_products_top['nums'];
                            }
                            $summ_product = $postrow[$in]['price']*$row_products_top['nums'];

                            $positionsArr[$i]['title'] = $postrow[$in]['title'];
                            $positionsArr[$i]['nums'] = $row_products_top['nums'];
                            $positionsArr[$i]['summ'] = $summ_product;

                            $i++;
                        } else {
                            $summ_product = 0;
                        }
                    }

                    $weight = floatval($weight);
                    $weight + 100;

                    if($arrForm['delivery'] == 1) {
                        $deliveryArr = russianPost('630082', $index, $weight, 26, 17, 8);
                    } else if($arrForm['delivery'] == 2){
                        $deliveryArr = sdek('630082', $index, round(($weight*0.1)/100, 3), 26, 17, 8, 136);
                    } else if($arrForm['delivery'] == 3){
                        $deliveryArr = sdek('630082', $index, round(($weight*0.1)/100, 3), 26, 17, 8, 137);
                    } else if($arrForm['delivery'] == 4){
                        $deliveryArr = delivery('630082', $post);
                    }
 
 
                    /*$client = new GuzzleHttp\Client();
                    $cdek = new \CdekSDK2\Client($client);
                    //$cdek->setTest(true);
                    $cdek->setAccount('fUftXf5shJ7qntH8l4bo1ZPvk85FNbSW');
                    $cdek->setSecure('x51LV4zlrUp33DGt3cdDhQ4m56L47qzF');

                    try {
                        $cdek->authorize();
                        $cdek->getToken();
                        $cdek->getExpire();
                    } catch (AuthException $exception) {
                        //Авторизация не выполнена, не верные account и secure
                        echo $exception->getMessage();
                    }*/


            ?>
            <div class="col-xxl-12">
                <form method="GET" id="checkout" data-scroll="false" data-pjax="content" action="/">
                    <input type="hidden" name="page" value="checkout">
                    <div class="row">
                        <div class="col-xxl-12">
                            <? 
                                if(!$arr_sale['result']) {
                                    ?>
                                        <div class="promo">
                                            <p>Есть промокод? <a href="/cart" data-pjax="content">Применить</a></p>
                                        </div>
                                    <?
                                }
                            ?>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="checkout__title">
                                <i class="fal fa-address-card"></i>
                                <h5>Контактная информация</h5>
                            </div>
                            <div class="checkout__contacts">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                        <div class="checkout__inputs row">
                                            <div class="checkout__inputs-row col-xxl-6 col-xl-6">
                                                <label for="billing_first_name" class="">Имя <abbr class="required" title="required">*</abbr></label>
                                                <input type="text" name="firstname" id="billing_first_name" placeholder="" value="<? echo $arrForm['firstname']; ?>" autofocus="autofocus" />
                                            </div>
                                            <div class="checkout__inputs-row col-xxl-6 col-xl-6" id="billing_last_name_field">
                                                <label for="billing_last_name" class="">Фамилия <abbr class="required" title="required">*</abbr></label>
                                                <input type="text" name="lastname" id="billing_last_name" placeholder="" value="<? echo $arrForm['lastname']; ?>" />
                                            </div>
                                            <div class="checkout__inputs-row col-xxl-6 col-xl-6 ">
                                                <label for="billing_phone" class="">Телефон <abbr class="required" title="required">*</abbr></label>
                                                <input type="phone" name="phone" id="billing_phone" value="<? echo $arrForm['phone']; ?>" autocomplete="off" placeholder="+7 (9__) ___-__-__"/>
                                            </div>
                                            <div class="checkout__inputs-row col-xxl-6 col-xl-6">
                                                <label for="billing_email" class="">Эл.почта <abbr class="required" title="required">*</abbr></label>
                                                <input type="email" name="email" id="billing_email" placeholder="example@gmail.com" value="<? echo $arrForm['email']; ?>" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                        <div class="checkout__inputs row">
                                            <div class="checkout__inputs-row col-xxl-4 col-xl-4">
                                                <label for="billing_post" class="">Индекс<abbr class="required" title="required">*</abbr></label>
                                                <input type="text" name="post" id="billing_post" placeholder="" value="<? echo $arrForm['post']; ?>" />
                                                <input type="hidden" name="post_value" value="<? echo $arrForm['post_value']; ?>" id="post" />
                                                <div class="checkout__city-result" id="result_index">
                                                    <ul>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="checkout__inputs-row col-xxl-8 col-xl-8" id="billing_city_field">
                                                <label for="billing_city" class="">Населенный пункт/город <abbr class="required" title="required">*</abbr></label>
                                                <input type="text" class="input-text " name="city" id="billing_city" placeholder="" value="<? echo $arrForm['city']; ?>" />
                                                <input type="hidden" name="city_value" value="<? echo $arrForm['city_value']; ?>" id="city" />
                                                <div class="checkout__city-result" id="result_city">
                                                    <ul>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="checkout__inputs-row col-xxl-12 col-xl-12">
                                                <label for="billing_address_1" class="">Улица, дом/корп, кв <abbr class="required" title="required">*</abbr></label>
                                                <input type="text" name="address" id="billing_address_1" placeholder="Адрес улицы для доставки" value="<? echo $arrForm['address']; ?>" />
                                                <input type="hidden" name="address_value" value="<? echo $arrForm['address_value']; ?>" id="address" />
                                                <div class="checkout__city-result" id="result_address">
                                                    <ul>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__title">
                                <i class="fal fa-shipping-fast"></i>
                                <h5>Способ получения</h5>
                            </div>
                            <div class="checkout__delivery">
                                <input type="hidden" name="delivery" value="<? echo $arrForm['delivery']; ?>">
                                <div class="select-button">
                                    <?
                                        //if($arrForm['post']) {
                                            foreach ($arrDelivery as $key => $value) {
                                                ?>
                                                    <div class="select-button__select <? if(intval($arrForm['delivery']) == $key) { echo 'active'; } ?>" data-value="<? echo $key; ?>">
                                                        <div class="select-button__icon"></div>
                                                        <div class="select-button__content">
                                                            <? echo $value; ?>
                                                        </div>
                                                    </div>
                                                <?
                                            }
                                        /*} else {
                                            foreach ($arrDelivery as $key => $value) {
                                                ?>
                                                    <div class="select-button__select disabled" data-value="<? echo $key; ?>">
                                                        <div class="select-button__icon"></div>
                                                        <div class="select-button__content">
                                                            <? echo $value; ?>
                                                        </div>
                                                    </div>
                                                <?
                                            }
                                        }*/
                                    ?>
                                </div>
                                <div class="checkout__delivery-content" data-id="0">
                                    <?php 
                                        if($arrForm['delivery']) {
                                            if($deliveryArr['result'] && intval($deliveryArr['price']) > 0) {
                                                if($arrForm['delivery'] == 1) {
                                                    ?>
                                                        <p>Стоимость доставки <? echo $deliveryArr['price']+intval(settings()['0']['delivery']); ?> руб.</p>
                                                    <?
                                                } else if($arrForm['delivery'] == 2) {
                                                    ?>
                                                        <p>Стоимость доставки <? echo $deliveryArr['price']+intval(settings()['0']['delivery']); ?> руб.</p>
                                                        <p>Забирать посылку со склада СДЭК</p>
                                                        <p>Срок доставки от <? echo $deliveryArr['period_min']; ?> до <? echo day_number_name($deliveryArr['period_max'], array('дней')); ?></p>
                                                    <?
                                                } else if($arrForm['delivery'] == 3) {
                                                    ?>
                                                        <p>Стоимость доставки <? echo $deliveryArr['price']+intval(settings()['0']['delivery']); ?> руб.</p>
                                                        <p>Курьер привезет посылку на дом. Будьте на связи.</p>
                                                        <p>Срок доставки от <? echo $deliveryArr['period_min']; ?> до <? echo day_number_name($deliveryArr['period_max'], array('дней')); ?></p>
                                                    <?
                                                } else if($arrForm['delivery'] == 4) {
                                                    ?>
                                                        <p>Стоимость доставки <? echo $deliveryArr['price']+intval(settings()['0']['delivery']); ?> руб.</p>
                                                        <p>Доставка осуществляется в пределах города Новосибирск.</p>
                                                        <p>По вопросам доставки с вами свяжится наш специалист.</p>
                                                    <?
                                                }
                                            } else {
                                                ?>
                                                    <p>Расчет стоимости посылки не удался, пожалуйста проверьте индекс и обновите страницу.</p>
                                                <?
                                            }
                                        } else {
                                            ?>
                                                <p>Забирать по адресу: г. Новосибирск, ул. Дуси Ковальчук, 238, отд. 18 <br>с 11:00 по 19:00</p>
                                            <?
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="checkout__title">
                                <i class="fal fa-cash-register"></i>
                                <h5>Способ оплаты</h5>
                            </div>
                            <div class="checkout__pay">
                                <input type="hidden" name="pay" value="<? echo $arrForm['pay']; ?>">
                                <div class="select-button">
                                    <?
                                        foreach ($arrPay as $key => $value) {
                                            ?>
                                                <div class="select-button__select <? if($cashDisabled && $cashKey == $key) { echo 'disabled'; } ?> <? if(intval($arrForm['pay']) == $key) { echo 'active'; } ?>" data-value="<? echo $key; ?>">
                                                    <div class="select-button__icon"></div>
                                                    <div class="select-button__content">
                                                        <? echo $value; ?>
                                                    </div>
                                                </div>
                                            <?
                                        }
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="checkout__inputs row">
                                        <div class="checkout__inputs-row col-md-12">
                                            <label for="billing_comment" class="">Комментарий к заказу</label>
                                            <textarea style="max-width: 100%;" rows="4" type="text" name="comment" id="billing_comment" placeholder="" value="<? echo $arrForm['comment']; ?>" /></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__title">
                                <i class="fal fa-shopping-basket"></i>
                                <h5>Детали заказа</h5>
                            </div>
                            <table class="checkout-table">
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Итого</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?

                                    foreach ($positionsArr as $key => $value) {
                                        ?>
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    <?php echo $value['title']; ?> <strong class="product-quantity">&times; <? echo $value['nums']; ?></strong>
                                                </td>
                                                <td class="product-total">
                                                    <span class="checkout-table__amount"><span class="checkout-table__currencySymbol"></span><? echo price($value['summ']); ?></span>
                                                </td>
                                            </tr>
                                        <?
                                    }

                                ?>

                                </tbody>
                                <tfoot>

                                <tr class="checkout-table__subtotal">
                                    <th>Итоговая сумма</th>
                                    <td><span class="checkout-table__amount"><span class="checkout-table__currencySymbol"></span><? echo price($summ); ?></span></td>
                                </tr>

                                <? 
                                    if($arrForm['delivery']) {
                                ?>
                                    <tr class="checkout-table__shipping">
                                        <th>Доставка</th>
                                        <td data-title="Shipping">

                                            <? 
                                                if($deliveryArr['result']) {
                                                    $deliverySumm = $deliveryArr['price']+intval(settings()['0']['delivery']);
                                                    echo $deliverySumm." &#8381;";
                                                } else {
                                                    echo "Невозможна";
                                                }

                                            ?>
                                        </td>
                                    </tr>

                                    <tr class="checkout-table__total">
                                        <th>Итоговая сумма с доставкой</th>
                                        <td><span class="checkout-table__amount"><span class="checkout-table__currencySymbol"></span><?php echo number_format($summ+$deliverySumm, 0, '.', ' '); ?> &#8381;</span></td>
                                    </tr>
                                <?
                                    }
                                ?>
                                <tr class="checkout-table__total">
                                    <th>Итоговая сумма к оплате с учетом скидки</th>
                                    <td><strong><span class="checkout-table__amount"><span class="checkout-table__currencySymbol"></span><? echo price(discount_payment($summ, $arr_sale['sale'])+$deliverySumm); ?></span></strong></td>
                                </tr>


                                </tfoot>
                            </table>
                        </div>
                    </div>  
                    <div class="row">
                        <div class="col-xxl-12">
                            <div class="checkout-table__payment">
                                <div class="form-row place-order">
                                    <input type="hidden" name="order" value="1">
                                    <button class="btn btn-blue btn-size_full" id="order_btn">Подтвердить</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                </form>
            </div>
            <?php 
                } else {
                    ?>
                        <div class="col-lg-12">
                            <div class="card-row">
                                <article class="card-row__title">У вас нет товаров в корзине.</article>
                            </div>
                        </div>
                    <?
                }
            ?>
        </div>
</section>