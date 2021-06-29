<?php
	if (isset($_POST['editlanding_page'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$id = val_string($_POST['id']);
				$h1 = val_string($_POST['h1']);
				$h2 = val_string($_POST['h2']);
				$h3 = val_string($_POST['h3']);
				$h4 = val_string($_POST['h4']);
				$h5 = val_string($_POST['h5']);
				$h6 = val_string($_POST['h6']);
				$text1 = val_string($_POST['text1']);
				$text2 = val_string($_POST['text2']);
				$text3 = val_string($_POST['text3']);
				$text4 = val_string($_POST['text4']);
				$text5 = val_string($_POST['text5']);
				$text6 = val_string($_POST['text6']);
				$text7 = val_string($_POST['text7']);
				$text8 = val_string($_POST['text8']);
				$content = val_string($_POST['content']);

				$image_arr = $_POST['image'];

				mysqli_query($GLOBALS['db'], "UPDATE `landing_page` SET `content`='$content', `h1`='$h1', `h2`='$h2', `h3`='$h3', `h4`='$h4', `h5`='$h5', `h6`='$h6', `text1`='$text1', `text2`='$text2', `text3`='$text3', `text4`='$text4', `text5`='$text5', `text6`='$text6', `text7`='$text7', `text8`='$text8' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'landing_page'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('landing_page', '$id', '$value', '$main_img', current_timestamp())");
				}

				echo insert_update();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
?>