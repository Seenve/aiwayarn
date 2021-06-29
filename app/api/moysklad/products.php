<?php

    include '../../ap/bd.php';

    header('Content-Type: application/json; charset=utf-8');

    ini_set('display_errors', 0);

    include 'functions.php';

    include '../../ap/image-compress.php';

    $kk = 0;

    foreach (settings() as $key_city => $val_city) {
        $login_moysklad = $val_city['login_product_moysklad'];
        $password_moysklad = $val_city['password_product_moysklad'];
        $nums_moysklad = $val_city['nums_product_moysklad'];
        $city_uid = $val_city['id'];
        if($login_moysklad && $password_moysklad) {


            $arrProducts = getProducts($nums_moysklad, $login_moysklad, $password_moysklad)['rows'];
            $i = 0;
            $arr = array();

            foreach ($arrProducts as $key => $value) {
                if(!$arr[$i]['archived']) {
                    //$arr[$i]['city_id'] = $city_uid;
                    $arr[$i]['uid'] = $value['id'];
                    $arr[$i]['name'] = $value['name']; 
                    if(is_array($value['productFolder'])) {
                        $arr[$i]['catalog'] = getUrl($value['productFolder']['meta']['href'], $login_moysklad, $password_moysklad)['name'];
                    }
                    $arr[$i]['price'] = $value['salePrices'][0]['value'];
                    $arr[$i]['volume'] = $value['volume'];
                    $arr[$i]['measure'] = getUrl($value['uom']['meta']['href'], $login_moysklad, $password_moysklad)['name'];
                    $arr[$i]['weight'] = $value['weight'];
                    $arr[$i]['description'] = $value['description'];
                    //$arr[$i]['image'] = $value['image'];
                    $nameimage = $value['image']['filename'];
                    $arr[$i]['image'] = $nameimage;
                    $arr_image = ImageNameMoysklad($nameimage, $city_uid);

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
                            $saved = saveImage($value['image']['meta']['href'], $save_file, $login_moysklad, $password_moysklad);
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
                        $saved = saveImage($value['image']['meta']['href'], $save_file, $login_moysklad, $password_moysklad);
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
                    //$city = $value['city_id'];
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
                        $category = productsCategoryNameCity($value['catalog'], $city_uid)['id'];
                    } else {
                        $category = 0;
                    }
                    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products` WHERE `uid_moysklad`='$uid' AND `city_id`='$city_uid'");
                    if(mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                        $id_product = $row['id'];
                        $type_product = 'products';
                        mysqli_query($GLOBALS['db'], "UPDATE `products` SET `title`='$title', `name`='$name', `category`='$category', `price`='$price',`content`='$content', `description`='$description', `measure`='$measure' WHERE `uid_moysklad`='$uid'");
                        if($image2name) {
                            mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product' AND `city_id` = '$city_uid'");
                            mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`city_id`, `type`, `uid`, `image`, `main`, `moysklad_image`, `regdate`) VALUES ('$city_uid', 'products', '$id_product', '$image2name', '0', '$image', current_timestamp())");
                        }
                    } else {
                        $query_id = '';
                        if($query_id == ''){ 
                            $query_insert = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`city_id`, `uid_moysklad`, `title`, `name`, `category`, `price`, `measure`, `content`, `regdate`) VALUES ('$city_uid', '$uid', '$title', '$name', '$category', '$price', '$measure', '$content', current_timestamp())");
                            $query_id = mysqli_insert_id($GLOBALS['db']);
                        }
                        $id_product = $query_id;
                        if($image2name) {
                            mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product' AND `city_id` = '$city_uid'");
                            mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`city_id`, `type`, `uid`, `image`, `main`, `moysklad_image`, `regdate`) VALUES ('$city_uid', 'products', '$id_product', '$image2name', '0', '$image', current_timestamp())");
                        }
                    }
                }
                mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `nums_product_moysklad`= `nums_product_moysklad` + 10 WHERE `id`='$city_uid'");
            } else {
                mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `nums_product_moysklad`= 0 WHERE `id`='$city_uid'");
                $arrProducts['result'] = false;
                $arrProducts['message'] = 'No data';
            }

            $arr_result = $arrProducts;

            $arr_city[$kk]['cityId'] = $city_uid;
            $arr_city[$kk]['arrProducts'] = $arr_result;
            $kk++;
        }
    }

    echo json_encode($arr_city);

    //echo json_encode($arrCharacters);
    //echo json_encode($arr_result);

    //echo var_dump($arr);

?>