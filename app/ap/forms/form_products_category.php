<?php
	if (isset($_POST['addproducts_category'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$title = val_string($_POST['title']);
				$content = val_string($_POST['content']);
				$include = val_string($_POST['include']);
				$category = intval(val_string($_POST['category']));
				$city_id = intval(val_string($_POST['city_id']));
				$city_id = 1;
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$name = str2url($title);
				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$image_arr = $_POST['image'];

				$insert = mysqli_query($GLOBALS['db'], "INSERT INTO `products_category` (`city_id`, `parent_id`, `show`, `title`, `name`, `content`, `keywords`, `description`, `include`) VALUES ('$city_id', '$category', '$show', '$title', '$name', '$content', '$tags', '$description', '$include')");
				$insert_id = mysqli_insert_id($GLOBALS['db']);

				$err = 'err: ';
				if(!$insert) {
					$err = mysqli_error($link);
				}

				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
				    mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_category', '$kundeid', '$value', '$main_img', current_timestamp())");
				}
				echo insert_add('/ap/?page=products_category');

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if (isset($_POST['editproducts_category'])) {
		if($uid) {
			if(user($uid)['admin'] == 2) {
				$id = val_string($_POST['id']);
				$title = val_string($_POST['title']);
				$content = val_string($_POST['content']);
				$include = val_string($_POST['include']);
				$category = intval(val_string($_POST['category']));
				$show = val_string($_POST['show']);
				$description = val_string($_POST['description']);
				$name = str2url($title);
				$tags_arr = $_POST['input'];
				$tags = implode(", ", $tags_arr);
				$image_arr = $_POST['image'];

				mysqli_query($GLOBALS['db'], "UPDATE `products_category` SET `parent_id`='$category', `show`='$show', `title`='$title', `name`='$name', `keywords`='$tags', `description`='$description', `content`='$content', `include`='$include' WHERE `id`='$id'");

				mysqli_query($GLOBALS['db'], "DELETE FROM `gallery` WHERE `uid` = '$id' AND `type` = 'products_category'");
				foreach ($image_arr as $value) {
					if ($value == "") {
						$value = "no-image.jpg";
					}
					$val_img = str_replace(".","_", $value);
					$main_img = $_POST[$val_img];
					mysqli_query($GLOBALS['db'], "INSERT INTO `gallery` (`type`, `uid`, `image`, `main`, `regdate`) VALUES ('products_category', '$id', '$value', '$main_img', current_timestamp())");
				}

				echo insert_update();

			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

	if(isset($_POST['category_save'])) {
		$jsonstring = $_POST['jsonstring'];
		$jsonDecoded = json_decode($jsonstring, true, 64);
		
		function parseJsonArray($jsonArray, $parentID = 0)
		{
		  $return = array();
		  foreach ($jsonArray as $subArray) {
			 $returnSubSubArray = array();
			 if (isset($subArray['children'])) {
			   $returnSubSubArray = parseJsonArray($subArray['children'], $subArray['id']);
			 }
			 $return[] = array('id' => $subArray['id'], 'parentID' => $parentID);
			 $return = array_merge($return, $returnSubSubArray);
		  }

		  return $return;
		}
		
		$readbleArray = parseJsonArray($jsonDecoded);
		
		foreach ($readbleArray as $key => $value) {
			if (is_array($value)) {
				$result = mysqli_query($GLOBALS['db'], "UPDATE `products_category` SET `rang` = '". $key ."', `parent_id` = '".$value['parentID']."' WHERE `id` = '".$value['id']."'");
			}
		}

		echo "Обновлено ".date("y-m-d H:i:s")."!";
	}

?>