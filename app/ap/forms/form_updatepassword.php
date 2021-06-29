<?php
	if(isset($_POST['updatepassword'])) {
		if($uid) {
			$password1 = val_string($_POST['passwordone']);
			$password2 = val_string($_POST['passwordtwo']);
			if($password1=="") {
				echo json_encode(array(
					'result' => true,
					'title' => '',
					'type' => 'warning',
					'redirect' => false,
					'reload' => false,
					'message' => 'Длина пароля должна составлять не менее 6 символов',
				));
			} else {
				if ($password1 == $password2) {
					$password = md5($password2);
					mysqli_query($GLOBALS['db'], "UPDATE `accounts` SET `password`='$password' WHERE `uid`='$uid'");
					echo json_encode(array(
						'result' => true,
						'title' => 'Выполнено',
						'type' => 'success',
						'redirect' => '/ap/?page=profile',
						'reload' => true,
						'message' => 'Пароль успешно изменен',
					));
				} else {
					echo json_encode(array(
						'result' => true,
						'title' => 'Ошибка',
						'type' => 'error',
						'redirect' => false,
						'reload' => false,
						'message' => 'Пароли не совпадают',
					));
				}
			}
		} else {
			echo auth_error();
		}
	}
?>