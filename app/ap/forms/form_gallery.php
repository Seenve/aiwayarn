<?php
	if (isset($_POST['addgallery'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$uid = val_string($_POST['uid']);
				$type = val_string($_POST['type']);
				$image_arr = $_POST['image'];

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$uid' AND `type` = '$type'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('$type', '$uid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
?>