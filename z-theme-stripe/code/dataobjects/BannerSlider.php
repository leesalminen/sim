<?php
/**
 * Banner Slider Object
 *
 * Anh Le <anhle@silverbusters.com>
 */
class BannerSlider extends DataObject
{
	public static $singular_name = 'Banner slider';
    public static $plural_name   = 'Banner sliders';
	
	static $db = array (
		'Title'     => 'Varchar(255)',
		'SubTitle'  => 'Varchar(255)',
		'Content'   => 'Text',
		'Align'		=> "Enum(array('left', 'center', 'right'), 'left')",
		'SortOrder' => 'Int',
		
		// List
		'Buttons'   => 'SimpleListFieldDB',
		'Lists' 	=> 'SimpleListFieldDB'
	);
 
	static $has_one = array (
		'Image' 	=> 'Image',
		'Page'  	=> 'Page'
	);
	
	static $summary_fields = array(
		'Title'		 	  => 'Title',
		'SubTitle'   	  => 'SubTitle',
		'ImageThumb' 	  => 'Image'
	);
	
	static $searchable_fields = array(
		'Title', 'SubTitle'
    );
	
	protected function getImageThumb(){
		return $this->Image()->setWidth(120);
	}
	
    static $default_sort =  'SortOrder ASC';
	
	/**
	 * Populate defaults
	 */ 
	public function populateDefaults() {
		parent::populateDefaults();
	}
	
	/*
	* Method to show CMS fields for creating or updating
	*/
	public function getCMSFields()
	{
		// Scenarios for SimpleListField
		$this->setSimpleListFieldScenarios();
		
		// Fields
		$fields =  new FieldList(
			DropdownField::create('Align', 'Align', $this->dbObject('Align')->enumValues()),
			new TextField('Title', 'Title'),
			new TextField('SubTitle', 'Sub-title'),
			new TextareaField('Content', 'Content'),
			iHelper::ImageUploadField('Image', 'Image', 'Uploads/Pages/'.$this->PageID.'/Banners'),
			SimpleListField::create('Buttons', 'Buttons')->useScenario('bannerslide_button'),
			SimpleListField::create('Lists', 'Lists')->useScenario('bannerslide_list')
		);
		
		return $fields;
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
	
	/**
	 * Set default Scenarios for SimpleListField
	 */ 
	private function setSimpleListFieldScenarios()
	{
		SimpleListField::staticSetScenarios(array(
			// button
			'bannerslide_button' => array(
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
					),
					array(
						'type'  	  => 'text',
						'name'        => 'IconClass',
						'label' 	  => 'Icon class'
					)
				)
			),
			// list
			'bannerslide_list' => array(
				'heading' => false,
				'fields'  => array(
					array(
						'type'  	  => 'text',
						'name'        => 'Text',
						'label' 	  => 'Text'
					),
					array(
						'type'  	  => 'text',
						'name'        => 'HTMLClass',
						'label' 	  => 'Custom HTML class'
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