<?php
	include '../ap/bd.php';
	ini_set('display_errors', 0);

	// регистрационная информация (пароль #2)
	$mrh_pass2 = "mK35Mrark6FglsoD6vY6";

	// чтение параметров
	$out_summ = $_REQUEST["OutSum"];
	$inv_id = $_REQUEST["InvId"];
	$shp_item = $_REQUEST["Shp_item"];
	$crc = $_REQUEST["SignatureValue"];
	$crc = strtoupper($crc);
	$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item"));

	// проверка корректности подписи
	if ($my_crc !=$crc)
	{
	  echo "bad sign\n
	  <meta http-equiv='refresh' content='0;/'>
	  ";
	  exit();
	}

	$query = mysqli_query($GLOBALS['db'],"SELECT * FROM `pays` WHERE `id`='$inv_id' AND `pay` = '0'");
	if(mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_assoc($query);
		$orderId = intval($row['order_id']);
		//$queryi = mysqli_query($GLOBALS['db'],"SELECT * FROM `order` WHERE `id`='$shp_item'");
		//$rowi = mysqli_fetch_assoc($queryi);

		//$email = $rowi['email'];
		//$firstname = $rowi['firstname'];

		$query  = "UPDATE `pays` SET `pay` = 1 WHERE `id`='$inv_id';";
		$query .= "UPDATE `order` SET `status` = 2 WHERE `id`='$orderId'";
		mysqli_multi_query($GLOBALS['db'], $query);

		/*$subject = "Ваш баланс успешно пополнен";
		$message .= "Здравствуйте, {$firstname}!<br><br><br>";
		$message .= "На Ваш баланс была зачислена сумма в размере {$out_summ} руб.<br><br>";
		$message .= "Если у вас возникнут какие-то трудности, обратитесь в службу поддержки.<br>";
		$message .= "-- \n";
		$message .= settings()['0']['title'];
		$send_mail = smtpmail($firstname, $email, $subject, $message, settings()['0']['email']);

		if($send_mail == 1) {
		}*/
		//echo "OK$inv_id\n";
	}
	echo "OK$inv_id\n";
?>