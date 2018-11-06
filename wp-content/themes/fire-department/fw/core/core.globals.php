<?php
/**
 * Fire Department Framework: global variables storage
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Get global variable
if (!function_exists('fire_department_get_global')) {
	function fire_department_get_global($var_name) {
		global $FIRE_DEPARTMENT_GLOBALS;
		return isset($FIRE_DEPARTMENT_GLOBALS[$var_name]) ? $FIRE_DEPARTMENT_GLOBALS[$var_name] : '';
	}
}

// Set global variable
if (!function_exists('fire_department_set_global')) {
	function fire_department_set_global($var_name, $value) {
		global $FIRE_DEPARTMENT_GLOBALS;
		$FIRE_DEPARTMENT_GLOBALS[$var_name] = $value;
	}
}

// Inc/Dec global variable with specified value
if (!function_exists('fire_department_inc_global')) {
	function fire_department_inc_global($var_name, $value=1) {
		global $FIRE_DEPARTMENT_GLOBALS;
		$FIRE_DEPARTMENT_GLOBALS[$var_name] += $value;
	}
}

// Concatenate global variable with specified value
if (!function_exists('fire_department_concat_global')) {
	function fire_department_concat_global($var_name, $value) {
		global $FIRE_DEPARTMENT_GLOBALS;
		$FIRE_DEPARTMENT_GLOBALS[$var_name] .= $value;
	}
}

// Get global array element
if (!function_exists('fire_department_get_global_array')) {
	function fire_department_get_global_array($var_name, $key) {
		global $FIRE_DEPARTMENT_GLOBALS;
		return isset($FIRE_DEPARTMENT_GLOBALS[$var_name][$key]) ? $FIRE_DEPARTMENT_GLOBALS[$var_name][$key] : '';
	}
}

// Set global array element
if (!function_exists('fire_department_set_global_array')) {
	function fire_department_set_global_array($var_name, $key, $value) {
		global $FIRE_DEPARTMENT_GLOBALS;
		if (!isset($FIRE_DEPARTMENT_GLOBALS[$var_name])) $FIRE_DEPARTMENT_GLOBALS[$var_name] = array();
		$FIRE_DEPARTMENT_GLOBALS[$var_name][$key] = $value;
	}
}

// Inc/Dec global array element with specified value
if (!function_exists('fire_department_inc_global_array')) {
	function fire_department_inc_global_array($var_name, $key, $value=1) {
		global $FIRE_DEPARTMENT_GLOBALS;
		$FIRE_DEPARTMENT_GLOBALS[$var_name][$key] += $value;
	}
}

// Concatenate global array element with specified value
if (!function_exists('fire_department_concat_global_array')) {
	function fire_department_concat_global_array($var_name, $key, $value) {
		global $FIRE_DEPARTMENT_GLOBALS;
		$FIRE_DEPARTMENT_GLOBALS[$var_name][$key] .= $value;
	}
}
?>