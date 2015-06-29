<?php
class TS_Search_Extension extends Extension {
	/**
	 * Return dataObjectSet of the results using $_REQUEST to get info from form.
	 * Wraps around {@link searchEngine()}.
	 * 
	 * @param int $pageLength DEPRECATED 2.3 Use SearchForm->pageLength
	 * @param array $data Request data as an associative array. Should contain at least a key 'Search' with all searched keywords.
	 * @return SS_List
	 */
	public function getTsSearchResults($pageLength = null, $data = null){
	 	// legacy usage: $data was defaulting to $_REQUEST, parameter not passed in doc.silverstripe.org tutorials
		if(!isset($data) || !is_array($data)) $data = $_REQUEST;
		
		// page length
		if(!$pageLength) $pageLength = 10;
		$start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
		
		$results = '';
		
		// set language (if present)
		if(class_exists('Translatable')) {
			if(singleton('SiteTree')->hasExtension('Translatable') && isset($data['searchlocale'])) {
				if($data['searchlocale'] == "ALL") {
					Translatable::disable_locale_filter();
				} else {
					$origLocale = Translatable::get_current_locale();
					Translatable::set_current_locale($data['searchlocale']);
				}
			}
		}

		$keywords = $data['Search'];

	 	$andProcessor = create_function('$matches','
	 		return " +" . $matches[2] . " +" . $matches[4] . " ";
	 	');
	 	$notProcessor = create_function('$matches', '
	 		return " -" . $matches[3];
	 	');

	 	$keywords = preg_replace_callback('/()("[^()"]+")( and )("[^"()]+")()/i', $andProcessor, $keywords);
	 	$keywords = preg_replace_callback('/(^| )([^() ]+)( and )([^ ()]+)( |$)/i', $andProcessor, $keywords);
		$keywords = preg_replace_callback('/(^| )(not )("[^"()]+")/i', $notProcessor, $keywords);
		$keywords = preg_replace_callback('/(^| )(not )([^() ]+)( |$)/i', $notProcessor, $keywords);
		$keywords = $this->addStarsToKeywords($keywords);
		
		if(strpos($keywords, '"') !== false || strpos($keywords, '+') !== false || strpos($keywords, '-') !== false || strpos($keywords, '*') !== false) {
			$results = DB::getConn()->searchEngine($this->getTsClassesToSearch(), $keywords, $start, $pageLength, $this->getTsSortingMode(), $this->getTsExtraFilter(), true, $this->getTsFileFilter());
		}
		else {
			$results = DB::getConn()->searchEngine($this->getTsClassesToSearch(), $keywords, $start, $pageLength, $this->getTsSortingMode(), $this->getTsExtraFilter(), false, $this->getTsFileFilter());
		}
		
		// filter by permission
		if($results) foreach($results as $result) {
			if(!$result->canView()) $results->remove($result);
		}
		
		// reset locale
		if(class_exists('Translatable')) {
			if(singleton('SiteTree')->hasExtension('Translatable') && isset($data['searchlocale'])) {
				if($data['searchlocale'] == "ALL") {
					Translatable::enable_locale_filter();
				} else {
					Translatable::set_current_locale($origLocale);
				}
			}
		}

		return $results;
	}
	
	private function addStarsToKeywords($keywords) {
		if(!trim($keywords)) return "";
		// Add * to each keyword
		$splitWords = preg_split("/ +/" , trim($keywords));
		while(list($i,$word) = each($splitWords)) {
			if($word[0] == '"') {
				while(list($i,$subword) = each($splitWords)) {
					$word .= ' ' . $subword;
					if(substr($subword,-1) == '"') break;
				}
			} else {
				$word .= '*';
			}
			$newWords[] = $word;
		}
		return implode(" ", $newWords);
	}
	
	/**
	 * Get classes to search
	 *
	 * @return string
	 */
	protected function getTsClassesToSearch() {
		if(method_exists($this->owner, 'getTsClassesToSearch')) {
			return $this->owner->getTsClassesToSearch();
		}
		
		return array(
			"SiteTree", "File"
		);;
	}
	
	/**
	 * Get sorting mode
	 *
	 * @return string
	 */
	protected function getTsSortingMode() {
		if(method_exists($this->owner, 'getTsSortingMode')) {
			return $this->owner->getTsSortingMode();
		}
		return "\"Relevance\" DESC";
	}
	
	/**
	 * Get extra filter
	 *
	 * @return string
	 */
	protected function getTsExtraFilter() {
		if(method_exists($this->owner, 'getTsExtraFilter')) {
			return $this->owner->getTsExtraFilter();
		}
		return "";
	}
	
	/**
	 * Get alternative File filter
	 *
	 * @return string
	 */
	protected function getTsFileFilter() {
		if(method_exists($this->owner, 'getTsFileFilter')) {
			return $this->owner->getTsFileFilter();
		}
		return "";
	}
	
	/**
	 * Get inverted match
	 *
	 * @return string
	 */
	protected function getTsInvertedMatch() {
		if(method_exists($this->owner, 'getTsInvertedMatch')) {
			return $this->owner->getTsInvertedMatch();
		}
		return false;
	}
}