<?php
    function lostmoney($uid_user) {
        $array_result = array();
        $i = 0;
        $userId = user($uid_user)['id'];
        $userMoney = user($uid_user)['money'];
        $money_rate = 0;
        foreach(service($userId) as $key => $value) {
            $money_rate += rate($value['rate'])['0']['money'];
            $i++;
        }
        if($i > 0) {
            $date_m = $userMoney/$money_rate;
            $date_m = intval($date_m);
            $days_out = day_number_name($date_m);
            $array_result = array(
                'result' => true,
                'message' => 'Денежных средств хватит на '.$days_out,
                'rate_money' => $money_rate,
                'user_money' => $userMoney,
            );
        } else {
            $array_result = array(
                'result' => false,
            );
        }
        return $array_result;
    }
?>