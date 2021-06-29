<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>


<?php include $path.'/../modules/breadcrumbs.php'; ?>


<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <h1><?php echo $title_page; ?></h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_stars` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 60"); 
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        $productArr = products_id($row['product_id']);
                        include $path.'/../modules/catalog_product.php';
                    }
                } else {
                    ?>
                        <div class="col-lg-12">
                            <div class="card-row">
                                <article class="card-row__title">Пусто</article>
                            </div>
                        </div>
                    <?
                }
            ?> 
        </div>
    </div>
</section>
