<?php
/**
 * Contact Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class ContactPage extends UserDefinedForm{
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/mail-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Contact page';
	
	/**
	 * Page description
	 */
	private static $description = 'Contact page';
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'EmbedMapURL' 	=> 'Varchar(255)',
		'Attributes'	=> 'SimpleListFieldDB',
		
		'OnCompleteHeading' => 'Varchar(255)'
	);
	
	/**
	 * Has_one
	 */
	private static $has_one = array();
	
	/**
	 * Has many
	 */
	private static $has_many = array();
	
	/**
	 * Defaults
	 */
	private static $defaults = array();
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
		// Scenarios for SimpleListField
		$this->setSimpleListFieldScenarios();
		
		// Get CMS fields
 		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.FormOptions', new TextField('OnCompleteHeading', _t('ContactPage.ONCOMPLETEHEADING') ), 'EmailRecipients');
		
		// Contact information
		$fields->addFieldToTab('Root.Main', TextField::create('EmbedMapURL', _t('ContactPage.EMBEDMAPURL') )->setDescription( _t('ContactPage.EMBEDMAPURLDESC') ), 'Content');
		$fields->addFieldToTab('Root.Main', SimpleListField::create('Attributes', _t('ContactPage.ATTRIBUTES', 'Contact details'))->useScenario('contact_attribute'), 'Content');
		
		return $fields;	
	}
	
	/**
	 * Set default Scenarios for SimpleListField
	 */ 
	private function setSimpleListFieldScenarios()
	{
		SimpleListField::staticSetScenarios(array(
			'contact_attribute' => array(
				'heading' => true,
				'fields'  => array(
					array(
						'type'  	  => 'text',
						'name'        => 'Label',
						'label' 	  => 'Label'
					),
					array(
						'type'  	  => 'text',
						'name'        => 'Value',
						'label' 	  => 'Value'
					),
					array(
						'type'  	  => 'text',
						'name'        => 'IconClass',
						'label' 	  => 'Icon class'
					)
				)
			)
		));
	}
}

/**
 * The controller class
 */
class ContactPage_Controller extends UserDefinedForm_Controller{ 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
		
		// Javascript to prevent contact email from spamming bots
		if($this->ContactEmail)
		{
			$ContactEmail = base64_encode($this->ContactEmail);
			
			Requirements::javascript(TSModule.'/assets/javascripts/base64.min.js');
			Requirements::customScript(<<<JS
  var contact_email = {
		'ce': document.getElementById("contact-email-link"),
		'e': Base64.decode('$ContactEmail')
	}
	
	if (contact_email.ce) {
		contact_email.ce.innerHTML = contact_email.e;
		contact_email.ce.href      = 'mailto:'+ contact_email.e;
	}
JS
);
		}
	}
	
	/**
	 * Get the form fields for the form on this page. Can modify this FieldSet
	 * by using {@link updateFormFields()} on an {@link Extension} subclass which
	 * is applied to this controller.
	 *
	 * @return FieldList
	 */
	public function getFormFields() {
		// Get fields from parent
		$fields = parent::getFormFields();
		
		// Modify fields
		if($this->Fields()) {
			foreach($this->Fields() as $editableField) {
				// inject the custom name to data-custom-name attribute
				if( isset($editableField->CustomName) && $editableField->CustomName ){
					$fields->fieldByName($editableField->Name)->setAttribute('data-custom-name', $editableField->CustomName);
				}
			}
		}
		
		// Return fields
		return $fields;
	}
}