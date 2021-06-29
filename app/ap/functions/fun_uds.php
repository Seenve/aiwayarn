<?
    function uds_user($id) {
        $query = mysqli_query($GLOBALS['db'], "SELECT * FROM `accounts_uds` WHERE `user_uid`='$id'");
        if(mysqli_num_rows($query) > 0) {
            $row = mysqli_fetch_array($query);
            $arr['result'] = true;
            $arr['firstname'] = $row['firstname'];
            $arr['lastname'] = $row['lastname'];
            $arr['scores'] = $row['scores'];
            $arr['vip'] = $row['vip'];
            $arr['participantId'] = $row['participantId'];
            $arr['dateCreated'] = $row['dateCreated'];
            $arr['skype'] = $row['skype'];
            $arr['instagram'] = $row['instagram'];
            $arr['birthday'] = $row['birthday'];
            $arr['gender'] = $row['gender'];
            $arr['uid'] = $row['uid'];
            $arr['birthDate'] = $row['birthDate'];
            $arr['avatar'] = $row['avatar'];
            $arr['participant'] = $row['participant'];
        } else {
            $arr['result'] = false;
            $arr['message'] = 'Пользователь не найден.';
        }
        return $arr;
    }
?>