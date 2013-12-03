<?

/**
 * Author: t0pep0
 * e-mail: t0pep0.gentoo@gmail.com
 * Jabber: t0pep0@jabber.ru
 * BTC   : 1ipEA2fcVyjiUnBqUx7PVy5efktz2hucb
 * donate free =)
 * 
 * Update: 12/2/13
 * Author: Zack Urben
 * Email : zackurben@gmail.com
 * Motivation BTC: 1HvXfXRP9gZqHPkQUCPKmt5wKyXDMADhvQ
 */

class cexapi {
	private $username;
	private $api_key;
	private $api_secret;
	private $nonce_v;

	/**
	 * Create class
	 * @param unknown $username
	 * @param unknown $api_key
	 * @param unknown $api_secret
	 */
	public function __construct($username, $api_key, $api_secret) {
		$this->username = $username;
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;
	}

	/**
	 * Create signature 
	 * @return unknown
	 */
	private function signature() {
		$string = $this->nonce_v . $this->username . $this->api_key; //Create string
		$hash = hash_hmac('sha256', $string, $this->api_secret); //Create hash
		$hash = strtoupper($hash);
	   
	   return $hash;
	}
	 
	/**
	 * Set nonce as timestamp
	 */
	private function nonce() {
		$this->nonce_v = time();
	}
	 
	/**
	 * Send post request to Cex.io API
	 * @param unknown $url
	 * @param unknown $param
	 * @return unknown
	 */
	private function post($url, $param = array()) {
		$post = '';
		if (!empty($param)) {
	    	foreach($param as $k => $v) {
				$post .= $k . '=' . $v . '&'; //Dirty, but work
	    	}
	    	
			$post = substr($post, 0, strlen($post)-1);
		}
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'phpAPI');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$out = curl_exec($ch);
		curl_close($ch);
		
		return $out;
	} 
	
	/**
	 * send api call (over post request)
	 * @param unknown $method
	 * @param unknown $param
	 * @param string $private
	 * @param string $couple
	 * @return unknown
	 */
	public function api_call($method, $param = array(), $private = false, $couple = '') {
	   $url = "https://cex.io/api/$method/"; //Create url
	   
		if ($couple !== '') {
			$url .= "$couple/"; //set couple if needed
		}
		
		if ($private === true) { //Create param
			$this->nonce();
			$param = array_merge(array(
					'key' => $this->api_key,
					'signature' => $this->signature(),
					'nonce' => $this->nonce_v), $param);
	    }
		
	    $answer = $this->post($url, $param);
		$answer = json_decode($answer, true);
	   
		return $answer;
	}
	
	/**
	 * 
	 * @param string $couple
	 * @return unknown
	 */
	public function ticker($couple) {
		return $this->api_call('order_book', array(), false, $couple = 'GHS/BTC');
	}
	
	/**
	 * 
	 * @param number $since
	 * @param string $couple
	 * @return unknown
	 */
	public function trade_history($since = 1, $couple = 'GHS/BTC') {
		return $this->api_call('trade_history', array("since" => $since), false, $couple);
	}
	
	/**
	 * 
	 * @return unknown
	 */
	public function balance() {
		return $this->api_call('balance', array(), true);
	}
	
	/**
	 * 
	 * @param string $couple
	 * @return unknown
	 */
	public function open_orders($couple = 'GHS/BTC') {
		return $this->api_call('open_orders', array(), true, $couple);
	}
	
	/**
	 * 
	 * @param unknown $order_id
	 * @return unknown
	 */
	public function cancel_order($order_id) {
		return $this->api_call('cancel_order', array("id" => $order_id), true);
	}
	
	/**
	 * 
	 * @param string $ptype
	 * @param number $amount
	 * @param number $price
	 * @param string $couple
	 * @return unknown
	 */
	public function place_order($ptype = 'buy', $amount = 1, $price = 1, $couple = 'GHS/BTC') {
		return $this->api_call('place_order', array(
			"type" => ptype,
	    	"amount" => amount,
			"price" => price), true, couple);
	}
} 
?>