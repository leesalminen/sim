<?php
/**
 * Portfolio Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PortfolioItem extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/portfolio-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Portfolio Item';
	
	/**
	 * Page description
	 */
	private static $description = 'Shows the portfolio details';
	
	/**
	 * Allowed page types as childrens
	 */
	private static $allowed_children = "none";
	
	/**
	 * Is able to be root?
	 */
	private static $can_be_root = false;
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'ShortDescription'  => 'Varchar(255)',
		'Date'	     		=> 'SS_Datetime',
		'Featured'		    => 'Boolean',
		'Attributes'		=> 'SimpleListFieldDB'
	);
	
	/**
	 * Has one
	 */ 
	private static $has_one = array();
	
	/**
	 * Many many
	 */
	private static $many_many = array(
		'RelatedItems'  => 'PortfolioItem',
		'Testimonials'  => 'Testimonial'
	);
	
	/**
	 * Many_many extra fields
	 */ 
	private static $many_many_extraFields = array(
        'Testimonials' => array(
            'SortOrder' => 'Int'
        )
    );
	
	/**
	 * Belongs many many
	 */
	private static $belongs_many_many = array(
		'Categories' => 'PortfolioCategory'
	);
	
	/**
	 * Defaults
	 */
	private static $defaults = array(
		'ProvideComments' => false
	);
	
	/**
	 * Hide from CMS SiteTree by default
	 */
	private static $show_in_sitetree = false;
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
		// Scenarios for SimpleListField
		$this->setSimpleListFieldScenarios();
		
		// Fields
 		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main', new TextareaField('ShortDescription', _t('Portfolio.SHORTDESC', 'Short description') ), 'Content');
		
		// Project detail
		$fields->addFieldToTab('Root.ProjectDetails', CheckboxField::create('Featured', _t('TSGeneral.FEATURED', 'Featured')) );
		$fields->addFieldToTab('Root.ProjectDetails',
			new CheckboxSetField('Categories', _t('TSGeneral.CATEGORIES', 'Categories'), PortfolioCategory::get()->filter('PageID', $this->parent()->ID))
		);
		
		$fields->addFieldToTab('Root.ProjectDetails', DateField::create('Date', _t('TSGeneral.DATE', 'Date'))->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.ProjectDetails', $field = new TreeMultiselectField('RelatedItems', 'Related portfolio item', 'SiteTree') );
		$field->setFilterFunction( create_function('$obj', 'return (( $obj->class == "PortfolioPage" || $obj->class == "PortfolioItem" ) && $obj->ID != "'.$this->ID.'"); ') );
		
		$fields->addFieldToTab('Root.ProjectDetails',
			SimpleListField::create('Attributes', _t('Portfolio.Attributes', 'Additional information'))->useScenario('portfolio_attribute')
		);
		
		// Images
		$fields->addFieldToTab('Root.Images',
			iHelper::ImageUploadField('Images', _t('TSGeneral.IMAGES', 'Image'), 'Uploads/Pages/'.(int)$this->owner->ID) // @see PageDecorator.php - Images
		);
		
		// Testimonials
		$cfg = GridFieldConfig_RelationEditor::create(30);
		
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		$cfg->getComponentByType('GridFieldAddExistingAutocompleter')
		    ->setSearchFields( array('Author', 'Company') )
			->setResultsFormat('$Author - $Company');
		
		$fields->addFieldToTab('Root.Testimonials', new GridField('Testimonials', 'Testimonials', $this->Testimonials(), $cfg) );
		
		return $fields;	
	}
	
	/**
	 * Set default Scenarios for SimpleListField
	 */ 
	private function setSimpleListFieldScenarios()
	{
		SimpleListField::staticSetScenarios(array(
			'portfolio_attribute' => array(
				'heading' => false,
				'fields'  => array(
					array(
						'type'  	  => 'text',
						'name'        => 'Name',
						'label' 	  => 'Name'
					),
					array(
						'type'  	  => 'text',
						'name'        => 'Value',
						'label' 	  => 'Value'
					),
				)
			)
		));
	}
}

/**
 * The controller class
 */
class PortfolioItem_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	} 	
}
