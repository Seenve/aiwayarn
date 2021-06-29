<?php
	if (isset($_POST['addproducts'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$title = val_string($_POST['title']);
				$prod = val_string($_POST['prod']);
				$name = str2url($title);
				$city_id = intval(val_string($_POST['city_id']));
				$type = intval(val_string($_POST['type']));
				$content = val_string($_POST['content']);
				$content2 = val_string($_POST['content2']);
				$content3 = val_string($_POST['content3']);
				$video_url = val_string($_POST['video_url']);
				$category = intval(val_string($_POST['category']));
				$archived = intval(val_string($_POST['archived']));
				$favorite = intval(val_string($_POST['favorite']));
				$stock = val_string($_POST['stock']);
				$stock = intval(preg_replace("/[^0-9]/", '', $stock));
				$weight = val_string($_POST['weight']);
				$weight = intval(preg_replace("/[^0-9]/", '', $weight));
				$price = val_string($_POST['price']);
				$price = floatval($price);
				$old_price = val_string($_POST['old_price']);
				$old_price = intval(preg_replace("/[^0-9]/", '', $old_price));
				$description = val_string($_POST['description']);
				$uid = makeUUID();
				$keywords_arr = $_POST['input'];
				$character_arr = $_POST['character'];
				$image_arr = $_POST['image'];
				$keywords = implode(", ", $keywords_arr);

				if($kundeid==''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `products` (`uid`, `type`, `weight`, `stock`, `video_url`, `city_id`, `content3`, `content2`, `prod`, `archived`, `favorite`, `title`, `name`, `category`, `price`, `content`, `keywords`, `description`, `old_price`) VALUES ('$uid', '$type', '$weight', '$stock', '$video_url', '$city_id', '$content3', '$content2', '$prod', '$archived', '$favorite', '$title', '$name', '$category', '$price', '$content', '$keywords', '$description', '$old_price')");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				$err = 'err: ';
				if(!$insert) {
					$err = mysqli_error($GLOBALS['db']);
				}


				/* gallery */
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products', '$kundeid', '$value', '$main_img', current_timestamp())");
				}

				/* character */
				mysqli_query($GLOBALS['db'], "DELETE FROM `products_character` WHERE `product_id` = '$kundeid'");
				foreach ($character_arr as $key_ch => $value_ch) {
					$name_character = $value_ch[0];
					$value_character = $value_ch[1];
					mysqli_query($GLOBALS['db'], "INSERT INTO `products_character` (`product_id`, `name`, `value`) VALUES ('$kundeid', '$name_character', '$value_character')");
				}

				//echo insert_add($err);
				echo insert_add('/ap/?page=products', $err);

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
	if (isset($_POST['editproducts'])) {
		if($uid) {
			if(user($uid)['admin'] >= 2) {
				$id = intval(val_string($_POST['id']));
				$title = val_string($_POST['title']);
				$prod = val_string($_POST['prod']);
				$name = str2url($title);
				$city_id = intval(val_string($_POST['city_id']));
				$type = intval(val_string($_POST['type']));
				$content = val_string($_POST['content']);
				$content2 = val_string($_POST['content2']);
				$content3 = val_string($_POST['content3']);
				$video_url = val_string($_POST['video_url']);
				$category = intval(val_string($_POST['category']));
				$favorite = intval(val_string($_POST['favorite']));
				$archived = intval(val_string($_POST['archived']));
				$stock = val_string($_POST['stock']);
				$stock = intval(preg_replace("/[^0-9]/", '', $stock));
				$weight = val_string($_POST['weight']);
				$weight = intval(preg_replace("/[^0-9]/", '', $weight));
				$price = val_string($_POST['price']);
				$price = floatval($price);
				$old_price = val_string($_POST['old_price']);
				$old_price = preg_replace("/[^0-9]/", '', $old_price);
				$description = val_string($_POST['description']);
				$keywords_arr = $_POST['input'];
				$character_arr = $_POST['character'];
				$image_arr = $_POST['image'];
				$keywords = implode(", ", $keywords_arr);


				mysqli_query($GLOBALS['db'], "UPDATE `products` SET `type`='$type', `weight`='$weight', `stock`='$stock', `video_url`='$video_url', `city_id`='$city_id', `content3`='$content3', `content2`='$content2', `prod`='$prod', `archived`='$archived', `favorite`='$favorite', `title`='$title', `name`='$name', `category`='$category', `price`='$price',`content`='$content', `description`='$description', `keywords`='$keywords', `old_price`='$old_price' WHERE `id`='$id'");

				/* gallery */
				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'products'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products', '$id', '$value', '$main_img', current_timestamp())");
				}

				/* character */
				mysqli_query($GLOBALS['db'], "DELETE FROM `products_character` WHERE `product_id` = '$id'");
				foreach ($character_arr as $key_ch => $value_ch) {
					$name_character = $value_ch[0];
					$value_character = $value_ch[1];
					mysqli_query($GLOBALS['db'], "INSERT INTO `products_character` (`product_id`, `name`, `value`) VALUES ('$id', '$name_character', '$value_character')");
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