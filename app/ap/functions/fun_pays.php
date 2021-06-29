<?php
    function pay($id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `pays` WHERE `id` = '$id'");
        $row = mysqli_fetch_array($query);
        return $row;
    }
?>