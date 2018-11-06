<?php
/**
 * Fire Department Framework: theme variables storage
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get theme variable
if (!function_exists('fire_department_storage_get')) {
	function fire_department_storage_get($var_name, $default='') {
		global $FIRE_DEPARTMENT_STORAGE;
		return isset($FIRE_DEPARTMENT_STORAGE[$var_name]) ? $FIRE_DEPARTMENT_STORAGE[$var_name] : $default;
	}
}

// Set theme variable
if (!function_exists('fire_department_storage_set')) {
	function fire_department_storage_set($var_name, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		$FIRE_DEPARTMENT_STORAGE[$var_name] = $value;
	}
}

// Check if theme variable is empty
if (!function_exists('fire_department_storage_empty')) {
	function fire_department_storage_empty($var_name, $key='', $key2='') {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!empty($key) && !empty($key2))
			return empty($FIRE_DEPARTMENT_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return empty($FIRE_DEPARTMENT_STORAGE[$var_name][$key]);
		else
			return empty($FIRE_DEPARTMENT_STORAGE[$var_name]);
	}
}

// Check if theme variable is set
if (!function_exists('fire_department_storage_isset')) {
	function fire_department_storage_isset($var_name, $key='', $key2='') {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!empty($key) && !empty($key2))
			return isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key][$key2]);
		else if (!empty($key))
			return isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key]);
		else
			return isset($FIRE_DEPARTMENT_STORAGE[$var_name]);
	}
}

// Inc/Dec theme variable with specified value
if (!function_exists('fire_department_storage_inc')) {
	function fire_department_storage_inc($var_name, $value=1) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (empty($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = 0;
		$FIRE_DEPARTMENT_STORAGE[$var_name] += $value;
	}
}

// Concatenate theme variable with specified value
if (!function_exists('fire_department_storage_concat')) {
	function fire_department_storage_concat($var_name, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (empty($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = '';
		$FIRE_DEPARTMENT_STORAGE[$var_name] .= $value;
	}
}

// Get array (one or two dim) element
if (!function_exists('fire_department_storage_get_array')) {
	function fire_department_storage_get_array($var_name, $key, $key2='', $default='') {
		global $FIRE_DEPARTMENT_STORAGE;
		if (empty($key2))
			return !empty($var_name) && !empty($key) && isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key]) ? $FIRE_DEPARTMENT_STORAGE[$var_name][$key] : $default;
		else
			return !empty($var_name) && !empty($key) && isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key][$key2]) ? $FIRE_DEPARTMENT_STORAGE[$var_name][$key][$key2] : $default;
	}
}

// Set array element
if (!function_exists('fire_department_storage_set_array')) {
	function fire_department_storage_set_array($var_name, $key, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if ($key==='')
			$FIRE_DEPARTMENT_STORAGE[$var_name][] = $value;
		else
			$FIRE_DEPARTMENT_STORAGE[$var_name][$key] = $value;
	}
}

// Set two-dim array element
if (!function_exists('fire_department_storage_set_array2')) {
	function fire_department_storage_set_array2($var_name, $key, $key2, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key])) $FIRE_DEPARTMENT_STORAGE[$var_name][$key] = array();
		if ($key2==='')
			$FIRE_DEPARTMENT_STORAGE[$var_name][$key][] = $value;
		else
			$FIRE_DEPARTMENT_STORAGE[$var_name][$key][$key2] = $value;
	}
}

// Add array element after the key
if (!function_exists('fire_department_storage_set_array_after')) {
	function fire_department_storage_set_array_after($var_name, $after, $key, $value='') {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if (is_array($key))
			fire_department_array_insert_after($FIRE_DEPARTMENT_STORAGE[$var_name], $after, $key);
		else
			fire_department_array_insert_after($FIRE_DEPARTMENT_STORAGE[$var_name], $after, array($key=>$value));
	}
}

// Add array element before the key
if (!function_exists('fire_department_storage_set_array_before')) {
	function fire_department_storage_set_array_before($var_name, $before, $key, $value='') {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if (is_array($key))
			fire_department_array_insert_before($FIRE_DEPARTMENT_STORAGE[$var_name], $before, $key);
		else
			fire_department_array_insert_before($FIRE_DEPARTMENT_STORAGE[$var_name], $before, array($key=>$value));
	}
}

// Push element into array
if (!function_exists('fire_department_storage_push_array')) {
	function fire_department_storage_push_array($var_name, $key, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if ($key==='')
			array_push($FIRE_DEPARTMENT_STORAGE[$var_name], $value);
		else {
			if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key])) $FIRE_DEPARTMENT_STORAGE[$var_name][$key] = array();
			array_push($FIRE_DEPARTMENT_STORAGE[$var_name][$key], $value);
		}
	}
}

// Pop element from array
if (!function_exists('fire_department_storage_pop_array')) {
	function fire_department_storage_pop_array($var_name, $key='', $defa='') {
		global $FIRE_DEPARTMENT_STORAGE;
		$rez = $defa;
		if ($key==='') {
			if (isset($FIRE_DEPARTMENT_STORAGE[$var_name]) && is_array($FIRE_DEPARTMENT_STORAGE[$var_name]) && count($FIRE_DEPARTMENT_STORAGE[$var_name]) > 0)
				$rez = array_pop($FIRE_DEPARTMENT_STORAGE[$var_name]);
		} else {
			if (isset($FIRE_DEPARTMENT_STORAGE[$var_name][$key]) && is_array($FIRE_DEPARTMENT_STORAGE[$var_name][$key]) && count($FIRE_DEPARTMENT_STORAGE[$var_name][$key]) > 0)
				$rez = array_pop($FIRE_DEPARTMENT_STORAGE[$var_name][$key]);
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if (!function_exists('fire_department_storage_inc_array')) {
	function fire_department_storage_inc_array($var_name, $key, $value=1) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if (empty($FIRE_DEPARTMENT_STORAGE[$var_name][$key])) $FIRE_DEPARTMENT_STORAGE[$var_name][$key] = 0;
		$FIRE_DEPARTMENT_STORAGE[$var_name][$key] += $value;
	}
}

// Concatenate array element with specified value
if (!function_exists('fire_department_storage_concat_array')) {
	function fire_department_storage_concat_array($var_name, $key, $value) {
		global $FIRE_DEPARTMENT_STORAGE;
		if (!isset($FIRE_DEPARTMENT_STORAGE[$var_name])) $FIRE_DEPARTMENT_STORAGE[$var_name] = array();
		if (empty($FIRE_DEPARTMENT_STORAGE[$var_name][$key])) $FIRE_DEPARTMENT_STORAGE[$var_name][$key] = '';
		$FIRE_DEPARTMENT_STORAGE[$var_name][$key] .= $value;
	}
}

// Call object's method
if (!function_exists('fire_department_storage_call_obj_method')) {
	function fire_department_storage_call_obj_method($var_name, $method, $param=null) {
		global $FIRE_DEPARTMENT_STORAGE;
		if ($param===null)
			return !empty($var_name) && !empty($method) && isset($FIRE_DEPARTMENT_STORAGE[$var_name]) ? $FIRE_DEPARTMENT_STORAGE[$var_name]->$method(): '';
		else
			return !empty($var_name) && !empty($method) && isset($FIRE_DEPARTMENT_STORAGE[$var_name]) ? $FIRE_DEPARTMENT_STORAGE[$var_name]->$method($param): '';
	}
}

// Get object's property
if (!function_exists('fire_department_storage_get_obj_property')) {
	function fire_department_storage_get_obj_property($var_name, $prop, $default='') {
		global $FIRE_DEPARTMENT_STORAGE;
		return !empty($var_name) && !empty($prop) && isset($FIRE_DEPARTMENT_STORAGE[$var_name]->$prop) ? $FIRE_DEPARTMENT_STORAGE[$var_name]->$prop : $default;
	}
}
?>