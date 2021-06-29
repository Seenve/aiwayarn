<?php
    function sms($userPhone, $text) {
        $message = urlencode($text);
        $send_get = fopen("https://sms.gep.su/?key=bd7f820fe9a9b70241841e85c5293d06&phone={$userPhone}&message={$message}","r");

        if (!feof($send_get)) {
            $send_get_status = fgets($send_get);
            $send_get_result = json_decode($send_get_status, true);
        }

        if ($send_get_result['send'] == true) {
            return true;
        } else {
            return false;
        }
    }
?>