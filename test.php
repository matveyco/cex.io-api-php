<?
 include_once('cexapi.class.php');
 $api = new cexapi('username', 'api_key', 'api_secret_code');
 echo "Ticker:\n\r";
 echo json_encode($api -> ticker("GHS\BTC"));
 echo "\n\rBalance:\n\r";
 echo json_encode($api -> balance());
 echo "\n\rstrlen(json(open_orders)): \r\n";
 echo strlen(json_encode($api -> open_orders()));
 echo "\n\r";
?>
