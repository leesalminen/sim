<?php
/**
 * Home Page
 *
 * Anh Le <anhle@silverbusters.com>
 */
class HomePage extends Page {
	/**
	 * Page name
	 */
	private static $singular_name = 'Home Page';
	
	/**
	 * Database fields
	 */
	private static $db = array(
		'BoxEnable'  => 'Boolean',
		'BoxHeading' => 'Varchar',
		
		'PortfolioCount'  	=> 'Int',
		'PortfolioFeatured' => 'Boolean',
		'PortfolioHeading'  => 'Varchar',
		
		'TimelineCount'  	=> 'Int',
		'TimelineHeading'  	=> 'Varchar',
		
		'TestimonialEnable' 	=> 'Boolean',
		'TestimonialHeading' 	=> 'Varchar',
		
		'TeamEnable' 	=> 'Boolean',
		'TeamHeading'  	=> 'Varchar'
	);
	
	/**
	 * Has_one
	 */
	private static $has_one = array(
		'PortfolioPage' => 'PortfolioPage'
	);
	
	/**
	 * Has_many
	 */
	private static $has_many = array(
		'Boxes' => 'Box'
	);
	
	/**
	 * Many_many
	 */
	private static $many_many = array(
		'Testimonials' => 'Testimonial'
	);
	
	/**
	 * Many_many extra fields
	 */ 
	private static $many_many_extraFields = array(
        'Testimonials' => array(
            'SortOrder' => 'Int'
        )
    );
	
	public function Testimonials() {
        return $this->getManyManyComponents('Testimonials')->sort('SortOrder');
    }
	
	/**
	 * Update CMS fields
	 */
	public function getCMSFields() {
 		$fields = parent::getCMSFields();
		
		// Banners
		$cfg = GridFieldConfig_RecordEditor::create(30);
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		
        $fields->addFieldToTab('Root.Slides',
			new GridField('Slides', 'Slides', $this->BannerSliders(), $cfg)
		);
		
		// Boxes
		$cfg = GridFieldConfig_RecordEditor::create(30);
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		
		$fields->addFieldToTab('Root.Boxes', CheckboxField::create('BoxEnable', _t('TSGeneral.ENABLE', 'Enable')) );
		$fields->addFieldToTab('Root.Boxes', TextField::create('BoxHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		$fields->addFieldToTab('Root.Boxes', new GridField('Boxes', 'Boxes', $this->Boxes(), $cfg) );
		
		// Portfolio
		$fields->addFieldToTab('Root.Sections', HeaderField::create('PortfolioSectionHeading', 'Portfolio') );
		$fields->addFieldToTab('Root.Sections', TextField::create('PortfolioHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		$fields->addFieldToTab('Root.Sections',
			NumericField::create('PortfolioCount', _t('TSGeneral.LIMIT', 'Limit'))->setDescription(_t('TSGeneral.ITEMS2SHOW_ZERO2DISABLE'))
		);
		$fields->addFieldToTab('Root.Sections', CheckboxField::create('PortfolioFeatured', _t('TSGeneral.FEATUREDONLY', 'Only shows featured item(s)')) );
		
		// Timeline
		$fields->addFieldToTab('Root.Sections', HeaderField::create('TimelineSectionHeading', 'Timeline') );
		$fields->addFieldToTab('Root.Sections', TextField::create('TimelineHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		$fields->addFieldToTab('Root.Sections',
			NumericField::create('TimelineCount', _t('TSGeneral.LIMIT', 'Limit'))->setDescription(_t('TSGeneral.ITEMS2SHOW_ZERO2DISABLE'))
		);
		
		// Team
		$fields->addFieldToTab('Root.Sections', HeaderField::create('TeamSectionHeading', 'Teams &amp; Persons') );
		$fields->addFieldToTab('Root.Sections', CheckboxField::create('TeamEnable', _t('TSGeneral.ENABLE', 'Enable')) );
		$fields->addFieldToTab('Root.Sections', TextField::create('TeamHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		
		// Testimonial
		$fields->addFieldToTab('Root.Sections', HeaderField::create('TestimonialSectionHeading', 'Testimonials') );
		$fields->addFieldToTab('Root.Sections', TextField::create('TestimonialHeading', _t('TSGeneral.HEADINGTEXT', 'Heading text')) );
		
		$cfg = GridFieldConfig_RelationEditor::create(30);
		
		$cfg->addComponent( new GridFieldSortableRows('SortOrder') );
		$cfg->getComponentByType('GridFieldAddExistingAutocompleter')
		    ->setSearchFields( array('Author', 'Company') )
			->setResultsFormat('$Author - $Company');
		
		$fields->addFieldToTab('Root.Sections', CheckboxField::create('TestimonialEnable', _t('TSGeneral.ENABLE', 'Enable')) );
		$fields->addFieldToTab('Root.Sections', new GridField('Testimonials', 'Testimonials', $this->Testimonials(), $cfg) );
		
		return $fields;	
	}
}

/**
 * The controller class
 */
class HomePage_Controller extends Page_Controller { 
	/**
	 * Initialize
	 */
	public function init() {
		parent::init();
	}
	
	/**
	 * Portfolio items
	 */
	public function getPortfolioItems($limit = 0)
	{
		$limit = $limit > 0 ? $limit : ( $this->PortfolioCount ? $this->PortfolioCount : 10 );
		
		if( $limit <= 0 ) return false;
		
		// get item
		$items = PortfolioItem::get();
		
		// filter by featured items
		if($this->PortfolioFeatured){
			$items = $items->filter('Featured', 1);
		}
		
		// limit
		$items = $items->limit($limit);
		
		// extend
		$this->extend('updateGetPortfolioItems', $items);
		
		return $items;
	}
	
	/**
	 * Timeline events
	 */
	public function getTimelineEvents($limit = 0)
	{
		$limit = $limit > 0 ? $limit : ( $this->TimelineCount ? $this->TimelineCount : 10 );
		
		if( $limit <= 0 ) return false;
		
		// get item
		$items = TimelineItem::get()->sort('Date', 'DESC');
		
		// limit
		$items = $items->limit($limit);
		
		// group by years
		if($items)
		{
			$years = array();
			
			foreach($items as $item)
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
			
			return new ArrayList($years);
		}
		
		return false;
	}
	
	/**
	 * Team persons
	 */
	public function getTeamPersons()
	{
		if($this->TeamEnable){
			return TeamPerson::get();
		}
		
		return false;
	}
}