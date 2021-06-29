<?
    $category = isset($_GET['catalog']) ? $_GET['catalog'] : '';
    $category = val_string($category);

    $getSort = $_GET['sort'];
    $getSort = preg_replace("/[^0-9]/", '', $getSort);
    if(!$getSort) $getSort = 0;

    $arr_sort[0] = 'По дате';
    $arr_sort[1] = 'Сначала дешевле';
    $arr_sort[2] = 'Сначала дороже';

    if ($getSort == 1) {
        $sort_txt = 'ORDER BY `price` ASC';
    } else if ($getSort == 2) {
        $sort_txt = 'ORDER BY `price` DESC';
    } else {
        $sort_txt = 'ORDER BY `regdate` DESC';
    }


    if(authuser()) {
        $user_uid = authuser();
    } else {
        $user_uid = guest();
    }

    $city_products = $GLOBALS['city'];

    if($category) {
        $query_pc = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `name` = '$category'"); 
        if(mysqli_num_rows($query_pc) > 0) {
            $row_pc = mysqli_fetch_assoc($query_pc);
            $id_category = $row_pc['id'];
            $title_category = $row_pc['title'];

            $product = isset($_GET[$category]) ? $_GET[$category] : '';
            $product = val_string($product);

            if($product) {
                $arrProduct = products_name($product, $id_category);
                if($arrProduct) {
                    $title = $arrProduct['title'];
                    ?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

        
<?
    $uid_product_m = products_name($product, $id_category)['uid_moysklad'];
    $vars = $_POST;

    $product_mod = products_mod_search($GLOBALS['city'], $uid_product_m, $vars);
    //echo json_encode($vars);
    //echo $product_mod;
    //if(/*count($vars) > 0 && $product_mod*/true) {
        $product2 = products_mod($GLOBALS['city'], $uid_product_m, $product_mod);
        //var_dump($product2);
?>

<section class="product" data-product="<? echo $arrProduct['id']; ?>">
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
                                                <img src="/ap/image.php?image=<? echo $value['image']; ?>&type=small" alt="<? echo $arrProduct['title']; ?>">
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
                                                <a href="/ap/image.php?image=<? echo $value['image']; ?>&type=full" data-fancybox="images">
                                                    <img src="/ap/image.php?image=<? echo $value['image']; ?>&type=middle" alt="<? echo $arrProduct['title']; ?>">
                                                </a>
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
                            foreach(characters_products_id($arrProduct['id'], 8) as $key_tag => $value_tag) {
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
                    <a href="#char" class="product-info__link link link--hevered">Смотреть все характеристики</a>
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
                        <?php 
                            if($arrProduct['price']) {
                                ?>
                                    <h6 class="price__price block-price__price"><? echo number_format($arrProduct['price'], 0, '.', ' '); ?> ₽</h6>
                                <?php
                            } else {
                                ?>
                                    <h6 class="price__price block-price__price-text">Цена по запросу</h6>
                                <?php
                            }
                        ?>
                    </div>

                    <div class="block-price__contact">
                        <a href="tel:<?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?>" class="link link--black">
                            <svg class="" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)" fill="#2F3540"><path d="M14.225 11.15c-.368-.383-.813-.588-1.284-.588-.467 0-.915.2-1.3.585l-1.2 1.196c-.098-.053-.197-.102-.292-.152-.137-.068-.266-.133-.376-.201-1.125-.714-2.147-1.645-3.127-2.85-.475-.6-.794-1.105-1.026-1.618.312-.285.6-.581.882-.866l.319-.323c.798-.798.798-1.83 0-2.629L5.784 2.667c-.118-.118-.24-.24-.353-.36a17.933 17.933 0 00-.715-.707c-.368-.365-.809-.559-1.272-.559-.464 0-.912.194-1.292.559l-.008.007L.853 2.91a2.78 2.78 0 00-.825 1.767c-.09 1.11.236 2.142.487 2.819.615 1.66 1.534 3.198 2.906 4.847a17.877 17.877 0 005.953 4.662c.874.414 2.04.904 3.343.987.08.004.163.008.24.008.877 0 1.614-.315 2.191-.942.004-.008.012-.012.016-.02.197-.239.425-.455.665-.687.163-.155.33-.319.493-.49.376-.391.574-.847.574-1.314 0-.471-.201-.924-.585-1.303l-2.086-2.094zm1.36 4c-.004 0-.004.005 0 0-.148.16-.3.305-.463.464-.247.236-.498.483-.733.76-.384.41-.836.604-1.429.604-.057 0-.118 0-.175-.004-1.128-.072-2.176-.513-2.963-.889a16.875 16.875 0 01-5.607-4.391C2.919 10.132 2.053 8.689 1.48 7.139c-.354-.946-.483-1.683-.426-2.379.038-.444.209-.813.524-1.128l1.296-1.295c.186-.175.383-.27.577-.27.24 0 .433.144.555.266l.011.011c.232.217.452.44.684.68.118.122.24.243.361.369L6.099 4.43c.403.403.403.775 0 1.178-.11.11-.216.22-.327.326-.319.327-.623.63-.953.927-.008.008-.015.012-.02.02-.326.326-.265.645-.197.862l.012.034c.27.653.65 1.269 1.227 2.002l.004.004c1.048 1.291 2.154 2.298 3.373 3.07.156.098.315.178.467.254.137.068.266.133.377.201.015.008.03.02.045.027.13.064.25.095.376.095.316 0 .513-.198.578-.262l1.299-1.3c.13-.129.334-.285.574-.285.235 0 .429.149.547.278l.007.007 2.094 2.094c.39.387.39.786.003 1.189zM9.727 4.282c.995.167 1.9.638 2.621 1.36a4.842 4.842 0 011.36 2.621.51.51 0 00.505.426c.03 0 .058-.004.088-.008a.513.513 0 00.421-.593 5.86 5.86 0 00-1.644-3.172 5.86 5.86 0 00-3.173-1.645.516.516 0 00-.592.418.507.507 0 00.414.593zM17.98 7.94a9.64 9.64 0 00-2.71-5.223 9.64 9.64 0 00-5.223-2.71.511.511 0 10-.167 1.011c1.77.3 3.385 1.14 4.669 2.42a8.606 8.606 0 012.42 4.67.51.51 0 00.505.425c.03 0 .057-.004.087-.008a.503.503 0 00.418-.585z"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h18v18H0z"></path></clipPath></defs></svg>
                            <?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?>
                        </a>
                        <a href="tel:<?php echo phone(settings_id($GLOBALS['city'])[0]['phone2']); ?>" class="link link--black">
                            <svg class="" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)" fill="#2F3540"><path d="M14.225 11.15c-.368-.383-.813-.588-1.284-.588-.467 0-.915.2-1.3.585l-1.2 1.196c-.098-.053-.197-.102-.292-.152-.137-.068-.266-.133-.376-.201-1.125-.714-2.147-1.645-3.127-2.85-.475-.6-.794-1.105-1.026-1.618.312-.285.6-.581.882-.866l.319-.323c.798-.798.798-1.83 0-2.629L5.784 2.667c-.118-.118-.24-.24-.353-.36a17.933 17.933 0 00-.715-.707c-.368-.365-.809-.559-1.272-.559-.464 0-.912.194-1.292.559l-.008.007L.853 2.91a2.78 2.78 0 00-.825 1.767c-.09 1.11.236 2.142.487 2.819.615 1.66 1.534 3.198 2.906 4.847a17.877 17.877 0 005.953 4.662c.874.414 2.04.904 3.343.987.08.004.163.008.24.008.877 0 1.614-.315 2.191-.942.004-.008.012-.012.016-.02.197-.239.425-.455.665-.687.163-.155.33-.319.493-.49.376-.391.574-.847.574-1.314 0-.471-.201-.924-.585-1.303l-2.086-2.094zm1.36 4c-.004 0-.004.005 0 0-.148.16-.3.305-.463.464-.247.236-.498.483-.733.76-.384.41-.836.604-1.429.604-.057 0-.118 0-.175-.004-1.128-.072-2.176-.513-2.963-.889a16.875 16.875 0 01-5.607-4.391C2.919 10.132 2.053 8.689 1.48 7.139c-.354-.946-.483-1.683-.426-2.379.038-.444.209-.813.524-1.128l1.296-1.295c.186-.175.383-.27.577-.27.24 0 .433.144.555.266l.011.011c.232.217.452.44.684.68.118.122.24.243.361.369L6.099 4.43c.403.403.403.775 0 1.178-.11.11-.216.22-.327.326-.319.327-.623.63-.953.927-.008.008-.015.012-.02.02-.326.326-.265.645-.197.862l.012.034c.27.653.65 1.269 1.227 2.002l.004.004c1.048 1.291 2.154 2.298 3.373 3.07.156.098.315.178.467.254.137.068.266.133.377.201.015.008.03.02.045.027.13.064.25.095.376.095.316 0 .513-.198.578-.262l1.299-1.3c.13-.129.334-.285.574-.285.235 0 .429.149.547.278l.007.007 2.094 2.094c.39.387.39.786.003 1.189zM9.727 4.282c.995.167 1.9.638 2.621 1.36a4.842 4.842 0 011.36 2.621.51.51 0 00.505.426c.03 0 .058-.004.088-.008a.513.513 0 00.421-.593 5.86 5.86 0 00-1.644-3.172 5.86 5.86 0 00-3.173-1.645.516.516 0 00-.592.418.507.507 0 00.414.593zM17.98 7.94a9.64 9.64 0 00-2.71-5.223 9.64 9.64 0 00-5.223-2.71.511.511 0 10-.167 1.011c1.77.3 3.385 1.14 4.669 2.42a8.606 8.606 0 012.42 4.67.51.51 0 00.505.425c.03 0 .057-.004.087-.008a.503.503 0 00.418-.585z"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h18v18H0z"></path></clipPath></defs></svg>
                            <?php echo phone(settings_id($GLOBALS['city'])[0]['phone2']); ?>
                        </a>
                    </div>

                    <a href="#" class="block-price__btn btn btn-orange btn-size_full buy">Заказать в 1 клик</a>

                    <noindex>
                        <p style="display: none;" class="product_info">
                            <? echo $arrProduct['title']; ?> [<? echo $arrProduct['id']; ?>] 
                            <?php echo $url; ?>
                        </p>
                    </noindex>

                    <div class="block-price__info">
                        <p class="block-price__info-p"> <img src="/images/catalog/delivery.svg" alt=""> Доставка в Новосибирск от <?php echo settings_id($GLOBALS['city'])[0]['delivery']; ?> рублей</p>
                        <p class="block-price__info-p"> <img src="/images/catalog/location.svg" alt=""> 1200+ пунктов выдачи по всей России</p>
                        <p class="block-price__info-p"> <img src="/images/catalog/surface1.svg" alt=""> Гарантия подлинности</p>
                        
                    </div>

                </div>


                <?php if($arrProduct['video_url']) { ?>
                    <a href="<? echo $arrProduct['video_url']; ?>" data-url="<? echo $arrProduct['video_url']; ?>" target="_blank" class="review">
                        <img src="/images/catalog/youtube.svg" alt="">
                        <p class="review__text">Смотреть видеоотзыв нашего покупателя о данном товаре</p>
                    </a>
                <?php } ?>

               
            </div>
        </div>
    </div>
</section>

<div class="tabs product-tabs" id="char">            
    <div class="tabs__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tabs__header">
                        <ul class="tabs__list tab-header tab-catalog">
                            <li class="tabs__item">
                                <a href="#" class="tabs__link link--black tab-header__item js-tab-trigger" data-tab="1">Обзор</a>
                            </li>
                            <li class="tabs__item">
                                <a href="#" class="tabs__link link--black tab-header__item js-tab-trigger" data-tab="2">Особенности</a>
                            </li>
                            <li class="tabs__item">
                                <a href="#" class="tabs__link link--black tab-header__item js-tab-trigger" data-tab="3">Характеристики</a>
                            </li>
                            <li class="tabs__item">
                                <a href="#" class="tabs__link link--black tab-header__item js-tab-trigger" data-tab="4">Документация</a>
                            </li>
                        </ul>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="special__body"> 
        <div class="container">
            <div class="tab-content js-tab-content def-content" data-tab="1">
                <div class="row">
                    <div class="col-lg-12">
                        <h6>О товаре</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo htmlspecialchars_decode($arrProduct['content']); ?>
                    </div>
                </div>
            </div>

            <div class="tab-content js-tab-content def-content" data-tab="2">
                <div class="row">
                    <div class="col-lg-12">
                        <h6>Особенности</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo htmlspecialchars_decode($arrProduct['content2']); ?>
                    </div>
                </div>
            </div>

            <div class="tab-content js-tab-content def-content" data-tab="3">
                <div class="row">
                    <div class="col-lg-12">
                        <h6>Характеристики</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="product-info__list list-catalog">
                            <?php
                                $i = 0;
                                foreach(characters_products_id($arrProduct['id']) as $key_tag => $value_tag) {
                                    if($i < 8) {
                                        ?>
                                            <li>
                                                <p><? echo $value_tag['name']; ?></p>
                                                <div class="dotted"></div>
                                                <p><? echo $value_tag['value']; ?></p>
                                            </li>
                                        <?
                                    $i++;
                                    }
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-content js-tab-content def-content" data-tab="4">
                <div class="row">
                    <div class="col-lg-12">
                        <h6>Документация</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <?php echo htmlspecialchars_decode($arrProduct['content3']); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include $path.'/../modules/special.php'; ?>


<?
                } else {
                    header("HTTP/1.0 404 Not Found");
                    include 'pages/404.php';
                    exit();
                }
            } else { 
                $title = $title_category;
?>
<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>
<?php include $path.'/../modules/breadcrumbs.php'; ?>


<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <h1>Каталог товаров</h1>
                    </div>
                    <div class="sort">
                        <form action="/" class="selector">
                            <input type="hidden" name="page" value="catalog">
                            <?php 
                                if($_GET['catalog']) {
                                    ?>
                                        <input type="hidden" name="catalog" value="<?php echo $_GET['catalog']; ?>">
                                    <?
                                }
                            ?>
                            <input type="hidden" name="sort" value="1" class="selector__value">
                            <div><p>Сортировать:</p><span><? echo $arr_sort[$getSort]; ?></span></div>
                            <ul>
                                <?php
                                    foreach ($arr_sort as $key => $value) {
                                        ?>
                                            <li data-id="<?php echo $key; ?>"><?php echo $value; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </form>
                    </div>
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
                            <button class="special__btn link link--blue">
                                Показать всё
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#007AFF"></path></svg>
                            </button>
                            <ul class="special__list tab-header">
                                <li class="special__item">
                                    <a href="/catalog" class="special__link link--black tab-header__item">Все товары <sup><? echo productsCount(); ?></sup></a>
                                </li>
                                <?php

                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);
                                        
                                    while($row = mysqli_fetch_array($result)) {
                                        if($row['name'] == $category) {
                                            echo '<li class="special__item" data-id="'.$row['id'].'">';
                                            echo '<a href="/catalog/'.$row['name'].'" class="special__link link--black tab-header__item active">'.$row['title'].' <sup>'.productsCountCategory($row['id']).'</sup></a>';
                                            echo '</li>';
                                        } else {
                                            echo '<li class="special__item" data-id="'.$row['id'].'">';
                                            echo '<a href="/catalog/'.$row['name'].'" class="special__link link--black tab-header__item">'.$row['title'].' <sup>'.productsCountCategory($row['id']).'</sup></a>';
                                            echo '</li>';
                                        }
                                    }
                                ?>             
                            </ul>
    
                            <div class="special__nagigate">

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

                        $url_page = '/?page=catalog&catalog='.$category.'&sort='.$getSort.'&num=';

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
                        $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `category` = '$id_category' $sort_txt LIMIT $start, $num");    
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
                                            <?php echo gallery('products', $idstr, 0, 1, 'small', $postrow[$in]['title'], false, true); ?>
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
                                                                <foreignObject x="4" y="0" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                                    <span class="price__seil-text" xmlns="http://www.w3.org/1999/xhtml">-<?php echo round($sale); ?>%</span>
                                                                </foreignObject>
                                                            </svg>
                                                        </p>
                                                    <?php
                                                } 
                                            ?>
                                            <?php 
                                                if($postrow[$in]['price']) {
                                                    ?>
                                                        <h6 class="price__price"><? echo number_format($postrow[$in]['price'], 0, '.', ' '); ?> ₽</h6>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <h6 class="price__price-text">Цена по запросу</h6>
                                                    <?php
                                                }
                                            ?>
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

<?php include $path.'/../modules/special_product.php'; ?>

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
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <h1>Каталог товаров</h1>
                    </div>
                    <div class="sort">
                        <form action="/" class="selector">
                            <input type="hidden" name="page" value="catalog">
                            <?php 
                                if($_GET['catalog']) {
                                    ?>
                                        <input type="hidden" name="catalog" value="<?php echo $_GET['catalog']; ?>">
                                    <?
                                }
                            ?>
                            <input type="hidden" name="sort" value="1" class="selector__value">
                            <div><p>Сортировать:</p><span><? echo $arr_sort[$getSort]; ?></span></div>
                            <ul>
                                <?php
                                    foreach ($arr_sort as $key => $value) {
                                        ?>
                                            <li data-id="<?php echo $key; ?>"><?php echo $value; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </form>
                    </div>
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
                            <button class="special__btn link link--blue">
                                Показать всё
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#007AFF"></path></svg>
                            </button>
                            <ul class="special__list tab-header">
                                <li class="special__item">
                                    <a href="/catalog" class="special__link link--black tab-header__item active">Все товары <sup><? echo productsCount(); ?></sup></a>
                                </li>
                                <?php
                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);
                                        
                                    while($row = mysqli_fetch_array($result)) {
                                        echo '<li class="special__item" data-id="'.$row['id'].'">';
                                        echo '<a href="/catalog/'.$row['name'].'" class="special__link link--black tab-header__item">'.$row['title'].' <sup>'.productsCountCategory($row['id']).'</sup></a>';
                                        
                                        
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
                        if($_GET['num']) {
                            $url_page = $_SERVER['REQUEST_URI'].'&sort='.$getSort.'&num=';
                        } else {
                            $url_page = '/?page=catalog&sort='.$getSort.'&num=';
                        }

                        //$url_page = '/?page=catalog&num=';

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
                        $result0 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `city_id` = '$city_products' $sort_txt LIMIT $start, $num");    
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
                                            <?php echo gallery('products', $idstr, 0, 1, 'small', $postrow[$in]['title'], false, true); ?>
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
                                                                <foreignObject x="4" y="0" width="30" height="18" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                                    <span class="price__seil-text" xmlns="http://www.w3.org/1999/xhtml">-<?php echo round($sale); ?>%</span>
                                                                </foreignObject>
                                                            </svg>
                                                        </p>
                                                    <?php
                                                } 
                                            ?>
                                            <?php 
                                                if($postrow[$in]['price']) {
                                                    ?>
                                                        <h6 class="price__price"><? echo number_format($postrow[$in]['price'], 0, '.', ' '); ?> ₽</h6>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <h6 class="price__price-text">Цена по запросу</h6>
                                                    <?php
                                                }
                                            ?>
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

<?php include $path.'/../modules/special.php'; ?>


<?
    }

