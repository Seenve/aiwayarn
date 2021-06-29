<?php

	if(isset($_POST['menu_save'])) {
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
				$result = mysqli_query($GLOBALS['db'], "UPDATE `menu` SET `rang` = '". $key ."', `parent_id` = '".$value['parentID']."' WHERE `id` = '".$value['id']."'");
			}
		}

		echo "Обновлено ".date("y-m-d H:i:s")."!";
	}

	if(isset($_POST['menu_show'])) {
		$id = val_string($_POST['id']);
		$show = val_string($_POST['show']);
		if($show == 0) {
			$show_set = 1;
			$message = 'Ссылка показывается в меню';
		} else {
			$show_set = 0;
			$message = 'Ссылка скрыта из меню';
		}
		mysqli_query($GLOBALS['db'], "UPDATE `menu` SET `show`='$show_set' WHERE `id`='$id'");
		echo json_encode(array(
			'result' => true,
			'title' => 'Выполнено',
			'type' => 'success',
			'redirect' => false,
			'reload' => true,
			'scroll' => 1,
			'message' => $message,
		));
	}

	if(isset($_POST['menu_edit'])) {
		$id = val_string($_POST['id']);
		$name = val_string($_POST['name']);
		$url = val_string($_POST['url']);
		mysqli_query($GLOBALS['db'], "UPDATE `menu` SET `name`='$name', `url`='$url' WHERE `id`='$id'");
		echo json_encode(array(
			'result' => true,
			'title' => 'Выполнено',
			'type' => 'success',
			'redirect' => false,
			'reload' => true,
			'scroll' => 1,
			'message' => 'Успешно обновлено',
		));
	}

	if(isset($_POST['add_menu'])) {
		if($uid) {
			if(user($uid)['admin'] >= 1) {
				$name = val_string($_POST['name']);
				$url = val_string($_POST['url']);
				$result = mysqli_query($GLOBALS['db'], "SELECT `id` FROM `menu`");
				$numRows = mysqli_num_rows($result);
				if($kundeid == ''){ 
					$insert_cpkunde = mysqli_query ($GLOBALS['db'], "INSERT INTO `menu` (`rang`, `parent_id`, `name`, `url`, `show`) VALUES ('$numRows', '0', '$name', '$url', '0')");
					$kundeid = mysqli_insert_id($GLOBALS['db']);
				}

				echo json_encode(array(
					'result' => true,
					'title' => 'Выполнено',
					'type' => 'success',
					'redirect' => false,
					'reload' => true,
					'scroll' => 1,
					'message' => 'Успешно добавлено',
				));
			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}
	if(isset($_POST['reset_menu'])) {
		if($uid) {
			if(user($uid)['admin'] >= 1) {
			    function menu_showNested($arr, $name, $id) {
			        foreach ($arr as $key => $value) {

			            if($value['id']) {
			                if(empty($value['children'])) {
			                    $url = $name.'/'.$value['name'];
			                    if (strpos($url, 'catalog') !== false) {
			                    	//$url = '/catalog/'.$value['name']; // для одной
			                    	$url = $name.'/'.$value['name'];
			                    }
			                    $set_url = $url;
			                    $set_name = $value['title'];
			                    mysqli_query($GLOBALS['db'], "INSERT INTO `menu` (`rang`, `parent_id`, `name`, `url`, `show`) VALUES ('0', '$id', '$set_name', '$set_url', '1')");
			                    $kundeid = mysqli_insert_id($GLOBALS['db']);
			                } else {
			                    $url = $name.'/'.$value['name'];
			                    if (strpos($url, 'catalog') !== false) {
			                    	$url = '/catalog/'.$value['name'];
			                    }
			                    $set_url = $url;
			                    $set_name = $value['title'];
			                    mysqli_query($GLOBALS['db'], "INSERT INTO `menu` (`rang`, `parent_id`, `name`, `url`, `show`) VALUES ('0', '$id', '$set_name', '$set_url', '1')");
			                    $kundeid = mysqli_insert_id($GLOBALS['db']);
			                    menu_showNested($value['children'], $url, $kundeid);
			                }
			            }
			        }
			    }
			    mysqli_query($GLOBALS['db'], "TRUNCATE TABLE `menu`");
			    //$base_url = settings()['0']['url'];
			    foreach (pagesArr() as $key => $value) {
			        if($value['id']) {
			            if(empty($value['children'])) {
			                $url = '/'.$value['name'];
			                $set_url = $url;
			                $set_name = $value['title'];
			                mysqli_query($GLOBALS['db'], "INSERT INTO `menu` (`rang`, `parent_id`, `name`, `url`, `show`) VALUES ('0', '0', '$set_name', '$set_url', '1')");
			                $kundeid = mysqli_insert_id($GLOBALS['db']);
			            } else {
			                $url = '/'.$value['name'];
			                $set_url = $url;
			                $set_name = $value['title'];
			                mysqli_query($GLOBALS['db'], "INSERT INTO `menu` (`rang`, `parent_id`, `name`, `url`, `show`) VALUES ('0', '0', '$set_name', '$set_url', '1')");
			                $kundeid = mysqli_insert_id($GLOBALS['db']);
			                menu_showNested($value['children'], $url, $kundeid);
			            }
			        }
			    }
				echo json_encode(array(
					'result' => true,
					'title' => 'Выполнено',
					'type' => 'success',
					'redirect' => false,
					'reload' => true,
					'scroll' => 1,
					'message' => 'Успешно сброшено',
				));
			} else {
				echo admin_error();
			}
		} else {
			echo auth_error();
		}
	}

?>