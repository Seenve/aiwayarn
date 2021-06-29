<form class="block-price" method="GET" data-pjax="content">
    <input type="hidden" name="mod" value="<? echo $modId; ?>">
    <div class="block-price__group">
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
                        <h6 class="price__price block-price__price"><? echo price($product['price']); ?></h6>
                    <?php
                } else {
                    ?>
                        <h6 class="price__price block-price__price-text">Цена по запросу</h6>
                    <?php
                }
            ?>
        </div>

        <div>
            <div class="block-price__contact product-stock">
                <?php 
                    if($stockArr['result']) {
                        ?>
                            В наличии <? echo $stockArr['stock']; ?> <? echo $arrTypeProduct[$product['type']]; ?>
                        <?
                    } else {
                        ?>
                            Нет в наличии
                        <?
                    }
                ?>
            </div>

            <!--<span class="block-price__label">Количество</span>-->
            <div class="input-nums">
                <div class="input-nums__control">
                    <div class="input-nums__arrow-right"><i class="fal fa-angle-left"></i></div>
                    <input type="number" name="nums" value="1" max="<? echo $stockArr['stock']; ?>">
                    <div class="input-nums__arrow-left"><i class="fal fa-angle-right"></i></div>
                </div>
                <div>
                    <button class="add-favorite <? if(like($product['id'], $user_uid)) {echo ' active';} ?>" data-id="<?php echo $product['id']; ?>"></button>
                </div>
            </div>
        </div>
    </div>

    <div class="block-price__buttons">
        <?php 
            if($stockArr['result']) {
                if($cartId = cart($product['id'], $modId, $user_uid)) {
                    ?>
                        <button class="card__btn btn btn-transparent_purple btn-size_full del_cart" data-id="<? echo $cartId; ?>">В корзине</button>
                    <?
                } else {
                    ?>
                        <button class="card__btn btn btn-buy btn-size_full add_cart" data-id="<? echo $product['id']; ?>" data-mod="<? echo $modId; ?>" data-nums="1">В корзину</button>
                    <?
                }
                ?>
                    <!--<button class="card__btn btn btn-transparent_blue btn-size_full order_cart" data-id="<? echo $product['id']; ?>" data-mod="<? echo $modId; ?>" data-nums="1">Купить в 1 клик</button>-->
                <?
            }
        ?>
    </div>

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