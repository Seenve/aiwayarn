<?
    function sendTelegram($token, $chat_id, $message) {
        //https://api.telegram.org/bot476421379:AAEoviECRe3Ugul9FJYcl43dOSOCFE1Kc7o/getUpdates?offset=-10&limit=10
        $t_message = urlencode($message);
        //$send_telegram = fopen("https://s4.gep.su/api/?token={$token}&type=sendMessage&chat_id={$chat_id}&parse_mode=Markdown&text={$t_message}","r");
        $send_telegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=Markdown&text={$t_message}","r");
        if (!feof($send_telegram)) {
            $send_status = fgets($send_telegram);
            $send_result = json_decode($send_status, true);
            return $send_result;
        } else {
            return false;
        }
    }
?>