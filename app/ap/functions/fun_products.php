<?php
    function products($categoryArr = array(), $sql = '') {
        $ids = join("','", $categoryArr);
        if(count($categoryArr)) {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `category` IN ('$ids') $sql");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` $sql");
        }
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function productUid($uid) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `uid` = '$uid'");
        $row = mysqli_fetch_array($query);
        return $row;
    }
    function productsCount() {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `products`");
        return mysqli_num_rows($query);
    }
    function productsCountCategory($id_category) {
        $nums = 0;
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `products` WHERE `category` = '$id_category'");
        $nums = $nums+mysqli_num_rows($query);

        $query2 = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$id_category'");
        while($row = mysqli_fetch_assoc($query2)){
            $id = $row['id'];
            $query3 = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `products` WHERE `category` = '$id'");
            $nums = $nums+mysqli_num_rows($query3);
        }
        return $nums;
    }
    function productsCountCategoryFavorite($id_category) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `products` WHERE `category` = '$id_category' AND `favorite` = 1");
        return mysqli_num_rows($query);
    }
    function productsCategory($id_category) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `id` = '$id_category'");
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    function productsCategoryParent($id_category) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$id_category'");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function productsCategoryName($string) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `title` = '$string'");
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    function productsCategoryNameCity($string, $city) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `title` = '$string' AND `city_id` = '$city'");
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    function products_id($product_id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `id` = '$product_id'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row['0'];
    }
    function characters_products_id($product_id, $limit = 100) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_character` WHERE `product_id` = '$product_id' ORDER BY `id` DESC LIMIT 0, $limit");
        $arr = array();
        while($row = mysqli_fetch_assoc($query)){
            $arr[] = $row; 
        }
        return $arr;
    }
    function products_name($product_name, $id_category) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `name` = '$product_name' AND `category` = '$id_category'");
        $arr = array();
        $row = mysqli_fetch_assoc($query);
        $arr[] = $row; 
        return $arr['0'];
    }
    function products_mod_search($city_id, $uid_moysklad, $vars) {
        $arr = array();
        foreach ($vars as $key => $value) {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_mod_char` WHERE `city_id` = '$city_id' AND `uid` = '$uid_moysklad' AND `name` = '$key' AND `value` = '$value'");
            $row = mysqli_fetch_assoc($query);
            if(mysqli_num_rows($query) > 0) {
                $arr[] = $row['code']; 
            }
        }
        $result = array_unique($arr);
        //$result = mergeByKey($arr)
        //$result = array_reverse($result);
        return $result[0];
        //return $arr;
        //var_dump($values);
    } 
    function product_mod($city, $id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_character` WHERE `product_id` = '$id'");
        //$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_mod_char` WHERE `uid` = '$uid' AND `city_id` = '$city'");
        $arr = array();
        $i = 0;
        while($row = mysqli_fetch_assoc($query)){
            //$arr[] = $row; 
            $arr[$i]['name'] = $row['name'];
            $arr[$i]['value'] = $row['value'];
            $i++;
        }
        return $arr;
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
    }

    function products_mod($city_id, $id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_mod` WHERE `city_id` = '$city_id' AND `id` = '$id'");
        $row = mysqli_fetch_assoc($query);
        return $row;
    }
    function product_mods($city_id, $uid) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_mod` WHERE `city_id` = '$city_id' AND `uid` = '$uid'");
        $arr = array();
        while($row = mysqli_fetch_assoc($query)){
            $arr[] = $row; 
        }
        return $arr;
    }

    // new

    function checkCategory($cityId, $catName, $catId) {
        $arr = array();
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `name` = '$catName' AND `parent_id` = '$catId' AND `city_id` = '$cityId'");
        $row = mysqli_fetch_assoc($query);
        $arr[] = $row; 
        return $arr['0'];
    }
    function checkProduct($cityId, $productName, $catId) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `name` = '$productName' AND `category` = '$catId' AND `city_id` = '$cityId'");
        $arr = array();
        $row = mysqli_fetch_assoc($query);
        $arr[] = $row; 
        return $arr['0'];
    }
    function productUrl($productId) {
        $city_products = $GLOBALS['city'];
        $url = array();

        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `id` = '$productId' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
        $row = mysqli_fetch_assoc($result); 
        $catId = $row['parent_id'];
        $url[0] = $row['name'];

        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `id` = '$catId' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
        $row = mysqli_fetch_array($result); 
        if($numRows = mysqli_num_rows($result)) {
            $catId = $row['parent_id'];
            $url[1] = $row['name'];
        }

        $url = array_reverse($url);
        $url = implode("/", $url);

        return '/catalog/'.$url;
    }

    function menu_showNested_catalog($parentID, $parentName) {
        $city_products = $GLOBALS['city'];
        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' AND `city_id` = '$city_products' AND `show` = '1' ORDER BY `rang`");
        $numRows = mysqli_num_rows($result);
        
        if ($numRows > 0) {
            echo '<ul>';
            while($row = mysqli_fetch_array($result)) {
                echo '<li data-id="'.$row['id'].'">';
                echo '<a href="/catalog/'.$parentName.'/'.$row['name'].'" data-pjax="content"><span class="section-sb-label">'.$row['title'].' <span class="count">'.productsCountCategory($row['id']).'</span></span></a>';
                
                menu_showNested_catalog($row['id'], $row['name']);
                
                echo '</li>';
            }
            echo '</ul>';
        }
    }

?>