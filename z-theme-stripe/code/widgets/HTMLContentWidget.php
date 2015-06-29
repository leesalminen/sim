<?php
/**
 * Shows custom HTML content
 *
 * Anh Le <anhle@silverbusters.com>
 */
class HTMLContentWidget extends Widget{
	/**
	 * DB Fields
	 */
    static $db = array();
	
	/**
	 * Defaults
	 */
    static $defaults = array();
 
    static $title 		= 'HTML Content';
    static $cmsTitle 	= 'HTML Content';
    static $description = 'Shows custom HTML content';
	
	/**
	 * Setting up CMSFields
	 */
	/*
	public function getCMSFields()
	{
		$this->beforeUpdateCMSFields(function($fields) {
			$fields->merge(
				new FieldList(
					new TextareaField('WidgetContent', 'HTML Content')
				)
			);
		});
		
		return parent::getCMSFields();
	}
	*/
}
