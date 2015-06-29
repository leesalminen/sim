<?php
/**
 * Service Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class ServicePage extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/tool-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Service Page';
	
	/**
	 * Page description
	 */
	private static $description = 'Service page';
	
	/**
	 * Database fields
	 */
	private static $db = array();
	
	/**
	 * Has_one
	 */
	private static $has_one = array();
	
	/**
	 * Has many
	 */
	private static $has_many = array(
		'Services' => 'Box'
	);
	
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
		
		// Services
		$cfg = GridFieldConfig_RecordEditor::create(30);
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		
		$addButton = $cfg->getComponentByType('GridFieldAddNewButton');
		$addButton->setButtonName('Add service');
		
		$fields->addFieldToTab('Root.Services',
			new GridField('Services', 'Services', $this->Services(), $cfg)
		);
		
		return $fields;	
	}
}

/**
 * The controller class
 */
class ServicePage_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	}
}