<?php
/**
 * TeamPerson Object
 *
 * Anh Le <anhle@silverbusters.com>
 */
class TeamPerson extends DataObject
{
	public static $singular_name = 'Person';
    public static $plural_name   = 'Persons';
	
	static $db = array (
		'Name'      => 'Varchar(255)',
		'JobTitle'  => 'Varchar(255)',
		'Bio' 		=> 'Text',
		'SortOrder' => 'Int'
	);
 
	static $has_one = array (
		'Photo'	=> 'Image',
		'Page'  => 'Page'
	);
	
	static $summary_fields = array(
		'Name', 'JobTitle', 'PhotoThumb'
	);
	
	static $searchable_fields = array(
		'Name', 'JobTitle'
    );
	
	protected function getPhotoThumb(){
		return ($this->PhotoID ? $this->Photo()->setWidth(120) : null);
	}
	
    static $default_sort = 'SortOrder ASC';
	
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
		$labels['Name'] 	  = _t('TeamPerson.NAME', 'Name');
		$labels['JobTitle']   = _t('TeamPerson.JOBTITLE', 'Job title');
		$labels['Bio'] 	  	  = _t('TeamPerson.BIOGRAPHY', 'Biography');
		$labels['Photo'] 	  = $labels['PhotoThumb'] = _t('TeamPerson.PHOTO', 'Photo');
		
		// Return labels
		return $labels;
	}
	
	/*
	* Method to show CMS fields for creating or updating
	*/
	public function getCMSFields()
	{
		$fields =  new FieldList(
			new TextField('Name', _t('TeamPerson.NAME', 'Name')),
			new TextField('JobTitle', _t('TeamPerson.JOBTITLE', 'Job title')),
			new TextareaField('Bio', _t('TeamPerson.BIOGRAPHY', 'Biography')),
			iHelper::ImageUploadField('Photo', _t('TeamPerson.PHOTO', 'Photo'), 'Uploads/Persons')
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
}