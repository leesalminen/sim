<?php
/*
 * Widget Decorator
 *
 * @author Anh Le (leanh@anhld.com)
 */
class WidgetDecorator extends DataExtension{
	/**
	 * Method to construct
	 */
	public function __construct(){
		parent::__construct();
	}
	
	static $db = array(
		'WidgetTitle'		=> 'Varchar(255)',
		'WidgetClassSuffix' => 'Varchar(60)',
		'WidgetContent'		=> 'HTMLText'
	);
	
	static $defaults = array(
		'WidgetTitle'		=> '',
		'WidgetClassSuffix' => ''
	);
	
	/**
	 * Update CMS fields
	 */ 
	public function updateCMSFields(FieldList $fields){
		// Creating FieldList
		$fieldList = new FieldList(
			new TextField('WidgetClassSuffix', _t('Widget.SUFFIXCLASS', 'Suffix class')),
			new TextField('WidgetTitle', _t('Widget.TITLE', 'Title')),
			new CheckboxField('Enabled', _t('Widget.ENABLE', 'Enable'))
		);
		
		// Remove Title field
		$fields->removeByName('Title');
		
		// The HTML Content field
		$allowedWidgets = Config::inst()->get('Widget', 'AllowContentOn');
		
		if( $allowedWidgets && is_array($allowedWidgets) && in_array(get_class($this->owner), $allowedWidgets) ){
			$fieldList->push( new TextareaField('WidgetContent', _t('Widget.HTMLCONTENT', 'HTML content')) );
		}
		else{
			$fields->removeByName('WidgetContent');
		}
		
		// Update CMS Fields
		$fields->merge($fieldList);
	}
	
	//Setting up Tittle
	public function WidgetTitle(){
		return $this->owner->WidgetTitle ? $this->owner->WidgetTitle : $this->owner->Title();
	}
}