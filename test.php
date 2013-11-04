<?
 include_once('tradeapi.class.php');
 $api = new tradeapi('username', 'api_key', 'api_secret_code');
 var_dump($api -> api_call('ticker',array(),false,'GHS/BTC'));
 var_dump($api -> api_call('balance',array(),true));
?>
