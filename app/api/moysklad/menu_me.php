<?php


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



?>