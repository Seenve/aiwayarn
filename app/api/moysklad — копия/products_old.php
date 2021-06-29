<?php

    include '../../ap/bd.php';

    header('Content-Type: application/json; charset=utf-8');

    ini_set('display_errors', 0);

    include 'functions.php';

    include '../../ap/image-compress.php';


    $arrProducts = getProducts(settings()['0']['nums_product_moysklad'])['rows'];
    $i = 0;
    $arr = array();

    foreach ($arrProducts as $key => $value) {
        if(!$arr[$i]['archived']) {
            $arr[$i]['uid'] = $value['id'];
            $arr[$i]['name'] = $value['name']; 
            if(is_array($value['productFolder'])) {
                $arr[$i]['catalog'] = getUrl($value['productFolder']['meta']['href'])['name'];
            }
            $arr[$i]['price'] = $value['salePrices'][0]['value'];
            $arr[$i]['volume'] = $value['volume'];
            $arr[$i]['measure'] = getUrl($value['uom']['meta']['href'])['name'];
            $arr[$i]['weight'] = $value['weight'];
            $arr[$i]['description'] = $value['description'];
            //$arr[$i]['image'] = $value['image'];
            $nameimage = $value['image']['filename'];
            $arr[$i]['image'] = $nameimage;
            $arr_image = ImageNameMoysklad($nameimage);

            $rand_name = rndstr(6).'_'.time();
            $targetDir2 = "../../uploads";

            if($arr_image) {
                $imageId = $arr_image['id'];
                $imageValue = $arr_image['image'];
                $check_file = '../../uploads/'.$imageValue;
                if (!file_exists($check_file)) {
                    $info = new SplFileInfo($nameimage);
                    $ext = '.'.$info->getExtension();
                    //$ext = substr($nameimage,strpos($nameimage,'.'),strlen($nameimage)-1);
                    $rand_name = $rand_name.$ext;
                    $save_file = '../../uploads/'.$rand_name;
                    $saved = saveImage($value['image']['meta']['href'], $save_file);
                    if($saved) {
                        $arr[$i]['image2name'] = $rand_name;
                        createThumbnail($targetDir2, $rand_name, '../../uploads/middle', 1024);
                        createThumbnail($targetDir2, $rand_name, '../../uploads/small', 384);
                    }
                } 
            } else {
                $info = new SplFileInfo($nameimage);
                $ext = '.'.$info->getExtension();
                //$ext = substr($nameimage,strpos($nameimage,'.'),strlen($nameimage)-1);
                $rand_name = $rand_name.$ext;
                $save_file = '../../uploads/'.$rand_name;
                $saved = saveImage($value['image']['meta']['href'], $save_file);
                if($saved) {
                    $arr[$i]['image2name'] = $rand_name;
                    createThumbnail($targetDir2, $rand_name, '../../uploads/middle', 1024);
                    createThumbnail($targetDir2, $rand_name, '../../uploads/small', 384);
                }
            }

            if($value['modificationsCount'] > 0) {
            }
        }
        $i++;
    }

    $arrProducts = array();

    $arrMeasure = array(
       'шт' => 0,
       'гр' => 1,
    );

    if(count($arr) > 0) {
        $arrProducts['result'] = true;
        $arrProducts['data'] = $arr;
        foreach ($arrProducts['data'] as $key => $value) {
            $uid = $value['uid'];
            $title = $value['name'];
            $name = str2url($title);
            $price2 = substr($value['price'], 0, -2);
            $price = $price2;
            $content = $value['description'];
            $measure = $arrMeasure[$value['measure']];
            $image = $value['image'];
            $image2name = $value['image2name'];
            //$image = urlencode($image);

            $volume = $value['volume']; // вес
            $weight = $value['weight']; // объем

            // $arrProducts['test'] = $measure;
            if($value['catalog']) {
                $category = productsCategoryName($value['catalog'])['id'];
            } else {
                $category = 0;
            }
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `uid_moysklad`='$uid'");
            if(mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                $id_product = $row['id'];
                $type_product = 'products';
                mysqli_query($GLOBALS['db'], "UPDATE `products` SET `title`='$title', `name`='$name', `category`='$category', `price`='$price',`content`='$content', `description`='$description', `measure`='$measure' WHERE `uid_moysklad`='$uid'");
                if($image2name) {
                    mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product'");
                    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `moysklad_image`, `regdate`) VALUES ('products', '$id_product', '$image2name', '0', '$image', current_timestamp())");
                }
            } else {
                $query_id = '';
                if($query_id == ''){ 
                    $query_insert = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`uid_moysklad`, `title`, `name`, `category`, `price`, `measure`, `content`, `regdate`) VALUES ('$uid', '$title', '$name', '$category', '$price', '$measure', '$content', current_timestamp())");
                    $query_id = mysqli_insert_id($GLOBALS['db']);
                }
                $id_product = $query_id;
                if($image2name) {
                    mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product'");
                    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `moysklad_image`, `regdate`) VALUES ('products', '$id_product', '$image2name', '0', '$image', current_timestamp())");
                }
            }
        }
        mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `nums_product_moysklad`= `nums_product_moysklad` + 10 WHERE `id`='1'");
    } else {
        mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `nums_product_moysklad`= 0 WHERE `id`='1'");
        $arrProducts['result'] = false;
        $arrProducts['message'] = 'No data';
    }

    $arr_result = $arrProducts;


    //getItems(0)['rows']

    //var_dump(getItems(1));

    //echo getItems(0)['rows'][0]['name'];
    //echo json_encode(getItems(0));

    /*$arrCharacters = getCharacters(0)['rows'];
    $i = 0;
    $arr = array();
    foreach ($arrCharacters as $key => $value) {
        if(is_array($value['characteristics'])) {
            $arr[$i]['uid_product'] = getUrl($value['product']['meta']['href'])['id'];
            $is = 0;
            foreach ($value['characteristics'] as $key => $value) {
                $arr_character[$is]['name'] = $value['name'];
                $arr_character[$is]['value'] = $value['value'];
                $is++;
            }
            $is = 0;
            $arr[$i]['characters'] = $arr_character;
        }
        $i++;
    }

    $arrCharacters = $arr;

    foreach ($arrProducts as $key => $value) {
        foreach ($arrCharacters as $key_ch => $value_ch) {
            if($value_ch['uid_product'] == $value['uid']) {
                $arrProducts[$key]['characters' ] = $value_ch['characters'];
            }
        }
    }*/
    //echo json_encode($arrCharacters);
    echo json_encode($arr_result);

    //echo var_dump($arr);

?>