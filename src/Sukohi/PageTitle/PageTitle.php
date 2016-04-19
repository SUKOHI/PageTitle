<?php namespace Sukohi\PageTitle;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class PageTitle {

	private $_page_titles = [];

	public function get($pattern_key = '', $route_name = '') {

		$patterns = Config::get('page-title::patterns');
		$replacements = Config::get('page-title::replacements');

		if(empty($pattern_key)) {

			$pattern = reset($patterns);
			$pattern_key = key($patterns);

		} else {

			$pattern = $patterns[$pattern_key];

		}

		$current_route = (!empty($route_name)) ? $route_name : $this->getCurrentRoute();

		if($this->hasPageTitle($pattern_key, $current_route)) {

			return $this->getPageTitle($pattern_key, $current_route);

		}

		$pattern_routes = explode('.', $pattern_key);
		$current_routes = explode('.', $current_route);
		$title_targets = $title_replacements = [];

		foreach ($pattern_routes as $pattern_route) {

			foreach ($current_routes as $index => $route) {

				if(isset($replacements[$pattern_route][$route])) {

					$title_targets[] = '{'. $pattern_route .'}';
					$title_replacements[] = $replacements[$pattern_route][$route];

				}

			}

		}

		if(count($current_routes) != count($title_targets) ||
			count($current_routes) != count($title_replacements)) {

			throw new \Exception('Route name not matched.');

		}

		$page_title = str_replace($title_targets, $title_replacements, $pattern);
		$this->_page_titles[$pattern_key][$current_route] = $page_title;
		return $page_title;

	}

	private function hasPageTitle($key, $route) {

		return isset($this->_page_titles[$key][$route]);

	}

	private function getPageTitle($key, $route) {

		return $this->_page_titles[$key][$route];

	}

	private function getCurrentRoute() {

		return Route::getCurrentRoute()->getName();

	}

}