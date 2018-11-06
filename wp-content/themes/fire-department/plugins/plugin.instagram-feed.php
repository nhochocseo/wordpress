<?php
/* Instagram Feed support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('fire_department_instagram_feed_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_instagram_feed_theme_setup', 1 );
	function fire_department_instagram_feed_theme_setup() {
		if (fire_department_exists_instagram_feed()) {
			if (is_admin()) {
				add_filter( 'fire_department_filter_importer_options',				'fire_department_instagram_feed_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'fire_department_filter_importer_required_plugins',		'fire_department_instagram_feed_importer_required_plugins', 10, 2 );
			add_filter( 'fire_department_filter_required_plugins',					'fire_department_instagram_feed_required_plugins' );
		}
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'fire_department_exists_instagram_feed' ) ) {
	function fire_department_exists_instagram_feed() {
		return defined('SBIVER');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fire_department_instagram_feed_required_plugins' ) ) {
	//add_filter('fire_department_filter_required_plugins',	'fire_department_instagram_feed_required_plugins');
	function fire_department_instagram_feed_required_plugins($list=array()) {
		if (in_array('instagram_feed', fire_department_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> esc_html__('Instagram Feed', 'fire-department'),
					'slug' 		=> 'instagram-feed',
					'required' 	=> false
				);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Feed in the required plugins
if ( !function_exists( 'fire_department_instagram_feed_importer_required_plugins' ) ) {
	//add_filter( 'fire_department_filter_importer_required_plugins',	'fire_department_instagram_feed_importer_required_plugins', 10, 2 );
	function fire_department_instagram_feed_importer_required_plugins($not_installed='', $list='') {
		if (fire_department_strpos($list, 'instagram_feed')!==false && !fire_department_exists_instagram_feed() )
			$not_installed .= '<br>' . esc_html__('Instagram Feed', 'fire-department');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'fire_department_instagram_feed_importer_set_options' ) ) {
	//add_filter( 'fire_department_filter_importer_options',	'fire_department_instagram_feed_importer_set_options' );
	function fire_department_instagram_feed_importer_set_options($options=array()) {
		if ( in_array('instagram_feed', fire_department_storage_get('required_plugins')) && fire_department_exists_instagram_feed() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'sb_instagram_settings';
		}
		return $options;
	}
}
?>