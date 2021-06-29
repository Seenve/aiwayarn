<div class="card__price price">
    <?php 
        if($productArr['old_price'] > $productArr['price']) {
            $sale = 100 - ($productArr['price']*100/$productArr['old_price']);
            ?>
                <p class="price__old-price"><span class="price__line"><? echo price($productArr['old_price']); ?></span>
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
                <h6 class="price__price"><? echo price($productArr['price']); ?></h6>
            <?php
        } else {
            ?>
                <h6 class="price__price-text">Цена по запросу</h6>
            <?php
        }
    ?>
</div>