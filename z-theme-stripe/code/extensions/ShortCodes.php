<?php
/**
 * ShortCodes class
 *
 * @author Anh Le <leanh@anhld.com>
 */
class ShortCodes {
	/**
	 * Embed button
	 */
	public static function Button($arguments = array(), $content = null, $parser = null, $tagName)
	{
		$arguments = ArrayLib::array_merge_recursive(array(
			'classes' 			=> 'btn-block btn-blue',
			'link' 				=> '',
			'newWindow'     	=> false,
			'noFollow'			=> false,
 			'attributes' 		=> array(),
			'wrapperClass' 		=> '',
			'iconClass'			=> ''
		), $arguments);
		
		$arguments['content'] = $content;
		
		$template = new SSViewer('Shortcode_button');
		
		return $template->process(new ArrayData($arguments));
		
		/*
		if($content)
		{
			// content
			$content = htmlentities($content);
			
			if($arguments['iconClass']){
				$content = '<i class="'.$arguments['iconClass'].'"></i> '.$content;
			}
			
			// html classes
			$class = 'btn '.$arguments['classes'];
			
			// attributes
			$attributes = '';
			
			if($arguments['newWindow']){
				$attributes .= 'target="_blank" ';
			}
			
			if($arguments['noFollow']){
				$attributes .= 'rel="nofollow" ';
			}
			
			// return the link
			if($arguments['link']){
				$content = '<a href="'.$arguments['link'].'" class="'.$class.'" '.$attributes.'>'.$content.'</a>';
			}
			// return the button
			else{
				$content = '<button class="'.$class.'">'.$content.'</button>';
			}
			
			return '<div class="'.$arguments['wrapperClass'].'">'.$content.'</div>';
		}
		
		return null;
		*/
	}
	
	/**
	 * Embed video
	 */
	public static function Video($arguments = array(), $content = null, $parser = null, $tagName)
	{
		$arguments = ArrayLib::array_merge_recursive(array(
			'id' 		=> '',
			'service' 	=> '',
			'width' 	=> '',
			'height' 	=> '',
		), $arguments);
		
		$template = new SSViewer('Shortcode_video');
		
		return $template->process(new ArrayData($arguments));
	}
}
