<?php
/**
 * Help Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class HelpArticle extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/question-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Help article';
	
	/**
	 * Page description
	 */
	private static $description = 'Shows the help article';
	
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
		'ShortDescription'  => 'Text',
		'Featured' 			=> 'Boolean'
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
	private static $belongs_many_many = array(
		'Categories' => 'HelpCategory'
	);
	
	/**
	 * Defaults
	 */
	private static $defaults = array();
	
	/**
	 * Hide from CMS SiteTree by default
	 */
	private static $show_in_sitetree = false;
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
		// Fields
 		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Main', new TextareaField('ShortDescription', _t('HelpPage.SHORTDESC', 'Short description') ), 'Content');
		
		// Options
		$fields->addFieldToTab('Root.Options', CheckboxField::create('Featured', _t('TSGeneral.FEATURED', 'Featured')) );
		$fields->addFieldToTab('Root.Options',
			new CheckboxSetField('Categories', _t('TSGeneral.CATEGORIES', 'Categories'), HelpCategory::get()->filter('PageID', $this->parent()->ID))
		);
		
		// Images
		$fields->addFieldToTab('Root.Images',
			iHelper::ImageUploadField('Images', _t('TSGeneral.IMAGES', 'Image'), 'Uploads/Pages/'.(int)$this->owner->ID) // @see PageDecorator.php - Images
		);
		
		return $fields;	
	}
}

/**
 * The controller class
 */
class HelpArticle_Controller extends Page_Controller {
	/**
	 * Extensions
	 */
	private static $extensions = array(
		'TS_Search_Extension'
	);
	
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	}
	
	/**
	 * Process and render search results.
	 *
	 * @param array $data The raw request data submitted by user
	 * @param SearchForm $form The form instance that was submitted
	 * @param SS_HTTPRequest $request Request generated for this action
	 */
	public function results($data, $form, $request) {
		//
		if(!isset($data) || !is_array($data)) $data = $_REQUEST;
		
		$data = array(
			'Results' 	=> ( isset($data['ClassName']) && strtolower($data['ClassName']) == 'helparticle' ? $this->getTsSearchResults(30) : $form->getResults()),
			'Query' 	=> $form->getSearchQuery(),
			'Title' 	=> _t('SearchForm.SearchResults', 'Search Results')
		);
		
		return $this->owner->customise($data)->renderWith(array('Page_results', 'Page'));
	}
	
	/**
	 * Get extra filter for the search form
	 *
	 * @return string
	 */
	public function getTsExtraFilter() {
		return "\"ClassName\" = 'HelpArticle'";
	}
}
