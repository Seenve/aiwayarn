<?php

	//$type = $_GET['type'];

	/*$postvars = array(
	    '@dateExecute2' => '2021-04-01',
	    '@senderCityId' => 36528,
	    '@receiverCityId ' => 288,
	    '@tariffId' => 1,
	    '@weight' => 300,
	    '@length' => 20,
	    '@width' => 20,
	    '@height' => 20,
	);
	$postdata = http_build_query($postvars);

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_URL, 'http://api.cdek.ru/calculator/calculate_price_by_json.php');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$answer = curl_exec($curl);
	curl_close($curl);


	echo $answer;*/

header('Content-type: application/json; charset=utf-8');

function russianPost($fromIndex = null, $toIndex = null, $weight = 1, $lenght = 20, $width = 20, $height = 20) {
	$arr = array();
	$postvars = array(
	    'from' => $fromIndex,
	    'to' => $toIndex,
	    'mass ' => $weight,
	    'vat' => 1,
	);
	$postdata = http_build_query($postvars);



	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://postprice.ru/engine/russia/api.php?$postdata");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($ch); 
	curl_close($ch);

	$json_string = stripslashes($result);
	$data = json_decode($json_string, true);


	if(count($data) > 0) {
		$arr['result'] = true;
		$arr['tariff'] = $data['cod'];
		$arr['price'] = $data['pkg'];
		$arr['period_min'] = 0;
		$arr['period_max'] = 0;
		$arr['currency'] = 'RUB';
	} else {
		$arr['result'] = false;
	}
	return $arr;
}

echo json_encode(russianPost('630061', '666032', 0.3, 15, 20, 20));


?>