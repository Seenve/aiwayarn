<?php
    include '../ap/bd.php';

    $word = val_string($_GET['q']);

    if(strlen($word) >= 3) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `title` LIKE '%$word%' OR `name` LIKE '%$word%' OR `content` LIKE '%$word%' OR `description` LIKE '%$word%' OR `keywords` LIKE '%$word%' ORDER BY id LIMIT 100");
        if(mysqli_num_rows($query) > 0) {
            $i = 0;
            while($row = mysqli_fetch_assoc($query)) {
                if($i < 8) {
                    $i++;
                    $productArr = products_id($row['id']);
                    $productArr['column'] = 3;
                    include '../modules/catalog_product_small.php';
                }
            }
            //if(mysqli_num_rows($query) > 8) {
                ?>
                    <div class="col-lg-12">
                        <div class="search__center">
                            <div class="search__btn active">
                                <button class="btn btn-purple btn-size_full" type="submit">Показать всё</button>
                            </div>
                        </div>
                    </div>
                <?
            //}
        } else {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(array(
                'result' => false,
                'message' => '<div class="col-lg-12"><span>По вашему запросу ничего не найдено. Рекомендуем воспользоваться <a href="/catalog" data-pjax="content">каталогом</a>.</span></div>',
            ));
        }
    } else {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array(
            'result' => false,
            'message' => '<div class="col-lg-12"><span>Напишите еще хотя бы 2 символа.</span></div>',
        ));
    }
?> 
