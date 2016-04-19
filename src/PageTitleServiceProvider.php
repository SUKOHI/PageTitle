<?php namespace Sukohi\PageTitle;

use Illuminate\Support\ServiceProvider;

class PageTitleServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
		$this->publishes([
			__DIR__.'/config/page-title.php' => config_path('page-title.php'),
		], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['page-title'] = $this->app->share(function($app)
        {
            return new PageTitle;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['page-title'];
    }

}