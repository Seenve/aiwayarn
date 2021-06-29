<?php
    function feedback($to = null, $do = null) {
        $to = preg_replace("/[^0-9]/", '', $to);
        $do = preg_replace("/[^0-9]/", '', $do);
        if($to !== '' && $do !== '') {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `feedback` ORDER BY `id` DESC LIMIT $to, $do");
        } else {
            $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `feedback` ORDER BY `id` DESC");
        }
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row;
        }
        return $array_of_row;
    }
?>