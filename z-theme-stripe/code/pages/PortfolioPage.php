<?php
/**
 * Portfolio Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PortfolioPage extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/list-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Portfolio Page';
	
	/**
	 * Page description
	 */
	private static $description = 'Shows the list of portfolio items';
	
	/**
	 * Allowed page types as childrens
	 */
	private static $allowed_children = array(
		'PortfolioItem'
	);
	
	/**
	 * Default childs
	 */
	static $default_child = 'PortfolioItem';
	
	/**
	 * Database fields
	 */
	private static $db = array();
	
	/**
	 * Has many
	 */
	private static $has_many = array(
		'Categories' => 'PortfolioCategory'
	);
	
	/**
	 * Defaults
	 */
	private static $defaults = array(
		'ProvideComments' => false
	);
	
	/**
	 * Extensions
	 */
	private static $extensions = array(
		'Lumberjack',
	);
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
 		$fields = parent::getCMSFields();
		
		// Categories
		$cfg = GridFieldConfig_RecordEditor::create(30);
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		
        $fields->addFieldToTab('Root.Categories',
			new GridField('Categories', _t('TSGeneral.CATEGORIES', 'Categories'), $this->Categories(), $cfg)
		);
		
		return $fields;	
	}
	
	/**
	 * Lumberjack title
	 */
	public function getLumberjackTitle() {
		return _t("Portfolio.LUMBERJACKLABEL", "Items");
	}
	
	/**
	 * Gridfield configuration for Lumberkjack
	 */
	public function getLumberjackGridFieldConfig(){
		return GridFieldConfig_Lumberjack::create()->addComponent( new GridFieldSortableRows('Sort') );
	}
}

/**
 * The controller class
 */
class PortfolioPage_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	} 	
}

/**
 * Portfolio Category Object
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PortfolioCategory extends DataObject
{
	public static $singular_name = 'Category';
    public static $plural_name   = 'Categories';
	
	static $db = array (
		'Title'     	=> 'Varchar(255)',
		'SortOrder' 	=> 'Int'
	);
 
	static $has_one = array (
		'Page' => 'PortfolioPage'
	);
	
	static $summary_fields = array(
		'Title' => 'Title'
	);
	
	static $searchable_fields = array(
		'Title'
    );
	
    static $default_sort =  'SortOrder ASC';
	
	/**
	 * Many many
	 */
	private static $many_many = array(
		'PortfolioItems' => 'PortfolioItem'
	);
	
	/**
	 * Populate defaults
	 */ 
	public function populateDefaults() {
		parent::populateDefaults();
	}
	
	/*
	* Method to show CMS fields for creating or updating
	*/
	public function getCMSFields(){
		return new FieldList(
			new TextField('Title', _t('TSGeneral.TITLE', 'Title'))
		);
	}
	
	/**
	 * On before write
	 */
	public function onBeforeWrite(){
		//save sort order position
		if( $this->SortOrder == 0 ){
			$item = self::get()->sort('SortOrder', 'DESC')->first();
			
			if( isset($item->SortOrder) ){
				$this->SortOrder = (int)$item->SortOrder + 1;
			}
		}
		
		parent::onBeforeWrite();
	}
	
	/**
	 * Can view the record
	 */
	public function canView($member = null) {
        return true;
    }
}
