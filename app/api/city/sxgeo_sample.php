<?php
include '../../ap/bd.php';

// Подключаем SxGeo.php класс
include("SxGeo.php");
// Создаем объект
// Первый параметр - имя файла с базой (используется оригинальная бинарная база SxGeo.dat)
// Второй параметр - режим работы: 
//     SXGEO_FILE   (работа с файлом базы, режим по умолчанию); 
//     SXGEO_BATCH (пакетная обработка, увеличивает скорость при обработке множества IP за раз)
//     SXGEO_MEMORY (кэширование БД в памяти, еще увеличивает скорость пакетной обработки, но требует больше памяти)
$SxGeo = new SxGeo('SxGeoCity.dat');
//$SxGeo = new SxGeo('SxGeoCity.dat', SXGEO_BATCH | SXGEO_MEMORY); // Самый производительный режим, если нужно обработать много IP за раз
//$ip = $_SERVER['REMOTE_ADDR'];
$ip = $_GET['ip'];
//$ip = '94.250.251.242';
//echo $ip;
$arr_city = $SxGeo->getCityFull($ip);
if($arr_city['region']['name_ru']) {
	$city_name = $arr_city['region']['name_ru'];
} else {
	$city_name = $arr_city['city']['name_ru'];
}

//$city_name = $SxGeo->getCityFull($ip)['city']['name_ru'];
//$city_name2 = $SxGeo->getCityFull($ip)['region']['name_ru'];

if($_SESSION['city_set']) {
	$not = 1;
} else {
	$not = 0;
}
//var_dump($SxGeo->getCityFull($ip));
if($city_name) {
	$query = mysqli_query($GLOBALS['db'], "SELECT * FROM `settings` WHERE `city_name` LIKE '%$city_name%'");
	if(mysqli_num_rows($query) > 0) {
		$row = mysqli_fetch_assoc($query);
		if($_SESSION['city_set']) {} else {
			$_SESSION['city_set'] = $row['id'];
		}
		echo json_encode(array(
			'result' => true,
			'notify' => $not,
			'message' => 'City accept',
			'city_name' => $row['city_name'],
		));
	} else {
		mysqli_query($GLOBALS['db'], "INSERT INTO `products_stars` (`product_id`, `user_uid`) VALUES ('$uidd', '$user_uid')");
		if($_SESSION['city_set']) {} else {
			$_SESSION['city_set'] = 1;
		}
		echo json_encode(array(
			'result' => false,
			'notify' => $not,
			'message' => 'City not found in database'
		));
	}
} else {
	if($_SESSION['city_set']) {} else {
		$_SESSION['city_set'] = 1;
	}
	echo json_encode(array(
		'result' => false,
		'notify' => $not,
		'message' => 'City not found'
	));
}

//echo json_encode(array('city' => $city_name));
//var_export($SxGeo->getCityFull($ip)); // Вся информация о городе
//var_export($SxGeo->get($ip));         // Краткая информация о городе или код страны (если используется база SxGeo Country)
//var_export($SxGeo->about());          // Информация о базе данных
