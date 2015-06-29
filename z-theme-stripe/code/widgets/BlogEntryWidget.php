<?php
/**
 * Shows blog entries
 *
 * Anh Le <anhle@silverbusters.com>
 */
class BlogEntryWidget extends Widget{
	/**
	 * DB Fields
	 */
    private static $db = array(
		'Limit'             => 'Int',
		'SortBy'            => "Enum('newest,popular,random', 'newest')",
		'Featured'			=> 'Boolean'
    );
	
	/**
	 * Defaults
	 */
    private static $defaults = array(
		'Limit' 	   => 6,
		'SortBy'  	   => 'newest',
		'ExcerptLimit' => 30
    );
 
    private static $title 		= 'Blog Entries';
    private static $cmsTitle 	= 'Blog Entries Widget';
    private static $description = 'Shows blog entries';
	
	/**
	 * Sorting mode
	 */
	private $sortingModes = array(
		'newest' 	=> 'Newest first',
		'popular'	=> 'Most popular',
		'random'  	=> 'Random'
	);
 
	/**
	 * Setting up CMSFields
	 */
	public function getCMSFields()
	{
		$this->beforeUpdateCMSFields(function($fields) {
			$fields->merge(
				new FieldList(
					new CheckboxField('Featured', 'Only show featured entries'),
					new NumericField('Limit', 'Limit'),
					new DropdownField('SortBy', 'Sort by', $this->sortingModes)
				)
			);
		});
		
		return parent::getCMSFields();
	}
	
	/**
	 * Blog Entries
	 */ 
    public function wgBlogEntries()
	{
        if( method_exists('Blog','getBlogPosts') )
		{			
			// sorting mode
			switch($this->SortBy){
				case 'popular': $sortBy = array('Hits' => 'DESC'); break;
				case 'random':  $sortBy = 'RAND()'; break;
				default: 	    $sortBy = array('PublishDate' => 'DESC');
			}
			
			// filter
			$filter = array();
			
			if( $this->Featured )
				$filter['Featured'] =  1;
			
			// get current blog tree
			$page = Controller::curr();
			
			if($page->ClassName == 'Blog')
				$filter['ParentID'] = $page->ID;
			
			// get posts
			$posts = BlogPost::get();
			
			if($filter){
				$posts = $posts->filter($filter);
			}
			
			if($sortBy){
				$posts = $posts->sort($sortBy);
			}
			
			if($this->Limit){
				$posts = $posts->limit($this->Limit);
			}
			
			return $posts;
		}
		return false;
    }
}

/**
 * Controller
 */
class BlogEntryWidget_Controller extends Widget_Controller {}
