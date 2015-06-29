<?php
/**
 * Timeline Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class TimelinePage extends Page {
	/**
     * Icon
     */
    private static $icon = array("z-theme-stripe/assets/images/icons/line-connector-16.png");
	
	/**
	 * Page name
	 */
	private static $singular_name = 'Timeline Page';
	
	/**
	 * Page description
	 */
	private static $description = 'Shows the timeline.';
	
	/**
	 * Allowed page types as childrens
	 */
	private static $allowed_children = array(
		'TimelineItem'
	);
	
	/**
	 * Default childs
	 */
	static $default_child = 'TimelineItem';
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'PageLength' => 'Int'
	);
	
	/**
	 * Has many
	 */
	private static $has_many = array();
	
	/**
	 * Defaults
	 */
	private static $defaults = array(
		'ProvideComments' => false,
		'PageLength'	  => 30
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
		
		// Options
		$fields->addFieldToTab('Root.Options',
			NumericField::create('PageLength', _t('Timeline.EVENTPERPAGE', 'Events per page'))->setDescription(_t('Timeline.EVENTPERPAGEDESC'))
		);
		
		return $fields;	
	}
	
	/**
	 * Lumberjack title
	 */
	public function getLumberjackTitle() {
		return _t("Timeline.LUMBERJACKLABEL", "Articles");
	}
}

/**
 * The controller class
 */
class TimelinePage_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	}
	
	/**
	 * Get timeline data
	 */
	public function getTimelineData()
	{
		// get limit
		$limit = $this->PageLength ? $this->PageLength : 30;
		
		// get item
		$items = TimelineItem::get()->filter('ParentID', $this->ID)->sort('Date', 'DESC');
		$total = $items->count();
		
		if($total > 0)
		{	
			// get the paginated list
			$list = new PaginatedList($items, Controller::curr()->request);
			$list->setTotalItems($total);
			$list->setPageLength($limit);
			
			// group by years
			$years = array();
			
			foreach($list as $item)
			{
				$year = date('Y', strtotime($item->Date) );
				
				if( isset($years[$year]['Year']) ){
					$years[$year]['Events'][] = $item;
				}
				else{
					$years[$year]['Year']     = $year;
					$years[$year]['Events']   = new ArrayList();
					$years[$year]['Events'][] = $item;
				}
			}
			
			// return data
			return new ArrayData(array(
				'TimelineEvents' => new ArrayList($years),
				'PaginatedList'	 => $list
			));
		}
		
		return null;
	}
}
