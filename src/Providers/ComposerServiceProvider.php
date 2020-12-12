<?php
namespace Rainsens\Composer\Providers;

use Rainsens\Compose\Composer;
use Illuminate\Support\ServiceProvider;
use Rainsens\Composer\Modifier;
use Rainsens\Composer\Facades\Modifier as ComposerModifier;

class ComposerServiceProvider extends ServiceProvider
{
    
    public function register()
    {
	    $this->app->bind('modifier', function () {return new Modifier;});
    }

    public function boot()
    {
    	$this->publishes([composer_config_path('composer.php') => config_path('composer.php')], 'config');
    	
    	if (empty(config('composer.file')) or !ComposerModifier::isFileExisting(config('composer.file'))) {
		    config(['composer.file' => base_path('composer.json')]);
	    }
    }
}
