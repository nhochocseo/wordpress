<?php
/**
 * Fire Department Framework: strings manipulations
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Check multibyte functions
if ( ! defined( 'FIRE_DEPARTMENT_MULTIBYTE' ) ) define( 'FIRE_DEPARTMENT_MULTIBYTE', function_exists('mb_strpos') ? 'UTF-8' : false );

if (!function_exists('fire_department_strlen')) {
	function fire_department_strlen($text) {
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_strlen($text) : strlen($text);
	}
}

if (!function_exists('fire_department_strpos')) {
	function fire_department_strpos($text, $char, $from=0) {
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_strpos($text, $char, $from) : strpos($text, $char, $from);
	}
}

if (!function_exists('fire_department_strrpos')) {
	function fire_department_strrpos($text, $char, $from=0) {
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_strrpos($text, $char, $from) : strrpos($text, $char, $from);
	}
}

if (!function_exists('fire_department_substr')) {
	function fire_department_substr($text, $from, $len=-999999) {
		if ($len==-999999) { 
			if ($from < 0)
				$len = -$from; 
			else
				$len = fire_department_strlen($text)-$from;
		}
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_substr($text, $from, $len) : substr($text, $from, $len);
	}
}

if (!function_exists('fire_department_strtolower')) {
	function fire_department_strtolower($text) {
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_strtolower($text) : strtolower($text);
	}
}

if (!function_exists('fire_department_strtoupper')) {
	function fire_department_strtoupper($text) {
		return FIRE_DEPARTMENT_MULTIBYTE ? mb_strtoupper($text) : strtoupper($text);
	}
}

if (!function_exists('fire_department_strtoproper')) {
	function fire_department_strtoproper($text) { 
		$rez = ''; $last = ' ';
		for ($i=0; $i<fire_department_strlen($text); $i++) {
			$ch = fire_department_substr($text, $i, 1);
			$rez .= fire_department_strpos(' .,:;?!()[]{}+=', $last)!==false ? fire_department_strtoupper($ch) : fire_department_strtolower($ch);
			$last = $ch;
		}
		return $rez;
	}
}

if (!function_exists('fire_department_strrepeat')) {
	function fire_department_strrepeat($str, $n) {
		$rez = '';
		for ($i=0; $i<$n; $i++)
			$rez .= $str;
		return $rez;
	}
}

if (!function_exists('fire_department_strshort')) {
	function fire_department_strshort($str, $maxlength, $add='...') {
		if ($maxlength < 0) 
			return $str;
		if ($maxlength == 0)
			return '';
		if ($maxlength >= fire_department_strlen($str))
			return strip_tags($str);
		$str = fire_department_substr(strip_tags($str), 0, $maxlength - fire_department_strlen($add));
		$ch = fire_department_substr($str, $maxlength - fire_department_strlen($add), 1);
		if ($ch != ' ') {
			for ($i = fire_department_strlen($str) - 1; $i > 0; $i--)
				if (fire_department_substr($str, $i, 1) == ' ') break;
			$str = trim(fire_department_substr($str, 0, $i));
		}
		if (!empty($str) && fire_department_strpos(',.:;-', fire_department_substr($str, -1))!==false) $str = fire_department_substr($str, 0, -1);
		return ($str) . ($add);
	}
}

// Clear string from spaces, line breaks and tags (only around text)
if (!function_exists('fire_department_strclear')) {
	function fire_department_strclear($text, $tags=array()) {
		if (empty($text)) return $text;
		if (!is_array($tags)) {
			if ($tags != '')
				$tags = explode($tags, ',');
			else
				$tags = array();
		}
		$text = trim(chop($text));
		if (is_array($tags) && count($tags) > 0) {
			foreach ($tags as $tag) {
				$open  = '<'.esc_attr($tag);
				$close = '</'.esc_attr($tag).'>';
				if (fire_department_substr($text, 0, fire_department_strlen($open))==$open) {
					$pos = fire_department_strpos($text, '>');
					if ($pos!==false) $text = fire_department_substr($text, $pos+1);
				}
				if (fire_department_substr($text, -fire_department_strlen($close))==$close) $text = fire_department_substr($text, 0, fire_department_strlen($text) - fire_department_strlen($close));
				$text = trim(chop($text));
			}
		}
		return $text;
	}
}

// Return slug for the any title string
if (!function_exists('fire_department_get_slug')) {
	function fire_department_get_slug($title) {
		return fire_department_strtolower(str_replace(array('\\','/','-',' ','.'), '_', $title));
	}
}

// Replace macros in the string
if (!function_exists('fire_department_strmacros')) {
	function fire_department_strmacros($str) {
		return str_replace(array("{{", "}}", "((", "))", "||"), array("<i>", "</i>", "<b>", "</b>", "<br>"), $str);
	}
}

// Unserialize string (try replace \n with \r\n)
if (!function_exists('fire_department_unserialize')) {
	function fire_department_unserialize($str) {
		if ( is_serialized($str) ) {
			try {
				$data = unserialize($str);
			} catch (Exception $e) {
				dcl($e->getMessage());
				$data = false;
			}
			if ($data===false) {
				try {
					$data = @unserialize(str_replace("\n", "\r\n", $str));
				} catch (Exception $e) {
					dcl($e->getMessage());
					$data = false;
				}
			}
			return $data;
		} else
			return $str;
	}
}
?>