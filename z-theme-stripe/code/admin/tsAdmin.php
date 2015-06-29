<?php
/**
 * ThemeStripe Admin Section
 *
 * Anh Le <anhle@silverbusters.com>
 */
class tsAdmin extends ModelAdmin
{
    private static $managed_models = array('Testimonial');
 
    private static $url_segment = 'tsadmin';
    private static $menu_title  = 'TS Admin';
	
	private static $model_importers = array();
    
    /**
     * Method to init
     */
    public function init(){
        parent::init();
    }
	
	/**
	 * Get Form to Edit
	 */ 
	public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
		
		/**
		 * Sortable classes
		 */
		$SortableClasses = array();
		
        if( !empty($SortableClasses)
		   && in_array($this->modelClass, $SortableClasses)
		   && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass)))
		{
            if($gridField instanceof GridField) {
                $gridField->getConfig()->addComponent(new GridFieldSortableRows('SortOrder'));
            }
        }
		
        return $form;
    }
}
