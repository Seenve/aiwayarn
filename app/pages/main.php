<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php /* ?>

                                <div class="maincont page-styling page-full">
        

<div class="hero-sliderblock" style="background-image: url('/img/shapka.jpg');">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <!--<p class="hero-sliderblock-subttl">
                    <a href="catalog-gallery.html">Магазин спортивного питания</a>
                </p>-->
                <h3 class="hero-sliderblock-ttl">Бесплатная доставка при покупке от 1000 &#8381;</h3>
                <a href="/catalog" class="btn" data-pjax="content">Каталог товаров</a>
            </div>
        </div>
    </div>
</div>

<?php
    $city_main = $GLOBALS['city'];
    $query_products_top = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `city_id` = '$city_main' AND `favorite` = '1' ORDER BY `id` LIMIT 0, 3"); 
    if(mysqli_num_rows($query_products_top) > 0) {
    ?>
<div class="container mb60 page-styling row-wrap-container row-wrap-nottl">
    <p class="maincont-subttl">Специальное предложение</p>
    <h2 class="mb35 heading-multishop">Топ продаж</h2>
    <div class="row prod-items prod-items-3">
    <?
        while($row_products_top = mysqli_fetch_assoc($query_products_top)) {
            //$idstr = $row_products_top['product_id'];
            $idstr = $row_products_top['id'];
            $postrow = array();
            $postrow[0] = products_id($idstr);
            $in = 0;    
        ?>
            <article class="cf-sm-6 cf-md-4 cf-lg-4 col-xs-6 col-sm-6 col-md-4 col-lg-4 sectgl-item">
                <div class="sectgl prod-i">
                    <div class="prod-i-top">
                        <a class="prod-i-img" href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>">
                            <img src="/uploads/small/<?php echo gallery_arr('products', $idstr, '1')['0']['image']; ?>" alt="">
                        </a>
                        <div class="prod-i-actions">
                            <div class="prod-i-actions-in">
                                <div class="prod-li-favorites">
                                    <a href="#" class="hover-label add_to_wishlist add_like" data-id="<? echo $idstr; ?>"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                                </div>
                                <p class="prod-i-cart">
                                    <a href="#" class="hover-label prod-addbtn add_cart" data-id="<? echo $idstr; ?>"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                                </p>
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
                            <p class="prod-i-categ"><a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>"><? echo productsCategory($postrow[$in]['category'])['title']; ?></a></p>
                        </div>
                        <h3 class="prod-i-ttl">
                            <a href="/catalog/<? echo productsCategory($postrow[$in]['category'])['name']; ?>/<?php echo $postrow[$in]['name']; ?>"><?php echo $postrow[$in]['title']; ?></a>
                        </h3>
                    </div>
                </div>
            </article>
        <?
        }
    ?>
    </div>
    <!--<p class="special-more">
        <a class="special-more-btn" href="#">Показать больше</a>
    </p>-->
</div>
    <?
    }
?> 

          <!--                         
<article class="cf-sm-6 cf-md-4 cf-lg-4 col-xs-6 col-sm-6 col-md-4 col-lg-4 sectgl-item">
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
                    <p class="prod-quickview">
                        <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                    </p>
                    <p class="prod-i-cart">
                        <a href="#" class="hover-label prod-addbtn"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                    </p>
                </div>
            </div>
            <p class="prod-i-badge"><span>Распродажа</span></p>
            <p class="prod-i-badge"><span class="badge-1">Top seller</span></p>
        </div>
        <div class="prod-i-bot">
            <div class="prod-i-info">
                <p class="prod-i-price"><s>93.00</s> 70.00 &#8381;</p>
                <p class="prod-i-categ"><a href="catalog-gallery.html">Протеин</a></p>
            </div>
            <h3 class="prod-i-ttl"><a href="product.html">Steel Power Fast Whey Protein</a></h3>
        </div>
    </div>
</article>                    
<article class="cf-sm-6 cf-md-4 cf-lg-4 col-xs-6 col-sm-6 col-md-4 col-lg-4 sectgl-item">
    <div class="sectgl prod-i">
        <div class="prod-i-top">
            <a class="prod-i-img" href="product.html">
                <img src="https://static-eu.insales.ru/images/collections/1/534/1819158/large_Gold-Standard_Gainer_5lb_2270gr_Optimum_Nutrition.jpg" alt="">
            </a>
            <div class="prod-i-actions">
                <div class="prod-i-actions-in">
                    <div class="prod-li-favorites">
                        <a href="wishlist.html" class="hover-label add_to_wishlist"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                    </div>
                    <p class="prod-quickview">
                        <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                    </p>
                    <p class="prod-i-cart">
                        <a href="#" class="hover-label prod-addbtn"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                    </p>
                </div>
            </div>
                    </div>
        <div class="prod-i-bot">
            <div class="prod-i-info">
                <p class="prod-i-price">24.00 &#8381;</p>
                <p class="prod-i-categ"><a href="catalog-gallery.html">Гейнеры</a></p>
            </div>
            <h3 class="prod-i-ttl"><a href="product.html">Ultimate Nutrition Muscle Juice Revolution</a></h3>
        </div>
    </div>
</article>                    
<article class="cf-sm-6 cf-md-4 cf-lg-4 col-xs-6 col-sm-6 col-md-4 col-lg-4 sectgl-item">
    <div class="sectgl prod-i">
        <div class="prod-i-top">
            <a class="prod-i-img" href="product.html">
                <img src="https://static-eu.insales.ru/images/collections/1/7215/1834031/large_Amin-X_Blue_Raz.jpg" alt="">
            </a>
            <div class="prod-i-actions">
                <div class="prod-i-actions-in">
                    <div class="prod-li-favorites">
                        <a href="wishlist.html" class="hover-label add_to_wishlist"><i class="icon ion-heart"></i><span>Нравиться</span></a>
                    </div>
                    <p class="prod-quickview">
                        <a href="#" class="hover-label quick-view"><i class="icon ion-plus"></i><span>Быстрый просмотр</span></a>
                    </p>
                    <p class="prod-i-cart">
                        <a href="#" class="hover-label prod-addbtn"><i class="icon ion-android-cart"></i><span>Добавить в корзину</span></a>
                    </p>
                </div>
            </div>
            <p class="prod-i-badge"><span class="badge-1">Топ продаж</span></p>
        </div>
        <div class="prod-i-bot">
            <div class="prod-i-info">
                <p class="prod-i-price">150.00 &#8381;</p>
                <p class="prod-i-categ"><a href="catalog-gallery.html">Аминокислоты</a></p>
            </div>
            <h3 class="prod-i-ttl"><a href="product.html">Ultimate Nutrition BCAA 12000</a></h3>
        </div>
        <div class="buttons">
            <a class="special-more-btn" href="#">Показать больше</a>
        </div>
    </div>
</article>   -->         


<div class="container mb40 page-styling row-wrap-container row-wrap-nottl front-icons">
    <div class="row">
        <div class="cf-lg-4 col-sm-4">
            <div class="iconbox-item iconbox-i">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <span>1</span>
                    </p>
                    <h3>Поиск</h3>
                </div>
                <p>На нашем сайте реализован удобный поиск товаров по большому ассортименту спортпита, но если у Вас возникли трудности с выбором, то мы всегда готовы придти на помощь, а также сформировать индивидуальный заказ в соответствии с вашими потребностями.</p>
            </div>
        </div>
        <div class="cf-lg-4 col-sm-4">
            <div class="iconbox-item iconbox-i">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <span>2</span>
                    </p>
                    <h3>Заказ</h3>
                </div>
                <p>Вы можете купить спортивное питание в интернет-магазине «Пик Формы», сохраняя уверенность в его качестве, а квалифицированный персонал нашего магазина сопроводит ваш заказ от А до Я.</p>
            </div>
        </div>
        <div class="cf-lg-4 col-sm-4">
            <div class="iconbox-item iconbox-i">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <span>3</span>
                    </p>
                    <h3>Доставка</h3>
                </div>
                <p>Наш магазин осуществляет доставку спортивного питания по всем регионам России. Мы контролируем все этапы от упаковки, отправки и вручения прямо в руки счастливым покупателям.</p>
            </div>
        </div>
    </div>
</div>


<div class="page-styling row-wrap-full front-image-half">
    <section class="image-half image-half-right">
        <div class="image-half-img" style="background-image: url('img/1/front/bg1.jpg');">
            <img src="img/1/front/bg1.jpg" alt="">
        </div>
        <div class="cont image-half-cont">
            <div class="image-half-inner">
                <p class="maincont-subttl">Бестселлеры</p>
                <h2>Лучшие предложения</h2>
                <div class="wpb_text_column wpb_content_element ">
                    <div class="wpb_wrapper">
                        <p>В нашем магазине представлен каскад средств для набора и снижения массы, восстановления и поддержки иммунитета – для каждого случая найдется свой продукт. При этом цены на спортпит в интернет-магазине «Пик Формы» остаются доступными. Более того, предусмотрен специальный раздел, в котором представлены товары со скидкой.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<div class="page-styling row-wrap-full front-image-half">
    <section class="image-half image-half-left">
        <div class="image-half-img" style="background-image: url('img/1/front/bg2.jpg');">
            <img src="img/1/front/bg2.jpg" alt="">
        </div>
        <div class="cont image-half-cont">
            <div class="image-half-inner">
                <h2>Спортивное питание <br>со скидкой</h2>
                <form method="post" class="mb55 wpcf7 wpcf7-form ajax">
                    <input type="hidden" name="form" value="Спортивное питание со скидкой">
                    <p class="form-submit">
                        <span class="wpcf7-form-control-wrap">
                            <input type="email" name="email" placeholder="Ваш E-mail">
                        </span>
                        <input type="submit" value="Получить скидку">
                    </p>
                </form>
            </div>
        </div>
    </section>
</div>


<!--
<div class="container page-styling row-wrap-container row-wrap-nottl">
    <div class="multishop_product_categories">
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat1.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat2.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat3.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat4.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat5.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat6.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
        <div class="multishop_product_categories_item">
            <a href="catalog-gallery.html">
                <span class="frontcategs-img">
                    <img src="img/1/front/cat7.png" alt="">
                </span>
                <p>Lorem ipsum dolor.</p>
            </a>
        </div>
    </div>
</div>
-->

<!--
<div class="container page-styling row-wrap-container row-wrap-nottl kach">
    <div class="row">
        <div class="cf-lg-6 col-sm-6">
            <div class="mb30 iconbox-item iconbox-i-4">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <i class="fa fa-heart"></i>
                    </p>
                    <h3><a href="#">Lorem ipsum dolor.</a></h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia earum id libero, quas porro qui, consequuntur unde excepturi quo neque quia cum fuga voluptas. Fugit labore eius nihil nisi natus.</p>
            </div>
            <div class="mb30 iconbox-item iconbox-i-4">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <i class="fa fa-plus-circle"></i>
                    </p>
                    <h3><a href="#">Lorem ipsum dolor.</a></h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia earum id libero, quas porro qui, consequuntur unde excepturi quo neque quia cum fuga voluptas. Fugit labore eius nihil nisi natus.</p>
            </div>
        </div>
        <div class="cf-lg-6 col-sm-6">
            <div class="mb30 iconbox-item iconbox-i-4">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <i class="fa fa-star"></i>
                    </p>
                    <h3><a href="#">Lorem ipsum dolor.</a></h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia earum id libero, quas porro qui, consequuntur unde excepturi quo neque quia cum fuga voluptas. Fugit labore eius nihil nisi natus.</p>
            </div>
            <div class="mb30 iconbox-item iconbox-i-4">
                <div class="iconbox-i-top">
                    <p class="iconbox-i-img">
                        <i class="fa fa-check"></i>
                    </p>
                    <h3><a href="#">Lorem ipsum dolor.</a></h3>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia earum id libero, quas porro qui, consequuntur unde excepturi quo neque quia cum fuga voluptas. Fugit labore eius nihil nisi natus.</p>
            </div>
        </div>
    </div>
</div>
-->
<div class="page-styling row-wrap-full align-center front-title-block">
    <h2>Не нашли нужный товар?</h2>
    <h4>Свяжитесь с нами</h4>
    <a class="mb40 btn-multishop" href="/contacts" data-pjax="content">Узнать больше</a>
</div>



                    </div><!-- .maincont.page-styling.page-full -->




*/ 
?>

    <h1 style="height: 0;line-height: 0;overflow: hidden;">Качественная пряжа из шерсти</h1>

    <section class="hero"> 
        <div class="owl-carousel owl-theme hero-slider">

            <?
                $query_slides = mysqli_query($GLOBALS['db'], "SELECT * FROM `slides` ORDER BY regdate DESC");
                $i = 0;
                while($row_slides = mysqli_fetch_array($query_slides)) {
                    $i++;
                    ?>
                        <div class="hero__inner">
                            <?php echo gallery('slides', $row_slides['id'], 0, 1, 'full', $row_slides['title'], true, false); ?>
                            <div class="hero__slide">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6">
                                            <div class="hero-slider__offer">
                                                <h2 class="hero-slider__title">
                                                    <?php echo $row_slides['title']; ?>
                                                </h2>
                                                <div class="hero-slider__content">
                                                    <?php echo htmlspecialchars_decode($row_slides['content']); ?>
                                                </div>
                                                <a href="<?php echo $row_slides['site']; ?>" class="hero-slider__offer-btn btn btn-purple btn-size_m" data-pjax="content">Подробнее <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#ffffff"></path></svg></a>
                                            </div>
                                        </div>

                                        <!--<div class="col-md-6 col-lg-5 ml-md-auto">
                                            <div class="hero-slider__block-img">
                                                <svg viewbox="0 0 100% 100%" class="star" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <style>
                                                    @media screen and (max-width: 1200px) {
                                                        .star {
                                                            width: 50px;
                                                            transform: scale(.8);
                                                        }
                                                    }
                                                </style>
                                                    <path class="star__path" d="M91.065 21.15a20 20 0 0118.341 7.257l13.851 17.186 13.577 17.403a20 20 0 012.886 19.512l-7.957 20.588-8.284 20.459a20.003 20.003 0 01-15.454 12.256l-21.81 3.403-21.86 3.056a20.001 20.001 0 01-18.34-7.257l-13.851-17.185-13.577-17.403a20.001 20.001 0 01-2.886-19.512l7.957-20.589 8.284-20.459A20 20 0 0147.397 27.61l21.808-3.403 21.86-3.056z" fill="#007AFF"/>                                        
                                                        <switch class="star__text"> 
                                                            <foreignObject x="35px" y="-10px" width="102px" height="98px" requiredFeatures="http://www.w3.org/TR/SVG11/feature#Extensibility">
                                                                <div class="star__block">
                                                                    <?php echo htmlspecialchars_decode($row_slides['content']); ?>        
                                                                </div>
                                                            </foreignObject>
                                                        </switch>                                           
                                                </svg>
                                                <a href="<?php echo $row_slides['site']; ?>" class="hero-slider__btn btn btn-purple btn-size_m d-flex d-md-none" data-pjax="content">Подробнее</a>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?
                }
            ?>

        </div>    
        <div class="container">
            <div class="row">
                <div class="col-xxl-12 hero-slider__nav">
                    <div class="hero-slider__navigation d-none d-md-flex">
                        <button type="button" class="prev link--blue">
                            <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.32 5.997l4.488 4.49A.65.65 0 018 10.95c0 .176-.068.34-.192.464l-.393.393a.651.651 0 01-.464.192.651.651 0 01-.464-.192L1.142 6.463a.651.651 0 01-.192-.465c0-.177.068-.342.192-.466l5.34-5.34A.651.651 0 016.946 0c.176 0 .34.068.464.192l.393.393a.657.657 0 010 .928L3.32 5.997z" fill="#2F3540"/></svg>
                        </button>
                        <button type="button" class="next link--blue">
                            <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#2F3540"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> 

    <?php include $path.'/../modules/banner.php'; ?>

    <section class="new-products">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="new-products__header">
                        <h4 class="new-products__header-title">Новые поступления</h4>
                        <div class="owl-navigate new-products-navigate">
                            <button type="button" class="prev link--blue">
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.32 5.997l4.488 4.49A.65.65 0 018 10.95c0 .176-.068.34-.192.464l-.393.393a.651.651 0 01-.464.192.651.651 0 01-.464-.192L1.142 6.463a.651.651 0 01-.192-.465c0-.177.068-.342.192-.466l5.34-5.34A.651.651 0 016.946 0c.176 0 .34.068.464.192l.393.393a.657.657 0 010 .928L3.32 5.997z" fill="#2F3540"></path></svg>
                            </button>
                            <button type="button" class="next link--blue">
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#2F3540"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="new-products__list">
                <div class="owl-carousel new-products-carousel owl-theme">
                    <?php
                        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` ORDER BY `id` DESC LIMIT 0, 12");
                        while ($row = mysqli_fetch_array($query)) {
                            $productArr = $row;
                            $productArr['slider'] = true;
                            include $path.'/../modules/catalog_product.php';
                        }
                    ?>     
                </div>
            </div>
        </div>
    </section>

    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="news__header">
                        <h4 class="news__header-title">Новости магазина</h4>
                        <div class="owl-navigate news-navigate">
                            <button type="button" class="prev link--blue">
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.32 5.997l4.488 4.49A.65.65 0 018 10.95c0 .176-.068.34-.192.464l-.393.393a.651.651 0 01-.464.192.651.651 0 01-.464-.192L1.142 6.463a.651.651 0 01-.192-.465c0-.177.068-.342.192-.466l5.34-5.34A.651.651 0 016.946 0c.176 0 .34.068.464.192l.393.393a.657.657 0 010 .928L3.32 5.997z" fill="#2F3540"></path></svg>
                            </button>
                            <button type="button" class="next link--blue">
                                <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#2F3540"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="news__list">
                <div class="owl-carousel news-carousel owl-theme">
                    <?php
                        $query_article = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` ORDER BY `regdate` DESC LIMIT 0, 12");    
                        while ($row_article = mysqli_fetch_array($query_article)) {
                            if($row_article['id'] > $pageId) {
                                ?>
                                    <div class="news__item">
                                        <a href="/news/<?php echo $row_article['name']; ?>" class="news__link" data-pjax="content">
                                            <div class="news__block-img">
                                                <?php echo gallery('news', $row_article['id'], 0, 1, 'small', $row_article['title']); ?>
                                            </div>
                                            <div class="news__content">
                                                <span class="news__date">
                                                    <svg class="news__icon" width="16" height="17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.47 10.279L8.24 8.606V5.197a.62.62 0 10-1.24 0v3.718c0 .196.092.38.248.496l2.479 1.86a.616.616 0 00.867-.125.619.619 0 00-.124-.867z" fill="#818181"/><path d="M8 .578c-4.411 0-8 3.588-8 8 0 4.411 3.589 8 8 8 4.412 0 8-3.589 8-8 0-4.412-3.588-8-8-8zm0 14.76a6.769 6.769 0 01-6.76-6.76A6.769 6.769 0 018 1.817a6.769 6.769 0 016.76 6.76A6.769 6.769 0 018 15.339z" fill="#818181"/></svg>
                                                    <time datetime="<? $date = strtotime($row_article['regdate']); echo date("Y-m-d H:i", $date); ?>"><? $date = strtotime($row_article['regdate']); echo date("d M Y", $date); ?></time>
                                                </span>
                                                <h6 class="news__title"><?php echo $row_article['title']; ?></h6>
                                                <?php /*echo  mb_substr(strip_tags(htmlspecialchars_decode($postrow[$in]['content'])), 0, 340, 'UTF-8').'...';*/ ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <a href="/news" class="btn btn-purple btn-size_m news__btn" data-pjax="content">Все новости</a>
        </div>
    </section>