<?php
/**
 * Member Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class MemberDecorator extends DataExtension{
	/**
	 * DB fields
	 */
	private static $db = array(
		'Biography' => 'HTMLText'
	);
	
	/**
	 * Has one
	 */
	private static $has_one = array(
		'Photo' => 'Image'
	);
	
	/**
	 * Update CMS fields
	 */ 
	public function updateCMSFields(FieldList $fields){
		// Bioghraphy
		$fields->addFieldToTab('Root.Bioghraphy', iHelper::ImageUploadField('Photo', 'Photo', 'Uploads/Members') );
		$fields->addFieldToTab('Root.Bioghraphy', iHelper::HTMLEditorField('Biography', 'Biography') );
	}
	
	/**
	 * Get blog author link
	 */
	public function getBlogAuthorLink(Blog $BlogHolder = null){
		$BlogHolder = $BlogHolder ? $BlogHolder : Blog::get()->first();
		
		return Controller::join_links($BlogHolder->Link(), "author", $this->getURLSegment());
	}
	
	/**
	 * Generate URLSegment bases on the ID and the Title
	 */
	public function getURLSegment(){
		return $this->owner->ID. '-'. URLSegmentFilter::create()->filter($this->owner->getTitle());
	}
}