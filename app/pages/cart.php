<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<?php 
    $arr_sale = array();
    $arr_sale = $_SESSION['promocode'];
?>

<section class="cart-items">
    <div class="container">
        <div class="row">
            <div class="col-xxl-12">
                <h1><? echo $title_page; ?></h1>
            </div>
        </div>
        <div class="row">
        <?php
            $query_products_top = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 60"); 
            if(mysqli_num_rows($query_products_top) > 0) {
                $summ = 0;
                $summ_product = 0;
                while($row = mysqli_fetch_assoc($query_products_top)) {



                    $productArr = products_id($row['product_id']);
                    $modArr = products_mod($GLOBALS['city'], $row['mod_id']);

                    /*if(count($modArr) > 0) {
                        $summ += $modArr['price']*$row['nums'];
                    } else {
                        $summ += $productArr['price']*$row['nums'];
                    }*/

                    if(stock($productArr, $modArr)['result']) {
                        $summ += floatval($productArr['price'])*$row['nums'];

                        $summ_product = floatval($productArr['price'])*$row['nums'];
                    } else {
                        $summ_product = 0;
                    }

                ?>
                    <div class="col-xxl-12">
                        <article class="cart <? if(stock($productArr, $modArr)['result']) {} else {echo 'disabled';} ?>" data-id="<? echo $row['id']; ?>">
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
                                                <?php include 'modules/product_price.php'; ?>
                                            </div>
                                            <div class="cart__col col-xxl-3 col-xl-4 col-lg-4">
                                                <label>Количество в <? echo $arrTypeProduct[$productArr['type']]; ?></label>
                                                <?
                                                    if(stock($productArr, $modArr)['result']) {
                                                        ?>
                                                            <div class="input-nums">
                                                                <div class="input-nums__control">
                                                                    <div class="input-nums__arrow-right" data-id="<? echo $row['id']; ?>"><i class="fal fa-angle-left"></i></div>
                                                                    <input type="number" name="nums" value="<? echo $row['nums']; ?>" data-id="<? echo $row['id']; ?>">
                                                                    <div class="input-nums__arrow-left" data-id="<? echo $row['id']; ?>"><i class="fal fa-angle-right"></i></div>
                                                                </div>
                                                            </div>
                                                        <?
                                                    } else {
                                                        ?>
                                                            <p>Нет в наличии</p>
                                                        <?
                                                    }
                                                ?>
                                            </div>
                                            <div class="cart__col col-xxl-3 col-xl-3 col-lg-4">
                                                <label>Итого</label>
                                                <div class="card__price price">
                                                    <h6 class="price__price products-total"><? echo price($summ_product); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart__control">
                                        <div class="cart__articule">Артикул: <span><? echo $productArr['id']; ?><? if($modArr['id']) {echo '-'.$modArr['id'];} ?></span></div>
                                        <div class="cart__buttons">
                                            <button class="cart__btn-char btn-char" data-id="<? echo $productArr['id']; ?>"></button>
                                            <button class="add-favorite <? if(like($productArr['id'], $user_uid)) {echo ' active';} ?>" data-id="<?php echo $productArr['id']; ?>"></button>
                                            <button class="del_cart btn-del" data-id="<? echo $row['id']; ?>"></button>
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
                        <div class="col-xxl-12">
                            <?php
                                if($arr_sale['result']) {
                                    ?>
                                        <div class="promo">
                                            <h5>Активирован промокод <span><? echo $arr_sale['code']; ?></span></h5>
                                            <p>Скидка по данному промокоду составляет <b><span><? echo $arr_sale['sale']; ?>%</span></b></p>
                                        </div>
                                    <?
                                }
                            ?>
                        </div>
                        <div class="col-xxl-12">
                            <div class="cart-items__actions">
                                <form class="cart-items__coupon promo-form <? if($arr_sale['result']) {echo 'active';} ?>">
                                    <input type="text" name="getPromoCode" placeholder="Промокод">
                                    <button type="submit" class="btn btn-purple btn-size_full">Применить</button>
                                </form>
                                <div class="cart-items__collaterals">
                                    <a href="/checkout" data-pjax="content" class="btn btn-blue btn-size_full">Оформить заказ</a>
                                    <div class="cart-items__total">
                                        <label>Итого</label>
                                        <? 
                                            if($arr_sale['result']) {
                                                ?>
                                                    <div class="card__price price">
                                                        <p class="price__old-price"><span class="price__line total-summ"><? echo $summ; ?>₽</span>
                                                            <svg width="35" height="18" class="price__seil" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.975 0h28.88v18H5.974L0 9l5.975-9z" fill="#F54D46"></path>
                                                                <foreignObject x="4" y="0" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                                    <span class="price__seil-text promo-sale" xmlns="http://www.w3.org/1999/xhtml">-<? echo $arr_sale['sale']; ?>%</span>
                                                                </foreignObject>
                                                            </svg>
                                                        </p>
                                                        <h6 class="price__price total-summ-sale"><?php echo number_format(discount_payment($summ, $arr_sale['sale']), 0, '.', ' '); ?> &#8381;</h6>
                                                    </div>
                                                <?
                                            } else {
                                                ?>
                                                    <div class="card__price price">
                                                        <h6 class="price__price total-summ"><? echo price($summ); ?></h6>
                                                    </div>
                                                <?
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?
                } else {
                    ?>
                        <div class="col-lg-12">
                            <div class="card-row">
                                <article class="card-row__title">Пусто</article>
                            </div>
                        </div>
                    <?
                }
            ?>
        </div>
    </div>
</section>