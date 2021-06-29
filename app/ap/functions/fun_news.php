<?php
    function news_tags_arr() {
        $lquery_nt = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` ORDER BY id ASC");
        $num_nt = 1;
        while($lrow_nt = mysqli_fetch_array($lquery_nt)) {
            $lname_nt1[] = $num_nt;
            $lname_nt2[] = $lrow_nt['tags'];
            $larray_nt = array_combine($lname_nt1, $lname_nt2);
            $num_nt++;
        }
        return $larray_nt;
    }

    function news_tags_arr_single($id) {
        $lquery_nt = mysqli_query($GLOBALS['db'], "SELECT * FROM `news` WHERE `id` = '$id' ORDER BY id ASC");
        $num_nt = 1;
        while($lrow_nt = mysqli_fetch_array($lquery_nt)) {
            $lname_nt1[] = $num_nt;
            $lname_nt2[] = $lrow_nt['tags'];
            $larray_nt = array_combine($lname_nt1, $lname_nt2);
            $num_nt++;
        }
        return $larray_nt;
    }
?>