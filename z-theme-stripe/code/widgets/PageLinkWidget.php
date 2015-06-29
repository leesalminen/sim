<?php
/**
 * Show a list of pages
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PageLinkWidget extends Widget{
	/**
	 * DB Fields
	 */
    private static $db = array();
	
	/**
	 * Defaults
	 */
    private static $defaults = array();
 
    private static $title 		= 'Links';
    private static $cmsTitle 	= 'Page Link';
    private static $description = 'Shows a list of pages';
	
	/**
	 * Setting up CMSFields
	 */
	public function getCMSFields()
	{
		// get the list of page to select
		$pagesMap = array();
		foreach(SiteTree::get() as $page) {
			// Listboxfield values are escaped, use ASCII char instead of &raquo;
			$pagesMap[$page->ID] = $page->getBreadcrumbs(' > ');;
		}
		
		asort($pagesMap);
		
		$tree = ListboxField::create('WidgetContent', singleton('SiteTree')->i18n_plural_name())
				->setMultiple(true)
				->setSource($pagesMap)
				->setAttribute('data-placeholder', 'Click and select page from dropdown')
				->addExtraClass('plw-select-page');
		
		// Update field
		$fields = parent::getCMSFields();
		$fields->merge( new FieldList($tree) );
		
		return $fields;
	}
	
	/**
	 * Get page links
	 */
	public function getPages()
	{
		// Get page ids
		$content = Convert::xml2raw($this->WidgetContent);
		$ids     = array();
		
		if($content)
		{
			foreach( explode(',', $content) as $id )
			{
				$id = (int)$id;
				
				if($id > 0){
					$ids[] = $id;
				}
			}
			
			if( !empty($ids) )
			{
				$pages = Page::get()->byIDs($ids);
				
				return $pages;
			}
		}
		
		return false;
	}
}