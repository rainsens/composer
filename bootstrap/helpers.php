<?php

use Rainsens\Composer\Facades\Modifier;

if (! function_exists('_composer_has')) {
	/**
	 * Check if has specified item.
	 *
	 * @param string $name
	 * @param string $path
	 * @return mixed
	 */
	function _composer_has(string $name, string $path = '') {
		return Modifier::setPath($path)->has($name);
	}
}

if (! function_exists('_composer_set')) {
	/**
	 * Set an existing item or add it once it does not exist to object.
	 *
	 * @param string $name
	 * @param $value
	 * @param string $path
	 * @return mixed
	 */
	function _composer_set(string $name, $value, string $path = '') {
		return Modifier::setPath($path)->set($name, $value);
	}
}

if (! function_exists('_composer_push')) {
	/**
	 * Push item to a specified array.
	 *
	 * @param string $name
	 * @param $value
	 * @param string $path
	 * @return mixed
	 */
	function _composer_push(string $name, $value, string $path = '') {
		return Modifier::setPath($path)->push($name, $value);
	}
}

if (! function_exists('_composer_remove')) {
	/**
	 * Remove item by given name
	 * if also provide the parameter $value
	 * remove the $value in $name array.
	 *
	 * @param string $name
	 * @param null $value
	 * @param string $path
	 * @return mixed
	 */
	function _composer_remove(string $name, $value = null, string $path = '') {
		return Modifier::setPath($path)->remove($name, $value);
	}
}

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * Helpers for vendor below.
 * ---------------------------------------------------------------------------------------------------------------------
 */

if (! function_exists('composer_base_path')) {
	/**
	 * Get the path to root.
	 *
	 * @param string $path
	 * @return string
	 */
	function composer_base_path(string $path = '') {
		$path = trim($path, DIRECTORY_SEPARATOR);
		return dirname(__DIR__) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
	}
}

if (! function_exists('composer_config_path')) {
	function composer_config_path(string $path = '') {
		return composer_base_path("config") . ($path ? DIRECTORY_SEPARATOR . $path : $path);
	}
}
