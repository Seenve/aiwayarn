<?
	ini_set('display_errros', 0);

    header('Content-Type: application/json');

	require __DIR__ . '/lib/autoload.php'; 

    use YandexCheckout\Client;

    $client = new Client();
    $client->setAuth('527818', 'live_oPiQlnCG9yGal01w82MUmR8BxduoldARO_o_3yNZy2k');

    #$total_summ = 100;
    #$order_id = 111;
    $order_id = preg_replace("/[^0-9]/", '', $_GET['order_id']);
    $total_summ = preg_replace("/[^0-9]/", '', $_GET['total_summ']);

    if($order_id && $total_summ) {
        $payment = $client->createPayment(
            array(
                'amount' => array(
                    'value' => $total_summ,
                    'currency' => 'RUB',
                ),
                'confirmation' => array(
                    'type' => 'redirect',
                    'return_url' => 'https://pikformy.ru/order/'.$order_id,
                ),
                'metadata' => array(
                    'order_id' => $order_id,
                ),
                'capture' => true,
                'description' => 'Заказ №'.$order_id,
            ),
            uniqid('', true)
        );
        $result = json_encode($payment);
    } 

    if($payment['confirmation']['confirmation_url']) {
        echo json_encode(array(
            'result' => true,
            'payment_id' => $payment['id'],
            'url' => $payment['confirmation']['confirmation_url'],
        ));
    } else {
        echo json_encode(array(
            'result' => false,
        ));
    }
?>