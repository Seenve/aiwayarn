<section class="special">
    <div class="container">
        <div class="row">
            <div class="col-lg-auto">
                <h4>Специальные предложения 🔥</h4>
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

                                <?php 
                                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' AND `show` = '1' ORDER BY `rang`");
                                    $numRows = mysqli_num_rows($result);
                                    $i = 1;
                                    while($row = mysqli_fetch_array($result)) {
                                        if(productsCountCategoryFavorite($row['id'])) {
                                            echo '<li class="special__item" data-id="'.$row['id'].'">';
                                            echo '<a href="/catalog/'.$row['name'].'" class="special__link link--black tab-header__item js-tab-trigger" data-tab="'.$i.'">'.$row['title'].' <sup>'.productsCountCategoryFavorite($row['id']).'</sup></a>';
                                            echo '</li>';
                                            $i++;
                                        }
                                    }
                                ?>               
                            </ul>
    
                            <div class="owl-navigate special-navigate">
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
            </div>
        </div>
    
        <div class="special__body"> 
            <div class="container">
                <?
                    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' ORDER BY `rang`");
                    $numRows = mysqli_num_rows($result);
                    $i = 1;
                    while($row = mysqli_fetch_array($result)) {
                        if(productsCountCategoryFavorite($row['id'])) {
                            $categoryId = $row['id'];
                            ?>
                                <div class="tab-content js-tab-content" data-tab="<? echo $i; ?>">
                                    <div class="row">
                                        <div class="owl-carousel owl-theme special-carousel">
                                            <?
                                                $query_products_favorite = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `archived` = '0' AND `favorite` = '1' AND `category` = '$categoryId' ORDER BY regdate DESC");
                                                $i = 0;
                                                while($row_products_favorite = mysqli_fetch_array($query_products_favorite)) {
                                                    $i++;
                                                    ?>

                                                        <div class="special-carousel__item">
                                                            <article class="catalog__item card">
                                                                <a class="card__link" href="/catalog/<? echo productsCategory($row_products_favorite['category'])['name']; ?>/<?php echo $row_products_favorite['name']; ?>" data-pjax="content">
                                                                    <div class="card__block-img">
                                                                        <?php echo gallery('products', $row_products_favorite['id'], 0, 1, 'small', $row_products_favorite['title'], true, true); ?>
                                                                    </div>
                                                                    <div class="card__block-heading">
                                                                        <h6 class="card__title"><?php echo $row_products_favorite['title']; ?></h6>
                                                                    </div>
                                                                </a>

                                                                <div class="card__manufacturer-city">
                                                                    <span class="card__city">Россия</span>
                                                                </div>

                                                                <div class="card__tags-list">                                     
                                                                    <?php
                                                                        foreach(characters_products_id($row_products_favorite['id'], 9) as $key_tag => $value_tag) {
                                                                            ?>
                                                                                <span class="card__tags-item"><? echo $value_tag['value']; ?></span>
                                                                            <?
                                                                        }
                                                                    ?>  
                                                                </div>

                                                                <div class="card__footer">
                                                                    <div class="card__price price">
                                                                        <?php 
                                                                            if($row_products_favorite['old_price'] > $row_products_favorite['price']) {
                                                                                $sale = 100 - ($row_products_favorite['price']*100/$row_products_favorite['old_price']);
                                                                                ?>
                                                                                    <p class="price__old-price"><? echo number_format($row_products_favorite['old_price'], 0, '.', ' '); ?> ₽
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
                                                                            if($row_products_favorite['price']) {
                                                                                ?>
                                                                                    <h6 class="price__price"><? echo number_format($row_products_favorite['price'], 0, '.', ' '); ?> ₽</h6>
                                                                                <?php
                                                                            } else {
                                                                                ?>
                                                                                    <h6 class="price__price-text">Цена по запросу</h6>
                                                                                <?php
                                                                            }
                                                                        ?>
                                                                    </div>

                                                                    <div class="card__block-btn">
                                                                        <a href="/catalog/<? echo productsCategory($row_products_favorite['category'])['name']; ?>/<?php echo $row_products_favorite['name']; ?>" data-pjax="content" class="card__btn btn btn-orange btn-size_full">
                                                                            Описание
                                                                            <svg width="8" height="12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.68 5.997l-4.488 4.49A.65.65 0 000 10.95c0 .176.068.34.192.464l.393.393a.651.651 0 00.464.192c.176 0 .34-.068.464-.192l5.345-5.345a.65.65 0 00.192-.465.651.651 0 00-.192-.466L1.518.192A.651.651 0 001.054 0 .651.651 0 00.59.192L.197.585a.657.657 0 000 .928L4.68 5.997z" fill="#ffffff"></path></svg>
                                                                        </a>
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
                            <?
                            $i++;
                        }
                    }
                ?>

            </div>
        </div>
    </div>
</section>