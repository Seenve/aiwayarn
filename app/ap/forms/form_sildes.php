<?php
	if (isset($_POST['addslides'])) {
		if($uid) {
			if(user($uid)['admin'] >= 1) {
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

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `slides` (`show`, `content`, `keywords`, `description`, `title`, `name`, `type`, `site`, `regdate`) VALUES ('$show', '$content', '$tags', '$description', '$title', '$name', '$type', '$site', current_timestamp())");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('slides', '$kundeid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add('/ap/?page=slides');
			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if (isset($_POST['editslides'])) {
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

				mysqli_query($GLOBALS['db'], "UPDATE `slides` SET `show`='$show', `keywords`='$tags', `description`='$description', `content`='$content', `name`='$name', `title`='$title', `type`='$type', `site`='$site' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'slides'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('slides', '$id', '$value', '$main_img', current_timestamp())");
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