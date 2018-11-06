<?php
/* Visual Composer support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('fire_department_vc_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_vc_theme_setup', 1 );
	function fire_department_vc_theme_setup() {
		if (fire_department_exists_visual_composer()) {
			if (is_admin()) {
				add_filter( 'fire_department_filter_importer_options',				'fire_department_vc_importer_set_options' );
			}
			add_action('fire_department_action_add_styles',		 				'fire_department_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'fire_department_filter_importer_required_plugins',		'fire_department_vc_importer_required_plugins', 10, 2 );
			add_filter( 'fire_department_filter_required_plugins',					'fire_department_vc_required_plugins' );
		}
	}
}

// Check if Visual Composer installed and activated
if ( !function_exists( 'fire_department_exists_visual_composer' ) ) {
	function fire_department_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if Visual Composer in frontend editor mode
if ( !function_exists( 'fire_department_vc_is_frontend' ) ) {
	function fire_department_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fire_department_vc_required_plugins' ) ) {
	//add_filter('fire_department_filter_required_plugins',	'fire_department_vc_required_plugins');
	function fire_department_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', fire_department_storage_get('required_plugins'))) {
			$path = fire_department_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> esc_html__('Visual Composer', 'fire-department'),
					'slug' 		=> 'js_composer',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'fire_department_vc_frontend_scripts' ) ) {
	//add_action( 'fire_department_action_add_styles', 'fire_department_vc_frontend_scripts' );
	function fire_department_vc_frontend_scripts() {
		if (file_exists(fire_department_get_file_dir('css/plugin.visual-composer.css')))
			fire_department_enqueue_style( 'fire_department-plugin.visual-composer-style',  fire_department_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check VC in the required plugins
if ( !function_exists( 'fire_department_vc_importer_required_plugins' ) ) {
	//add_filter( 'fire_department_filter_importer_required_plugins',	'fire_department_vc_importer_required_plugins', 10, 2 );
	function fire_department_vc_importer_required_plugins($not_installed='', $list='') {
		if (!fire_department_exists_visual_composer() )		// && fire_department_strpos($list, 'visual_composer')!==false
			$not_installed .= '<br>' . esc_html__('Visual Composer', 'fire-department');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'fire_department_vc_importer_set_options' ) ) {
	//add_filter( 'fire_department_filter_importer_options',	'fire_department_vc_importer_set_options' );
	function fire_department_vc_importer_set_options($options=array()) {
		if ( in_array('visual_composer', fire_department_storage_get('required_plugins')) && fire_department_exists_visual_composer() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'wpb_js_templates';
		}
		return $options;
	}
}
?>