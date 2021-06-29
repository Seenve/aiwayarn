<?php
    function like($id, $account) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `products_stars` WHERE `product_id` = '$id' AND `user_uid` = '$account'");
        if(mysqli_num_rows($query) > 0) {
            return true;
        } else {
            return false;
        }
    }
    function cart($id, $mod, $account) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `product_id` = '$id' AND `mod_id` = '$mod' AND `user_uid` = '$account'");
        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            return $row['id'];
        } else {
            return false;
        }
    }
    function like_count($account) {
        $query = mysqli_query($GLOBALS['db'], "SELECT (id) FROM `products_stars` WHERE `user_uid` = '$account'");
        return mysqli_num_rows($query);
    }
    function cart_count($user_uid) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 100"); 
        if(mysqli_num_rows($query) > 0) {
            $summ = 0;
            $nums = 0;
            while($row = mysqli_fetch_assoc($query)) {
                $idstr = $row['product_id'];
                $mod_id = $row['mod_id'];
                $postrow = array();
                $postrow[0] = products_id($idstr);
                $in = 0; 
                // доп. с ценами
                /*$product2 = products_mod($GLOBALS['city'], $mod_id);
                if($product2) {
                    $summ += $product2['price']*$row['nums']; 
                } else {
                    $summ += $postrow[$in]['price']*$row['nums']; 
                }*/
                $summ += $postrow[$in]['price']*$row['nums']; 
                $nums++;
            }
            $arr['result'] = true;
            $arr['summ'] = $summ;
            $arr['nums'] = $nums;
        } else {
            $arr['result'] = false;
            $arr['summ'] = '';
            $arr['nums'] = 0;
        }
        return $arr;
    }

    function userCard($user_uid) {
        $arr = array();
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$user_uid' ORDER BY `regdate` LIMIT 0, 100"); 
        while($row = mysqli_fetch_assoc($query)){
            $arr[] = $row; 
        }
        return $arr;
    }
    $arrDelivery = array(
        0 => 'Самовывоз', 
        1 => 'Почта России', 
        2 => 'СДЭК', 
        3 => 'СДЭК курьером', 
        //4 => 'Доставка по г. Новосибирск', 
        //3 => 'СДЭК курьером', 
        //4 => 'Доставка по г. Новосибирск', 
    );

    $arrPay = array(
        0 => 'При получении', 
        1 => 'Онлайн', 
    );

    $arrTypeProduct = array(
        0 => 'шт.', 
        1 => 'гр.', 
    );

    $arrTypeProduct2 = array(
        0 => 'штук', 
        1 => 'грамм', 
    );

    $arr_type_pay[0] = 'Оплата наличными';
    $arr_type_pay[1] = 'Онлайн оплата';

    $arr_order_status[0] = 'Заказ принят';
    $arr_order_status[1] = 'Заказ принят и ожидает оплаты';
    $arr_order_status[2] = 'Заказ подтвержден';
    $arr_order_status[3] = 'Заказ в пути';
    $arr_order_status[4] = 'Заказ доставлен';
    $arr_order_status[5] = 'Заказ готов к выдаче';
    $arr_order_status[6] = 'Заказ завершен';

    function type_pay($id) {
        $arr[0] = 'Оплата наличными';
        $arr[1] = 'Онлайн оплата';
        return $arr[$id];
    }
    function order_status($id) {
        $arr[0] = 'Заказ принят';
        $arr[1] = 'Заказ принят и ожидает оплаты';
        $arr[2] = 'Заказ подтвержден';
        $arr[3] = 'Заказ в пути';
        $arr[4] = 'Заказ доставлен';
        $arr[5] = 'Заказ готов к выдаче';
        $arr[6] = 'Заказ завершен';
        return $arr[$id];
    }
    function discount_payment($summ, $sale) {
        $nsale = ($summ/100)*$sale;
        $result = $summ-$nsale;
        //$result = $summ; //убрать если отключить скидку
        if($result < 0) {
            $result = 0;
        }
        return $result;
    }

    function cartTotalSumm($uuid) {
        $arr['result'] = true;
        $arr['summ'] = 0;
        $arr['summ_sale'] = 0;
        $arr['sale'] = 0;

        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `cart` WHERE `user_uid` = '$uuid' ORDER BY `regdate` LIMIT 0, 60"); 
        if(mysqli_num_rows($query) > 0) {
            $summ = 0;
            while($row = mysqli_fetch_assoc($query)) {
                $productArr = products_id($row['product_id']);
                $modArr = products_mod($GLOBALS['city'], $row['mod_id']);

                /*if(count($modArr) > 0) {
                    $summ += $modArr['price']*$row['nums'];
                } else {
                    $summ += $productArr['price']*$row['nums'];
                }*/

                if($row['nums'] <= $productArr['stock']) {
                    $summ += $productArr['price']*$row['nums'];
                }
                
            }
            $arr['summ'] = $summ;

            $arr_sale = array();
            $arr_sale = $_SESSION['promocode'];
            if($arr_sale['result']) {
                $arr['sale'] = $arr_sale['sale'];
                $arr['summ_sale'] = discount_payment($summ, $arr_sale['sale']);
            }
        } else {
            $arr['result'] = false;
        }
        return $arr;
    }

    function likes($uuid) {
        $query = mysqli_query($GLOBALS['db'], "SELECT (id) FROM `products_stars` WHERE `user_uid` = '$uuid'"); 
        return mysqli_num_rows($query);
    }

    function stock($arrProduct, $arrMods) {
        $arr['result'] = false;
        $arr['stock'] = 0;
        $arr['mod'] = false;
        if(count($arrMods) > 0) {
            $arr['mod'] = true;
            $i = 0;
            foreach ($arrMods as $key => $value) {
                if($value['stock'] > 0) {
                    $i = $i+$value['stock'];
                }
            }
            $arr['stock'] = $i;
            if($i > 0) {
                $arr['result'] = true;
            }
        } else {
            if($arrProduct['stock']) {
                $arr['stock'] = $arrProduct['stock'];
                if($arr['stock'] > 0) {
                    $arr['result'] = true;
                }
            }
        }
        return $arr;
    }

    function checkPay($id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `pays` WHERE `id` = '$id'");
        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_assoc($query);
            return intval($row['pay']);
        } else {
            return false;
        }
    }

    function updateStock($uid) {
        $arr = array();

        foreach (userCard($uid) as $i => $row) {
            $productId = intval($row['product_id']);
            $modId = intval($row['mod_id']);
            $nums = intval($row['nums']);
            if($modId) {
                mysqli_query($GLOBALS['db'], "UPDATE `products_mod` SET `stock` = `stock` - $nums WHERE `id` = $modId");
            } else {
                mysqli_query($GLOBALS['db'], "UPDATE `products` SET `stock` = `stock` - $nums WHERE `id` = $productId");
            }
        }
        $result = mysqli_query($GLOBALS['db'], "DELETE FROM `cart` WHERE `user_uid` = '$uid'");
        return $arr;
    }






?>