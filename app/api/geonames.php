<?php
	header('Content-Type: application/json; charset=utf-8');

	$string = isset($_GET['search']) ? $_GET['search'] : '';

	require '../ap/libs/dadata/vendor/autoload.php';

	/*$token = "e4931a40f6df8b4ee6a3b09caec271e2a51638b4";
	$secret = "99eb5daa0002176c717514c6316f0baa9d9320ef";
	$dadata = new \Dadata\DadataClient($token, $secret);

	$response = $dadata->clean("address", "ново");*/



    $token = "e9ba9c7e0d228634540f61afcdf86a3310648ca8";
	$dadata = new \Dadata\DadataClient($token, null);
	$result = $dadata->suggest("address", $string);


   	//echo '<pre>';
    //echo json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    //echo '</pre>';

    echo json_encode($result);

    /*echo json_encode(array(
    	'result' => true,
    	'arr' => array(
    		0 => 'г Москва',
    		1 => 'г Москва',
    		2 => 'г Москва',
    	),
    ));*/


/*
    {
        "value": "г Иркутск, ул Безымянная",
        "unrestricted_value": "664050, Иркутская обл, г Иркутск, ул Безымянная",
        "data": {
            "postal_code": "664050",
            "country": "Россия",
            "country_iso_code": "RU",
            "federal_district": null,
            "region_fias_id": "6466c988-7ce3-45e5-8b97-90ae16cb1249",
            "region_kladr_id": "3800000000000",
            "region_iso_code": "RU-IRK",
            "region_with_type": "Иркутская обл",
            "region_type": "обл",
            "region_type_full": "область",
            "region": "Иркутская",
            "area_fias_id": null,
            "area_kladr_id": null,
            "area_with_type": null,
            "area_type": null,
            "area_type_full": null,
            "area": null,
            "city_fias_id": "8eeed222-72e7-47c3-ab3a-9a553c31cf72",
            "city_kladr_id": "3800000300000",
            "city_with_type": "г Иркутск",
            "city_type": "г",
            "city_type_full": "город",
            "city": "Иркутск",
            "city_area": null,
            "city_district_fias_id": null,
            "city_district_kladr_id": null,
            "city_district_with_type": null,
            "city_district_type": null,
            "city_district_type_full": null,
            "city_district": null,
            "settlement_fias_id": null,
            "settlement_kladr_id": null,
            "settlement_with_type": null,
            "settlement_type": null,
            "settlement_type_full": null,
            "settlement": null,
            "street_fias_id": "fadf6a68-ae30-4e27-be7f-9ae983d4e33c",
            "street_kladr_id": "38000003000005200",
            "street_with_type": "ул Безымянная",
            "street_type": "ул",
            "street_type_full": "улица",
            "street": "Безымянная",
            "house_fias_id": null,
            "house_kladr_id": null,
            "house_type": null,
            "house_type_full": null,
            "house": null,
            "block_type": null,
            "block_type_full": null,
            "block": null,
            "entrance": null,
            "floor": null,
            "flat_fias_id": null,
            "flat_type": null,
            "flat_type_full": null,
            "flat": null,
            "flat_area": null,
            "square_meter_price": null,
            "flat_price": null,
            "postal_box": null,
            "fias_id": "fadf6a68-ae30-4e27-be7f-9ae983d4e33c",
            "fias_code": "3800000300000000052",
            "fias_level": "7",
            "fias_actuality_state": "0",
            "kladr_id": "38000003000005200",
            "geoname_id": "2023469",
            "capital_marker": "2",
            "okato": "25401380000",
            "oktmo": "25701000001",
            "tax_office": "3812",
            "tax_office_legal": "3812",
            "timezone": null,
            "geo_lat": "52.286387",
            "geo_lon": "104.28066",
            "beltway_hit": null,
            "beltway_distance": null,
            "metro": null,
            "qc_geo": "4",
            "qc_complete": null,
            "qc_house": null,
            "history_values": null,
            "unparsed_parts": null,
            "source": null,
            "qc": null
        }
    },*/

?>