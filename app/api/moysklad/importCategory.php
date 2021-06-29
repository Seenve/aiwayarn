<?php
    include '../../ap/bd.php';
    header('Content-Type: application/json; charset=utf-8');
    ini_set('display_errors', 0);
    include 'functions.php';

    $login = 'admin@seenve';
    $password = 'cda7cb74d999';

    $GLOBALS['login_moysklad'] = $login;
    $GLOBALS['password_moysklad'] =  $password;

    $arrResult = array();
    $arr = array();

    function setGroup($login, $password, $data) {
        $data_string = json_encode ($data, JSON_UNESCAPED_UNICODE);
        $urlrest = "https://online.moysklad.ru/api/remap/1.1/entity/productfolder";
        if($ch = curl_init($urlrest) ) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
               'Content-Type: application/json',
               'Content-Length: ' . strlen($data_string))
            );
            curl_setopt($ch, CURLOPT_USERPWD, $login.':'.$password);
            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }
    }

    function moyskladSetGroup($parentID, $parentName, $parentMeta) {
        $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '$parentID' ORDER BY `rang`");
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $uid = $row['moysklad_uid'];
            $title = $row['title'];
            if(!$row['moysklad_uid']) {
                $arr = setGroup($GLOBALS['login_moysklad'], $GLOBALS['password_moysklad'], array(
                    'name' => $title,
                    'code' => $id,
                    'productFolder' => $parentMeta,
                    //'externalCode' => $parentID,
                ));
                $arrResult[] = $arr;
                if(is_array($arr)) {
                    $uid = $arr['id'];
                    if($uid) {
                        mysqli_query($GLOBALS['db'], "UPDATE `products_category` SET `moysklad_uid`='$uid' WHERE `id`='$id'");
                    }
                }
            } else {

            }
            //moyskladSetGroup($row['id'], $row['title']);
        }
        return $arrResult;
    }

    $result = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_category` WHERE `parent_id` = '0' ORDER BY `rang`");
    $numRows = mysqli_num_rows($result);

    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $uid = $row['moysklad_uid'];
        $title = $row['title'];
        if(!$row['moysklad_uid']) {
            $arr = setGroup($GLOBALS['login_moysklad'], $GLOBALS['password_moysklad'], array(
                'name' => $title,
                'code' => $id,
            ));
            $arrResult[] = $arr;
            if(is_array($arr)) {
                $uid = $arr['id'];
                if($uid) {
                    mysqli_query($GLOBALS['db'], "UPDATE `products_category` SET `moysklad_uid`='$uid' WHERE `id`='$id'");
                    //$arrResult[] = moyskladSetGroup($id, $title, $arr);
                }
            }
        } else {
            $arr = getGroup($GLOBALS['login_moysklad'], $GLOBALS['password_moysklad'], $uid);
            if(is_array($arr)) {
                $arrResult[] = moyskladSetGroup($id, $title, $arr);
            }
        }



        //productsCountCategory($row['id'])
        /*$image = gallery_arr('products_category', $row['id'])['0']['image'];
        $image = gallery_arr('products_category', $row['id'])['0']['image'];
        if($image) {
            ?>
                <img src="/uploads/images/jpeg/<?php echo $image; ?>-100x100.jpeg" alt="Avatar" class="avatar-img rounded-circle">
            <?
        } else {
            ?>
                <img src="/ap/assets/images/no-image.svg" alt="Avatar" class="avatar-img rounded-circle">
            <?
        }*/
        //apCategories($row['id'], $row['name']);
    }


    //$arrResult = getGroup($login, $password);

    /*$arrProducts = getProducts(settings()['0']['nums_product_moysklad'])['rows'];
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
            $targetDir2 = "../../uploads";
            $save_file = '../../uploads/'.$nameimage;
            if($value['image']['meta']['href']) {
                if (!file_exists($save_file)) {
                    //$nameimage = rndstr(6).'_'.time();
                    $saved = saveImage($value['image']['meta']['href'], $save_file);
                    if($saved) {
                        include '../../ap/image-compress.php';
                        createThumbnail($targetDir2, $nameimage, '../../uploads/middle', 1024);
                        createThumbnail($targetDir2, $nameimage, '../../uploads/small', 384);
                    }
                    $arr[$i]['image_upload'] = $saved;
                } else {
                    $arr[$i]['image_upload'] = 'uploaded';
                }
                $arr[$i]['image'] = $nameimage;
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
            $price = $value['price'];
            $content = $value['description'];
            $measure = $arrMeasure[$value['measure']];
            $image = $value['image'];

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
                if($image) {
                    mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product'");
                    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('$type_product', '$id_product', '$image', '0', current_timestamp())");
                }
            } else {
                $query_id = '';
                if($query_id == ''){ 
                    $query_insert = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`uid_moysklad`, `title`, `name`, `category`, `price`, `measure`, `content`, `regdate`) VALUES ('$uid', '$title', '$name', '$category', '$price', '$measure', '$content', current_timestamp())");
                    $query_id = mysqli_insert_id($GLOBALS['db']);
                }
                $id_product = $query_id;
                if($image) {
                    mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id_product' AND `type` = '$type_product'");
                    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('$type_product', '$id_product', '$image', '0', current_timestamp())");
                }
            }
        }
    } else {
        $arrProducts['result'] = false;
        $arrProducts['message'] = 'No data';
    }

    $arr_result = $arrProducts;*/


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
    echo json_encode($arrResult);

    //echo var_dump($arr);

?>