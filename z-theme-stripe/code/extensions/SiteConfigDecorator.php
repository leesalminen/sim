<?php
/**
 * Site Configuration Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class SiteConfigDecorator extends Extension{
	/**
	 * DB fields
	 */
	private static $db = array(
		'CopyrightText'  => 'HTMLText',
		'SocialFB'	     => 'Varchar(255)',
		'SocialTW'	     => 'Varchar(255)',
		'SocialLI'	     => 'Varchar(255)'
	);
	
	/**
	 * Has one
	 */
	private static $has_one = array(
		'FooterWidget' => 'WidgetArea',
	);
	
	/**
	 * Method to update CMS fields
	 */
	public function updateCMSFields(FieldList $fields){
		// Footer
		$fields->addFieldToTab('Root.Footer.Gerenal', new TextareaField('CopyrightText', 'Copyright text'));
		
		$fields->addFieldToTab('Root.Footer.Gerenal', new HeaderField('SocialHeading', 'Socials Connect', 3) );
		$fields->addFieldToTab('Root.Footer.Gerenal', new TextField('SocialFB', 'Facebook URL'));
		$fields->addFieldToTab('Root.Footer.Gerenal', new TextField('SocialTW', 'Twitter URL'));
		$fields->addFieldToTab('Root.Footer.Gerenal', new TextField('SocialLI', 'LinkedIn URL'));
		
		// Footer widgets
		$fields->addFieldToTab('Root.Footer.Widgets', new WidgetAreaEditor("FooterWidget"));
	}
}