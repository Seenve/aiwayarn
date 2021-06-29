<?php
    function category_products_arr() {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` ORDER BY `id` DESC");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
?>