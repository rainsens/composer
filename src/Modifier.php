<?php
namespace Rainsens\Composer;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class Modifier
{
	public function hasFile(string $path)
	{
		return File::exists($path);
	}
	
	public function setPath(string $path)
	{
		if ($path) {
			config(['composer.file' => $path]);
		}
		return $this;
	}
	
	public function getPath()
	{
		return config('composer.file');
	}
	
	public function getAllItems()
	{
		$path = $this->getPath();
		$content = File::get($path);
		$items = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content));
		return $items;
	}
	
	public function get(string $name, string $default = '')
	{
		$items = $this->getAllItems();
		return data_get($items, $name, $default);
	}
	
	public function has(string $name)
	{
		return (bool)$this->get($name);
	}
	
	/**
	 * Set an existing item or add it once it does not exist to object.
	 * {key : value}
	 *
	 * @param string $name
	 * @param $value
	 * @return mixed
	 */
	public function set(string $name, $value)
	{
		$items = $this->getAllItems();
		data_set($items, $name, $value);
		$this->putToFile($items);
		return $this->getAllItems();
	}
	
	/**
	 * Push item to a specified array.
	 * key: [item]
	 *
	 * @param string $name
	 * @param $value
	 * @return mixed
	 */
	public function push(string $name, $value)
	{
		$partialItems = array_flip($this->get($name));
		
		if (gettype($partialItems) === 'array' && !Arr::has($partialItems, $value))
		{
			$partialItems = array_flip($partialItems);
			
			$partialItems[] = $value;
			$this->set($name, $partialItems);
		}
		
		return $this->getAllItems();
	}
	
	/**
	 * Remove item by given name
	 * if also provide the paramter $value
	 * remove the $value in $name array.
	 *
	 * @param string $name
	 * @param $value
	 * @return mixed
	 */
	public function remove(string $name, $value = null)
	{
		if ($value) {
			return $this->removeItemFromArray($name, $value);
		}
		return $this->removeItemFromObject($name);
	}
	
	protected function removeItemFromObject(string $name)
	{
		$items = $this->getAllItems();
		unset($items->$name);
		$this->putToFile($items);
		return $this->getAllItems();
	}
	
	protected function removeItemFromArray(string $name, $value)
	{
		$partialItems = array_flip($this->get($name));
		
		if (gettype($partialItems) === 'array' && Arr::has($partialItems, $value))
		{
			Arr::forget($partialItems, $value);
			$this->set($name, array_flip($partialItems));
		}
		return $this->getAllItems();
	}
	
	protected function putToFile($content): void
	{
		$json = str_replace('\\/', '/', json_encode($content, JSON_PRETTY_PRINT));
		File::put($this->getPath(), $json);
	}
}
