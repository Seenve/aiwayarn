<?php
    $GLOBALS['db'] = mysqli_connect('127.0.0.1', 'root', 'sda43ca1', 'aiwayarn_bd');


    $query_isl = mysqli_query($GLOBALS['db'], "SELECT * FROM `gallery` WHERE `image` LIKE '%.jpg%' ORDER BY id ASC LIMIT 0, 1");
    $array_of_row = array();
    while($row = mysqli_fetch_array($query_isl)){

        $imageId = $row['id'];
        $imageOld = $row['image'];



            //$nameimage = 's';
            //$ext = mb_strtolower($ext);

            $exploded = explode('.', $imageOld);

            $tempDir = '../uploads';
            $nameimage = $exploded[0];
            $ext = $exploded[count($exploded) - 1];
            $ext = '.'.$ext;
            echo $nameimage;

            include 'image.php';

            mysqli_query($GLOBALS['db'], "UPDATE `gallery` SET `image`='$nameimage' WHERE `id` = '$imageId'");
            echo $ext.'<br>';
       //}
    }


?>