<?php namespace Sukohi\PageTitle\Facades;

use Illuminate\Support\Facades\Facade;

class PageTitle extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'page-title'; }

}