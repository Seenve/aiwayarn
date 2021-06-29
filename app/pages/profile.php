<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<?
    $currentPage = isset($_GET[$page]) ? $_GET[$page] : '';
    $currentPage = val_string($currentPage);
    if (authuser()) {
        $userId = user($uuid)['id'];
        $userPhone = user($uuid)['phone'];
        $user_arr = user($uuid);
?>
<section class="profile">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <h1><b id="day">Привет</b><?php if(user($uuid)['firstname']) {echo ', '.user($uuid)['firstname'];} ?></h1>
            </div>
        </div>
    </div>

    <section class="tabs-menu">
        <div class="container">
            <div class="row">
                <div class="col-xxl-12">
                    <ul>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>">Мой кабинет</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/orders">Мои заказы</a></li>
                        <li><a data-pjax="content" href="/<?php echo $page; ?>/info">Личные данные</a></li>
                        <li class="last logout-btn"><a href="#" id="logout">Выйти <i class="fa fa-sign-out"></i></a></li>
                    </ul>      
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row">
            <div class="col-xxl-12">

<?
       if($currentPage == 'info') {
?>
          
    <article class="profile__contacts">

        <div class="row">
            <div class="col-md-12">
                <h5>Контакты</h5>
                <form class="ajax-notice checkout woocommerce-checkout">

                    <div class="row" id="customer_details">
                        <div class="col-xxl-12">
                            <div class="woocommerce-billing-fields">

                                <div class="woocommerce-billing-fields__field-wrapper">
                                    <p class="form-row form-row-first validate-required" data-priority="10">
                                        <label for="billing_first_name" class="">Имя <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="firstname" id="billing_first_name" placeholder="" value="<? echo $user_arr['firstname']; ?>" autocomplete="given-name" autofocus="autofocus" />
                                    </p>
                                    <p class="form-row form-row-last validate-required" id="billing_last_name_field" data-priority="20">
                                        <label for="billing_last_name" class="">Фамилия <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="lastname" id="billing_last_name" placeholder="" value="<? echo $user_arr['lastname']; ?>" autocomplete="family-name" />
                                    </p>
                                    <p class="form-row form-row-first validate-required validate-phone" data-priority="100">
                                        <label for="billing_phone" class="">Телефон</label>
                                        <input type="phone" class="input-text " name="phone" id="billing_phone" value="<? echo $user_arr['phone']; ?>" autocomplete="off" placeholder="+7 (9__) ___-__-__" disabled/>
                                    </p>
                                    <p class="form-row form-row-last validate-required validate-email" data-priority="110">
                                        <label for="billing_email" class="">Эл.почта <abbr class="required" title="required">*</abbr></label>
                                        <input type="email" class="input-text " name="email" id="billing_email" placeholder="example@gmail.com" value="<? echo $user_arr['email']; ?>" autocomplete="email username" />
                                    </p>
                                    <br> <br>
                                    <h5>Адрес доставки</h5>
                                    <p class="form-row form-row-wide address-field validate-required" data-priority="50">
                                        <label for="billing_address_1" class="">Улица, дом/корм, кв <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="address" id="billing_address_1" placeholder="Адрес улицы для доставки" value="<? echo $user_arr['address']; ?>" autocomplete="address-line1" />
                                    </p>
                                    <p class="form-row form-row-wide address-field validate-required" id="billing_city_field" data-priority="70">
                                        <label for="billing_city" class="">Город <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="city" id="billing_city" placeholder="" value="<? echo $user_arr['city']; ?>" autocomplete="address-level2" />
                                    </p>
                                    <p class="form-row form-row-wide address-field validate-required validate-postcode" data-priority="90">
                                        <label for="billing_post" class="">Индекс
                                            <abbr class="required" title="required">*</abbr></label>
                                        <input type="text" class="input-text " name="post" id="billing_post" placeholder="" value="<? echo $user_arr['post']; ?>" autocomplete="postal-code" />
                                    </p>
                                </div>

                                <div id="payment" class="woocommerce-checkout-payment">
                                    <div class="form-row place-order">
                                        <input type="hidden" name="userupdate">
                                        <div class="buttons">
                                            <button type="submit" class="btn btn-purple btn-size_full">Изменить</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </form>


            </div>
        </div>
    </article>

<?
        } else if($currentPage == 'orders') {
?>

                   
    <article class="page-cont">

        <div class="row">
            <div class="col-md-12  animated">
                <?php
                    $arr = array();
                    $pagenum = isset($_GET[$currentPage]) ? $_GET[$currentPage] : '';
                    $pagenum = val_string($pagenum);
                    $url_page = '/'.$page.'/'.$currentPage.'/';
                    //$url_page = '/?page=news&num=';
                    $pagenum = preg_replace("/[^0-9]/", '', $pagenum);
                    $num = 10;  
                    $posts = count(orders($userPhone));  
                    $total = intval(($posts - 1) / $num) + 1;  
                    $pagenum = intval($pagenum);  
                    if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
                    if($pagenum > $total) $pagenum = $total;  
                    $start = $pagenum * $num - $num;  
                    $arr = orders($userPhone, $start, $num);
                    #$arr = array_reverse($arr, true);

                    if($posts > 0){  
                        echo '
                                <div class="profile_orders">
                                    <div class="head">
                                        <div>Дата</div>
                                        <div>Номер</div>
                                        <div>Способ оплаты</div>
                                        <div>Сумма</div>
                                        <div>Статус</div>
                                    </div>
                        ';
                        for($in = 0; $in < $num; $in++)  
                        {  
                            //$idstr = $arr[$in]['id'];
                            $idstr = isset($arr[$in]['id']) ? $arr[$in]['id'] : 0;
                            if($idstr > 0) {
                                $time = strtotime($arr[$in]['reg_date']);
                ?>
                                    <div class="link" href="/<?php echo $page; ?>/order/<?php echo $arr[$in]['id']; ?>">
                                        <div><div class="mob">Дата</div><?php echo date('d.m.Y в H:i', $time); ?></div>
                                        <div><div class="mob">Номер</div><?php echo $arr[$in]['id']; ?></div>
                                        <div><div class="mob">Способ оплаты</div><?php echo type_pay($arr[$in]['type_pay']); ?></div>
                                        <div><div class="mob">Сумма</div><?php echo $arr[$in]['total_summ']; ?> <i class="fa fa-rub"></i></div>
                                        <div><div class="mob">Статус</div><?php echo order_status($arr[$in]['status']); ?></div>
                                    </div>
                <?php
                            }
                        }
                    echo '</div>';
                    } else {
                        echo 'У вас нет заказов';
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <?php include 'modules/pagination.php'; ?>
            </div>
        </div>
    </article>


<?
        } else if($currentPage == 'order') {
?>

<?
    $orderId = $_GET[$_GET[$page]];
    $orderId = preg_replace("/[^0-9]/", '', $orderId);
?>
                      

                <article class="profile__order">
                    <div class="row">
                        <div class="col-md-12">
                            <?
                                $order_arr = order($orderId, $userPhone);
                                if(is_array($order_arr)) {
                            ?>
                                <h2>Заказ #<? echo $orderId; ?></h2>
                                <p class="status">Статус заказа: <?php echo order_status($order_arr['status']); ?></p>
                                <div class="row">
                                    <div class="col-xxl-3 animated col-xl-4 col-lg-6">
                                        <h5>Контакты</h5>
                                        <ul class="list-catalog">
                                           <li>
                                                <p>Имя</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['firstname']; ?></p>
                                            </li>
                                            <li>
                                                <p>Фамилия</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['lastname']; ?></p>
                                            </li>
                                            <li>
                                                <p>Эл. почта</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['email']; ?></p>
                                            </li>
                                            <li>
                                                <p>Телефон</p>
                                                <div class="dotted"></div>
                                                <p><?php echo phone($order_arr['phone']); ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xxl-4 offset-xxl-1 animated col-xl-4 col-lg-6">
                                        <h5>Адрес доставки</h5>
                                        <ul class="list-catalog">
                                           <li>
                                                <p>Населенный пункт</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['city']; ?></p>
                                            </li>
                                            <li>
                                                <p>Индекс</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['post']; ?></p>
                                            </li>
                                            <li>
                                                <p>Адрес</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['address']; ?></p>
                                            </li>
                                            <li>
                                                <p>Трек номер</p>
                                                <div class="dotted"></div>
                                                <?php  
                                                    if($order_arr['delivery']) {
                                                        if($order_arr['track']) {
                                                            if($order_arr['delivery']) {
                                                                ?>
                                                                    <p><a href="https://www.pochta.ru/tracking#<? echo $order_arr['track']; ?>" target="_blank"><? echo $order_arr['track']; ?></a></p>
                                                                <?
                                                            } else if($order_arr['delivery'] == 2) {
                                                                ?>
                                                                    <p><a href="https://www.cdek.ru/ru/tracking?order_id=<? echo $order_arr['track']; ?>" target="_blank"><? echo $order_arr['track']; ?></a></p>
                                                                <?
                                                            }
                                                        } else {
                                                            ?>
                                                                <p>Ожидайте</p>
                                                            <?
                                                        }
                                                    } else {
                                                        ?>
                                                            <p>Недоступен</p>
                                                        <?
                                                    }
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xxl-3 offset-xxl-1 animated col-xl-4 col-lg-6">
                                        <h5>О заказе</h5>
                                        <ul class="list-catalog">
                                           <li>
                                                <p>Стоимость доставки</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['delivery_price']; ?> руб.</p>
                                            </li>
                                            <li>
                                                <p>Сумма</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['summ']; ?> руб.</p>
                                            </li>
                                            <li>
                                                <p>Итоговая сумма</p>
                                                <div class="dotted"></div>
                                                <p><?php echo $order_arr['total_summ']; ?> руб.</p>
                                            </li>
                                            <li>
                                                <p>Способ оплаты</p>
                                                <div class="dotted"></div>
                                                <p><?php echo type_pay($order_arr['type_pay']); ?></p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Товары</h5>
                                        <div class="row">


                                            <?
                                                $products_arr = json_decode($order_arr['products'], true);
                                                $summ = 0;
                                                $weight = 0;
                                                foreach ($products_arr as $key => $row) {
                                                    $product = $products_arr[$key];

                                                    $productArr = products_id(intval($row['product_id']));
                                                    $modArr = products_mod($GLOBALS['city'], intval($row['mod_id']));

                                                    /*if(count($modArr) > 0) {
                                                        $summ += $modArr['price']*$row['nums'];
                                                    } else {
                                                        $summ += $productArr['price']*$row['nums'];
                                                    }*/

                                                    $summ += floatval($productArr['price'])*$row['nums'];
                                                    $weight += $productArr['weight']*$row['nums'];

                                                    $summ_product = floatval($productArr['price'])*$row['nums'];

                                                ?>
                                                    <div class="col-xxl-12">
                                                        <article class="cart" data-id="<? echo $row['id']; ?>">
                                                            <div class="cart__product">
                                                                <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="cart__img" data-pjax="content">
                                                                    <?php 
                                                                        if(count($modArr) > 0) {
                                                                            echo gallery('products_mod', $modArr['id'], 0, 1, 'small', $productArr['title'], false, true);
                                                                        } else {
                                                                            echo gallery('products', $productArr['id'], 0, 1, 'small', $productArr['title'], false, true);
                                                                        }
                                                                    ?>
                                                                </a>
                                                                <div class="cart__content">
                                                                    <div class="cart__info">
                                                                        <div class="cart__title col-xxl-5 col-xl-5 col-lg-12">
                                                                            <p><? echo productsCategory($productArr['category'])['title']; ?></p>
                                                                            <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" data-pjax="content"><h5><?php echo $productArr['title']; ?></h5></a>
                                                                        </div>
                                                                        <div class="cart__columns row">
                                                                            <div class="cart__col col-xxl-6 col-xl-5 col-lg-4">
                                                                                <label>Цена</label>
                                                                                <h6 class="price__price"><? echo number_format($productArr['price'], 0, '.', ' '); ?> ₽</h6>
                                                                            </div>
                                                                            <div class="cart__col col-xxl-3 col-xl-4 col-lg-4">
                                                                                <label>Количество</label>
                                                                                <p><? echo $row['nums']; ?></p>
                                                                            </div>
                                                                            <div class="cart__col col-xxl-3 col-xl-3 col-lg-4">
                                                                                <label>Итого</label>
                                                                                <div class="card__price price">
                                                                                    <h6 class="price__price products-total"><? echo number_format($summ_product, 0, '.', ' '); ?> ₽</h6>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="cart__chars cart-chars" data-id="<? echo $productArr['id']; ?>">
                                                                <div class="row">
                                                                    <?php
                                                                        foreach(characters_products_id($productArr['id']) as $key_tag => $value_tag) {
                                                                            ?>
                                                                                <div class="col-xxl-3 col-xl-4 col-lg-6">
                                                                                    <div class="cart__char">
                                                                                        <p><? echo $value_tag['name']; ?></p>
                                                                                        <div class="dotted"></div>
                                                                                        <p><? echo $value_tag['value']; ?></p>
                                                                                    </div>
                                                                                </div>

                                                                            <?
                                                                        }
                                                                    ?>
                                                                </div>   
                                                            </div>
                                                        </article>
                                                    </div>
                                                <?
                                                    }
                                                ?>
                                         </div>
                                    </div>
                                </div>
                                <p>Вес: <?php echo $weight; ?> гр.</p>
                            <?
                                } else {
                                    echo "Указанный вами заказ не существует.";
                                }
                            ?>

                        </div>
                    </div>
                </article>


<?
        } else {
?>

                <article class="page-cont">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Личные данные</h5>
                            <div class="row">
                                <div class="col-lg-4 animated product-info">
                                    <ul class="list-catalog">
                                       <li>
                                            <p>Имя</p>
                                            <div class="dotted"></div>
                                            <p><?php echo user($uuid)['firstname']; ?></p>
                                        </li>
                                        <li>
                                            <p>Фамилия</p>
                                            <div class="dotted"></div>
                                            <p><?php echo user($uuid)['lastname']; ?></p>
                                        </li>
                                        <li>
                                            <p>Эл. почта</p>
                                            <div class="dotted"></div>
                                            <p><?php echo user($uuid)['email']; ?></p>
                                        </li>
                                        <li>
                                            <p>Телефон</p>
                                            <div class="dotted"></div>
                                            <p><?php echo phone(user($uuid)['phone']); ?></p>
                                        </li>
                                    </ul>
                                    <br>
                                    <a data-pjax="content" class="btn btn-purple btn-size_full" href="/<?php echo $page; ?>/info">Изменить</a>
                                </div>
                            </div>
                            <!--<div class="boardTitle">
                                <div class="bill">Изменить пароль:</div>
                            </div>
                            <form class="accountForm ajax" action="/engine/forms.php">
                                <input type="hidden" name="changepassword" value="1">
                                <div class="row">
                                    <div class="col-lg-4 animated">
                                        <div class="checkoutWrep">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span class="inputTitle">Придумайте новый пароль:</span>
                                                    <div class="pass">
                                                        <input type="password" name="password" class="pass-control" autocomplete="off">
                                                        <div class="pass-hide" data-tooltip="Показать/скрыть пароль"><i class="fa fa-eye-slash"></i></div>
                                                        <div class="pass-gen js-active" data-tooltip="Сгенерировать пароль"><i class="fa fa-key"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="result"></div>
                                        <div class="result_success"></div>
                                        <div class="result_error"></div>
                                        <div class="submitBtn">
                                            <button type="submit" class="btn">Изменить</button>
                                        </div>
                                    </div>
                                </div>
                            </form>-->
                        </div>
                    </div>
                </article>


<?
        }
        ?>

            </div>
        </div>
    </div>
</section>


        <?
    } else {
?>

<section class="profile">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <h1><? echo $title_page; ?></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-6">
                <h5>Авторизация</h5>
                <form method="post" class="form ajax-default">
                    <input type="hidden" name="auth">
                    <div class="form__row">
                        <label for="username">Телефон или E-mail <span class="required">*</span></label>
                        <input type="text" name="username" onfocus="this.removeAttribute('readonly')" readonly>
                    </div>
                    <div class="form__row">
                        <label for="password">Пароль <span class="required">*</span></label>
                        <input type="password" name="password" onfocus="this.removeAttribute('readonly')" readonly>
                    </div>
                    <div class="form__row auth-submit">
                        <div>
                            <button class="btn btn-purple btn-size_full">Войти</button>
                            <!--<a href="/reset" data-pjax="content">Забыли пароль?</a>-->
                        </div>
                        <!--<input type="checkbox" id="rememberme" value="forever">
                        <label for="rememberme">Запомнить меня</label>-->
                    </div>
                    <!--<p class="auth-lost_password">
                        <a href="/reset" data-pjax="content">Забыли пароль?</a>
                    </p>-->
                </form>
            </div>
            <div class="col-xxl-6">
                <h5>Регистрация</h5>
                <form method="post" class="form register ajax-reg" data-action="/api/index.php">
                    <input type="hidden" name="reg">
                    <div class="form__row">
                        <label for="reg_email">Телефон <span class="required">*</span></label>
                        <input type="phone" name="phone" placeholder="+7 (9__) ___-__-__" onfocus="this.removeAttribute('readonly')" readonly>
                    </divdiv>
                    <div class="form__row">
                        <label for="reg_password">Пароль <span class="required">*</span></label>
                        <input type="text" name="password" onfocus="this.removeAttribute('readonly')" readonly>
                    </div>
                    <div class="form__row auth-submit" id="reg_button">
                        <div>
                            <button class="btn btn-purple btn-size_full">Регистрация</button>
                        </div>
                    </div>
                    <div id="verify_phone">
                        <h5>На ваш телефон отправлено смс с кодом</h5>
                        <label>Введите проверочный код <span class="required">*</span></label>
                        <input type="text" name="code" onfocus="this.removeAttribute('readonly')" readonly>
                        <div>
                            <button class="btn btn-blue btn-size_full">Подтвердить</button>
                            <!--<a href="/reset" data-pjax="content">Забыли пароль?</a>-->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?  
    }
?>