<?php
    function services() {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `services`");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function servicesCount() {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `services`");
        return mysqli_num_rows($query);
    }
    function service($user_id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `services` WHERE `user_id` = '$user_id' AND `del` = '0'");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function service_id($service_id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `services` WHERE `id` = '$service_id'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row['0'];
    }
?>