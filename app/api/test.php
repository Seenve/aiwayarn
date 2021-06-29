<?php

include '../ap/bd.php';

header('Content-type: application/json; charset=utf-8');

$GLOBALS['seo'] = array();
$base_url = settings()['0']['url'];
$base_url = '';


function seoProduct($id, $show = '') {
    $i = 0;
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `category` FROM `products` WHERE `category` = '$id' AND `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `category` FROM `products` WHERE `category` = '$id'");
    }
    while($row = mysqli_fetch_assoc($query)){
        $array[] = $row;
        $i++;
    }
    return $array;
}

function seoCatalog($id, $show = '') {
    $i = 0;
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id' AND `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `products_category` WHERE `parent_id` = '$id'");
    }
    while($row = mysqli_fetch_assoc($query)){
        $array[] = $row;
        $array[$i]['children'] = seoCatalog($row['id'], $show);
        $array[$i]['products'] = seoProduct($row['id'], $show);
        $i++;
    }
    return $array;
}
function seoPages($page, $show) {
    $i = 0;
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `$page` WHERE `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title` FROM `$page`");
    }
    while($row = mysqli_fetch_assoc($query)){
        $array[] = $row;
        $i++;
    }
    $array[$i]['children'] = $array;
    return $array;
}
function seoArr($inc = 0, $show = 0) {
    $array = array();
    if($show == 1) {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '0' AND `show` = '1'");
    } else {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id`, `name`, `title`, `include` FROM `pages` WHERE `category` = '0'");
    }
    $i = 0;
    while($row = mysqli_fetch_assoc($query)){
        if($row['include'] == 1) {
            if($row['name'] == 'catalog') {
                $array[] = $row;
                $array[$i]['children'] = seoCatalog($show);
            } else {
                $array[] = $row;
                $array[$i]['children'] = seoPages($row['name'], $show);
            }
        } else {
            $array[] = $row;
            $array[$i]['children'] = category_inset($row['id'], $show);
        }
        $i++;
    }
    $array['0']['title'] = 'Главная';
    return $array;
}

function checkArr($arr = null, $name, $dap, $builder, $base_url) {
    foreach ($arr as $key => $value) {
        if($value['id']) {
            if($key == 0) {
                $dap = $dap-0.1;
            }

            if(!empty($value['children'])) {
                $url = $name.'/'.$value['name'];
                $dap_str = str_replace(',', '.', $dap);
                $GLOBALS['seo'][] = array('loc'=>$base_url.$url);
                checkArr($value['children'], $url, $dap, $builder, $base_url);
            } else {
                $url = $name.'/'.$value['name'];
                $dap_str = str_replace(',', '.', $dap);
                $GLOBALS['seo'][] = array('loc'=>$base_url.$url);
            }

            foreach ($value['products'] as $key => $value2) {
                $url2 = $url.'/'.$value2['name'];
                $GLOBALS['seo'][] = array('loc'=>$base_url.$url2);
            }

        }
    }
}

foreach (seoArr() as $key => $value) {
    $dap = '1.0';
    if($value['id']) {
        if(!empty($value['children'])) {
            $url = '/'.$value['name'];
            $GLOBALS['seo'][] = array('loc'=>$base_url.$url);
            //$arr[]= $value['children'];
            checkArr($value['children'], $url, 1.0, $builder, $base_url);
        } else {
            $url = '/'.$value['name'];
            $GLOBALS['seo'][] = array('loc'=>$base_url.$url);
        }
    }
}


echo json_encode($GLOBALS['seo']);