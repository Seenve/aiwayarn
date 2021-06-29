<?
	// https://api.telegram.org/bot524362793:AAF7Jp62n59VhWoTPL4_j7ghsmJ1ufxT238/getUpdates

	include '../ap/bd.php';

    header('Content-Type: application/json; charset=utf-8');

    ini_set('display_errors', 0);

	$domain = $_SERVER['SERVER_NAME'];
	$error = 'Ошибка! Пожалуйста, заполните обязательные поля.';
	$error2 = 'Ошибка! Свяжитесь с нами другим способом';
	$success = 'Спасибо за обращение!<br>В ближайшее время мы с вами свяжемся.';
	$date = date("d.m.Y");
	$time = date("H:i");
	$token = "476421379:AAEoviECRe3Ugul9FJYcl43dOSOCFE1Kc7o";
	$chat_id = "-1001423120384"; //68148927 -234747814

	$utm_source = urldecode(htmlspecialchars($_POST['utm_source']));
	$utm_term = urldecode(htmlspecialchars($_POST['utm_term']));
	$form = htmlspecialchars($_POST['form']);
	$url = htmlspecialchars($_POST['url']);
	$zapros = htmlspecialchars($_POST['zapros']);
	$mess = htmlspecialchars($_POST['message']);
	$name = htmlspecialchars($_POST['firstname']);
	$type = htmlspecialchars($_POST['type']);
	$phone = htmlspecialchars($_POST['phone']);
	$phone2 = preg_replace("/[^0-9]/", '', $phone);
	$phone = preg_replace('/^(\d)(\d{3})(\d{3})(\d{2})(\d{2})$/','+\1 (\2) \3-\4-\5',(string)$phone2);
	$email = htmlspecialchars($_POST['email']);

	if($form) {

		$subject = "Сообщение со страницы: ".$url;
		$message = "{$subject} \r\n";
		$message .= 'Форма: '.$form. " \r\n";
		if($name) {
			$message .= "Имя: {$name}\r\n";
		}
		if($phone) {
			$message .= "Телефон: {$phone}\r\n";
		}
		if($email) {
			$message .= "Эл. почта: {$email}\r\n";
		}
		if($mess) {
			$message .= "Сообщение: {$mess}\r\n";
		}
		$message .= "\r\n";
		if($utm_source) {
			$message .= "Откуда: {$utm_source}\r\n";
		}
		if($utm_term) {
			$message .= "Слова: {$utm_term}\r\n";
		}

		$resultTelegram = sendTelegram($token, $chat_id, $message);

		$message = wordwrap($message, 200, "\r\n");
		$headers = 'Content-type: text/plain; charset="utf-8"';
		$send_mail = smtpmail('', settings($GLOBALS['city'])['0']['email'], $subject, $message, 'server@seenve.ru', '1');
		//$send_mail = smtpmail('', 'seenve@gmail.com', $subject, $message, 'server@seenve.ru', '1');

		$send_bd = mysqli_query($GLOBALS['db'],"INSERT INTO `feedback` (`form`, `name`, `phone`, `email`, `message`, `regdate`) VALUES ('$form', '$name', '$phone2', '$email', '$mess', current_timestamp())"); 
		$mysql_id = mysqli_insert_id($GLOBALS['db']);

		if ($resultTelegram['ok'] == 1 || $send_mail == 1 || $mysql_id) {
			echo json_encode(array(
				'result' => true,
				'message' => $success
			));
		} else {
			echo json_encode(array(
				'result' => false,
				'message' => $error2
			));
		}
	} else {
		echo json_encode(array(
			'result' => false,
			'message' => $error
		));
	}

?>
