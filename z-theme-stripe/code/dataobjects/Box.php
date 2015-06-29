<?php
/**
 * Box Object
 *
 * Anh Le <anhle@silverbusters.com>
 */
class Box extends DataObject
{
	private static $singular_name = 'Box';
    private static $plural_name   = 'Boxes';
	
	private static $db = array (
		'Title'     	=> 'Varchar(255)',
		'HTMLClass' 	=> 'Varchar(255)',
		'Content'   	=> 'Text',
		'Link'			=> 'Varchar(255)',
		'LinkBehaviour' => 'Int',
		'SortOrder' 	=> 'Int',
		'CategoryID'	=> 'Int',
		'LinkedPageID'  => 'Int'
	);
 
	private static $has_one = array (
		'Page' => 'Page'
	);
	
	private static $summary_fields = array(
		'Title', 'HTMLClass'
	);
	
	private static $searchable_fields = array(
		'Title'
    );
	
    private static $default_sort =  'SortOrder ASC';
	
	private static $LinkBehaviours = array(
		0 => 'Default',
		1 => 'New window',
		2 => 'No-follow',
		3 => 'New window + No-follow'
	);
	
	/**
	 * Populate defaults
	 */ 
	public function populateDefaults() {
		parent::populateDefaults();
	}
	
	/**
	 * Field labels
	 */ 
	public function fieldLabels($includerelations = true){
		// Get labels from parent
		$labels = parent::fieldLabels($includerelations);
		
		// Modify labels
		$labels['Title'] 	  = _t("TSGeneral.TITLE", "Title");
		$labels['HTMLClass']  = _t("Box.HTMLCLASS", "HTML Class");
		
		// Return labels
		return $labels;
	}
	
	/*
	 * Method to show CMS fields for creating or updating
	 */
	public function getCMSFields()
	{
		return new FieldList(
			new TextField('Title', _t("TSGeneral.TITLE", "Title")),
			new TextareaField('Content', _t("TSGeneral.CONTENT", "Content")),
			TreeDropdownField::create('LinkedPageID', _t("TSGeneral.PAGE", "Page"), 'SiteTree')->setDescription(_t("Box.CHOOSEPAGETOCONNECT")),
			TextField::create('Link', _t("TSGeneral.LINK", "Link"))->setDescription(_t("Box.ORFILLLINK")),
			new DropdownField('LinkBehaviour', _t("TSGeneral.LINKBEHAVIOUR", "Link behaviour"), self::$LinkBehaviours),
			new TextField('HTMLClass', _t("Box.HTMLCLASS", "HTML Class"))
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
	 * Get link
	 */
	public function LinkTo(){
		if($this->getField('Link'))
			return $this->getField('Link');
		
		if($this->LinkedPageID && $page = Page::get()->byID($this->LinkedPageID))
			return $page->Link();
		
		return false;
	}
	
	/**
	 * Can view the record
	 */
	public function canView($member = null) {
        return true;
    }
}
