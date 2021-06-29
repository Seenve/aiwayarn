<?php
    function rates() {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `rates`");
        $array_of_row = array();
        while($row = mysqli_fetch_array($query)){
            $array_of_row[] = $row; 
        }
        return $array_of_row;
    }
    function ratesCount() {
        $query = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `rates`");
        return mysqli_num_rows($query);
    }
    function rate($id_rate) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `rates` WHERE `id` = '$id_rate'");
        $array_of_row = array();
        $row = mysqli_fetch_array($query);
        $array_of_row[] = $row; 
        return $array_of_row;
    }
?>