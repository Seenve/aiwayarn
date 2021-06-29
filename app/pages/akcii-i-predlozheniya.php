<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { include 'header.php'; } ?>

<?php include 'modules/breadcrumbs.php'; ?>

<?php 
    $pagenum = isset($_GET['_num']) ? $_GET['_num'] : '';
    $pagenum = val_string($pagenum);
    $getSort = isset($_GET['_sort']) ? $_GET['_sort'] : '';
    $getSort = preg_replace("/[^0-9]/", '', $getSort);

    $arrGet = array();
    if(!$arrGet['_sort']) {
        $arrGet['_sort'] = 0;
    }

    $url_page_ext = $_SERVER['REQUEST_URI'];
    foreach ($_GET as $key => $value) {
        if(strpos($key,'_') === false) {} else {
            //echo '<p>'.$value.'</p>';
            if($key == '_num' || $value == '#content') {

            } else {
                $arrGet[$key] = $value;
            }
        }
    }
    $url_page = $GLOBALS['url'].'?'.http_build_query($arrGet).'&_num=';

    if(!$getSort) $getSort = 0;
    $arr_sort[0] = 'По дате';
    $arr_sort[1] = 'Сначала дешевле';
    $arr_sort[2] = 'Сначала дороже';

    if ($getSort == 1) {
        $sort_txt = 'ORDER BY `price` ASC';
    } else if ($getSort == 2) {
        $sort_txt = 'ORDER BY `price` DESC';
    } else {
        $sort_txt = 'ORDER BY `regdate` DESC';
    }
?>

<section class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="catalog__head">
                    <div class="category">
                        <h1><?php echo $title_page; ?></h1>
                    </div>
                    <div class="sort">
                        <form action="<?php echo $GLOBALS['url']; ?>" class="selector" data-pjax="content">
                            <input type="hidden" name="_sort" value="1" class="selector__value">
                            <?php
                                foreach ($_GET as $key => $value) {
                                    if(strpos($key,'_') === false) {} else {
                                        //echo '<p>'.$value.'</p>';
                                        if($key == '_num') {
                                            ?>
                                                <input type="hidden" name="_num" value="<?php echo $value; ?>">
                                            <?
                                        }
                                    }
                                }
                            ?>
                            <div><p>Сортировать:</p><span><? echo $arr_sort[$getSort]; ?></span></div>
                            <ul>
                                <?php
                                    foreach ($arr_sort as $key => $value) {
                                        ?>
                                            <li data-id="<?php echo $key; ?>"><?php echo $value; ?></li>
                                        <?
                                    }
                                ?>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <?php

                        $page = htmlspecialchars($_GET['page']);
                        // Переменная хранит число сообщений выводимых на станице  
                        $num = 18;  

                        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `price` < `old_price`");
                        $posts = mysqli_num_rows($query);

                        //$posts = mysqli_num_rows($result01s);  
                        // Находим общее число страниц  
                        $total = intval(($posts - 1) / $num) + 1;  
                        // Определяем начало сообщений для текущей страницы  
                        $pagenum = intval($pagenum);  
                        // Если значение $pagenum меньше единицы или отрицательно  
                        // переходим на первую страницу  
                        // А если слишком большое, то переходим на последнюю  
                        if(empty($pagenum) or $pagenum < 0) $pagenum = 1;  
                          if($pagenum > $total) $pagenum = $total;  
                        // Вычисляем начиная к какого номера  
                        // следует выводить сообщения  
                        $start = $pagenum * $num - $num;  

                        $postrow = array();

                        $filter = $sort_txt.' LIMIT '.$start.', '.$num;

                        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `price` < `old_price` $filter");
                        while ($row = mysqli_fetch_array($query)) {
                            $postrow[] = $row;
                        }
                        $posts = mysqli_num_rows($query);

                        if($posts > 0){  
                            for($in = 0; $in < $num; $in++) {  
                                $idstr = $postrow[$in]['id'];
                                if($idstr > 0) {
                                    $productArr = $postrow[$in];
                                    include $path.'/../modules/catalog_product.php';
                                }
                            }
                        } else {
                            echo '<div class="card-row"><article class="card-row__title">В данной категории нет товаров</article></div>';
                        }
                    ?>     
                </div>   
            </div>
        </div>
    </div>
</section>


<section class="catalog-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <?php include $path.'/../modules/pagination.php'; ?>
            </div>
            <div class="col-lg-6">
                <div class="catalog-pages__info">
                    <p>В распродаже <? echo $posts; ?> <? echo ending($posts, 'товар', 'товара', 'товаров'); ?></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php
                    if(strlen(htmlspecialchars_decode($row_pages['content'])) > 1) {
                        ?>
                            <div class="catalog-pages__content">
                                <?php echo htmlspecialchars_decode($row_pages['content']); ?>
                            </div>
                        <?
                    }
                ?>
            </div>
        </div>
    </div>
</section>