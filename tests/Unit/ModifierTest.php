<?php
namespace Rainsens\Composer\Tests\Unit;

use Rainsens\Composer\Facades\Modifier;
use Rainsens\Composer\Tests\TestCase;

class ModifierTest extends TestCase
{
	/** @test */
	public function can_check_if_file_is_existing()
	{
		
		$existence = Modifier::hasFile(config('composer.file'));
		
		$this->assertTrue($existence);
	}
	
	/** @test */
	public function can_set_file_path_dynamically()
	{
		Modifier::setPath('test_path');
		$this->assertEquals('test_path', config('composer.file'));
	}
	
	/** @test */
	public function can_get_all_items_from_file()
	{
		$items = Modifier::getAllItems();
		$this->assertIsString($items->name);
	}
	
	/** @test */
	public function can_get_certain_item_from_file()
	{
		$item = Modifier::get('name');
		$this->assertFalse(empty($item));
	}
	
	/** @test */
	public function can_get_certain_item_by_dot()
	{
		$item = Modifier::get('autoload.classmap');
		$this->assertFalse(empty($item));
	}
	
	/** @test */
	public function can_set_certain_item_as_string()
	{
		$items = Modifier::set('test_name', 'test_value');
		$this->assertEquals('test_value', $items->test_name);
		
		Modifier::remove('test_name');
	}
	
	/** @test */
	public function can_set_certain_item_as_array()
	{
		$array = ['first', 'second'];
		$items = Modifier::set('test_array', $array);
		$this->assertEquals('first', $items->test_array[0]);
		
		Modifier::remove('test_array');
	}
	
	/** @test */
	public function can_set_certain_item_as_object()
	{
		$object = new \stdClass();
		$object->name = 'Susan';
		$object->age = '25';
		$items = Modifier::set('test_object', $object);
		$this->assertEquals('Susan', $items->test_object->name);
		
		Modifier::remove('test_object');
	}
	
	/** @test */
	public function can_push_item_to_json_array()
	{
		$items = Modifier::push('autoload.classmap', 'pushed_class');
		$this->assertArrayHasKey('pushed_class', array_flip($items->autoload->classmap));
		
		Modifier::remove('autoload.classmap', 'pushed_class');
	}
	
	/** @test */
	public function can_check_if_item_had_already()
	{
		$result = Modifier::has('name');
		$this->assertTrue($result);
		
		$result = Modifier::has('fake_name');
		$this->assertFalse($result);
	}
	
	/** @test */
	public function can_remove_an_specified_value_in_array()
	{
		$items = Modifier::push('autoload.classmap', 'pushed_class');
		$this->assertArrayHasKey('pushed_class', array_flip($items->autoload->classmap));
		
		$items = Modifier::remove('autoload.classmap', 'pushed_class');
		$this->assertArrayNotHasKey('pushed_class', array_flip($items->autoload->classmap));
	}
	
	/** @test */
	public function can_remove_an_specified_item_in_object()
	{
		$items = Modifier::set('test', 'test_value');
		$this->assertEquals('test_value', $items->test);
		
		Modifier::remove('test');
		$this->assertFalse(Modifier::has('test'));
	}
}
