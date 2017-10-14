<?php

namespace RCS\CMS;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use RCS\CMS\Facades\CMS as CMSFacade;

class CMSServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'cms');
        $this->loadMigrationsFrom(__DIR__.'/Migrations');
        $this->mergeConfigFrom(__DIR__.'/Config/CMS.php', 'cms');
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('CMS', CMSFacade::class);
        $this->app->singleton('cms', function () {
            return new CMS();
        });

        if ($this->app->runningInConsole()) {
            /*$this->registerPublishableResources();*/
            $this->registerConsoleCommands();
        }
    
    }

    /**
     * Register the commands accessible from the Console.
     */
    private function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);

    }

}
