<?php
/**
 * Page Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PageDecorator extends Extension{
	/**
	 * DB fields
	 */
	private static $db = array(
		'PageLayout'  => 'Varchar(30)',
		'PageHeading' => 'Varchar(255)'
	);
	
	/**
	 * Has many
	 */
	private static $has_many = array(
		'BannerSliders' => 'BannerSlider',
		'Images'		=> 'PageImage'
	);
	
	public function updateCMSFields(FieldList $fields) {
		// hide the Widgets tab by default
		$fields->removeByName('Widgets');
		
		// page heading
		$fields->addFieldToTab('Root.Main', TextField::create('PageHeading', 'Page heading')->setDescription('Optional. Leave it blanks to use Page Name instead.'), 'URLSegment');
		
		// allow to choice layout from available layouts
		if( $layouts = $this->getThemeLayouts() ){
			$fields->addFieldToTab('Root.Main', $field = DropdownField::create('PageLayout', 'Layout', $layouts), 'Content');
			
			$field->setDescription('Note: always flush the cache after change the layout.');
			$field->setEmptyString('Default');
		}
	}
	
	/**
	 * Sidebar Editor for managing Widgets
	 */
	public function loadSidebarEdtior($fields){
		$label = _t('Widget.SIDEBARTAB', 'Sidebar');
		
		$fields->addFieldToTab(
			"Root.{$label}", 
			new CheckboxField('InheritSideBar', _t('Widget.INHERITFROMPARENT', 'Inherit sidebar from parent'))
		);
		$fields->addFieldToTab(
			"Root.{$label}", 
			new WidgetAreaEditor('SideBar')
		);
	}
	
	/**
	 * Get available layoyts for this page type
	 */
	private function getThemeLayouts()
	{
		$ds			= DIRECTORY_SEPARATOR;
		$layoutPath = BASE_PATH."{$ds}themes{$ds}".Config::inst()->get('SSViewer', 'theme')."{$ds}templates{$ds}Layout";
		$className  = get_class($this->owner);
		
		if( file_exists($layoutPath) && is_dir($layoutPath) )
		{
			$finder = new SS_FileFinder();
			$finder->setOptions(array(
				'name_regex'     => '/^('.$className.'.*.ss)/i',
				'max_depth'      => 1
			));
			
			$layouts = $finder->find($layoutPath);
			
			if( $layouts && count($layouts) > 1 )
			{
				$_layouts = array();
				
				foreach($layouts as $layout){
					$name 			 = pathinfo($layout, PATHINFO_FILENAME);
					
					if($name != $className){
						$niceName = preg_replace("/^[^A-Za-z0-9]/", '', str_ireplace($className, '', $name) );
						$niceName = URLSegmentFilter::create()->filter($niceName);
						$niceName = ucfirst(str_replace('-', ' ', $niceName));
						
						$_layouts[$name] = $niceName;
					}
				}
				
				return $_layouts;
			}
		}
		
		return false;
	}
	
	/**
	 * Link to the Previous or Next pages
	 */
	public function getPreviousNextPage($sameType = true)
	{
		$filter = array('ParentID' => $this->owner->ParentID);
		$next   = $previous = false;
		
		if($sameType){
			$filter['ClassName'] = get_class($this->owner);
		}
		
		// next
		$filter['Sort:GreaterThan'] = $this->owner->Sort;
		
		$next = SiteTree::get()->filter($filter)->sort('Sort', 'ASC')->limit(1)->first();
		
		// previous
		unset($filter['Sort:GreaterThan']);
		
		$filter['Sort:LessThan'] = $this->owner->Sort;
		
		$previous = SiteTree::get()->filter($filter)->sort('Sort', 'DESC')->limit(1)->first();
		
		if($next || $previous){
			return (new ArrayData(array(
				'Previous' 	=> $previous,
				'Next' 		=> $next
			)));
		}
		
		return false;
	}
}

/**
 * Page Controller Decorator
 *
 * Anh Le <anhle@silverbusters.com>
 */
class PageControllerDecorator extends Extension{
	/**
	 * Allowed actions
	 */
	private static $allowed_actions = array(
		'updateThemeSettings' => 'ADMIN'
	);
	
	/**
	 * Custom assets
	 */
	protected static $_CustomAssets = array();
	
	/**
	 * Custom HTML Classes
	 */
	protected static $_CustomHTMLClasses = array();
	
	/**
	 * Permission check
	 */
	public function hasPermission($code){
		return Permission::check($code);
	}
	
	/**
	 * Method to update viewer
	 */
	public function updateViewer($viewer, $action){
		# setup layout to render
		if( $this->owner->PageLayout )
		{
			$ds			= DIRECTORY_SEPARATOR;
			$layoutPath = BASE_PATH."{$ds}themes{$ds}".Config::inst()->get('SSViewer', 'theme')."{$ds}templates{$ds}Layout{$ds}".$this->owner->PageLayout.'.ss';
			
			if( file_exists($layoutPath) && is_file($layoutPath) )
				$viewer->setTemplateFile('Layout', $layoutPath);
		}
		
		return $viewer;
	}
	
	/**
	 * Load theme assets
	 */
	public function loadThemeAssets(){
		# get current theme
		$currentTheme = Config::inst()->get('SSViewer', 'theme');
		$themeDir     = $this->owner->ThemeDir();
		$assets    	  = Config::inst()->get('ThemeStripe', 'Assets');
		$combinedDir  = Config::inst()->get('ThemeStripe', 'CombinedDir');
		
		# put the combined folder inside our theme so that relative css image paths work
		Requirements::set_combined_files_folder($themeDir . $combinedDir);
		
		# combine CSS
		if( isset($assets[$currentTheme]['css']) ){
			$files = $assets[$currentTheme]['css'];
			
			if( isset( self::$_CustomAssets['css'] ) && is_array(self::$_CustomAssets['css']) ){
				$files = array_merge($files, self::$_CustomAssets['css']);
			}
			
			if( !empty($files) ){
				$fileList = array();
				
				foreach($files as $file){
					if( preg_match("~^(?:f|ht)tps?://~i", $file) ){
						Requirements::css($file);
					}
					else if( file_exists(BASE_PATH.'/'.$themeDir.'/'.$file) ){
						$fileList[md5($file)] = $themeDir.'/'.$file;
					}
				}
				
				if( !empty($fileList) ){
					Requirements::combine_files('stylesheet.css', $fileList);
				}
			}
		}
		
		# combine JS
		if( isset($assets[$currentTheme]['js']) ){
			$files = $assets[$currentTheme]['js'];
			
			if( isset( self::$_CustomAssets['js'] ) && is_array(self::$_CustomAssets['js']) ){
				$files = array_merge($files, self::$_CustomAssets['js']);
			}
			
			if( !empty($files) ){
				$fileList = array();
				
				foreach($files as $file){
					if( preg_match("~^(?:f|ht)tps?://~i", $file) ){
						Requirements::javascript($file);
					}
					else if( file_exists(BASE_PATH.'/'.$themeDir.'/'.$file) ){
						$fileList[md5($file)] = $themeDir.'/'.$file;
					}
				}
				
				if( !empty($fileList) ){
					Requirements::combine_files('javascript.js', $fileList);
				}
			}
		}
	}
	
	/**
	 * Set custom assets
	 *
	 * @param string $file
	 * @param string $type possible values: css|js
	 * @param boolean $reload true|false : reload assets.
	 */
	public function setCustomAssets($file, $type = 'css', $reload = true){
		if( in_array($type, array('js', 'css') ) ){
			self::$_CustomAssets[$type][] = $file;
			
			if( (boolean)$reload == true )
			{
				// clear current assets
				Requirements::clear();
				
				// load new assets
				$this->loadThemeAssets();
			}
		}
	}
	
	/**
	 * Set Custom HTML Classes
	 */
	public static function setCustomHTMLClasses( $classes = array() ){
		settype($classes, 'array');
		
		if( !empty($classes) ){
			foreach( $classes as $class ){
				if( !isset(self::$_CustomHTMLClasses[$class]) ){
					self::$_CustomHTMLClasses[] = $class;
				}
			}
		}
	}
	
	/**
	 * Get Custom HTML Classes
	 */
	public static function getCustomHTMLClasses( $return_array = false ){
		$classes = self::$_CustomHTMLClasses;
		
		if( !empty($classes) ){
			return ( $return_array ? $classes : implode(' ', $classes) );
		}
		
		return null;
	}
	
	/**
	 * Browser detection
	 */
	public static function browser_lt_ie($version = 9){
		if(browser_detection::is_ie() && browser_detection::get_browser_version() < $version) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Get name of current theme
	 */
	public function getThemeName(){
		if(class_exists('SiteConfig') && ($config = SiteConfig::current_site_config()) && $config->Theme) {
			return $config->Theme;
		} elseif(Config::inst()->get('SSViewer', 'theme_enabled') && Config::inst()->get('SSViewer', 'theme')) {
			return Config::inst()->get('SSViewer', 'theme');
		}
		
		return false;
	}
	
	/**
	 * Update theme settings
	 */
	public function updateThemeSettings($request){
		// get current site configuration
		$cfg = SiteConfig::current_site_config();
		
		$ts  = unserialize($cfg->ThemeSettings);
		$ts  = $ts ? $ts : array();
		$ts  = ArrayLib::array_merge_recursive($ts, $request->requestVar('settings'));
		
		if($ts){
			$cfg->ThemeSettings = serialize($ts);
			$cfg->write();
			
			return 1;
		}
		
		return 0;
	}
	
	/**
	 * Get theme settings
	 */
	private static $_ThemeSettings = null;
	
	public function ThemeSettings($key = null, $theme = null)
	{
		// get theme
		$theme = $theme ? $theme : $this->getThemeName();
		
		//
		$ts = self::$_ThemeSettings;
		
		if( $ts === null ){
			// get current site configuration
			$cfg = SiteConfig::current_site_config();
			$ts  = unserialize($cfg->ThemeSettings);
			
			self::$_ThemeSettings = $ts;
		}
		
		return ( ($ts && $theme && $key && isset($ts[$theme][$key])) ? $ts[$theme][$key] : false );
	}
}

/**
 * Page Image Object
 */
class PageImage extends Image{
	/**
	 * Has_one
	 */
	private static $has_one = array(
		'Page' => 'Page'
	);
}