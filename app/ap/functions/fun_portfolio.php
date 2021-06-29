<?php
    /*function products() {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products`");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function productsCount() {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `products`");
        return mysqli_num_rows($query);
    }
    function products_id($product_id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `id` = '$product_id'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row['0'];
    }
    function productsBrands() {
        $lquery_nt = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_brand` ORDER BY id ASC");
        $num_nt = 1;
        while($lrow_nt = mysqli_fetch_array($lquery_nt)) {
            $lname_nt1[] = $num_nt;
            $lname_nt2[] = $lrow_nt['title'];
            $larray_nt = array_combine($lname_nt1, $lname_nt2);
            $num_nt++;
        }
        return $larray_nt;
    }*/

    $typeportfolio_arr = array(
        '1' => 'Лендинг пейдж',
        '2' => 'Квиз',
        '3' => 'Корпоративный сайт',
        '4' => 'Сайт визитка',
        '5' => 'Сайт каталог',
        '6' => 'Интернет магазин',
        '7' => 'Сервис',
    );

?>