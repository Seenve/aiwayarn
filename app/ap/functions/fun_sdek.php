<?php
function sdek($fromIndex = null, $toIndex = null, $weight = 1, $lenght = 20, $width = 20, $height = 20, $type = 1) {
	require_once __DIR__.'/../../ap/libs/sdek/vendor/autoload.php';
	$client = new \CdekSDK\CdekClient('fUftXf5shJ7qntH8l4bo1ZPvk85FNbSW', 'x51LV4zlrUp33DGt3cdDhQ4m56L47qzF');

	//$request = new \CdekSDK\Requests\CalculationWithTariffListRequest();
	$request = new \CdekSDK\Requests\CalculationAuthorizedRequest();
	$request->setSenderCityPostCode($fromIndex)
	    ->setReceiverCityPostCode($toIndex)
	    ->setCurrency('RUB')
	    ->setTariffId($type) //->addTariffToList(8)
	    ->addPackage([
	        'weight' => $weight,
	        'length' => $lenght,
	        'width'  => $width,
	        'height' => $height,
	    ]);

	$response = $client->sendCalculationRequest($request);
	$arr = array();
	$arr['result'] = true;

	if ($response->hasErrors()) {
	    // обработка ошибок
	    $arr['result'] = false;
	} else {
		$arr['result'] = true;
		$arr['tariff'] = $response->getTariffId();
		$arr['price'] = $response->getPrice();
		$arr['period_min'] = $response->getDeliveryPeriodMin();
		$arr['period_max'] = $response->getDeliveryPeriodMax();
		$arr['currency'] = $response->getCurrency();
	}

	return $arr;
/*

	$request = new \CdekSDK\Requests\CalculationWithTariffListAuthorizedRequest();
	//$request = new \CdekSDK\Requests\CalculationWithTariffListRequest();
	$request->setSenderCityPostCode($fromIndex)
	    ->setReceiverCityPostCode($toIndex)
	    ->setCurrency('RUB')
	    ->addTariffToList($type) //->addTariffToList(8)
	    ->addPackage([
	        'weight' => $weight,
	        'length' => $lenght,
	        'width'  => $width,
	        'height' => $height,
	    ]);
	$response = $client->sendCalculationWithTariffListRequest($request);
	$arr = array();
	if ($response->hasErrors()) {
		$arr['result'] = false;
		$i = 0;
	    foreach ($response->getErrors() as $err) {
	        $arr['error'][$i]['code'] = $err->getErrorCode();
	        $arr['error'][$i]['message'] = $err->getMessage();
	        $i++;
	    }
	    return $arr;
	    $i = 0;
	} else {
		$i = 0;
		$arr['result'] = true;
		foreach ($response->getResults() as $result) {
		    if ($result->hasErrors()) {
		        // обработка ошибок
		        $arr['result'] = false;
		        continue;
		    }
		    if (!$result->getStatus()) {
		        continue;
		    }
			$arr['tariff'] = $result->getTariffId();
			$arr['price'] = $result->getPrice();
			$arr['period_min'] = $result->getDeliveryPeriodMin();
			$arr['period_max'] = $result->getDeliveryPeriodMax();
			$arr['currency'] = $result->getCurrency();
			$i++;
		}
		return $arr;
	}*/
}
?>