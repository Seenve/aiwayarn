<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include $path.'/../modules/breadcrumbs.php'; ?>

<?php 
    $word = val_string($_GET['q']);
    $query_products_top = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `title` LIKE '%$word%' OR `name` LIKE '%$word%' OR `content` LIKE '%$word%' OR `description` LIKE '%$word%' OR `keywords` LIKE '%$word%' ORDER BY id LIMIT 100");
    $posts = mysqli_num_rows($query_products_top);
?>

<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <h1>Поиск</h1>
                    </div>
                </div>
                <form action="/search" data-pjax="content" class="search-page">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <input type="text" name="q" placeholder="Поиск" class="search__input2" value="<?php echo $word; ?>">
                                <button class="btn btn-purple btn-size_full" type="submit">Найти</button>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="search-page__info">
                                <span>Найдено <b><? echo $posts; ?></b> <? echo ending($posts, 'товар', 'товара', 'товаров'); ?></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php
                        if($posts > 0) {
                            while($row_products_top = mysqli_fetch_assoc($query_products_top)) {
                                $idstr = $row_products_top['id'];
                                $productArr = products_id($idstr);
                                include $path.'/../modules/catalog_product.php';
                            }
                        } else {
                            //echo '<div class="card-row"><article class="card-row__title">В данной категории нет товаров</article></div>';
                            ?>
                                <div class="cf-sm-6 cf-md-4 cf-lg-4 col-xs-6 col-sm-6 col-md-4 col-lg-4">
                                    <p>По вашему запросу ничего не найдено</p>
                                </div>
                            <?
                        }
                    ?>     
                </div>   
            </div>
        </div>
    </div>
</section>