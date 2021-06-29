<?php
	if (isset($_POST['addbrands'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$title = val_string($_POST['title']);
				$image_arr = $_POST['image'];

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `products_brand` (`title`, `regdate`) VALUES ('$title', current_timestamp())");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_brand', '$kundeid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
	if (isset($_POST['editbrands'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$id = val_string($_POST['id']);
				$title = val_string($_POST['title']);
				$image_arr = $_POST['image'];
				mysqli_query($GLOBALS['db'], "UPDATE `products_brand` SET `title`='$title' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'products_brand'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_brand', '$id', '$value', '$main_img', current_timestamp())");
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