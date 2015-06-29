<?php
/**
 * Timeline Item
 *
 * Anh Le <anhle@silverbusters.com>
 */
class TimelineItem extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/calendar-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Timeline event';
	
	/**
	 * Page description
	 */
	private static $description = 'Display the details of a timeline event.';
	
	/**
	 * Allowed page types as childrens
	 */
	private static $allowed_children = "none";
	
	/**
	 * Is able to be root?
	 */
	private static $can_be_root = false;
	
	/**
	 * The default parent class for this page.
	 * Note: Value might be cached, see {@link $allowed_chilren}.
	 *
	 * @config
	 * @var string
	 */
	private static $default_parent = 'TimelinePage';
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'ShortDescription'  => 'Varchar(255)',
		'Date'	     		=> 'SS_Datetime',
		'Links'				=> 'SimpleListFieldDB'
	);
	
	/**
	 * Has one
	 */ 
	private static $has_one = array();
	
	/**
	 * Many many
	 */
	private static $many_many = array();
	
	/**
	 * Belongs many many
	 */
	private static $belongs_many_many = array();
	
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
	 * Populate default values
	 */
	public function populateDefaults(){
		parent::populateDefaults();
		
		$this->setField('Date', date('Y-m-d H:i:s', strtotime('now')));
	}
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
		// Scenarios for SimpleListField
		$this->setSimpleListFieldScenarios();
		
		// Fields
 		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', $dateField = DatetimeField::create('Date', _t('TSGeneral.DATE', 'Date')), 'Content');
		$dateField->getDateField()->setConfig('showcalendar', true);
		$dateField->getTimeField()->setConfig('timeformat', 'H:m:s');
		
		$fields->addFieldToTab('Root.Main', new TextareaField('ShortDescription', _t('Timeline.SHORTDESC', 'Short description') ), 'Content');
		
		$fields->addFieldToTab('Root.Main',
			SimpleListField::create('Links', _t('Timeline.LINKS', 'Links'))->useScenario('timeline_link'), 'Metadata'
		);
		
		// Images
		$fields->addFieldToTab('Root.Images',
			iHelper::ImageUploadField('Images', _t('TSGeneral.IMAGES', 'Image'), 'Uploads/Pages/'.(int)$this->owner->ID) // @see PageDecorator.php - Images
		);
		
		return $fields;	
	}
	
	/**
	 * Set default Scenarios for SimpleListField
	 */ 
	private function setSimpleListFieldScenarios()
	{
		SimpleListField::staticSetScenarios(array(
			'timeline_link' => array(
				'heading' => false,
				'fields'  => array(
					array(
						'type'  	  => 'text',
						'name'        => 'Text',
						'label' 	  => 'Text'
					),
					array(
						'type'  	  => 'text',
						'name'        => 'Link',
						'label' 	  => 'Link'
					),
					array(
						'type'  	  => 'dropdown',
						'name'        => 'LinkBehaviour',
						'label' 	  => 'Link behaviour',
						'list'		  => array(
							'0' => 'Default',
							'1' => 'New window',
							'2' => 'No-follow',
							'3' => 'New window + no-follow'
						),
						'default_value' => 0 // the default value
					),
					array(
						'type'  	  => 'text',
						'name'        => 'HTMLClass',
						'label' 	  => 'Custom HTML class'
					)
				)
			)
		));
	}
}

/**
 * The controller class
 */
class TimelineItem_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	} 	
}
