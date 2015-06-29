<?php
/**
 * BlogPost Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class BlogPostDecorator extends DataExtension{
	/**
	 * Database field
	 */
	private static $db = array(
		'Hits' 		=> 'Int',
		'Featured'  => 'Boolean',
		'VideoURL'  => 'Varchar(255)'
	);
	
	/**
	 * Has one
	 */ 
	private static $has_one = array();
	
	/**
	 * Belongs many many
	 */
	private static $belongs_many_many = array();
	
	/**
	 * Update CMS fields
	 */ 
	public function updateCMSFields(FieldList $fields){
		// Remove fields
		$fields->removeByName('FeaturedImage');
		
		// Options
		$fields->addFieldToTab('Root.Main', new CheckboxField('Featured', 'Featured'), 'Title');
		$fields->addFieldToTab('Root.Main', new NumericField('Hits', 'Hits'), 'Content');
		$fields->addFieldToTab('Root.Main', TextField::create('VideoURL', 'Embed Video URL')->setDescription('If you\'d like to show the video on the blog list instead of showing the image, put the embed url of the video here.'), 'Content');
		
		// Images
		$fields->addFieldToTab('Root.Images', iHelper::ImageUploadField('FeaturedImage', 'Featured image', 'Uploads/Pages/'.(int)$this->owner->ID) );
		$fields->addFieldToTab('Root.Images', iHelper::ImageUploadField('Images', 'Images', 'Uploads/Pages/'.(int)$this->owner->ID) ); // @see PageDecorator.php - Images
		
		$this->owner->loadSidebarEdtior($fields);
	}
	
	/**
	 * Populate defaults
	 */
	public function populateDefaults(){
		parent::populateDefaults();
	}
	
	/**
	 * Method to update hits
	 */
	public function updateHits(){
		$Hits = $this->owner->Hits + 1;
		
		DB::query('UPDATE "BlogPost" SET "Hits"=\''.$Hits.'\' WHERE "ID" = \''.$this->owner->ID.'\' ');
		DB::query('UPDATE "BlogPost_Live" SET "Hits"=\''.$Hits.'\' WHERE "ID" = \''.$this->owner->ID.'\' ');
		DB::query('UPDATE "BlogPost_versions" SET "Hits"=\''.$Hits.'\' WHERE "RecordID" = \''.$this->owner->ID.'\' ');
	}
}