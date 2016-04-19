<?php namespace Sukohi\PageTitle;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class PageTitle {

	private $_page_titles = [];
	private $_current_route = '';

	public function get($pattern_key = '', $route_name = '') {

		$patterns = config('page-title.patterns');
		$this->_current_route = $this->getCurrentRoute($route_name);

		if(empty($pattern_key)) {

			$pattern = reset($patterns);
			$pattern_key = key($patterns);

		} else {

			$pattern = $patterns[$pattern_key];

		}

		if($this->hasPageTitle($pattern_key, $this->_current_route)) {

			return $this->getPageTitle($pattern_key, $this->_current_route);

		}

		$labels = $this->getLabels($pattern_key);
		$page_title = $pattern;

		foreach ($labels as $key => $label) {

			$page_title = str_replace('{'. $key .'}', $label, $page_title);

		}

		if(preg_match('|[\{\}]|', $page_title)) {

			throw new \Exception('Route name not matched.');

		}

		return $page_title;

	}

	private function hasPageTitle($key, $route) {

		return isset($this->_page_titles[$key][$route]);

	}

	private function getPageTitle($key, $route) {

		return $this->_page_titles[$key][$route];

	}

	private function getCurrentRoute($route_name) {

		return (!empty($route_name)) ? $route_name : Route::getCurrentRoute()->getName();

	}

	private function getLabels($pattern_key) {

		$labels = [];
		$replacements = config('page-title.replacements');
		$pattern_keys = explode('.', $pattern_key);
		$current_routes = explode('.', $this->_current_route);

		foreach ($pattern_keys as $index => $pattern_route) {

			foreach ($replacements[$pattern_route] as $route => $label) {

				if($route == $current_routes[$index]) {

					$labels[$pattern_route] = $label;

				}

			}

		}

		return $labels;

	}

}