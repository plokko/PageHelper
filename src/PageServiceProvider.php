<?php
namespace plokko\PageHelper;

use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views/', 'pagehelper');
        $this->publishes([ __DIR__.'/config/example.php' => config_path('PageHelper.php')]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/default.php','PageHelper');


        //---{ View composer }---//
        view()->composer('*',ViewComposers\PageComposer::class);

        //---{ Register services }---//
        $this->app->singleton('Page',function ($app){
            return new Page(config('PageHelper'));
        });

        $this->app->singleton('Meta',function ($app){
            return new Meta(config('PageHelper.meta'));

             });
        $this->app->singleton('Script',function ($app){
            return new Script(config('PageHelper.script'));
        });


        $this->app->singleton('Style',function ($app){
            return new Style(config('PageHelper.style'));
        });
    }

/*
    public function provides()
    {
        return [
            'Page',
            'Script',
            'Meta',
            'Style',
            'JS',
        ];
    }
*/
}