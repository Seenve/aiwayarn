<?

    ini_set('display_errors', 0);

    header('Content-Type: application/json');

	require __DIR__ . '/lib/autoload.php'; 

    use YandexCheckout\Client;

    $paymentId = $_GET['id'];

    if($paymentId) {
        $client = new Client();
        $client->setAuth('527818', 'live_oPiQlnCG9yGal01w82MUmR8BxduoldARO_o_3yNZy2k');

        $payment = $client->getPaymentInfo($paymentId);
        $result = json_encode($payment);

        //echo $result;

        if($payment['status']) {
            echo json_encode(array(
                'result' => true,
                'order_id' => $payment['metadata']['order_id'],
                'status' => $payment['status'],
            ));
        } else {
            echo json_encode(array(
                'result' => false,
                'message' => 'Not found - ID',
            ));
        }
    } else {
        echo json_encode(array(
            'result' => false,
            'message' => 'Empty - ID',
        ));
    }

?>