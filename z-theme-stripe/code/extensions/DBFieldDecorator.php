<?php
class DBFieldDecorator extends DataExtension{
	/**
	 * No HTML
	 */
	public function noHTML(){
		$text = $this->owner->value;
		$text = preg_replace("'<script[^>]*>.*?</script>'si", '', $text);
        $text = preg_replace('/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $text);
        $text = preg_replace('/<!--.+?-->/', '', $text);
        $text = preg_replace('/{.+?}/', '', $text);
        $text = preg_replace('/&nbsp;/', ' ', $text);
        $text = preg_replace('/&amp;/', ' ', $text);
        $text = preg_replace('/&quot;/', ' ', $text);
        $text = strip_tags($text);
        $text = htmlspecialchars($text);
		
		return trim($text);
	}
	
	/**
	 * No Space
	 */
	public function noSpace(){
		$val = $this->owner->value;
		
		return str_replace(' ', '', $val);
	}
	
	/**
	 * Base64 encoding / decoding
	 */
	public function base64($decode = false){
		$val = $this->owner->value;
		
		return ( $decode ? base64_decode($val) : base64_encode($val) );
	}
	
	/**
	 * Safe string to use on the URL
	 */
	public function safeURLString($encode = false){
		$val = $this->owner->value;
		
		return ( $encode ? urlencode($val) : URLSegmentFilter::create()->filter($val) );
	}
}