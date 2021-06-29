<?
    $category = isset($_GET['catalog']) ? $_GET['catalog'] : '';
    $category = val_string($category);


    if(authuser()) {
        $user_uid = authuser();
    } else {
        $user_uid = guest();
    }

    $city_products = $GLOBALS['city'];

    if($category) {
        $query_pc = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `name` = '$category' AND `city_id` = '$city_products'"); 
        if(mysqli_num_rows($query_pc) > 0) {
            $row_pc = mysqli_fetch_assoc($query_pc);
            $id_category = $row_pc['id'];
            $title_category = $row_pc['title'];

            $product = isset($_GET[$category]) ? $_GET[$category] : '';
            $product = val_string($product);

            if($product) {
                $arrProduct = products_name($product, $id_category);
                if($arrProduct) {
                    ?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

        
<?
    $uid_product_m = products_name($product, $id_category)['uid_moysklad'];
    $vars = $_POST;

    $product_mod = products_mod_search($GLOBALS['city'], $uid_product_m, $vars);
    //echo json_encode($vars);
    //echo $product_mod;
    if(/*count($vars) > 0 && $product_mod*/true) {
        $product2 = products_mod($GLOBALS['city'], $uid_product_m, $product_mod);
        //var_dump($product2);
?>

<section class="product" data-product="<? echo $uid_product_m; ?>">
    <div class="container">
        <div class="product__block-text">
            <h1 class="product__title"><? echo $arrProduct['title']; ?></h1>
            <p class="product__articule">артикул <? echo $arrProduct['id']; ?></p>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="product__cart slider-cart">
                    <div class="swiper-container-wrapper">
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">

                                <?php /*echo gallery('product', $arrProduct['id'], 0, 12, 'middle', $arrProduct['title'], false);*/ ?>

                                <?php
                                    $num_image = 0;
                                    foreach (gallery_arr('products', $arrProduct['id'], '1') as $key => $value) {
                                        ?>
                                            <div class="swiper-slide">
                                                <img src="/uploads/small/<? echo $value['image']; ?>" alt="<? echo $arrProduct['title']; ?>">
                                            </div>
                                        <?
                                        $num_image++;
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <?php
                                    $num_image = 0;
                                    foreach (gallery_arr('products', $arrProduct['id'], '1') as $key => $value) {
                                        ?>
                                            <div class="swiper-slide">
                                                <img src="/uploads/middle/<? echo $value['image']; ?>" alt="<? echo $arrProduct['title']; ?>">
                                            </div>
                                        <?
                                        $num_image++;
                                    }
                                ?>
                            </div>
                            <!-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="product-info">
                    <h6 class="product-info__title">Характеристики</h6>
                    <ul class="product-info__list list-catalog">
                        <?php
                            foreach(characters_products_id($arrProduct['id']) as $key_tag => $value_tag) {
                                ?>
                                    <li>
                                        <p><? echo $value_tag['name']; ?></p>
                                        <div class="dotted"></div>
                                        <p><? echo $value_tag['value']; ?></p>
                                    </li>
                                <?
                            }
                        ?>
                        <span class="product-info__small"><?php echo htmlspecialchars_decode($arrProduct['description']); ?></span>
                    </ul>
                    <a href="#" class="product-info__link link link--hevered">Смотреть все характеристики</a>
                </div>
                
            </div>
            <div class="col-lg-3">

                <div class="block-price">
                    <div class="card__price block-price__total">
                        <?php 
                            if($arrProduct['old_price'] > $arrProduct['price']) {
                                $sale = 100 - ($arrProduct['price']*100/$arrProduct['old_price']);
                                ?>
                                    <p class="price__old-price block-price__old"><? echo number_format($arrProduct['old_price'], 0, '.', ' '); ?> ₽
                                        <svg width="35" height="18" class="price__seil" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.975 0h28.88v18H5.974L0 9l5.975-9z" fill="#F54D46"></path>
                                            <foreignObject x="4" y="0" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                <span class="price__seil-text" xmlns="http://www.w3.org/1999/xhtml">-<?php echo round($sale); ?>%</span>
                                            </foreignObject>
                                        </svg>
                                    </p>
                                <?php
                            } 
                        ?>
                        <h6 class="price__price block-price__price"><? echo number_format($arrProduct['price'], 0, '.', ' '); ?> ₽</h6>
                    </div>

                    <div class="block-price__contact">
                        <a href="tel:+7(383)274-32-32" class="link link--black">
                            <svg class="" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)" fill="#2F3540"><path d="M14.225 11.15c-.368-.383-.813-.588-1.284-.588-.467 0-.915.2-1.3.585l-1.2 1.196c-.098-.053-.197-.102-.292-.152-.137-.068-.266-.133-.376-.201-1.125-.714-2.147-1.645-3.127-2.85-.475-.6-.794-1.105-1.026-1.618.312-.285.6-.581.882-.866l.319-.323c.798-.798.798-1.83 0-2.629L5.784 2.667c-.118-.118-.24-.24-.353-.36a17.933 17.933 0 00-.715-.707c-.368-.365-.809-.559-1.272-.559-.464 0-.912.194-1.292.559l-.008.007L.853 2.91a2.78 2.78 0 00-.825 1.767c-.09 1.11.236 2.142.487 2.819.615 1.66 1.534 3.198 2.906 4.847a17.877 17.877 0 005.953 4.662c.874.414 2.04.904 3.343.987.08.004.163.008.24.008.877 0 1.614-.315 2.191-.942.004-.008.012-.012.016-.02.197-.239.425-.455.665-.687.163-.155.33-.319.493-.49.376-.391.574-.847.574-1.314 0-.471-.201-.924-.585-1.303l-2.086-2.094zm1.36 4c-.004 0-.004.005 0 0-.148.16-.3.305-.463.464-.247.236-.498.483-.733.76-.384.41-.836.604-1.429.604-.057 0-.118 0-.175-.004-1.128-.072-2.176-.513-2.963-.889a16.875 16.875 0 01-5.607-4.391C2.919 10.132 2.053 8.689 1.48 7.139c-.354-.946-.483-1.683-.426-2.379.038-.444.209-.813.524-1.128l1.296-1.295c.186-.175.383-.27.577-.27.24 0 .433.144.555.266l.011.011c.232.217.452.44.684.68.118.122.24.243.361.369L6.099 4.43c.403.403.403.775 0 1.178-.11.11-.216.22-.327.326-.319.327-.623.63-.953.927-.008.008-.015.012-.02.02-.326.326-.265.645-.197.862l.012.034c.27.653.65 1.269 1.227 2.002l.004.004c1.048 1.291 2.154 2.298 3.373 3.07.156.098.315.178.467.254.137.068.266.133.377.201.015.008.03.02.045.027.13.064.25.095.376.095.316 0 .513-.198.578-.262l1.299-1.3c.13-.129.334-.285.574-.285.235 0 .429.149.547.278l.007.007 2.094 2.094c.39.387.39.786.003 1.189zM9.727 4.282c.995.167 1.9.638 2.621 1.36a4.842 4.842 0 011.36 2.621.51.51 0 00.505.426c.03 0 .058-.004.088-.008a.513.513 0 00.421-.593 5.86 5.86 0 00-1.644-3.172 5.86 5.86 0 00-3.173-1.645.516.516 0 00-.592.418.507.507 0 00.414.593zM17.98 7.94a9.64 9.64 0 00-2.71-5.223 9.64 9.64 0 00-5.223-2.71.511.511 0 10-.167 1.011c1.77.3 3.385 1.14 4.669 2.42a8.606 8.606 0 012.42 4.67.51.51 0 00.505.425c.03 0 .057-.004.087-.008a.503.503 0 00.418-.585z"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h18v18H0z"></path></clipPath></defs></svg>
                            8(383)274-32-32
                        </a>
                        <a href="tel:+7(383)272-49-49" class="link link--black">
                            <svg class="" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)" fill="#2F3540"><path d="M14.225 11.15c-.368-.383-.813-.588-1.284-.588-.467 0-.915.2-1.3.585l-1.2 1.196c-.098-.053-.197-.102-.292-.152-.137-.068-.266-.133-.376-.201-1.125-.714-2.147-1.645-3.127-2.85-.475-.6-.794-1.105-1.026-1.618.312-.285.6-.581.882-.866l.319-.323c.798-.798.798-1.83 0-2.629L5.784 2.667c-.118-.118-.24-.24-.353-.36a17.933 17.933 0 00-.715-.707c-.368-.365-.809-.559-1.272-.559-.464 0-.912.194-1.292.559l-.008.007L.853 2.91a2.78 2.78 0 00-.825 1.767c-.09 1.11.236 2.142.487 2.819.615 1.66 1.534 3.198 2.906 4.847a17.877 17.877 0 005.953 4.662c.874.414 2.04.904 3.343.987.08.004.163.008.24.008.877 0 1.614-.315 2.191-.942.004-.008.012-.012.016-.02.197-.239.425-.455.665-.687.163-.155.33-.319.493-.49.376-.391.574-.847.574-1.314 0-.471-.201-.924-.585-1.303l-2.086-2.094zm1.36 4c-.004 0-.004.005 0 0-.148.16-.3.305-.463.464-.247.236-.498.483-.733.76-.384.41-.836.604-1.429.604-.057 0-.118 0-.175-.004-1.128-.072-2.176-.513-2.963-.889a16.875 16.875 0 01-5.607-4.391C2.919 10.132 2.053 8.689 1.48 7.139c-.354-.946-.483-1.683-.426-2.379.038-.444.209-.813.524-1.128l1.296-1.295c.186-.175.383-.27.577-.27.24 0 .433.144.555.266l.011.011c.232.217.452.44.684.68.118.122.24.243.361.369L6.099 4.43c.403.403.403.775 0 1.178-.11.11-.216.22-.327.326-.319.327-.623.63-.953.927-.008.008-.015.012-.02.02-.326.326-.265.645-.197.862l.012.034c.27.653.65 1.269 1.227 2.002l.004.004c1.048 1.291 2.154 2.298 3.373 3.07.156.098.315.178.467.254.137.068.266.133.377.201.015.008.03.02.045.027.13.064.25.095.376.095.316 0 .513-.198.578-.262l1.299-1.3c.13-.129.334-.285.574-.285.235 0 .429.149.547.278l.007.007 2.094 2.094c.39.387.39.786.003 1.189zM9.727 4.282c.995.167 1.9.638 2.621 1.36a4.842 4.842 0 011.36 2.621.51.51 0 00.505.426c.03 0 .058-.004.088-.008a.513.513 0 00.421-.593 5.86 5.86 0 00-1.644-3.172 5.86 5.86 0 00-3.173-1.645.516.516 0 00-.592.418.507.507 0 00.414.593zM17.98 7.94a9.64 9.64 0 00-2.71-5.223 9.64 9.64 0 00-5.223-2.71.511.511 0 10-.167 1.011c1.77.3 3.385 1.14 4.669 2.42a8.606 8.606 0 012.42 4.67.51.51 0 00.505.425c.03 0 .057-.004.087-.008a.503.503 0 00.418-.585z"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h18v18H0z"></path></clipPath></defs></svg>
                            8(383)274-32-32
                        </a>
                    </div>

                    <a href="#" class="block-price__btn btn btn-orange btn-size_full">Купить в 1 клик</a>

                    <div class="block-price__info">
                        <p class="block-price__info-p"> <img src="/images/catalog/delivery.svg" alt=""> Доставка в Новосибирск от 780 рублей</p>
                        <p class="block-price__info-p"> <img src="/images/catalog/location.svg" alt=""> 1200+ пунктов выдачи по всей России</p>
                        <p class="block-price__info-p"> <img src="/images/catalog/surface1.svg" alt=""> Гарантия подлинности</p>
                        
                    </div>

                </div>

                <a href="#" class="review">
                    <img src="/images/catalog/youtube.svg" alt="">
                    <p class="review__text">Смотреть видеоотзыв нашего покупателя о модели стиральной машины F25</p>
                </a>

               
            </div>
        </div>
    </div>
</section>



<div class="tabs product-tabs">            
    <div class="special__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="special__header">
                        <ul class="special__list tab-header">
                            <li class="special__item">
                                <a href="#" class="special__link link--black tab-header__item js-tab-trigger active" data-tab="1">Обзор</a>
                            </li>
                            <li class="special__item">
                                <a href="#" class="special__link link--black tab-header__item js-tab-trigger" data-tab="2">Особенности</a>
                            </li>
                            <li class="special__item">
                                <a href="#" class="special__link link--black tab-header__item js-tab-trigger" data-tab="3">Характеристики</a>
                            </li>
                            <li class="special__item">
                                <a href="#" class="special__link link--black tab-header__item js-tab-trigger" data-tab="4">Документация</a>
                            </li>
                        </ul>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="special__body"> 
        <div class="container">
            <div class="tab-content js-tab-content" data-tab="1">
                <div class="row">
                  <h6>О товаре</h6>
                  <?php echo htmlspecialchars_decode($arrProduct['content']); ?>
                </div>
            </div>

            <div class="tab-content js-tab-content" data-tab="2">
                <div class="row">
                  <h6>Особенности</h6>
                  <p>
                    Новая профессиональная стирально-отжимная машина ReinMaster с разовой загрузкой 25 кг.
                    5 базовых программ с возможностью перепрограммирования, отжим 750 об/мин, остаточная влажность белья после отжима 50%, что исключает из технологической цепи центрифугу, двигатель с частотным управлением, варианты нагрева электрический или паровой.
                    Стиральные машины ReinMaster имеют высокую производительность и идеальны для коммерческих прачечных.
                  </p>
                </div>
            </div>

            <div class="tab-content js-tab-content" data-tab="3">
                <div class="row">
                  <h6>Характеристики</h6>
                  <p>
                    Новая профессиональная стирально-отжимная машина ReinMaster с разовой загрузкой 25 кг.
                    5 базовых программ с возможностью перепрограммирования, отжим 750 об/мин, остаточная влажность белья после отжима 50%, что исключает из технологической цепи центрифугу, двигатель с частотным управлением, варианты нагрева электрический или паровой.
                    Стиральные машины ReinMaster имеют высокую производительность и идеальны для коммерческих прачечных.
                  </p>
                </div>
            </div>

            <div class="tab-content js-tab-content" data-tab="4">
                <div class="row">
                  <h6>Документация</h6>
                  <p>
                    Новая профессиональная стирально-отжимная машина ReinMaster с разовой загрузкой 25 кг.
                    5 базовых программ с возможностью перепрограммирования, отжим 750 об/мин, остаточная влажность белья после отжима 50%, что исключает из технологической цепи центрифугу, двигатель с частотным управлением, варианты нагрева электрический или паровой.
                    Стиральные машины ReinMaster имеют высокую производительность и идеальны для коммерческих прачечных.
                  </p>
                </div>
            </div>

        </div>
    </div>
</div>


    <article data-product="<? echo $uid_product_m; ?>">
                <div class="prod">
                    <div class="prod-slider-wrap prod-slider-shown">
                        <div class="flexslider prod-slider" id="prod-slider">
                            <?
                                if(count(gallery_arr('products_mod', $product2['id'], '1')) > 0) {
                                    ?>
                                        <ul class="slides">
                                            <?php
                                                $num_image = 0;
                                                foreach (gallery_arr('products_mod', $product2['id'], '1') as $key => $value) {

                                                    ?>
                                                        <li>
                                                            <a data-fancybox-group="prod" class="fancy-img" href="/uploads/<? echo $value['image']; ?>">
                                                                <img src="/uploads/small/<? echo $value['image']; ?>" alt="<? echo $product2['title']; ?>">
                                                            </a>
                                                        </li>
                                                    <?
                                                    $num_image++;
                                                }
                                            ?>
                                        </ul>
                                    <?
                                } else {
                                    if(count(gallery_arr('products', products_name($product, $id_category)['id'], '1')) > 0) {
                                        ?>
                                            <ul class="slides">
                                                <?php
                                                    $num_image = 0;
                                                    foreach (gallery_arr('products', products_name($product, $id_category)['id'], '1') as $key => $value) {

                                                        ?>
                                                            <li>
                                                                <a data-fancybox-group="prod" class="fancy-img" href="/uploads/<? echo $value['image']; ?>">
                                                                    <img src="/uploads/small/<? echo $value['image']; ?>" alt="<? echo products_name($product, $id_category)['title']; ?>">
                                                                </a>
                                                            </li>
                                                        <?
                                                        $num_image++;
                                                    }
                                                ?>
                                            </ul>
                                        <?
                                    } else {
                                        ?>
                                            <ul class="slides">
                                                <li>
                                                    <a data-fancybox-group="prod" class="fancy-img" href="/ap/assets/images/nophoto.png">
                                                        <img src="/ap/assets/images/nophoto.png" alt="">
                                                    </a>
                                                </li>
                                            </ul>
                                        <?
                                    }
                                }
                            ?>
                            <div class="prod-slider-count"><p><span class="count-cur">1</span> / <span class="count-all"><? echo $num_image; ?></span></p><p class="hover-label prod-slider-zoom"><i class="icon ion-search"></i><span>Приблизить</span></p></div>
                        </div>
                        <div class="flexslider prod-thumbs" id="prod-thumbs">
                            <?
                                if(count(gallery_arr('products_mod', $product2['id'], '1')) > 0) {
                                    ?>
                                    <ul class="slides">
                                        <?php
                                            foreach (gallery_arr('products_mod', $product2['id'], '1') as $key => $value) {
                                                ?>
                                                    <li>
                                                        <img src="/uploads/middle/<? echo $value['image']; ?>" alt="<? echo products_name($product, $id_category)['title']; ?>">
                                                    </li>
                                                <?
                                            }
                                        ?>
                                    </ul>
                                    <?
                                } else {
                                    ?>
                                        <ul class="slides">
                                            <li>
                                                <img src="/ap/assets/images/nophoto.png" alt="">
                                            </li>
                                        </ul>
                                    <?
                                }
                            ?>
                        </div>
                    </div>

                    <div class="prod-cont">
                        <div class="prod-rating-wrap">
                        </div>
                        <p class="prod-categs"><a href="/catalog/<? echo $category; ?>" data-pjax="content"><? echo $title_category; ?></a></p>
                        <h1><? echo products_name($product, $id_category)['title']; ?></h1>
                        <div class="variations_form cart">
                            <p class="prod-price"><? echo number_format($product2['price'], 0, '.', ' '); ?> &#8381;</p>
                            <p class="prod-excerpt"><?php echo  mb_substr(strip_tags(htmlspecialchars_decode(products_name($product, $id_category)['content'])), 0, 340, 'UTF-8').'...'; ?> <a id="prod-showdesc" class="prod-excerpt-more" href="#">читать далее</a></p>
                            <div class="prod-add">
                                <form class="variations select-mod-form">
                                    <?php 

                                        $input = product_mod($GLOBALS['city'], $uid_product_m);
                                        //var_dump($_POST);

                                        foreach (mergeByKey($input, 'name') as $key => $value) {
                                    ?>
                                    <div class="variations-row">
                                        <div class="label"><label><? echo $value['name']; ?></label></div>
                                        <div class="value">
                                            <select name="<? echo $value['name']; ?>" class="select-mod">
                                                <option value="">Выбрать</option>
                                                <?  
                                                    if(is_array($value['value']) > 0) {
                                                        foreach (array_unique($value['value']) as $keys => $values) {
                                                            if($values == $_POST[$value['name']]) {
                                                                echo'<option selected>'.$values.'</option>';
                                                            } else {
                                                                echo'<option>'.$values.'</option>';
                                                            }
                                                        }
                                                    } else {
                                                        if($value['value'] == $_POST[$value['name']]) {
                                                            echo'<option selected>'.$value['value'].'</option>';
                                                        } else {
                                                            echo'<option>'.$value['value'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?
                                        }
                                    ?>
                                </form>
                                <?php 
                                    if(products_name($product, $id_category)['stock'] > 0) {
                                ?>
                                    <button type="submit" class="button add_cart<? if(cart(products_name($product, $id_category)['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo products_name($product, $id_category)['id']; ?>" data-mod="<? echo $product_mod; ?>"><i class="icon ion-android-cart"></i> <span></span></button>
                                <?
                                    } else {
                                        echo ' <p class="qnt-wrap prod-li-qnt">Товар отсутствует</p>';
                                    }
                                ?>
                                <p class="qnt-wrap prod-li-qnt">
                                </p>
                                <div class="prod-li-favorites">
                                    <a href="#" class="hover-label add_like<? if(like(products_name($product, $id_category)['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo products_name($product, $id_category)['id']; ?>"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="prod-tabs-wrap">
                    <ul class="prod-tabs">
                        <li id="prod-desc" class="active" data-prodtab-num="1">
                            <a data-prodtab="#prod-tab-1" href="#">Описание</a>
                        </li>
                        <li data-prodtab-num="2" id="prod-props">
                            <a data-prodtab="#prod-tab-2" href="#">Характеристики</a>
                        </li>
                    </ul>
                    <div class="prod-tab-cont">
                        <p data-prodtab-num="1" class="prod-tab-mob active" data-prodtab="#prod-tab-1">Описание</p>
                        <div class="prod-tab page-styling prod-tab-desc" id="prod-tab-1">
                            <?php echo htmlspecialchars_decode(products_name($product, $id_category)['content']); ?>
                        </div>
                        <p data-prodtab-num="2" class="prod-tab-mob" data-prodtab="#prod-tab-2">Характеристики</p>
                        <div class="prod-tab" id="prod-tab-2">
                            <dl class="prod-tab-props">
                                <?php
                                    foreach(characters_products_id(products_name($product, $id_category)['id']) as $key_tag => $value_tag) {
                                        ?>
                                            <dt><? echo $value_tag['name']; ?></dt>
                                            <dd><? echo $value_tag['value']; ?></dd>
                                        <?
                                    }
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>

            </article>
    <?
        } else {
    ?>
    <article data-product="<? echo $uid_product_m; ?>">
                <div class="prod">
                    <div class="prod-slider-wrap prod-slider-shown">
                        <div class="flexslider prod-slider" id="prod-slider">
                            <?
                                if(count(gallery_arr('products', products_name($product, $id_category)['id'], '1')) > 0) {
                                    ?>
                                        <ul class="slides">
                                            <?php
                                                $num_image = 0;
                                                foreach (gallery_arr('products', products_name($product, $id_category)['id'], '1') as $key => $value) {

                                                    ?>
                                                        <li>
                                                            <a data-fancybox-group="prod" class="fancy-img" href="/uploads/<? echo $value['image']; ?>">
                                                                <img src="/uploads/small/<? echo $value['image']; ?>" alt="<? echo products_name($product, $id_category)['title']; ?>">
                                                            </a>
                                                        </li>
                                                    <?
                                                    $num_image++;
                                                }
                                            ?>
                                        </ul>
                                    <?
                                } else {
                                    ?>
                                        <ul class="slides">
                                            <li>
                                                <a data-fancybox-group="prod" class="fancy-img" href="/ap/assets/images/nophoto.png">
                                                    <img src="/ap/assets/images/nophoto.png" alt="">
                                                </a>
                                            </li>
                                        </ul>
                                    <?
                                }
                            ?>
                            <div class="prod-slider-count"><p><span class="count-cur">1</span> / <span class="count-all"><? echo $num_image; ?></span></p><p class="hover-label prod-slider-zoom"><i class="icon ion-search"></i><span>Приблизить</span></p></div>
                        </div>
                        <div class="flexslider prod-thumbs" id="prod-thumbs">
                            <?
                                if(count(gallery_arr('products', products_name($product, $id_category)['id'], '1')) > 0) {
                                    ?>
                                    <ul class="slides">
                                        <?php
                                            foreach (gallery_arr('products', products_name($product, $id_category)['id'], '1') as $key => $value) {
                                                ?>
                                                    <li>
                                                        <img src="/uploads/middle/<? echo $value['image']; ?>" alt="<? echo products_name($product, $id_category)['title']; ?>">
                                                    </li>
                                                <?
                                            }
                                        ?>
                                    </ul>
                                    <?
                                } else {
                                    ?>
                                        <ul class="slides">
                                            <li>
                                                <img src="/ap/assets/images/nophoto.png" alt="">
                                            </li>
                                        </ul>
                                    <?
                                }
                            ?>
                        </div>
                    </div>

                    <div class="prod-cont">
                        <div class="prod-rating-wrap">
                            <!--<p data-rating="4" class="prod-rating">
                                <i class="rating-ico" title="1"></i><i class="rating-ico" title="2"></i><i class="rating-ico" title="3"></i><i class="rating-ico" title="4"></i><i class="rating-ico" title="5"></i>
                            </p>
                            <p class="prod-rating-count">7</p>
                             -->
                        </div>
                        <p class="prod-categs"><a href="/catalog/<? echo $category; ?>" data-pjax="content"><? echo $title_category; ?></a></p>
                        <h1><? echo products_name($product, $id_category)['title']; ?></h1>
                        <div class="variations_form cart">
                            <p class="prod-price"><? echo number_format(products_name($product, $id_category)['price'], 0, '.', ' '); ?> &#8381;</p>
                            <p class="prod-excerpt"><?php echo  mb_substr(strip_tags(htmlspecialchars_decode(products_name($product, $id_category)['content'])), 0, 340, 'UTF-8').'...'; ?> <a id="prod-showdesc" class="prod-excerpt-more" href="#">читать далее</a></p>
                            <div class="prod-add">
                                <form class="variations select-mod-form">
                                    <?php 

                                        $input = product_mod($GLOBALS['city'], $uid_product_m);
                                        //var_dump($input);

                                        foreach (mergeByKey($input, 'name') as $key => $value) {
                                    ?>
                                    <div class="variations-row">
                                        <div class="label"><label><? echo $value['name']; ?></label></div>
                                        <div class="value">
                                            <select name="<? echo $value['name']; ?>" class="select-mod">
                                                <option value="">Выбрать</option>
                                                <?  
                                                    if(is_array($value['value']) > 0) {
                                                        foreach (array_unique($value['value']) as $keys => $values) {
                                                            if($values == $_POST[$value['name']]) {
                                                                echo'<option selected>'.$values.'</option>';
                                                            } else {
                                                                echo'<option>'.$values.'</option>';
                                                            }
                                                        }
                                                    } else {
                                                        if($value['value'] == $_POST[$value['name']]) {
                                                            echo'<option selected>'.$value['value'].'</option>';
                                                        } else {
                                                            echo'<option>'.$value['value'].'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?
                                        }
                                    ?>
                                    <!--<div class="variations-row">
                                        <div class="label"><label>Цвет</label></div>
                                        <div class="value">
                                            <select>
                                                <option value="">Выберите цвет</option>
                                                <option value="blue">Синий</option>
                                                <option value="green">Зеленый</option>
                                                <option value="yellow">Желтый</option>
                                            </select>
                                        </div>
                                    </div>-->
                                </form>
                                <?php 
                                    if(products_name($product, $id_category)['stock'] > 0) {
                                ?>
                                    <button type="submit" class="button add_cart<? if(cart(products_name($product, $id_category)['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo products_name($product, $id_category)['id']; ?>" data-mod=""><i class="icon ion-android-cart"></i> <span></span></button>
                                <?
                                    } else {
                                        echo ' <p class="qnt-wrap prod-li-qnt">Товар отсутствует</p>';
                                    }
                                ?>
                                <p class="qnt-wrap prod-li-qnt">
                                    <!--<a href="#" class="qnt-plus prod-li-plus"><i class="icon ion-arrow-up-b"></i></a>
                                    <input type="text" value="1">
                                    <a href="#" class="qnt-minus prod-li-minus"><i class="icon ion-arrow-down-b"></i></a>-->
                                </p>
                                <div class="prod-li-favorites">
                                    <a href="#" class="hover-label add_like<? if(like(products_name($product, $id_category)['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo products_name($product, $id_category)['id']; ?>"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                </div>
                            </div>
                        </div>
                        <!--<div class="prod-props">
                            <dl class="product_meta">
                                <dt>Артикул:</dt>
                                <dd>2135687</dd>
                                <dt>Вес</dt>
                                <dd>1 кг</dd>
                                <dt>Размеры</dt>
                                <dd>41 x 150 мм</dd>
                                <dt>Цвет</dt>
                                <dd>Синий, зеленый</dd>
                                <dt>Старна</dt>
                                <dd>Германия</dd>
                                <dt>Материал</dt>
                                <dd>Пластик</dd>
                            </dl>
                        </div>-->

                    </div>
                    <!--<p class="prod-badge">
                        <span class="badge-1">Топ продаж</span>
                    </p>-->
                </div>
                <div class="prod-tabs-wrap">
                    <ul class="prod-tabs">
                        <li id="prod-desc" class="active" data-prodtab-num="1">
                            <a data-prodtab="#prod-tab-1" href="#">Описание</a>
                        </li>
                        <li data-prodtab-num="2" id="prod-props">
                            <a data-prodtab="#prod-tab-2" href="#">Характеристики</a>
                        </li>
                        <!--<li data-prodtab-num="3" id="prod-reviews">
                            <a data-prodtab="#prod-tab-3" href="#">Отзывы (7)</a>
                        </li>
                        <li class="prod-tabs-addreview">Add a review</li>   -->
                    </ul>
                    <div class="prod-tab-cont">
                        <p data-prodtab-num="1" class="prod-tab-mob active" data-prodtab="#prod-tab-1">Описание</p>
                        <div class="prod-tab page-styling prod-tab-desc" id="prod-tab-1">
                            <?php echo htmlspecialchars_decode(products_name($product, $id_category)['content']); ?>
                        </div>
                        <p data-prodtab-num="2" class="prod-tab-mob" data-prodtab="#prod-tab-2">Характеристики</p>
                        <div class="prod-tab" id="prod-tab-2">
                            <dl class="prod-tab-props">
                                <?php
                                    foreach(characters_products_id(products_name($product, $id_category)['id']) as $key_tag => $value_tag) {
                                        ?>
                                            <dt><? echo $value_tag['name']; ?></dt>
                                            <dd><? echo $value_tag['value']; ?></dd>
                                        <?
                                    }
                                ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <?php /* ?>
                <h2 class="prod-related-ttl">Сопутствующие товары</h2>
                <div class="row prod-items prod-items-4">
                                            
                    <article class="cf-sm-6 cf-md-6 cf-lg-3 col-xs-6 col-sm-6 col-md-6 col-lg-3 sectgl-item sectgl-item">
                        <div class="sectgl prod-i">
                            <div class="prod-i-top">
                                <a class="prod-i-img" href="product.html">
                                    <img src="https://static-eu.insales.ru/images/collections/1/533/1819157/large_aa63f0cc391dcc747d9e5c8139a29be6.jpg" alt="">
                                </a>
                                <div class="prod-i-actions">
                                    <div class="prod-i-actions-in">
                                        <div class="prod-li-favorites">
                                            <a href="wishlist.html" class="hover-label add_to_wishlist"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                        </div>
                                        <!--<p class="prod-quickview">
                                            <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                                        </p>-->
                                        <p class="prod-i-cart">
                                            <a href="#" class="hover-label prod-addbtn"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                                        </p>
                                    </div>
                                </div>
                                <!--<p class="prod-i-badge"><span>Распродажа</span></p>-->
                            </div>
                            <div class="prod-i-bot">
                                <div class="prod-i-info">
                                    <p class="prod-i-price"><!--<s>93.00</s> -->70.00 &#8381;</p>
                                    <p class="prod-i-categ"><a href="catalog-gallery.html">Протеин</a></p>
                                </div>
                                <h3 class="prod-i-ttl"><a href="product.html">Steel Power Fast Whey Protein</a></h3>
                            </div>
                        </div>
                    </article>                                             
                               
                </div>

                <h2 class="prod-related-ttl">Похожие товары</h2>
                <div class="row prod-items prod-items-4">

                    <article class="cf-sm-6 cf-md-6 cf-lg-3 col-xs-6 col-sm-6 col-md-6 col-lg-3 sectgl-item sectgl-item">
                        <div class="sectgl prod-i">
                            <div class="prod-i-top">
                                <a class="prod-i-img" href="product.html">
                                    <img src="https://static-eu.insales.ru/images/collections/1/533/1819157/large_aa63f0cc391dcc747d9e5c8139a29be6.jpg" alt="">
                                </a>
                                <div class="prod-i-actions">
                                    <div class="prod-i-actions-in">
                                        <div class="prod-li-favorites">
                                            <a href="wishlist.html" class="hover-label add_to_wishlist"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                        </div>
                                        <!--<p class="prod-quickview">
                                            <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                                        </p>-->
                                        <p class="prod-i-cart">
                                            <a href="#" class="hover-label prod-addbtn"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                                        </p>
                                    </div>
                                </div>
                                <!--<p class="prod-i-badge"><span>Распродажа</span></p>-->
                            </div>
                            <div class="prod-i-bot">
                                <div class="prod-i-info">
                                    <p class="prod-i-price"><!--<s>93.00</s> -->70.00 &#8381;</p>
                                    <p class="prod-i-categ"><a href="catalog-gallery.html">Протеин</a></p>
                                </div>
                                <h3 class="prod-i-ttl"><a href="product.html">Steel Power Fast Whey Protein</a></h3>
                            </div>
                        </div>
                    </article>                                          

                </div><?php */ ?>

            </article>
            <? } ?>
        </div>
<?
                } else {
                    header("HTTP/1.0 404 Not Found");
                    include 'pages/404.php';
                    exit();
                }
            } else {
?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>
                    <div class="cont maincont">

                        <div class="section-top">
                            <h1 class="maincont-ttl">Каталог товаров</h1>
                            <ul class="b-crumbs">
                                <li><a href="/" data-pjax="content">Главная</a></li>
                                <li><a href="/catalog" data-pjax="content">Каталог товаров</a></li>
                                <li><? echo $title_category; ?></li>
                            </ul>
                            <div class="section-top-sort">

                            </div>
                        </div>

                        <div class="section-wrap-withsb">
                            <aside class="blog-sb-widgets section-sb" id="section-sb">
                                <div class="theiaStickySidebar">
                                    <div class="section-filter">
                                        <div class="section-filter">
                                            <div class="blog-sb-widget multishopcategories_widget">
                                                <h3 class="widgettitle">Категории</h3>
                                                <div class="section-sb-current">

                                                    <?php
                                                        function menu_showNested($parentID) {
                                                            $city_products = $GLOBALS['city'];
                                                            $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                                            $numRows = mysqli_num_rows($result);
                                                            
                                                            if ($numRows > 0) {
                                                                echo '<ul>';
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    echo '<li data-id="'.$row['id'].'">';
                                                                    echo '<a href="/catalog/'.$row['name'].'" data-pjax="content"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                                                                    
                                                                    menu_showNested($row['id']);
                                                                    
                                                                    echo '</li>';
                                                                }
                                                                echo '</ul>';
                                                            }
                                                        }
                                                        

                                                        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                                        $numRows = mysqli_num_rows($result);

                                                            echo '<ul class="section-sb-list">';
                                                            
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    echo '<li data-id="'.$row['id'].'">';
                                                                    echo '<a href="/catalog/'.$row['name'].'" data-pjax="content"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                                                                    
                                                                    menu_showNested($row['id']);
                                                                    
                                                                    echo '</li>';
                                                                }
                                                                
                                                            echo '</ul>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </aside>        
                            <div class="section-list-withsb" id="section-list-withsb">
                                <div class="theiaStickySidebar">


                                    <div class="row prod-items prod-items-2">

                    <?php
                        $url_page = '/?page=catalog&catalog='.$category.'&num=';

                        $pagenum = htmlspecialchars($_GET['num']);
                        $page = htmlspecialchars($_GET['page']);
                        // Переменная хранит число сообщений выводимых на станице  
                        $num = 12;  
                        $result01s = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `category` = '$id_category'");  
                        $posts = mysqli_num_rows($result01s);  
                        // Находим общее число страниц  
                        $total = intval(($posts - 1) / $num) + 1;  
                        // Определяем начало сообщений для текущей страницы  
                        $pagenum = intval($pagenum);  
                        // Если значение $pagenum меньше единицы или отрицательно  
                        // переходим на первую страницу  
                        // А если слишком большое, то переходим на последнюю  
                        if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
                          if($pagenum > $total) $pagenum = $total;  
                        // Вычисляем начиная к какого номера  
                        // следует выводить сообщения  
                        $start = $pagenum * $num - $num;  
                        // Выбираем $num сообщений начиная с номера $start  
                        $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `category` = '$id_category' ORDER BY `regdate` DESC LIMIT $start, $num");    
                        // В цикле переносим результаты запроса в массив $postrow  
                        while ($postrow[] = mysqli_fetch_array($result0));  


                        if($posts > 0){  
                            //while($row1 = mysql_fetch_array($res1)) {
                            for($in = 0; $in < $num; $in++)  
                            {  
                                $idstr = $postrow[$in]['id'];
                                if($idstr > 0) {
                    ?>
                                        <article class="cf-sm-6 cf-md-6 cf-lg-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 sectgl-item">
                                            <div class="sectgl prod-i">
                                                <div class="prod-i-top">
                                                    <a class="prod-i-img" href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" data-pjax="content">
                                                        <?
                                                            if(gallery_arr('products', $idstr, '1')['0']['image']) {
                                                                ?>
                                                                    <img src="/uploads/small/<?php echo gallery_arr('products', $idstr, '1')['0']['image']; ?>" alt="">
                                                                <?
                                                            } else {
                                                                ?>
                                                                    <img src="/ap/assets/images/nophoto.png" alt="">
                                                                <?
                                                            }
                                                        ?>
                                                    </a>
                                                    <div class="prod-i-actions">
                                                        <div class="prod-i-actions-in">
                                                            <div class="prod-li-favorites">
                                                                <a href="#" class="hover-label add_like<? if(like($idstr, $user_uid)) {echo ' active';} ?>" data-id="<? echo $idstr; ?>"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                                            </div>
                                                            <!--<p class="prod-quickview">
                                                                <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                                                            </p>-->
                                                            <?php 
                                                                if($postrow[$in]['stock'] > 0) {
                                                            ?>
                                                                <p class="prod-i-cart">
                                                                    <a href="#" class="hover-label prod-addbtn add_cart<? if(cart($idstr, $user_uid)) {echo ' active';} ?>" data-id="<? echo $idstr; ?>"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                                                                </p>
                                                            <?
                                                                }
                                                            ?>
                                                            <!--<p class="prod-li-compare">
                                                                <a href="#" class="hover-label prod-li-compare-btn"><span>Сравнение</span><i class="icon ion-arrow-swap"></i></a>
                                                            </p>-->
                                                        </div>
                                                    </div>
                                                    <p class="prod-i-badge">
                                                    <?php if($postrow[$in]['old_price'] > $postrow[$in]['price']) { ?><span>Распродажа</span><?} ?>
                                                    <?php 
                                                        $rr_time = strtotime($postrow[$in]['regdate'])+2592000;
                                                        if($rr_time > time()) {
                                                            echo '<span class="badge-2">Новинка</span>';
                                                        }
                                                    ?>
                                                    </p>
                                                </div>
                                                <div class="prod-i-bot">
                                                    <div class="prod-i-info">
                                                        <p class="prod-i-price"><?php if($postrow[$in]['old_price'] > $postrow[$in]['price']) { ?><s><? echo number_format($postrow[$in]['old_price'], 0, '.', ' '); ?></s><?} ?> <? echo number_format($postrow[$in]['price'], 0, '.', ' '); ?> &#8381;</p>
                                                        <p class="prod-i-categ"><a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>" data-pjax="content"><? echo productsCategory($postrow[$in]['category'])['title']; ?></a></p>
                                                    </div>
                                                    <h3 class="prod-i-ttl">
                                                        <a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" data-pjax="content"><?php echo $postrow[$in]['title']; ?></a>
                                                    </h3>
                                                </div>
                                            </div>
                                        </article>   
                    <?php
                                }
                            }
                        } else {
                            echo '<div class="col-lg-12 sectgl-item">В данной категории нет товаров</div>';
                        }
                    ?>        
                                        
                                    </div>

                                    <?php  
                                        $pervpage = '';
                                        $nextpage = '';
                                        $pagenum1left = '';
                                        $pagenum2left = '';
                                        $pagenum1right = '';
                                        $pagenum2right = '';
                                       
                                        if ($pagenum != 1) $pervpage = '<li><a data-pjax=content href='.$url_page.'1><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>  
                                                                       <li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'><i class="fa fa-angle-left" aria-hidden="true"></i></a></li>';  
                                        
                                        if ($pagenum != $total) $nextpage = ' <li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'><i class="fa fa-angle-right" aria-hidden="true"></i></a></li>  
                                                                           <li><a data-pjax=content href='.$url_page.''.$total. '><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';  

                                        
                                        if($pagenum - 2 > 0) $pagenum2left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 2) .'>'. ($pagenum - 2) .'</a></li>';  
                                        if($pagenum - 1 > 0) $pagenum1left = '<li><a data-pjax=content href='.$url_page.''. ($pagenum - 1) .'>'. ($pagenum - 1) .'</a></li>';  
                                        if($pagenum + 2 <= $total) $pagenum2right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 2) .'>'. ($pagenum + 2) .'</a></li>';  
                                        if($pagenum + 1 <= $total) $pagenum1right = '<li><a data-pjax=content href='.$url_page.''. ($pagenum + 1) .'>'. ($pagenum + 1) .'</a></li>'; 

                                        if($num < $posts) {
                                            ?>
                                                <ul class="page-numbers">
                                                    <?
                                                    echo $pervpage.$pagenum2left.$pagenum1left.'<li><span class="page-numbers current">'.$pagenum.'</span></li>'.$pagenum1right.$pagenum2right.$nextpage;  
                                                    ?>
                                                </ul>
                                            <?
                                        }
                                    ?>

                                </div><!-- .theiaStickySidebar -->
                            </div><!-- .section-list-withsb -->
                        </div><!-- .section-wrap-withsb -->

                    </div>
                <?
            }
        } else {
            header("HTTP/1.0 404 Not Found");
            include 'pages/404.php';
            exit();
            //нет категории
        }
    } else {
?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-auto">
                <div class="category">
                    <h4>Каталог товаров</h4>
                </div>
                <div class="sort">
                       -- Сортировка --
                </div>
            </div>
        </div>
    </div>
    
    <div class="tabs">            
        <div class="special__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="special__header">
                            <ul class="special__list tab-header">

                                <?php
                                    /*function menu_showNested($parentID) {
                                        $city_products = $GLOBALS['city'];
                                        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                        $numRows = mysqli_num_rows($result);
                                        
                                        if ($numRows > 0) {
                                            echo '<ul>';
                                            while($row = mysqli_fetch_array($result)) {
                                                echo '<li data-id="'.$row['id'].'">';
                                                echo '<a href="/catalog/'.$row['name'].'"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                                                
                                                menu_showNested($row['id']);
                                                
                                                echo '</li>';
                                            }
                                            echo '</ul>';
                                        }
                                    }
                                    

                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);

                                        echo '<ul class="section-sb-list">';
                                        
                                            while($row = mysqli_fetch_array($result)) {
                                                echo '<li data-id="'.$row['id'].'">';
                                                echo '<a href="/catalog/'.$row['name'].'"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                                                
                                                menu_showNested($row['id']);
                                                
                                                echo '</li>';
                                            }
                                            
                                        echo '</ul>';
                                    */

                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang` LIMIT 0, 5");
                                    $numRows = mysqli_num_rows($result);
                                        
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<li class="special__item" data-id="'.$row['id'].'">';
                                        echo '<a href="/catalog/'.$row['name'].'" class="special__link link--black tab-header__item js-tab-trigger">'.$row['title'].' <sup>'.productsCountCategory($row['id']).'</sup></a>';
                                        
                                        
                                        echo '</li>';
                                    }
                                            

                                ?>             
                            </ul>
    
                            <div class="special__nagigate">
                                <!--<button type="button" class="prev link--blue">
                                    <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.32 5.997l4.488 4.49A.65.65 0 018 10.95c0 .176-.068.34-.192.464l-.393.393a.651.651 0 01-.464.192.651.651 0 01-.464-.192L1.142 6.463a.651.651 0 01-.192-.465c0-.177.068-.342.192-.466l5.34-5.34A.651.651 0 016.946 0c.176 0 .34.068.464.192l.393.393a.657.657 0 010 .928L3.32 5.997z" fill="#2F3540"></path></svg>
                                </button>
                                <button type="button" class="next link--blue">
                                    <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#2F3540"></path></svg>
                                </button>-->
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
   
        <div class="special__body"> 
            <div class="container">
                 <div class="row">
                    <?php
                        /*if($_GET['num']) {
                            $url_page = $_SERVER['REQUEST_URI'].'&num=';
                        } else {
                            $url_page = '/?page=catalog&num=';
                        }*/

                        $url_page = '/?page=catalog&num=';

                        $pagenum = htmlspecialchars($_GET['num']);
                        $page = htmlspecialchars($_GET['page']);
                        // Переменная хранит число сообщений выводимых на станице  
                        $num = 24;  
                        $result01s = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `city_id` = '$city_products'");  
                        $posts = mysqli_num_rows($result01s);  
                        // Находим общее число страниц  
                        $total = intval(($posts - 1) / $num) + 1;  
                        // Определяем начало сообщений для текущей страницы  
                        $pagenum = intval($pagenum);  
                        // Если значение $pagenum меньше единицы или отрицательно  
                        // переходим на первую страницу  
                        // А если слишком большое, то переходим на последнюю  
                        if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
                          if($pagenum > $total) $pagenum = $total;  
                        // Вычисляем начиная к какого номера  
                        // следует выводить сообщения  
                        $start = $pagenum * $num - $num;  
                        // Выбираем $num сообщений начиная с номера $start  
                        $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `city_id` = '$city_products' ORDER BY `regdate` DESC LIMIT $start, $num");    
                        // В цикле переносим результаты запроса в массив $postrow  
                        while ($postrow[] = mysqli_fetch_array($result0));  


                        if($posts > 0){  
                            //while($row1 = mysql_fetch_array($res1)) {
                            for($in = 0; $in < $num; $in++)  
                            {  
                                $idstr = $postrow[$in]['id'];
                                if($idstr > 0) {

                                if($in == 12) {
                                    include $path.'/../modules/banner.php';
                                }
                    ?>

                            <div class="special-carousel__item col-lg-3">
                                <article class="catalog__item card">
                                    <a class="card__link" href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" data-pjax="content">
                                        <div class="card__block-img">
                                            <?php echo gallery('products', $idstr, 0, 1, 'small', $postrow[$in]['title']); ?>
                                        </div>
                                        <div class="card__block-heading">
                                            <h6 class="card__title"><?php echo $postrow[$in]['title']; ?></h6>
                                        </div>
                                    </a>

                                    <div class="card__manufacturer-city">
                                        <span class="card__city"><?php echo $postrow[$in]['prod']; ?></span>
                                    </div>

                                    <div class="card__tags-list">  
                                        <?php
                                            foreach(characters_products_id($idstr) as $key_tag => $value_tag) {
                                                ?>
                                                    <span class="card__tags-item"><? echo $value_tag['value']; ?></span>
                                                <?
                                            }
                                        ?>        
                                    </div>

                                    <div class="card__footer">
                                        <div class="card__price price">
                                            <?php 
                                                if($postrow[$in]['old_price'] > $postrow[$in]['price']) {
                                                    $sale = 100 - ($postrow[$in]['price']*100/$postrow[$in]['old_price']);
                                                    ?>
                                                        <p class="price__old-price"><? echo number_format($postrow[$in]['old_price'], 0, '.', ' '); ?> ₽
                                                            <svg width="35" height="18" class="price__seil" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.975 0h28.88v18H5.974L0 9l5.975-9z" fill="#F54D46"/>
                                                                <foreignObject x="4" y="-2" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                                    <span class="price__seil-text" xmlns="http://www.w3.org/1999/xhtml">-<?php echo round($sale); ?>%</span>
                                                                </foreignObject>
                                                            </svg>
                                                        </p>
                                                    <?php
                                                } 
                                            ?>
                                            <h6 class="price__price"><? echo number_format($postrow[$in]['price'], 0, '.', ' '); ?> ₽</h6>
                                        </div>

                                        <div class="card__block-btn">
                                            <a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" class="card__btn btn btn-orange btn-size_full" data-pjax="content">
                                                Описание
                                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#ffffff"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                            <?php
                                        }
                                    }
                                } else {
                                    echo '<div class="col-lg-12">В данной категории нет товаров</div>';
                                }
                            ?>        



                 </div>


            </div>
        </div>
    </div>
</section>

<section class="catalog-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php include $path.'/../modules/pagination.php'; ?>
            </div>
            <div class="col-lg-6">
                <div class="catalog-pages__info">
                    <p>В нашей продукции <? echo $posts; ?> <? echo ending($posts, 'товар', 'товара', 'товаров'); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog-pages__content">
                    <?php echo htmlspecialchars_decode($row_pages['content']); ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="catalog-simular">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="catalog-simular__heading">Вы смотрели ранее</h2>
            </div>
        </div>
        <div class="row">


            <div class="special-carousel__item col-lg-3">
                <article class="catalog__item card">
                    <a class="card__link" href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" data-pjax="content">
                        <div class="card__block-img">
                            <?php echo gallery('products', $idstr, 0, 1, 'small', $postrow[$in]['title']); ?>
                        </div>
                        <div class="card__block-heading">
                            <h6 class="card__title"><?php echo $postrow[$in]['title']; ?></h6>
                        </div>
                    </a>

                    <div class="card__manufacturer-city">
                        <span class="card__city">Россия</span>
                    </div>

                    <div class="card__tags-list">  
                        <?php
                            foreach(characters_products_id($idstr) as $key_tag => $value_tag) {
                                ?>
                                    <span class="card__tags-item"><? echo $value_tag['value']; ?></span>
                                <?
                            }
                        ?>        
                    </div>

                    <div class="card__footer">
                        <div class="card__price price">
                            <?php 
                                if($postrow[$in]['old_price'] > $postrow[$in]['price']) {
                                    $sale = 100 - ($postrow[$in]['price']*100/$postrow[$in]['old_price']);
                                    ?>
                                        <p class="price__old-price"><? echo number_format($postrow[$in]['old_price'], 0, '.', ' '); ?> ₽
                                            <svg width="35" height="18" class="price__seil" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.975 0h28.88v18H5.974L0 9l5.975-9z" fill="#F54D46"/>
                                                <foreignObject x="4" y="-2" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                    <span class="price__seil-text" xmlns="http://www.w3.org/1999/xhtml">-<?php echo round($sale); ?>%</span>
                                                </foreignObject>
                                            </svg>
                                        </p>
                                    <?php
                                } 
                            ?>
                            <h6 class="price__price"><? echo number_format($postrow[$in]['price'], 0, '.', ' '); ?> ₽</h6>
                        </div>

                        <div class="card__block-btn">
                            <a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>" class="card__btn btn btn-orange btn-size_full" data-pjax="content">
                                Описание
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#ffffff"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            </div>


        </div>
    </div>
</section>


<?
    }

