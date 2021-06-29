<?php
	if(isset($_POST['delete'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {

				$id = val_string($_POST['id']);
				$id = preg_replace("/[^0-9]/", '', $id);
				$table = val_string($_POST['table']);
				$image = val_string($_POST['image']);
				$reload = val_string($_POST['reload']);

				$utm1 = val_string($_POST['utm1']);
				$utm2 = val_string($_POST['utm2']);
				$utm3 = val_string($_POST['utm3']);

				if($table == 'gallery') {
					$img1 = '../uploads/'.$image;
					$img2 = '../uploads/small'.$image;
					$img3 = '../uploads/middle'.$image;
					delete($img1);delete($img2);delete($img3);
				}
				$result = mysqli_query ($GLOBALS['db'], "DELETE FROM `$table` WHERE `id` = '$id'");

				if($result) {
					if($reload == 1) {
						echo json_encode(array(
							'result' => true,
							'title' => 'Выполнено',
							'type' => 'success',
							'reload' => true,
							'message' => 'Успешно удалено!',
						));
					} else {
						echo json_encode(array(
							'result' => true,
							'title' => 'Выполнено',
							'type' => 'success',
							'redirect' => '/ap/?page='.$table,
							'message' => 'Успешно удалено!',
						));
					}
				} else {
					echo json_encode(array(
						'result' => false,
						'title' => 'Ошибка',
						'type' => 'error',
						'redirect' => false,
						'message' => 'Обратитесь в службу поддержки: support@vucs.ru',
					));
				}

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
?>