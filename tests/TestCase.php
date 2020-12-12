<?php
namespace Rainsens\Composer\Tests;

use Rainsens\Composer\Facades\Modifier;
use Rainsens\Composer\Providers\ComposerServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
	    parent::setUp();
    }
	
	protected function getPackageProviders($app)
    {
    	return [
    		ComposerServiceProvider::class,
	    ];
    }
    
    protected function getPackageAliases($app)
    {
    	return [
    		'Modifier' => Modifier::class,
	    ];
    }
	
	public function getEnvironmentSetUp($app)
    {
    }
}
