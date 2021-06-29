<?php
	if (isset($_POST['addcoupon'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$name = val_string($_POST['name']);
				$type = intval(val_string($_POST['type']));
				$value = val_string($_POST['currency']);
				$startdate = val_string($_POST['startdate']);
				$olddate = val_string($_POST['olddate']);

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `coupon` (`name`, `type`, `value`, `startdate`, `olddate`, `regdate`) VALUES ('$name', '$type', '$value', '$startdate', '$olddate', current_timestamp())");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				echo insert_add('/ap/?page=coupon');
			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
	/*if (isset($_POST['editcoupon'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$id = val_string($_POST['id']);
				$title = val_string($_POST['title']);
				$name = str2url($title);
				$content = val_string($_POST['content']);
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$tags_arr = $_POST['input'];
				$image_arr = $_POST['image'];
				$tags = implode(", ", $tags_arr);

				mysqli_query($GLOBALS['db'], "UPDATE `coupon` SET `show`='$show', `title`='$title', `name`='$name', `content`='$content', `tags`='$tags', `description`='$description', `keywords`='$tags' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'coupon'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('coupon', '$id', '$value', '$main_img', current_timestamp())");
				}

				echo insert_update();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}*/
?>