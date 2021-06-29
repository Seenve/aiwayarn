<?php
	//header("Cache-control: public");
	//header("Cache-Control: public, max-age=31536000");
	//header("Expires: " . gmdate("D, d M Y H:i:s", time() + 60) . " GMT");

	$title = '';
	$description = '';
	$keywords = '';
	$og_url = '';
	$og_image = '';
	$ajax = false;

	//var_dump($_GET);
	
	if (!isset($_SERVER['HTTP_X_PJAX'])) { 
		include 'ap/bd.php';
		$page = isset($_GET['page']) ? $_GET['page'] : '';
		$page = val_string($page);
		$arrGet = $_GET;

		if(count($_GET) > 0) {} else {
			$arr = explode("/", $_SERVER['REQUEST_URI']);
			if(count($arr) > 2) {
				header("HTTP/1.0 404 Not Found");
				include 'pages/404.php';
				exit();
			} else {
				$arr = explode("?", $_SERVER['REQUEST_URI']);
				if(count($arr) > 1) {
					header("HTTP/1.0 404 Not Found");
					include 'pages/404.php';
					exit();
				}
			}
		}

		#include 'ap/functions/stats.php';
		$pagen='pages/'.$page.'.php';
		$query_pages = mysqli_query($GLOBALS['db'], "SELECT * FROM `pages` WHERE `name`='$page' AND `show`='1' AND `category`='0'");
		if(mysqli_num_rows($query_pages) > 0) {
			$row_pages = mysqli_fetch_array($query_pages);
			$id_page = $row_pages['id'];
			$name_page = $row_pages['name'];
			$title_page = $row_pages['title'];
			$include_page = $row_pages['include'];
			$category_page = $row_pages['category'];
			$show_page = $row_pages['show'];
			$set_id = $set['info']['id'];
			if($row_pages['include'] == 1) {
				if($page == '') $pagen = 'pages/main.php';
				if (file_exists($pagen)) {
				    include $pagen;
				    include 'footer.php';
				} else {
					$content = $row_pages['content'];
					include 'content.php';
				    include 'footer.php';
				}
			} else {
			    $set = array('result' => true);
				foreach ($arrGet as $key => $value) {
					if($set['result'] == true) {
						$set = page_cat(val_string($value));
					}
				}
				if($set['result'] == true) {
					include 'content.php';
					include 'footer.php';
				} else {
					header("HTTP/1.0 404 Not Found");
					include 'pages/404.php';
					exit();
				}
			}
			//visit($name_page, $_SERVER[REQUEST_URI]);
		} else {
			header("HTTP/1.0 404 Not Found");
			include 'pages/404.php';
			exit();
		}
	} else { 
		include 'ap/bd.php';
		$page = isset($_GET['page']) ? $_GET['page'] : '';
		$page = val_string($page);

		#include 'ap/functions/stats.php';
		$pagen='pages/'.$page.'.php';
		$query_pages = mysqli_query($GLOBALS['db'], "SELECT * FROM `pages` WHERE `name`='$page' AND `show`='1'");
		if(mysqli_num_rows($query_pages) > 0) {
			$row_pages = mysqli_fetch_array($query_pages);
			$id_page = $row_pages['id'];
			$set_id = $id_page;
			$name_page = $row_pages['name'];
			$title_page = $row_pages['title'];
			$include_page = $row_pages['include'];
			$category_page = $row_pages['category'];
			$show_page = $row_pages['show'];
			if($row_pages['include'] == 1) {
				if($page == '') $pagen = 'pages/main.php';
				if (file_exists($pagen)) {
				    include $pagen;
				} else {
				    $content = $row_pages['content'];
				    include 'content.php';
				}
			} else {
				$content = $row_pages['content'];
				include 'content.php';
			}
				//visit($name_page, $_SERVER[REQUEST_URI]);
		} else {
		    $set = array('result' => true);
			foreach ($arrGet as $key => $value) {
				if($set['result'] == true) {
					$set = page_cat(val_string($value));
				}
			}
			if($set['result'] == true) {
				$set_id = $set['info']['id'];
				include 'content.php';
			} else {
				include 'pages/404.php';
				exit();
			}
		}
	?> 
		<title><?php echo meta($_GET, true)['title']; ?></title>
	<?php 
	} 
?>