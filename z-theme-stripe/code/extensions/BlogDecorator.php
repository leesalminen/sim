<?php
/**
 * Blog Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class BlogDecorator extends DataExtension{
	/**
	 * Update CMS fields
	 */
	public function updateCMSFields(FieldList $fields) {
		$this->owner->loadSidebarEdtior($fields);
	}
}


/**
 * Bloge controller decorator
 */
class Blog_Controller_Decorator extends Extension{
	/**
	 * Allowed actions
	 */
	private static $allowed_actions = array(
		'author'
	);
	
	/**
	 * Get selected author
	 */
	public function TsCurrentAuthor(){
		if( $this->owner->request->param('Action') == 'author' )
		{
			// get author
			$author   = $this->owner->request->param('ID');
			$authorID = (int)$author;
			
			if($authorID && $member = Member::get()->byID($authorID)){
				return $member->getName();
			}
			elseif($author){
				return $author;
			}
		}
		
		return null;
	}
	
	/**
	 * Renders the blog posts for a given author
	 *
	 * @return SS_HTTPResponse
	**/
	public function author() {
		// get author
		$author   = $this->owner->request->param('ID');
		$authorID = (int)$author;
		
		if($authorID || $author)
		{
			if($authorID){
				$posts = BlogPost::get()->filter('Authors.ID', $authorID);
			}
			else{
				$posts = BlogPost::get()->filter('AuthorNames:PartialMatch:nocase', strtolower($author));
			}
			
			$this->owner->blogPosts = $posts;
			return $this->owner->render();
		}
		
		// return 404
		return $this->httpError(404, "Not Found");
	}
}