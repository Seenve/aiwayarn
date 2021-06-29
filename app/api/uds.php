<?php

include '../ap/bd.php';

    if(authuser()) {
        $user_uid = authuser();
    } else {
        $user_uid = guest();
    }

$date = new DateTime();
$promoCode = 166037;
$url = 'https://udsgame.com/v1/partner/promo-code?code='.$promoCode;

// Create a stream
$opts = array(
    'http' => array(
        'method' => 'GET',
        'header' => "Accept: application/json\r\n" .
                    "Accept-Charset: utf-8\r\n" .
                    "X-Api-Key: ".settings()['0']['key_uds']."\r\n" .
                    "X-Origin-Request-Id: ".$uuid."\r\n" .
                    "X-Timestamp: ".$date->format(DateTime::ATOM)
    )
);

$context = stream_context_create($opts);
$result = file_get_contents($url, false, $context);
$result = json_decode($result, true);
var_dump($date);
var_dump($result);



/*use PHPUnit\Framework\TestCase;

class UDSGameTest extends TestCase {

  public function testParsePromoCode() {
    $UDS = new UDSGame(Data::$apiKey);
    $promoCodeInfo = $UDS->parsePromoCode(Data::$promoCode);
    $this->assertEquals($promoCodeInfo->code, Data::$promoCode);
  }

  public function testGetClientInfoByCode() {
    $UDS = new UDSGame(Data::$apiKey);
    $clientInfo = $UDS->getClientInfoByCode(Data::$promoCode);
    $this->assertObjectHasAttribute('id', $clientInfo);
  }

  public function testGetClientInfoById() {
    $UDS = new UDSGame(Data::$apiKey);
    $clientInfo = $UDS->getClientInfoById(Data::$clientId);
    $this->assertObjectHasAttribute('id', $clientInfo);
  }

  public function testGetCompanyInfo() {
    $UDS = new UDSGame(Data::$apiKey);
    $companyInfo = $UDS->getCompanyInfo();
    $this->assertObjectHasAttribute('id', $companyInfo);
  }

}*/

/*
//Задать переменные
//Промо-код из приложения UDS Game
$promoCode = "874782";
//Ключ API из UDS Game Admin компании
$apiKey = "NDBiZTVjODItNmJjNy00MThhLTk3NTItMjY0NTNjMWQzM2U4";
//Айди клиента, можно получить по промокоду
//$clientId = "824638291027";
//Количество баллов, для оплаты части суммы заказа
$scores = 10;
//Полная сумма заказа
$summ = 1000;
//Часть суммы заказа, оплаченная деньгами, $cash = $total - $scores
$cash = $total - $scores;
//Номер счета
$invoiceNumber = "33";

//Создать объект класса UDSGame
$UDS = new UDSGame\UDSGame(settings()['0']['key_uds']);

//Получить информацию о клиенте по промо-коду
$clientInfo = $UDS->getClientInfoByCode($promoCode);
$clientId = $clientInfo->id;

//Получить информацию о клиенте по ид клиента
//$clientInfo = $UDS->getClientInfoById($clientId);

//Получить информацию о промо-коде
$promoCodeInfo = $UDS->parsePromoCode($promoCode);

//Получить информацию о компании, которой принадлежит ключ API
#$companyInfo = $UDS->getCompanyInfo();

//Совершить покупку
//$operation = $UDS->makePayment($promoCode, $scores, $total, $cash, $invoiceNumber);
$operation = $UDS->makePayment(178269, $scores, $summ, $cash);
$points = 0;
//$operation = $UDS->make_balls(824638291027, 0, $summ, $cash, $points);

echo json_encode($operation);
//Отменить операцию
#$companyInfo = $UDS->revertOperation($operation->id);
*/
/** 
 * Результатом выполнения всех функций является объект, с полями, информацию о которых можно посмотреть в документации к API
 * https://udsgame.com/api-docs/partner#
 */

/*{"cash":990,"cashier":null,"customer":{"id":824638291027,"surname":"\u0411\u0443\u043b\u0430\u043d\u043e\u0432","name":"\u041d\u0438\u043a\u043e\u043b\u0430\u0439"},"dateCreated":"2019-07-02T13:07:29.880Z","id":77681368,"marketingSettings":{"discountBase":10,"discountLevel1":5,"discountLevel2":3,"discountLevel3":2,"maxScoresDiscount":50},"participantId":1099529617339,"scoresDelta":-10,"total":1000}*/