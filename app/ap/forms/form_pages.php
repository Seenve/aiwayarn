<?php
	if (isset($_POST['addpages'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$title = val_string($_POST['title']);
				$content = val_string($_POST['content']);
				$include = val_string($_POST['include']);
				$category = val_string($_POST['category']);
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$name = str2url($title);
				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$image_arr = $_POST['image'];

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query($GLOBALS['db'], "INSERT INTO `pages` (`category`, `show`, `title`, `name`, `content`, `keywords`, `description`, `include`, `regdate`) VALUES ('$category', '$show', '$title', '$name', '$content', '$tags', '$description', '$include', current_timestamp())");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('pages', '$kundeid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add('/ap/?page=pages');

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if (isset($_POST['editpages'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$id = val_string($_POST['id']);
				$title = val_string($_POST['title']);
				$content = val_string($_POST['content']);
				$include = val_string($_POST['include']);
				$category = val_string($_POST['category']);
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$name = str2url($title);
				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$image_arr = $_POST['image'];

				mysqli_query($GLOBALS['db'], "UPDATE `pages` SET `category`='$category', `show`='$show', `title`='$title', `name`='$name', `keywords`='$tags', `description`='$description', `content`='$content', `include`='$include' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'pages'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('pages', '$id', '$value', '$main_img', current_timestamp())");
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