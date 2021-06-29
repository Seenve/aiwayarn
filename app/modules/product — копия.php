<?php
    function printImage($imageName = '', $title = '') {
        $explode = explode(".", $imageName);
        $image = $explode[0];
        if($image) {
            ?>
                <div class="swiper-slide">
                    <a href="/uploads/images/jpeg/<? echo $image; ?>-1920x1080.jpeg" data-fancybox="images">
                        <?php echo galleryImage($image, 'middle', $title); ?>
                    </a>
                </div>
            <?
        }
    }
    function printNoImage($image) {
        ?>
            <div class="swiper-slide">
                <a href="#">
                    <picture>
                        <img srcset="/ap/assets/images/no-image.svg"> 
                    </picture>
                </a>
            </div>
        <?
    }
    function printImageThumb($imageName = '', $title = '') {
        $explode = explode(".", $imageName);
        $image = $explode[0];
        if($image) {
            ?>
                <div class="swiper-slide">
                    <?php echo galleryImage($image, 'thumb', $title); ?>
                </div>
            <?
        }
    }
    function printNoImageThumb() {
        ?>
            <div class="swiper-slide">
                <picture>
                    <img srcset="/ap/assets/images/no-image.svg"> 
                </picture>
            </div>
        <?
    }
    function printImageSelect($imageName = '', $title = '') {
        $explode = explode(".", $imageName);
        $image = $explode[0];
        if($image) {
            ?>
                <?php echo galleryImage($image, 'thumb', $title); ?>
            <?
        }
    }
    function printNoImageSelect() {
        ?>
            <picture>
                <img srcset="/ap/assets/images/no-image.svg"> 
            </picture>
        <?
    }
?>

<?php $productMods = product_mods($GLOBALS['city'], $product['uid']); ?>
<section class="product" data-product="<? echo $product['id']; ?>">
    <div class="container">
        <div class="product__block-text">
            <h1 class="product__title"><? echo $product['title']; ?></h1>
            <p class="product__articule">Артикул: <? echo $product['id']; ?></p>
        </div>
        <div class="row">
            <div class="col-lg-5">
                <div class="product__cart slider-cart">
                    <div class="swiper-container-wrapper">
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">

                                <?
                                    $productMods = product_mods($GLOBALS['city'], $product['uid']);
                                    if(count($productMods) > 0) {
                                        foreach ($productMods as $key => $value) {
                                            printImageThumb(gallery_arr('products_mod', $value['id'], '1')[0]['image'], $product['title']);
                                        }
                                    } else {
                                        if(count(gallery_arr('products', $product['id'], '1')) > 0) {
                                            $num_image = 0;
                                            foreach (gallery_arr('products', $product['id'], '1') as $key => $value) {
                                                printImageThumb($value['image'], $product['title']);
                                                $num_image++;
                                            }
                                        } else {
                                            printNoImageThumb();
                                        }
                                    }
                                ?>


                            </div>
                        </div>
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper">
                                <?
                                    if(count($productMods) > 0) {
                                        foreach ($productMods as $key => $value) {
                                            printImage(gallery_arr('products_mod', $value['id'], '1')[0]['image'], $product['title']);
                                        }
                                    } else {
                                        if(count(gallery_arr('products', $product['id'], '1')) > 0) {
                                            $num_image = 0;
                                            foreach (gallery_arr('products', $product['id'], '1') as $key => $value) {
                                                printImage($value['image'], $product['title']);
                                                $num_image++;
                                            }
                                        } else {
                                            printNoImage();
                                        }
                                    }
                                ?>
                            </div>
                            <!-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-info">
                    <div>
                        <h6 class="product-info__title">Характеристики</h6>
                        <ul class="product-info__list list-catalog">
                            <?php
                                foreach(characters_products_id($product['id'], 8) as $key_tag => $value_tag) {
                                    ?>
                                        <li>
                                            <p><? echo $value_tag['name']; ?></p>
                                            <div class="dotted"></div>
                                            <p><? echo $value_tag['value']; ?></p>
                                        </li>
                                    <?
                                }
                            ?>
                        </ul>
                        <a href="#char" class="product-info__link link link--hevered">Все характеристики</a>
                    </div>
                    <!--<span class="product-info__small"><?php echo htmlspecialchars_decode($product['description']); ?></span>-->
                    <?php 

                        $input = product_mod($GLOBALS['city'], $product['id']);
                        //var_dump($input);

                        foreach (mergeByKey($input, 'name') as $key => $value) {
                    ?>
                    <!--<div class="variations-row">
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
                    </div>-->
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
                    </div>
                    <div class="f-select">
                        <div class="lab" style="display: none;">Выбрать</div>
                        <div>
                            <label class="checkbox">Эконом-класс<input type="checkbox" name="mg[]" value="1"><span class="checkmark"></span></label>
                            <label class="checkbox">Комфорт-класс<input type="checkbox" name="mg[]" value="2"><span class="checkmark"></span></label>
                            <label class="checkbox">Бизнес-класс<input type="checkbox" name="mg[]" value="3"><span class="checkmark"></span></label>
                            <label class="checkbox">Элит-класс<input type="checkbox" name="mg[]" value="4"><span class="checkmark"></span></label>                             
                        </div>
                    </div>-->
                    <?
                        }
                    ?>

                    <hr>

                    <?php

                        if(count($productMods) > 0) {
                            echo '<div class="variations">';
                            foreach ($productMods as $key => $value) {
                                ?>
                                    <div class="variations__select" data-id="<?php echo $value['id']; ?>">
                                        <?php 
                                            if($image = gallery_arr('products_mod', $value['id'], '1')[0]['image']) {
                                                printImageSelect($image, $product['title']);
                                            } else {
                                                printNoImageSelect();
                                            }
                                            //echo gallery_arr('products_mod', $value['id'], '1')[0]['image']; galleryImage($image, 'thumb', $title); 
                                        ?>
                                    </div>
                                <?
                            }
                            echo '</div>';
                        } else {
                            echo 'no mod';
                        }

                    ?>

                </div>
                
            </div>
            <div class="col-lg-3">

                <form class="block-price" class="ajax" method="GET">
                    <input type="hidden" name="product_mod" value="">
                    <div class="card__price block-price__total">
                        <?php 
                            if($product['old_price'] > $product['price']) {
                                $sale = 100 - ($product['price']*100/$product['old_price']);
                                ?>
                                    <p class="price__old-price block-price__old"><? echo number_format($product['old_price'], 0, '.', ' '); ?> ₽
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
                            if($product['price']) {
                                ?>
                                    <h6 class="price__price block-price__price"><? echo number_format($product['price'], 0, '.', ' '); ?> ₽</h6>
                                <?php
                            } else {
                                ?>
                                    <h6 class="price__price block-price__price-text">Цена по запросу</h6>
                                <?php
                            }
                        ?>
                    </div>

                    <!--<div class="block-price__contact">
                        <a href="tel:<?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?>" class="link link--black">
                            <svg class="" width="18.031" height="18" viewBox="0 0 18.031 17.969" aria-hidden="true"><path d="M673.56,155.153c-4.179-4.179-6.507-7.88-2.45-12.3l0,0a3,3,0,0,1,4.242,0l1.87,2.55a3.423,3.423,0,0,1,.258,3.821l-0.006-.007c-0.744.7-.722,0.693,0.044,1.459l0.777,0.873c0.744,0.788.759,0.788,1.458,0.044l-0.009-.01a3.153,3.153,0,0,1,3.777.264l2.619,1.889a3,3,0,0,1,0,4.243C681.722,162.038,677.739,159.331,673.56,155.153Zm11.17,1.414a1,1,0,0,0,0-1.414l-2.618-1.89a1.4,1.4,0,0,0-.926-0.241l0.009,0.009c-1.791,1.835-2.453,1.746-4.375-.132l-1.05-1.194c-1.835-1.878-1.518-2.087.272-3.922l0,0a1.342,1.342,0,0,0-.227-0.962l-1.87-2.549a1,1,0,0,0-1.414,0l-0.008-.009c-2.7,3.017-.924,6.1,2.453,9.477s6.748,5.54,9.765,2.837Z" transform="translate(-669 -142)"></path></svg>
                            <?php echo phone(settings_id($GLOBALS['city'])[0]['phone']); ?>
                        </a>
                        </a>
                    </div>-->

                    <div class="block-price__contact">
                        В наличии <?php $product['stock']; ?> шт.
                    </div>

                    <span class="block-price__label">Количество</span>
                    <div class="input-nums">
                        <div class="input-nums__arrow-right"><i class="fal fa-angle-left"></i></div>
                        <input type="number" name="nums" value="0">
                        <div class="input-nums__arrow-left"><i class="fal fa-angle-right"></i></div>
                    </div>

                    <!--<a href="#" class="block-price__btn btn btn-blue btn-size_full buy">Добавить в корзину</a>-->
                    <a href="/catalog/instrumenty/knit-pro/spicy-krugovye-nova-metal" class="card__btn btn btn-buy btn-size_full" data-pjax="content">Добавить в корзину</a>
                    <a href="/catalog/instrumenty/knit-pro/spicy-krugovye-nova-metal" class="card__btn btn btn-buy btn-transparent btn-size_full" data-pjax="content">Оформить заказ</a>

                    <noindex>
                        <p style="display: none;" class="product_info">
                            <? echo $product['title']; ?> [<? echo $product['id']; ?>] 
                            <?php echo $url; ?>
                        </p>
                    </noindex>

                    <div class="block-price__info">
                        <p class="block-price__info-p"><i class="fal fa-shipping-fast"></i>Быстрая доставка</p>
                        <p class="block-price__info-p"><i class="fal fa-credit-card"></i>Множество вариантов оплаты</p>
                        <p class="block-price__info-p"><i class="fal fa-percent"></i>Привлекательно низкие цены</p>
                        <p class="block-price__info-p"><i class="fal fa-thumbs-up"></i>Довольные клиенты</p>
                        
                    </div>

                </form>


                <?php if($product['video_url']) { ?>
                    <a href="<? echo $product['video_url']; ?>" data-url="<? echo $product['video_url']; ?>" target="_blank" class="review">
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
                                <a href="#" class="tabs__link link--black tab-header__item js-tab-trigger" data-tab="3">Характеристики</a>
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
                        <?php echo htmlspecialchars_decode($product['content']); ?>
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
                                foreach(characters_products_id($product['id']) as $key_tag => $value_tag) {
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

        </div>
    </div>
</div>


<?php 
exit();
 ?>

<?php var_dump($_GET['type']); ?>


<?php $productMods = product_mods($GLOBALS['city'], $product['uid']); ?>
<div class="cont maincont">      
    <article data-product="<? echo $product['uid']; ?>">
                <div class="prod">
                    <div class="prod-slider-wrap prod-slider-shown">
                        <?php //var_dump(product_mods($GLOBALS['city'], $product['uid'])); ?>
                        <div class="flexslider prod-slider" id="prod-slider">
                            <ul class="slides">
                                <?
                                    if(count($productMods) > 0) {
                                        foreach ($productMods as $key => $value) {
                                            printImage(gallery_arr('products_mod', $value['id'], '1')[0]['image'], $product['title']);
                                        }
                                    } else {
                                        if(count(gallery_arr('products', $product['id'], '1')) > 0) {
                                            $num_image = 0;
                                            foreach (gallery_arr('products', $product['id'], '1') as $key => $value) {
                                                printImage($value['image'], $product['title']);
                                                $num_image++;
                                            }
                                        } else {
                                            printNoImage();
                                        }
                                    }
                                ?>
                            </ul>
                            <div class="prod-slider-count"><p><span class="count-cur">1</span> / <span class="count-all"><? echo $num_image; ?></span></p><p class="hover-label prod-slider-zoom"><i class="icon ion-search"></i><span>Приблизить</span></p></div>
                        </div>
                        <div class="flexslider prod-thumbs" id="prod-thumbs">
                            <ul class="slides">
                                <?
                                    $productMods = product_mods($GLOBALS['city'], $product['uid']);
                                    if(count($productMods) > 0) {
                                        foreach ($productMods as $key => $value) {
                                            printImageThumb(gallery_arr('products_mod', $value['id'], '1')[0]['image'], $product['title']);
                                        }
                                    } else {
                                        if(count(gallery_arr('products', $product['id'], '1')) > 0) {
                                            $num_image = 0;
                                            foreach (gallery_arr('products', $product['id'], '1') as $key => $value) {
                                                printImageThumb($value['image'], $product['title']);
                                                $num_image++;
                                            }
                                        } else {
                                            printNoImageThumb();
                                        }
                                    }
                                ?>
                            </ul>
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
                        <!--<p class="prod-categs" style="display: flex;flex-wrap: wrap; justify-content: space-between;"><a href="/catalog/<? echo $category; ?>" data-pjax="content"><? echo $title_category; ?></a><small>Артикул <? echo $product['article']; ?></small></p>-->
                        <p class="prod-categs">Артикул <? echo $product['id']; ?></p>
                        <h1><? echo $product['title']; ?></h1>
                        <div class="variations_form cart">
                            <p class="prod-price"><? echo number_format($product['price'], 0, '.', ' '); ?> &#8381;</p>
                            <p class="prod-excerpt"><?php echo  mb_substr(strip_tags(htmlspecialchars_decode($product['content'])), 0, 340, 'UTF-8').'...'; ?> <a id="prod-showdesc" class="prod-excerpt-more" href="#">читать далее</a></p>
                            <?php 
                                if($product['stock'] > 0) {
                            ?>
                            <p>В наличии <?php echo $product['stock']; ?> шт</p>
                            <?php 
                                } 
                            ?>
                            <div class="prod-add">
                                <form class="variations select-mod-form">
                                    <?php 

                                        $input = product_mod($GLOBALS['city'], $product['id']);
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
                                   <div class="variations-row">
                                        <div class="label"><label>Цвет</label></div>
                                        <div class="value">
                                            <select>
                                                <option value="">Выберите цвет</option>
                                                <option value="blue">Синий</option>
                                                <option value="green">Зеленый</option>
                                                <option value="yellow">Желтый</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                                <?php 
                                    if($product['stock'] > 0) {
                                ?>
                                    <button type="submit" class="button add_cart<? if(cart($product['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo $product['id']; ?>" data-mod=""><i class="icon ion-android-cart"></i> <span></span></button>
                                <?
                                    } else {
                                        echo ' <p class="qnt-wrap prod-li-qnt">Товар отсутствует</p>';
                                    }
                                ?>
                                <p class="qnt-wrap prod-li-qnt">
                                    <a href="#" class="qnt-plus prod-li-plus"><i class="icon ion-arrow-up-b"></i></a>
                                    <input type="text" name="nums" value="1">
                                    <a href="#" class="qnt-minus prod-li-minus"><i class="icon ion-arrow-down-b"></i></a>
                                </p>
                                <div class="prod-li-favorites">
                                    <a href="#" class="hover-label add_like<? if(like($product['id'], $user_uid)) {echo ' active';} ?>" data-id="<? echo $product['id']; ?>"><i class="icon ion-heart"></i><span>Нравиться</span></a>
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
                            <?php echo htmlspecialchars_decode($product['content']); ?>
                        </div>
                        <p data-prodtab-num="2" class="prod-tab-mob" data-prodtab="#prod-tab-2">Характеристики</p>
                        <div class="prod-tab" id="prod-tab-2">
                            <dl class="prod-tab-props">
                                <?php
                                    foreach(characters_products_id($product['id']) as $key_tag => $value_tag) {
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
</div>