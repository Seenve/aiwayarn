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
                    <div class="slider__image">
                        <?php echo galleryImage($image, 'thumb', $title); ?>
                    </div>
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

<?php 
    $productMods = product_mods($GLOBALS['city'], $product['uid']);
    $stockArr = stock($product, $productMods);
    $modId = isset($_GET['mod']) ? $_GET['mod'] : '';
    $modId = val_string($modId);
    if($modId) {
        $modArr = products_mod($GLOBALS['city'], $modId);
        if(count($modArr) > 0) {
            $stockArr = stock($modArr, null);
        } else {
            $modId = 0;
        }
    } else {
        $modId = 0;
    }
?>
<section class="product <? if(!$stockArr['result']) {echo 'no-stock';} ?>" data-product="<? echo $product['id']; ?>">
    <div class="container">
        <div class="product__block-text">
            <h1 class="product__title"><? echo $product['title']; ?></h1>
            <p class="product__articule" id="articule">Артикул: <? echo $product['id']; ?></p>
        </div>
        <div class="row">
            <div class="col-lg-5">

                <div class="slider">
                    <div class="slider__flex">
                        <div class="slider__images">
                            <div class="swiper-container">
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
                            </div>
                        </div>
                        <div class="slider__col">
                            <div class="slider__prev"><i class="fal fa-angle-left"></i></div>
                            <div class="slider__thumbs">
                                <div class="swiper-container">
                                    <div class="swiper-wrapper">
                                        <?
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
                            </div>
                            <div class="slider__next"><i class="fal fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>



                <div class="product__cart slider-cart" style="display: none;">
                    <div class="swiper-container-wrapper">
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">

                                <?
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
                    <div class="product-info__chars">
                        <h6 class="product-info__title">Характеристики</h6>
                        <ul class="product-info__list list-catalog">
                            <?php
                                foreach(characters_products_id($product['id'], 5) as $key_tag => $value_tag) {
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
                        <a href="#" class="product-info__link link--black" data-scroll="#char" data-tab="3">Все характеристики</a>
                    </div>
                    <?php

                        if(count($productMods) > 0) {
                            echo '<div class="variations">';
                            $productModsNum = 0;
                            foreach ($productMods as $key => $value) {
                                ?>
                                    <div class="variations__select <? if($value['stock'] == 0) { echo 'opacity'; } ?> <? if($value['id'] == $modId) { echo 'active'; } ?>" data-id="<?php echo $value['id']; ?>" data-product="<?php echo $product['id']; ?>" data-num="<? echo $productModsNum; ?>">
                                        <div class="variations__title"><?php echo $value['title']; ?></div>
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
                                $productModsNum++;
                            }
                            echo '</div>';
                        }
                    ?>
                </div>
                
            </div>
            <div class="col-lg-3" id="block-price">
                <?php include 'product_block_price.php'; ?>
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
                                <a href="#" class="tabs__link tab-header__item active" data-tab="1">Обзор</a>
                            </li>
                            <li class="tabs__item">
                                <a href="#" class="tabs__link tab-header__item" data-tab="3">Характеристики</a>
                            </li>
                        </ul>
                    </div>
                
                </div>
            </div>
        </div>
    </div>

    <div class="special__body"> 
        <div class="container">
            <div class="tab-content active" data-id="1">
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

            <div class="tab-content active2" data-id="3">
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

<section class="new-products">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="new-products__header">
                    <h4 class="new-products__header-title">Рекомендуем</h4>
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
                    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `old_price` > `price` ORDER BY `id` DESC LIMIT 0, 12");
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