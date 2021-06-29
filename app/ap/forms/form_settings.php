<?php
	if (isset($_POST['addsettings'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$city_name = val_string($_POST['city_name']);
				$title = val_string($_POST['title']);
				$description = val_string($_POST['description']);

				$soc_1 = val_string($_POST['soc_1']);
				$soc_2 = val_string($_POST['soc_2']);
				$soc_3 = val_string($_POST['soc_3']);
				$soc_4 = val_string($_POST['soc_4']);

				$banner_1 = val_string($_POST['banner_1']);
				$banner_2 = val_string($_POST['banner_2']);
				$banner_3 = val_string($_POST['banner_3']);

				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$address = val_string($_POST['address']);
				$jobtime = val_string($_POST['jobtime']);
				$map = val_string($_POST['map']);
				$phone = val_string($_POST['phone']);
				$phone = preg_replace("/[^0-9]/", '', $phone);
				$email = val_string($_POST['email']);
				$phone2 = val_string($_POST['phone2']);
				$phone2 = preg_replace("/[^0-9]/", '', $phone2);
				$email2 = val_string($_POST['email2']);
				$delivery = val_string($_POST['delivery']);
				$lat = val_string($_POST['lat']);
				$lng = val_string($_POST['lng']);
				$login_product_moysklad = val_string($_POST['login_product_moysklad']);
				$password_product_moysklad = val_string($_POST['password_product_moysklad']);


				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query($GLOBALS['db'], "INSERT INTO `settings` (`banner_3`,`banner_2`,`banner_1`,`lat`, `lng`, `delivery`, `city_name`, `title`, `description`, `address`, `keywords`, `map`, `phone`, `email`, `jobtime`, `login_product_moysklad`, `password_product_moysklad`, `soc_1`, `soc_2`, `soc_3`, `soc_4`, `reg_date`) VALUES ('$banner_3', '$banner_2', '$banner_1', '$lat', '$lng', '$delivery', '$city_name', '$title', '$description', '$address', '$tags', '$map', '$phone', '$email', '$jobtime', '$login_product_moysklad', '$password_product_moysklad', '$soc_1', '$soc_2', '$soc_3', '$soc_4', current_timestamp())");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				echo insert_add('/ap/?page=settings');

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if (isset($_POST['editsettings'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$id = val_string($_POST['id']);
				$city_name = val_string($_POST['city_name']);
				$title = val_string($_POST['title']);
				$description = val_string($_POST['description']);

				$soc_1 = val_string($_POST['soc_1']);
				$soc_2 = val_string($_POST['soc_2']);
				$soc_3 = val_string($_POST['soc_3']);
				$soc_4 = val_string($_POST['soc_4']);

				$banner_1 = val_string($_POST['banner_1']);
				$banner_2 = val_string($_POST['banner_2']);
				$banner_3 = val_string($_POST['banner_3']);

				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$address = val_string($_POST['address']);
				$jobtime = val_string($_POST['jobtime']);
				$map = val_string($_POST['map']);
				$phone = val_string($_POST['phone']);
				$phone = preg_replace("/[^0-9]/", '', $phone);
				$email = val_string($_POST['email']);
				$phone2 = val_string($_POST['phone2']);
				$phone2 = preg_replace("/[^0-9]/", '', $phone2);
				$email2 = val_string($_POST['email2']);
				$delivery = val_string($_POST['delivery']);
				$lat = val_string($_POST['lat']);
				$lng = val_string($_POST['lng']);
				$login_product_moysklad = val_string($_POST['login_product_moysklad']);
				$password_product_moysklad = val_string($_POST['password_product_moysklad']);

				mysqli_query($GLOBALS['db'], "UPDATE `settings` SET `banner_1`='$banner_1',`banner_2`='$banner_2',`banner_3`='$banner_3',`lat`='$lat', `lng`='$lng', `delivery`='$delivery', `phone2`='$phone2', `email2`='$email2', `city_name`='$city_name', `title`='$title', `description`='$description', `address`='$address', `keywords`='$tags', `map`='$map', `phone`='$phone', `email`='$email', `jobtime`='$jobtime', `login_product_moysklad`='$login_product_moysklad', `password_product_moysklad`='$password_product_moysklad', `soc_1`='$soc_1', `soc_2`='$soc_2', `soc_3`='$soc_3', `soc_4`='$soc_4' WHERE `id`='$id'");

				echo insert_update();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
?>