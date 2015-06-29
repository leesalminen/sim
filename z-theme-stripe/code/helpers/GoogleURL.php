<?php
/**
 * https://chart.googleapis.com/chart?cht=qr&chs=150x150&choe=UTF-8&chld=H&chl=http://goo.gl/Lp33l
*/
class GoogleUrl{
	/**
	 * instance variable
	 */
	static $instance = null;
	
	/**
	 * The API url
	 */
	protected $apiURL = 'https://www.googleapis.com/urlshortener/v1/url';
	
	/**
	 * The API key
	 */
	protected $apiKey = 'AIzaSyCtzFCRuDupRiymEQVv9XvCOPxVgqa5efI';
	
	/**
	 * Method to construct
	 */
	public function __construct($options = array()){
		//blank
	}
	
	/**
	 * Method to init
	 */
	public static function init( $options = array() ){
		if(!self::$instance){
			self::$instance = new GoogleUrl($options);
		}
		
		return self::$instance;
	}
	
	/**
	 * Method to shorten a URL
	 */
	public function shorten($url) {
		$postData = array('longUrl' => $url, 'key' => $this->apiKey);
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->apiURL);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData) );
		
		
		$res = curl_exec($ch);
		curl_close($ch);
		
		//decode result
		$res = json_decode($res);
		
		//return the short url
		return ( isset($res->id) ? $res->id : $url );
	}
	
	/**
	 * Method to expand a URL
	 */
	public function expand($url) {
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->apiURL.'?shortUrl='.$url.'&projection=FULL');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
		
		
		$res = curl_exec($ch);
		curl_close($ch);
		
		//decode result
		$res = json_decode($res);
		
		//return result
		return $res;
	}
}