<?php
	//phpinfo();
	SESSION_START();

	//require 'vendor/autoload.php';

	$version = '1.4';

    /*if(intval($_SESSION['city_set'])) {
    	$GLOBALS['city'] = intval($_SESSION['city_set']);
    } else {
    	$GLOBALS['city'] = 1;
    }

	if(isset($_GET['city'])) {
		$GLOBALS['city'] = intval($_GET['city']);
		$_SESSION['city_set'] = intval($_GET['city']);
	}*/

	$GLOBALS['city'] = 1;
	$city_products = $GLOBALS['city'];

	ini_set('display_errors', 0);
	error_reporting(E_ALL);
	$GLOBALS['db'] = mysqli_connect('localhost', 'aiwayarn_bd', 'pGf4SyTKET', 'aiwayarn_bd');
	if(!$GLOBALS['db']) {
		$GLOBALS['db'] = mysqli_connect('localhost', 'root', 'sda43ca1', 'aiwayarn_bd');
	}
	mysqli_set_charset($GLOBALS['db'], 'utf8');
	//setlocale(LC_ALL, 'ru_RU.UTF-8');
	//date_default_timezone_set('Asia/Novosibirsk');
	date_default_timezone_set('Europe/Moscow');

	$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$path = __DIR__;
	include 'fun.php';

    foreach (glob("$path/functions/fun_*.php") as $docFile) {
       include $docFile;
    }

	$timeNow = time();
	$GLOBALS['path'] = $path;
	$core = $_SERVER['DOCUMENT_ROOT'];

    if(!authuser()) {
    	$uuid = isset($_SESSION['useruid']) ? $_SESSION['useruid'] : '';
	    if($uuid == '') {
    		$uuid = makeUUID();
			$_SESSION['useruid'] = $uuid;
	    }
    } else {
    	$uuid = authuser();
    }
    $user_uid = $uuid;


    //require __DIR__ . '/yandex-kassa/lib/autoload.php';

?>