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
        //$login_moysklad = 'ekbtech@пикформы';
        //$password_moysklad = '123654ekb';
        $nums_moysklad = $val_city['nums_product_moysklad'];
        $city_uid = $val_city['id'];
        if($login_moysklad && $password_moysklad) {
            //include 'menu_me.php';
/////////////////// catalog
            $arrGroups = getGroup($login_moysklad, $password_moysklad)['rows'];
            $i = 0;
            foreach ($arrGroups as $key => $value) {
                $title = $value['name'];
                $name = str2url($title);
                $arr[$i]['name'] = $value['name'];
                $pathName = '';
                $pathName = $value['pathName'];
                if($pathName == '') {
                    $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `title`='$title' AND `moysklad` = '1' AND `city_id` = '$city_uid'");
                    if(mysqli_num_rows($query) > 0) {
                        //update
                        $row = mysqli_fetch_assoc($query);
                        $arr[$i]['id'] = $row['id'];
                    } else {
                        $query_id = '';
                        if($query_id == ''){ 
                            $query_insert = mysqli_query($GLOBALS['db'], "INSERT INTO `products_category` (`city_id`, `title`, `name`, `moysklad`, `regdate`) VALUES ('$city_uid', '$title', '$name', '1', current_timestamp())");
                            $query_id = mysqli_insert_id($GLOBALS['db']);
                        }
                        $arr[$i]['id'] = $query_id;
                    }
                    //$arr[$i]['rang'] = 0;
                } else {
                    //$arr[$i]['path_name'] = $value['pathName'];
                    $van = array();
                    $arr_van = array();
                    $van = explode('/', $pathName);
                    $van_count = count($van);
                    if($van_count > 0) {
                        foreach ($van as $key => $value) {
                            //$arr[$i]['parents'][$key]['id'] = $key;
                            $arr_van[$key]['name'] = $value;
                            if(productsCategoryNameCity($value, $city_uid)) {
                                $arr_van[$key]['parent_id'] = productsCategoryNameCity($value, $city_uid)['id'];
                            }
                        }
                        //$arr[$i]['parents'] = $arr_van;
                    }
                    if(end($arr_van)['parent_id']) {
                        if(productsCategoryNameCity(end($arr_van)['name'], $city_uid)) {
                            $parent_id = end($arr_van)['parent_id'];
                            $arr[$i]['parent_id'] = $parent_id;
                            if(productsCategoryNameCity($title, $city_uid)) {
                                $arr[$i]['id'] = productsCategoryNameCity($title, $city_uid)['id'];
                            } else {
                                $query_id = '';
                                if($query_id == ''){ 
                                    $query_insert = mysqli_query($GLOBALS['db'], "INSERT INTO `products_category` (`city_id`, `title`, `name`, `moysklad`, `parent_id`, `regdate`) VALUES ('$city_uid', '$title', '$name', '1', '$parent_id', current_timestamp())");
                                    $query_id = mysqli_insert_id($GLOBALS['db']);
                                }
                                $arr[$i]['id'] = $query_id;
                            }
                        } else {
                            
                        }
                    }
                }
                $i++;
            }

            $arr = array();
            $van = array();
            $arr_van = array();
///////////////////

            $arrProducts = getProductsNew($nums_moysklad, $login_moysklad, $password_moysklad)['rows'];
            $i = 0;
            $arr = array();
            $f_arr = array();

            foreach ($arrProducts as $key => $value) {
                //if(!$arr[$i]['archived']) {
                    //$arr[$i]['city_id'] = $city_uid;

                $self = getUrl($value['meta']['href'], $login_moysklad, $password_moysklad);
                $uid_product = getUrl($self['meta']['href'], $login_moysklad, $password_moysklad)['product']['id'];
                $arr_product = product($uid_product, $login_moysklad, $password_moysklad);

                if($uid_product && count($arr_product) > 0 && !in_array($uid_product, $f_arr)) {
                    $f_arr[] = $uid_product;
                    $arr[$i]['uid'] = $uid_product;
                    $arr[$i]['stock'] = $value['stock'];
                    $arr[$i]['inTransit'] = $value['inTransit'];
                    $arr[$i]['reserve'] = $value['reserve'];
                    $arr[$i]['quantity'] = $value['quantity'];
                    $arr[$i]['price'] = $value['salePrice'];
                    //$arr[$i]['catalog'] = $value['folder']['name'];
                    $i_char = 0;
                    foreach ($self['characteristics'] as $key_char => $value_char) {
                        $arr_char[$i_char]['name'] = $value_char['name'];
                        $arr_char[$i_char]['value'] = $value_char['value'];
                        $i_char++;
                    }
                    $arr[$i]['characteristics'] = $arr_char;


                    //$arr[$i]['uid'] = $value['id'];
                    $arr[$i]['name'] = $arr_product['name']; 

                    //$arr[$i]['catalog'] = getUrl($value['productFolder']['meta']['href'], $login_moysklad, $password_moysklad)['name'];

                    if(is_array($arr_product['productFolder'])) {
                        $arr[$i]['catalog'] = getUrl($arr_product['productFolder']['meta']['href'], $login_moysklad, $password_moysklad)['name'];
                    }
                    //$arr[$i]['price'] = $arr_product['salePrice'];
                    $arr[$i]['volume'] = $arr_product['volume'];

                    $arr[$i]['measure'] = getUrl($arr_product['uom']['meta']['href'], $login_moysklad, $password_moysklad)['name'];
                    $arr[$i]['weight'] = $arr_product['weight'];
                    $arr[$i]['description'] = $arr_product['description'];
                    //$arr[$i]['arr_product'] = $arr_product;



                    $nameimage = $arr_product['image']['filename'];
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
                            $saved = saveImage($arr_product['image']['meta']['href'], $save_file, $login_moysklad, $password_moysklad);
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
                        $saved = saveImage($arr_product['image']['meta']['href'], $save_file, $login_moysklad, $password_moysklad);
                        if($saved) {
                            $arr[$i]['image2name'] = $rand_name;
                            createThumbnail($targetDir2, $rand_name, '../../uploads/middle', 1024);
                            createThumbnail($targetDir2, $rand_name, '../../uploads/small', 384);
                        }
                    }
                    if($value['modificationsCount'] > 0) {
                    }

                    $self = array();
                    $uid_product = array();
                    $arr_product = array();

                    $i++;
                }
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

                    $stock = $value['stock'];
                    $inTransit = $value['inTransit'];
                    $reserve = $value['reserve'];
                    $quantity = $value['quantity'];
                    $characteristics = mysqli_real_escape_string($GLOBALS['db'], json_encode($value['characteristics']));

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
                        mysqli_query($GLOBALS['db'], "UPDATE `products` SET `title`='$title', `name`='$name', `category`='$category', `price`='$price',`content`='$content', `description`='$description', `measure`='$measure', `stock`='$stock', `inTransit`='$inTransit', `reserve`='$reserve', `quantity`='$quantity', `char`='$characteristics' WHERE `uid_moysklad`='$uid'");
                        if($image2name) {
                            mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product' AND `city_id` = '$city_uid'");
                            mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`city_id`, `type`, `uid`, `image`, `main`, `moysklad_image`, `regdate`) VALUES ('$city_uid', 'products', '$id_product', '$image2name', '0', '$image', current_timestamp())");
                        }
                    } else {
                        $query_id = '';
                        if($query_id == ''){ 
                            $query_insert = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`city_id`, `uid_moysklad`, `title`, `name`, `category`, `price`, `measure`, `content`, `stock`, `inTransit`, `reserve`, `quantity`, `char`, `regdate`) VALUES ('$city_uid', '$uid', '$title', '$name', '$category', '$price', '$measure', '$content', '$stock', '$inTransit', '$reserve', '$quantity', '$characteristics', current_timestamp())");
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