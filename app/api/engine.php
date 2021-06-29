<?
include '../ap/bd.php';

if(authuser()) {
	$account = authuser();


	if(isset($_POST['star']) && isset($_POST['type'])) {
		$id = htmlspecialchars($_POST['star']);
		$type = htmlspecialchars($_POST['type']);
        $query_star = mysql_query("SELECT * FROM `stars` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
        if(mysql_num_rows($query_star) > 0) {
        	mysql_query ("DELETE FROM `stars` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
			echo json_encode(array(
				'result' => true,
				'status' => false,
				'message' => '<i class="fa fa-trash" aria-hidden="true"></i> Объект <b>#'.$id.'</b> удален из избранного',
			));
        } else {
        	mysql_query ("INSERT INTO `stars` (`type`, `uid`, `account`) VALUES ('$type', '$id', '$account')");
			echo json_encode(array(
				'result' => true,
				'status' => true,
				'message' => '<i class="fa fa-check"></i> Объект <b>#'.$id.'</b> добавлен в избранное',
			));
        }
	}

	if(isset($_POST['like']) && isset($_POST['type'])) {
		$id = htmlspecialchars($_POST['like']);
		$type = htmlspecialchars($_POST['type']);
        $query_star = mysql_query("SELECT * FROM `likes` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
        if(mysql_num_rows($query_star) > 0) {
        	mysql_query ("DELETE FROM `likes` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
			echo json_encode(array(
				'result' => true,
				'status' => false,
				'message' => '<i class="fa fa-trash" aria-hidden="true"></i> Объект <b>#'.$id.'</b> удален из избранного',
			));
        } else {
        	mysql_query ("INSERT INTO `likes` (`type`, `uid`, `account`) VALUES ('$type', '$id', '$account')");
			echo json_encode(array(
				'result' => true,
				'status' => true,
				'message' => '<i class="fa fa-check"></i> Объект <b>#'.$id.'</b> добавлен в избранное',
			));
        }
	}




} else {

	if(isset($_POST['star']) && isset($_POST['type'])) {
		$account = guest();
		$id = htmlspecialchars($_POST['star']);
		$type = htmlspecialchars($_POST['type']);
        $query_star = mysql_query("SELECT * FROM `stars` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
        if(mysql_num_rows($query_star) > 0) {
        	mysql_query ("DELETE FROM `stars` WHERE `type`='$type' AND `uid` = '$id' AND `account` = '$account'");
			echo json_encode(array(
				'result' => true,
				'status' => false,
				'message' => '<i class="fa fa-trash" aria-hidden="true"></i> Объект <b>#'.$id.'</b> удален из избранного',
			));
        } else {
        	mysql_query ("INSERT INTO `stars` (`type`, `uid`, `account`) VALUES ('$type', '$id', '$account')");
			echo json_encode(array(
				'result' => true,
				'status' => true,
				'message' => '<i class="fa fa-check"></i> Объект <b>#'.$id.'</b> добавлен в избранное',
			));
        }
	} else {
		echo json_encode(array(
			'result' => false,
			'message' => '<i class="fa fa-exclamation-triangle"></i> Ошибка! Вы не авторизованы',
		));
	}
}

?>