<?php
/**
 * About page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class AboutPage extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/information-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'About Page';
	
	/**
	 * Page description
	 */
	private static $description = 'About Page';
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'PersonEnable' 	=> 'Boolean',
		'PersonHeading' => 'Varchar',
		
		'TestimonialEnable' 	=> 'Boolean',
		'TestimonialHeading'	=> 'Varchar'
	);
	
	/**
	 * Has_one
	 */
	private static $has_one = array();
	
	/**
	 * Has_many
	 */
	private static $has_many = array(
		'Persons' => 'TeamPerson'
	);
	
	/**
	 * Many_many
	 */
	private static $many_many = array(
		'Testimonials' => 'Testimonial'
	);
	
	/**
	 * Many_many extra fields
	 */ 
	private static $many_many_extraFields = array(
        'Testimonials' => array(
            'SortOrder' => 'Int'
        )
    );
	
	public function Testimonials() {
        return $this->getManyManyComponents('Testimonials')->sort('SortOrder');
    }

	/**
	 * Defaults
	 */
	private static $defaults = array(
		'ProvideComments' => false
	);
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
 		$fields = parent::getCMSFields();
		
		// Persons
		$cfg = GridFieldConfig_RecordEditor::create(30);
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		
		$fields->addFieldToTab('Root.Persons', CheckboxField::create('PersonEnable', _t('TSGeneral.ENABLE', 'Enable')) );
		$fields->addFieldToTab('Root.Persons', TextField::create('PersonHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		$fields->addFieldToTab('Root.Persons', new GridField('Persons', 'Persons', $this->Persons(), $cfg) );
		
		// Testimonials
		$cfg = GridFieldConfig_RelationEditor::create(30);
		
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		$cfg->getComponentByType('GridFieldAddExistingAutocompleter')
		    ->setSearchFields( array('Author', 'Company') )
			->setResultsFormat('$Author - $Company');
		
		$fields->addFieldToTab('Root.Testimonials', CheckboxField::create('TestimonialEnable', _t('TSGeneral.ENABLE', 'Enable')) );
		$fields->addFieldToTab('Root.Testimonials', TextField::create('TestimonialHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		$fields->addFieldToTab('Root.Testimonials', new GridField('Testimonials', 'Testimonials', $this->Testimonials(), $cfg) );
		
		return $fields;	
	}
}

/**
 * The controller class
 */
class AboutPage_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	}
}