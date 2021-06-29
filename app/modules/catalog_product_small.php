<div class="card-column col-lg-12">
    <article class="card-row">
        <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="card-row__block-img" data-pjax="content">
            <?php echo gallery('products', $productArr['id'], 0, 1, 'small', $productArr['title'], false, true); ?>
        </a>
        <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="card-row__title"><?php echo $productArr['title']; ?></a>
        <div class="card-row__price price">
            <?php 
                if($productArr['old_price'] > $productArr['price']) {
                    $sale = 100 - ($productArr['price']*100/$productArr['old_price']);
                    ?>
                        <p class="price__old-price"><span class="price__line"><? echo number_format($productArr['old_price'], 0, '.', ' '); ?></span> ₽
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
                if($productArr['price']) {
                    ?>
                        <h6 class="price__price"><? echo number_format($productArr['price'], 0, '.', ' '); ?> ₽</h6>
                    <?php
                } else {
                    ?>
                        <h6 class="price__price-text">Цена по запросу</h6>
                    <?php
                }
            ?>
        </div>
        <div class="card-row__block-btn">
            <?php
                if($productArr['stock'] > 0) {
                    ?>
                        <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="card-row__btn btn btn-blue btn-size_default" data-pjax="content"></a>
                    <?
                } else {
                    ?>
                        <button class="card-row__btn2 btn btn-size_default" data-pjax="content">
                            Нет в наличии
                        </button>
                    <?
                }
            ?>
        </div>
    </article>
</div>