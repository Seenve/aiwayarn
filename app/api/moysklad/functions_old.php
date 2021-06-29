<?php

    //$GLOBALS['login'] = 'admin@seenve';
    //$GLOBALS['password'] = 'cda7cb74d999';
    $GLOBALS['login'] = 'antonsh@пикформы';
    $GLOBALS['password'] = '123654';

    function getGroup() {
        $urlrest = 'https://online.moysklad.ru/api/remap/1.1/entity/productfolder/?limit=100&offset=0';
        if($ch = curl_init($urlrest) ) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['login'].':'.$GLOBALS['password']); #--------- логин и пароль
            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }
    }

    function getProducts($offset){
        $urlrest = 'https://online.moysklad.ru/api/remap/1.1/entity/product/?limit=10&offset='.$offset; #--------- лимит 100 товаров и начинать с позиции $offset 

        if($ch = curl_init($urlrest) ) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['login'].':'.$GLOBALS['password']); #--------- логин и пароль
            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }
    }

    function getCharacters($offset){
        $urlrest = 'https://online.moysklad.ru/api/remap/1.1/entity/variant/?limit=10&offset='.$offset; #--------- лимит 100 товаров и начинать с позиции $offset 

        if($ch = curl_init($urlrest) ) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['login'].':'.$GLOBALS['password']); #--------- логин и пароль
            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }
    }

    function getUrl($urlrest) {
        if($ch = curl_init($urlrest) ) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_COOKIEFILE,  dirname(__FILE__).'/cookie.txt');
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $GLOBALS['login'].':'.$GLOBALS['password']); #--------- логин и пароль
            $res = curl_exec($ch);
            curl_close($ch);

            return json_decode($res, true);
        }
    }

    function rndstr($len) { 
        $all = "abcdefghijklmnopqrstuvwxyz"; 

        $cnt = strlen($all) - 1; 
        srand((double)microtime()*1000000); 
        for($i=0; $i<$len; $i++) $pass .= $all[rand(0, $cnt)]; 

        return $pass; 
    }

    function saveImage($getUrl, $saveUrl) {
        $rt = false;

        if($getUrl && $saveUrl){
            $img = curl_init($getUrl);
            curl_setopt($img, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($img, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($img, CURLOPT_FOLLOWLOCATION , true);
            curl_setopt($img, CURLOPT_USERPWD, $GLOBALS['login'].':'.$GLOBALS['password']);
            $output = curl_exec($img);
            $info = curl_getinfo($img);

            if($info['url']){
                $fh = fopen($saveUrl, 'w');
                fwrite($fh, file_get_contents($info['url']));
                fclose($fh);
                $rt = true;
            }
        }
        
        return $rt;
    }

    function ImageNameMoysklad($string) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `gallery` WHERE `moysklad_image`='$string' ORDER BY main DESC");
        $row = mysqli_fetch_assoc($query);
        return $row;
    }

?>