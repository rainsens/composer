<?php
namespace Rainsens\Composer\Facades;

use Illuminate\Support\Facades\Facade;

class Modifier extends Facade
{
	protected static function getFacadeAccessor()
	{
		return 'modifier';
	}
}
