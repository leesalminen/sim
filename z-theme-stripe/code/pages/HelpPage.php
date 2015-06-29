<?php
/**
 * Help Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class HelpPage extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/help-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Help Page';
	
	/**
	 * Page description
	 */
	private static $description = 'Help index page';
	
	/**
	 * Allowed page types as childrens
	 */
	private static $allowed_children = array(
		'HelpArticle'
	);
	
	/**
	 * Default childs
	 */
	static $default_child = 'HelpArticle';
	
	/**
	 * Database fields
	 */
	private static $db = array();
	
	/**
	 * Has many
	 */
	private static $has_many = array(
		'Categories' => 'HelpCategory'
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
		'Lumberjack'
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
		return _t("Help.LUMBERJACKLABEL", "Items");
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
class HelpPage_Controller extends Page_Controller {
	/**
	 * Allowed acttions
	 */
	private static $allowed_actions = array(
		'category'
	);
	
	/**
	 * URL handlers
	 */
	private static $url_handlers = array(
		'category/$Category!' => 'category'
	);
	
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
	 * Display help articles for a given category
	 *
	 * @return SS_HTTPResponse
	 */
	public function category() {
		$category = $this->getCurrentCategory();
		
		if($category) {
			$data = new ArrayData(array(
				'Category' => $category
			));
			
			return $this->customise($data)->renderWith( array('HelpPage_category', 'Page') );
		}
		
		return $this->httpError(404, "Not Found");
	}
	
	
	/**
	 * Category Getter for use in templates.
	 *
	 * @return HelpCategory|null
	 */ 
	public function getCurrentCategory() {
		$str = $this->request->param("Category");
		
		if($str){
			$category = HelpCategory::get()->filter("ID", (int)$str)->first();
			
			if($category && $category->getURLSegment() != $str){
				return $this->redirect($category->getLink(), 301);
			}
			
			return $category;
		}
		
		return null;
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

/**
 * Help Category Object
 *
 * Anh Le <anhle@silverbusters.com>
 */
class HelpCategory extends DataObject
{
	public static $singular_name = 'Category';
    public static $plural_name   = 'Categories';
	
	static $db = array (
		'Title'     	=> 'Varchar(255)',
		'SortOrder' 	=> 'Int'
	);
 
	static $has_one = array (
		'Page' => 'HelpPage'
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
		'HelpArticles' => 'HelpArticle'
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
			$this->SortOrder = self::get()->max('SortOrder') + 1;
		}
		
		parent::onBeforeWrite();
	}
	
	/**
	 * Can view the record
	 */
	public function canView($member = null) {
        return true;
    }
	
	/**
	 * Generate URLSegment bases on the ID and the Title
	 */
	public function getURLSegment(){
		return $this->ID. '-'. URLSegmentFilter::create()->filter($this->Title);
	}
	
	/**
	 * Returns a relative link to this category.
	 *
	 * @return string URL
	 */ 
	public function getLink() {
		return Controller::join_links($this->Page()->Link(), "category", $this->getURLSegment());
	}
	
	/**
	 * Return PaginatedList Article
	 */ 
	public function getArticles($limit = 30){
		// get articles
		$articles = $this->HelpArticles();
		$total    = $articles->Count();
		
		if($total){
			// get the paginated list
			$list = new PaginatedList($articles, Controller::curr()->request);
			$list->setTotalItems($total);
			$list->setPageLength($limit);
			
			// return the list
			return $list;
		}
		
		return null;
	}
}
