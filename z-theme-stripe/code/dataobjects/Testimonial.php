<?php
/**
 * Testimonial
 */
class Testimonial extends DataObject
{
	private static $singular_name = 'Testimonial';
    private static $plural_name   = 'Testimonials';
	
	private static $db = array (
		'Author'      	=> 'Varchar(255)',
		'Company'     	=> 'Varchar(255)',
		'Title'		  	=> 'Varchar(255)',
		'Comment'     	=> 'Varchar(255)',
		'Date'	     	=> 'SS_Datetime',
	);
	
	private static $has_one = array(
		'Photo' => 'Image'
	);
	
	private static $belongs_many_many = array(
        'Pages' => 'Page'
    );
	
	private static $summary_fields = array(
		'Author'   => 'Author',
		'Company'  => 'Company'
	);
	
	private static $searchable_fields = array();
	
    private static $default_sort = 'Date DESC';
	
	/**
	 * Defaults
	 */
	public function populateDefaults(){
		parent::populateDefaults();
		
		$this->setField('Date', date('Y-m-d', strtotime('now')));
	}
	
	/*
	* Method to show CMS fields for creating or updating
	*/
	public function getCMSFields()
	{
		$fields =  new FieldList(
			TextField::create('Author', _t('Testimonial.AUTHOR', 'Author')),
			TextField::create('Company', _t('Testimonial.COMPANY', 'Company')),
			TextField::create('Title', _t('Testimonial.TITLE', 'Title')),
			TextareaField::create('Comment', _t('Testimonial.COMMENT', 'Comment')),
			DateField::create('Date', _t('Testimonial.DATE', 'Date'))->setConfig('showcalendar', true),
			iHelper::ImageUploadField('Photo', _t('Testimonial.PHOTO', 'Photo'), 'Uploads/Clients/Authors')
		);
		
		return $fields;
	}
	
	/**
	 * Can view the record
	 */
	public function canView($member = null) {
        return true;
    }
}