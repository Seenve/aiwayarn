<?php
	if (isset($_POST['editorder'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$id = intval(val_string($_POST['id']));
				$track = val_string($_POST['track']);
				$status = val_string($_POST['status']);
				$comment = val_string($_POST['comment']);
				$comment_user = val_string($_POST['comment_user']);

				mysqli_query($GLOBALS['db'], "UPDATE `order` SET `comment_user`='$comment_user', `comment`='$comment', `track`='$track', `status`='$status' WHERE `id`='$id'");

				echo insert_update();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
?>