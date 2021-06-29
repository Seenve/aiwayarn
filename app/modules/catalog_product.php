<?php 
    if($productArr['column']) {
        ?>
            <div class="card-column col-lg-<?php echo $productArr['column']; ?>">
        <?
    } else {
        if($productArr['slider']) {
            ?>
                <div class="card-column">
            <?
        } else {
            ?>
                <div class="card-column col-md-6 col-lg-6 col-xl-4 col-xxl-3">
            <?
        }
    }
?>
    <article class="card">
        <div class="card__badge">
            <?php /*if($productArr['old_price'] > $productArr['price']) { ?><span>Распродажа</span><?}*/ ?>
            <?php 
                $rr_time = strtotime($productArr['regdate'])+2592000;
                if($rr_time > time()) {
                    echo '<span>Новинка</span>';
                }
            ?>
        </div>
        <button class="add-favorite <? if(like($productArr['id'], $user_uid)) {echo ' active';} ?>" data-id="<?php echo $productArr['id']; ?>"></button>
        <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="card__block-img" data-pjax="content">
            <?php echo gallery('products', $productArr['id'], 0, 1, 'default', $productArr['title'], false, true); ?>
        </a>
        <div class="card__card-content">
            <div class="card__head">
                <a class="card__link" href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" data-pjax="content">
                    <div class="card__block-heading">
                        <h5 class="card__title"><?php echo $productArr['title']; ?></h5>
                    </div>
                </a>

                <div class="card__manufacturer-city">
                    <span class="card__city"><?php echo $productArr['prod']; ?></span>
                </div>

                <div class="card__tags-list">  
                    <?php
                        foreach(characters_products_id($productArr['id']) as $key_tag => $value_tag) {
                            ?>
                                <span class="card__tags-item"><? echo $value_tag['value']; ?></span>
                            <?
                        }
                    ?>        
                </div>
            </div>

            <div class="card__footer">
                <?php include 'product_price.php'; ?>
                <div class="card__block-btn">
                    <?php
                        if($productArr['stock'] > 0) {
                            ?>
                                <a href="<?php echo productUrl($productArr['category']); ?>/<?php echo $productArr['name']; ?>" class="card__btn btn btn-blue btn-size_full" data-pjax="content">
                                    Купить
                                </a>
                            <?
                        } else {
                            ?>
                                <button class="card__btn2 btn btn-size_full" data-pjax="content">
                                    Нет в наличии
                                </button>
                            <?
                        }
                    ?>
                </div>
            </div>
        </div>
    </article>
</div>