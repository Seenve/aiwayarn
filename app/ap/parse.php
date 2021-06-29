<?php 
    //header('Content-Type: application/json');
    include 'ap/bd.php';

    $arrNames = array();
    $arrMod = array();

    function customSearch($keyword, $arrayToSearch){
        foreach($arrayToSearch as $key => $arrayItem){
            if(stristr($arrayItem['name'], $keyword)){
                return array(
                    'result' => true,
                    'num' => $key,
                    'id' => $arrayItem['id'],
                    'uid' => $arrayItem['uid'],
                );
            }
            /*if($arrayToSearch[$arrayItem]['name'] == $keyword) {
                return $key;
            }*/
        }
    }

    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products`");
    while($row = mysqli_fetch_assoc($query)) {
        //var_dump($row);
        //var_dump($row['name']);
        $search = customSearch($row['name'], $arrNames);
        if($search['result']) {
            $arrMod[] = array(
                'id' => intval($row['id']),
                'uid' => $search['uid'],
                'name' => $row['name'],
                'title' => $row['title'],
                'price' => intval($row['price']),
                'stock' => intval($row['stock']),
                'gallery' => gallery_arr('products', $row['id'], '1')[0],
            );
        } else {
            //$arrNames[] = $row['id'];
            $arrNames[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'uid' => $row['uid'],
                'parent' => array(),
            );
        }
    }
    foreach ($arrNames as $key => $value) {
        //$id = $value['id'];
        //$uid = makeUUID();
        //mysqli_query($GLOBALS['db'], "UPDATE `products` SET `uid` = '$uid' WHERE `id`='$id'");

        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `name` = '$value'");
        if(mysqli_num_rows($query >= 2)) {
            $row = mysqli_fetch_assoc($query);
            $arrMod[] = $row;
        }
    }
    //echo json_encode($arrMod);

    foreach ($arrMod as $key => $value) {
        $uid = $value['uid'];
        $price = $value['price'];
        $stock = $value['stock'];
        $gallery_id = $value['gallery']['id'];
        $gallery_image = $value['gallery']['image'];


        /*$insert = mysqli_query ($GLOBALS['db'], "INSERT INTO `products_mod` (`uid`, `price`, `stock`) VALUES ('$uid', '$price', '$stock')");
        $insert_id = mysqli_insert_id($GLOBALS['db']);
        if($insert_id) {
            $insert2 = mysqli_query ($GLOBALS['db'], "INSERT INTO `gallery` (`uid`, `type`, `image`) VALUES ('$insert_id', 'products_mod', '$gallery_image')");
        }*/

        //mysqli_query($GLOBALS['db'], "UPDATE `gallery` SET `type` = 'products_mod' WHERE `id`='$gallery_id'");
        //var_dump($value);
    }


        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products`");
        while($row = mysqli_fetch_assoc($query)) {
            $id = $row['id'];
            if(strlen($row['uid']) > 2) {
                echo 'YES = '.$row['name'].''.$row['uid'].'<br>';
                //mysqli_query($GLOBALS['db'], "DELETE FROM `products` WHERE `id` = '$id'");
            } else {
                echo 'NO = '.$row['name'].''.$row['uid'].'<br>';
                //mysqli_query($GLOBALS['db'], "DELETE FROM `products` WHERE `id` = '$id'");
            }
        }

/*
                if($kundeid==''){ 
                    $insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`stock`, `video_url`, `city_id`, `content3`, `content2`, `prod`, `archived`, `favorite`, `title`, `name`, `category`, `price`, `content`, `keywords`, `description`, `old_price`) VALUES ('$stock', '$video_url', '$city_id', '$content3', '$content2', '$prod', '$archived', '$favorite', '$title', '$name', '$category', '$price', '$content', '$keywords', '$description', '$old_price')");
                    $kundeid = mysqli_insert_id($GLOBALS['db']);
                }


                mysqli_query($GLOBALS['db'], "DELETE FROM `products_character` WHERE `product_id` = '$kundeid'");


                mysqli_query($GLOBALS['db'], "UPDATE `products` SET `stock`='$stock', `video_url`='$video_url', `city_id`='$city_id', `content3`='$content3', `content2`='$content2', `prod`='$prod', `archived`='$archived', `favorite`='$favorite', `title`='$title', `name`='$name', `category`='$category', `price`='$price',`content`='$content', `description`='$description', `keywords`='$keywords', `old_price`='$old_price' WHERE `id`='$id'");



*/


?>
