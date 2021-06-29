<?php
	header('Content-Type: application/json');

	//$type = $_GET['type'];

	$postvars = array(
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


	echo $answer;


?>