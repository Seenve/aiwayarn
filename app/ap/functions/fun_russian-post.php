<?php
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
	function delivery($fromIndex = null, $toIndex = null) {
		$arr = array();


		//if(count($data) > 0) {
			$arr['result'] = true;
			$arr['tariff'] = 0;
			$arr['price'] = 250;
			$arr['period_min'] = 1;
			$arr['period_max'] = 3;
			$arr['currency'] = 'RUB';
		//} else {
		//	$arr['result'] = false;
		//}
		return $arr;
	}
?>