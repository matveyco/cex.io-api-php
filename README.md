#Cex.io API
PHP source files and examples for the Cex.io API.

##How to use:
1. Download API source
2. Generate API key and API secret (https://cex.io/trade/profile)
3. Create your PHP project
4. Add the API import:

```php
require_once("cexapi.class.php");
```
5. Create an API object:

```php
$api = new cexapi($username, $api_key, $api_secret);
```

```php
$username;		// Your username on Cex.io
$api_key;		// Your API key
$api_secret;	// Your API secret
```

##Methods and Parameters:
Parameters:

```php
			// Description (Data Type): Examples
$couple;	// Currency pair (String): "GHS/BTC", "NMC/BTC", "GHS/NMC", "BF1/BTC"
$since;		// Timestamp (Integer): TODO
$order_id;	// Order Number (Integer): TODO
$ptype;		// Order Type (String): "buy", "sell"
$amount;	// Order Quantitity (Float): TODO 
$price;		// Order Price (Float): TODO
```

Methods:

```php 
// Method Format:
// Description with Parameters(default value)
// Method(Parameters);
   
// Get ticker results for $couple("GHS/BTC")
ticker($couple);

// Get buy/sell data for $couple("GHS/BTC")
order_book($couple);

// Get trade history $since(1), for $couple("GHS/BTC") 
trade_history($since, $couple);

// Get account balance
balance();

// Get account open orders for $couple("GHS/BTC")
open_orders($couple);

// Cancel account order with $order_id(none)
cancel_order($order_id);

// Place order of $ptype("buy"), for $amount(1), at $price(1), for $couple("GHS/BTC").
place_order($ptype, $amount, $price, $couple);
```
 
##Examples:
Connect and create API object:

```php
<?php
	requre_once("cexapi.class.php");
	$api = new cexapi($username, $api_key, $api_secret);
	
	// Call API methods here
?>
```

Get the pair ticker:

```php
var_dump($api->ticker("GHS/BTC"));
```

```json
{'volume': '7154.78339022', 'last': '0.1078', 'timestamp': '1383379041', 'bid': '0.10778', 'high': '0.10799999', 'low': '0.10670076', 'ask': '0.10780000000000001'}
```

Get the order book:

```php
var_dump($api->order_book("BF1/BTC"));
```

```json
{'timestamp': '1383378967', 'bids': [['1.7', '0.30100000'], ['1.67', '0.00011000'], ['0.8', '0.02070000'], ['0.1002', '0.27748002'], ['0.1', '0.10000000'], ['0.011', '0.30500000'], ['0.009', '1.00000000'], ['0.00171', '0.00100000'], ['0.0012', '1.00000000'], ['0.00116819', '0.50000000'], ['0.001002', '33.00000000'], ['0.001001', '53.00000000'], ['0.001', '3.00000000'], ['0.00097626', '36.00000000'], ['0.0006', '85.00000000'], ['0.00058409', '0.50000000'], ['0.0004889', '0.06823960'], ['0.0003', '1.00000000'], ['0.00029204', '0.90000000'], ['0.0001', '101.00000000']], 'asks': []}
```

Get your account balance:

```php
var_dump($api->balance());
```

```json
{'timestamp': '1383379054', 'BTC': {'available': '0.04614310', 'orders': '0.00170000'}, 'GHS': {'available': '0.02000000'}}
```

Get your current active orders:

```php
var_dump($api->open_orders("BF1/BTC"));
```

```json
[{'price': '1.7', 'amount': '0.00100000', 'time': '1383378514737', 'type': 'buy', 'id': '6219104', 'pending': '0.00100000'}]
```

Place a new order:

```php
var_dump($api->place_order("buy", 0.001, 1.7, "BF1/BTC"));
```

```json
{'price': '1.7', 'amount': '0.00100000', 'time': 1383378987622, 'type': 'buy', 'id': '6219145', 'pending': '0.00100000'}
```

Cancel an order:

```php
var_dump(api->cancel_order(6219145));
```

```json
True
```

##Additional Help
* Cex.io online API documentation: https://cex.io/api

##Known Issues

API always returns null. Issue is caused by incorrect SSL certificates on the client. To fix, download [this .pem file](http://curl.haxx.se/ca/cacert.pem) and add the following line to your _php.ini_ file:

```
curl.cainfo=[PATH-TO]/cacert.pem
```
