<?php
    function landing_page() {
        $query_sl = mysqli_query($GLOBALS['db'], "SELECT * FROM `landing_page`");
        $array_of_row = array();
        while($row_sl = mysqli_fetch_assoc($query_sl)){
            $array_of_row[] = $row_sl; 
        }
        return $array_of_row;
    }
?>