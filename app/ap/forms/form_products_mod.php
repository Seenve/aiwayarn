<?php
	if (isset($_POST['addproducts_mod'])) {
		if($uid) {
			if(user($uid)['admin'] >= 1) {
				$uid = val_string($_POST['uid']);
				$title = val_string($_POST['title']);
				$name = str2url($title);
				$content = val_string($_POST['content']);
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$type = val_string($_POST['type']);
				$site = val_string($_POST['url']);
				$tags_arr = $_POST['input'];
				$image_arr = $_POST['image'];
				$tags = implode(", ", $tags_arr);
				$stock = val_string($_POST['weight']);
				$stock = preg_replace("/[^0-9]/", '', $stock);

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `products_mod` (`uid`, `title`, `stock`) VALUES ('$uid', '$title', '$stock')");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_mod', '$kundeid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add('/ap/?page=products_mod');
			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if (isset($_POST['editproducts_mod'])) {
		if($uid) {
			if(user($uid)['admin'] >= 1) {
				$id = val_string($_POST['id']);
				$title = val_string($_POST['title']);
				$name = str2url($title);
				$content = val_string($_POST['content']);
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$type = val_string($_POST['type']);
				$site = val_string($_POST['url']);
				$tags_arr = $_POST['input'];
				$image_arr = $_POST['image'];
				$tags = implode(", ", $tags_arr);
				$stock = val_string($_POST['weight']);
				$stock = preg_replace("/[^0-9]/", '', $stock);

				mysqli_query($GLOBALS['db'], "UPDATE `products_mod` SET `title`='$title', `stock`='$stock' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'products_mod'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_mod', '$id', '$value', '$main_img', current_timestamp())");
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