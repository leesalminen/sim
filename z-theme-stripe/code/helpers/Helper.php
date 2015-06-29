<?php
class iHelper
{
    /**
     * Method to make string be safe
     */
    public static function stringURLSafe($string)
	{
		//remove any '-' from the string since they will be used as concatenaters
		$str = str_replace('-', ' ', $string);
        
		// Convert certain symbols to letter representation
		$str = str_replace(array('&', '"', '<', '>'), array('a', 'q', 'l', 'g'), $str);
        
		// Lowercase and trim
		$str = trim(strtolower($str));
        
		// Remove any duplicate whitespace, and ensure all characters are alphanumeric
		$str = preg_replace(array('/\s+/','/[^A-Za-z0-9\-]/'), array('-',''), $str);

		return $str;
	}
    
    /**
	 * Method to create an excerpt from contents
	 */
	public static function createExcerpt($string, $maxOut)
	{
        //Clean input text
        $string = self::cleanText($string);
        
	    $string2Array = explode(' ', $string, ($maxOut + 1));
	    
	    if( count($string2Array) > $maxOut ){
	       array_pop($string2Array);
	       $output = implode(' ', $string2Array)."...";
	    }else{
		$output = $string;
	    }
	    return $output;
	}
    
    /**
    *
    * Cleans text of all formating and scripting code
    *
    * @access public
    * @return string
    */
    public static function cleanText(&$text)
    {
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
	
	/*
	 * Method to extract image from a string
	 */
	public static function parseImage($string='', $alText='')
	{
		if( trim($string) == '' ) return false;
		$alText = ($alText != '') ? $alText : 'Image';
		$output = '';
		
		$regex = "/\<img.+src\s*=\s*\"([^\"]*)\"[^\>]*\>/";
	    preg_match ($regex, $string, $matches);
	    $images = (count($matches)) ? $matches : array();
	    $image = '';
	    if (count($images)) $image = $images[1];
		
		if($image){
			$output .= '<img src="'.$image.'" alt="'.$alText.'" />';
		}
		
		return $output;
	}
	
	/**
	 * Build ImageField
	 */
	public static function ImageField($name, $label, $folder){
		$f = new ImageField($name, $label);
		$f->setFolderName($folder);
		
		return $f;
	}
	
	/**
	 * Image Upload Field
	 */
	public static function ImageUploadField($name, $label, $folder, $items=null){
		$f 					  = new UploadField($name, $label, $items);
		$f->allowedExtensions = array('jpg', 'png', 'gif');
		$f->setFolderName($folder);
		
		return $f;
	}
	
	/**
	 * HTML Editor Field
	 */
	public static function HTMLEditorField($name, $label, $rows=null, $cols=null){
		$f = new HTMLEditorField($name, $label);
		
		//set number of rows
		if($rows){
			$f->setRows($rows);
		}
		
		//set number of columns
		if($cols){
			$f->setColumns($cols);
		}
		
		return $f;
	}
	
	/**
	* Merges any number of arrays of any dimensions, the later overwriting 
	* previous keys, unless the key is numeric, in whitch case, duplicated 
	* values will not be added. 
	*
	* The arrays to be merged are passed as arguments to the function.
	*
	* @access public
	* @return array Resulting array, once all have been merged
	*/
	public static function array_merge() {
		// Holds all the arrays passed
		$params = func_get_args();
		
		// First array is used as the base, everything else overwrites on it
		$return = array_shift ( $params );
		
		// Merge all arrays on the first array
		foreach ( $params as $array ) {
			foreach ( $array as $key => $value ) {
				// Numeric keyed values are added (unless already there)
				if (is_numeric ( $key ) && (! in_array ( $value, $return ))) {
					if (is_array ( $value )) {
						$return [] = self::array_merge ( $return [$$key], $value );
					} else {
						$return [] = $value;
					}
					
				// String keyed values are replaced
				} else {
					if (isset ( $return [$key] ) && is_array ( $value ) && is_array ( $return [$key] )) {
						$return [$key] = self::array_merge ( $return [$$key], $value );
					} else {
						$return [$key] = $value;
					}
				}
			}
		}
		
		return $return;
	}
	
	/**
	* array_merge_recursive does indeed merge arrays, but it converts values with duplicate
	* keys to arrays rather than overwriting the value in the first array with the duplicate
	* value in the second array, as array_merge does. I.e., with array_merge_recursive,
	* this happens (documented behavior):
	*
	* array_merge_recursive(array('key' => 'org value'), array('key' => 'new value'));
	*     => array('key' => array('org value', 'new value'));
	*
	* array_merge_recursive_distinct does not change the datatypes of the values in the arrays.
	* Matching keys' values in the second array overwrite those in the first array, as is the
	* case with array_merge, i.e.:
	*
	* array_merge_recursive_distinct(array('key' => 'org value'), array('key' => 'new value'));
	*     => array('key' => array('new value'));
	*
	* Parameters are passed by reference, though only for performance reasons. They're not
	* altered by this function.
	*
	* @param array $array1
	* @param array $array2
	* @return array
	* @author Daniel <daniel (at) danielsmedegaardbuus (dot) dk>
	* @author Gabriel Sobrinho <gabriel (dot) sobrinho (at) gmail (dot) com>
	*/
	public static function array_merge_recursive( $array1, $array2 )
	{
		$merged = $array1;
	  
		foreach ( $array2 as $key => &$value )
		{
			if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
			{
				$merged [$key] = self::array_merge_recursive( $merged [$key], $value );
			}
			else
			{
				$merged [$key] = $value;
			}
		}
	  
		return $merged;
	}
	
	/**
	 * Method to cut-off a string
	 */
	public static function substr($str, $len, $more = '...', $encode = 'utf-8'){
		if ($str == "" || $str == NULL || is_array($str) || strlen($str) <= $len)
		{
			return $str;
		}
		$str = mb_substr($str, 0, $len, $encode);
		if ($str != "")
		{
			if (!substr_count($str, " "))
			{
				$str .= $more;
				return $str;
			}
			while(strlen($str) && ($str[strlen($str)-1] != " "))
			{
				$str = mb_substr($str, 0, -1, $encode);
			}
			$str = mb_substr($str, 0, -1, $encode);
			$str .= $more;
		}
		$str = preg_replace("/[[:blank:]]+/", " ", $str);
		return $str;
	}
}