<?php

// Check if shortcodes settings are now used
if ( !function_exists( 'fire_department_shortcodes_is_used' ) ) {
	function fire_department_shortcodes_is_used() {
		return fire_department_options_is_used() 															// All modes when Theme Options are used
			|| (is_admin() && isset($_POST['action']) 
					&& in_array($_POST['action'], array('vc_edit_form', 'wpb_show_edit_form')))		// AJAX query when save post/page
			|| (is_admin() && !empty($_REQUEST['page']) && $_REQUEST['page']=='vc-roles')			// VC Role Manager
			|| (function_exists('fire_department_vc_is_frontend') && fire_department_vc_is_frontend());			// VC Frontend editor mode
	}
}

// Width and height params
if ( !function_exists( 'fire_department_shortcodes_width' ) ) {
	function fire_department_shortcodes_width($w="") {
		return array(
			"title" => esc_html__("Width", 'fire-department'),
			"divider" => true,
			"value" => $w,
			"type" => "text"
		);
	}
}
if ( !function_exists( 'fire_department_shortcodes_height' ) ) {
	function fire_department_shortcodes_height($h='') {
		return array(
			"title" => esc_html__("Height", 'fire-department'),
			"desc" => wp_kses_data( __("Width and height of the element", 'fire-department') ),
			"value" => $h,
			"type" => "text"
		);
	}
}

// Return sc_param value
if ( !function_exists( 'fire_department_get_sc_param' ) ) {
	function fire_department_get_sc_param($prm) {
		return fire_department_storage_get_array('sc_params', $prm);
	}
}

// Set sc_param value
if ( !function_exists( 'fire_department_set_sc_param' ) ) {
	function fire_department_set_sc_param($prm, $val) {
		fire_department_storage_set_array('sc_params', $prm, $val);
	}
}

// Add sc settings in the sc list
if ( !function_exists( 'fire_department_sc_map' ) ) {
	function fire_department_sc_map($sc_name, $sc_settings) {
		fire_department_storage_set_array('shortcodes', $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list after the key
if ( !function_exists( 'fire_department_sc_map_after' ) ) {
	function fire_department_sc_map_after($after, $sc_name, $sc_settings='') {
		fire_department_storage_set_array_after('shortcodes', $after, $sc_name, $sc_settings);
	}
}

// Add sc settings in the sc list before the key
if ( !function_exists( 'fire_department_sc_map_before' ) ) {
	function fire_department_sc_map_before($before, $sc_name, $sc_settings='') {
		fire_department_storage_set_array_before('shortcodes', $before, $sc_name, $sc_settings);
	}
}

// Compare two shortcodes by title
if ( !function_exists( 'fire_department_compare_sc_title' ) ) {
	function fire_department_compare_sc_title($a, $b) {
		return strcmp($a['title'], $b['title']);
	}
}



/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_shortcodes_settings_theme_setup' ) ) {
//	if ( fire_department_vc_is_frontend() )
	if ( (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') || (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline') )
		add_action( 'fire_department_action_before_init_theme', 'fire_department_shortcodes_settings_theme_setup', 20 );
	else
		add_action( 'fire_department_action_after_init_theme', 'fire_department_shortcodes_settings_theme_setup' );
	function fire_department_shortcodes_settings_theme_setup() {
		if (fire_department_shortcodes_is_used()) {

			// Sort templates alphabetically
			$tmp = fire_department_storage_get('registered_templates');
			ksort($tmp);
			fire_department_storage_set('registered_templates', $tmp);

			// Prepare arrays 
			fire_department_storage_set('sc_params', array(
			
				// Current element id
				'id' => array(
					"title" => esc_html__("Element ID", 'fire-department'),
					"desc" => wp_kses_data( __("ID for current element", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
			
				// Current element class
				'class' => array(
					"title" => esc_html__("Element CSS class", 'fire-department'),
					"desc" => wp_kses_data( __("CSS class for current element (optional)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
			
				// Current element style
				'css' => array(
					"title" => esc_html__("CSS styles", 'fire-department'),
					"desc" => wp_kses_data( __("Any additional CSS rules (if need)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
			
			
				// Switcher choises
				'list_styles' => array(
					'ul'	=> esc_html__('Unordered', 'fire-department'),
					'ol'	=> esc_html__('Ordered', 'fire-department'),
					'iconed'=> esc_html__('Iconed', 'fire-department')
				),

				'yes_no'	=> fire_department_get_list_yesno(),
				'on_off'	=> fire_department_get_list_onoff(),
				'dir' 		=> fire_department_get_list_directions(),
				'align'		=> fire_department_get_list_alignments(),
				'float'		=> fire_department_get_list_floats(),
				'hpos'		=> fire_department_get_list_hpos(),
				'show_hide'	=> fire_department_get_list_showhide(),
				'sorting' 	=> fire_department_get_list_sortings(),
				'ordering' 	=> fire_department_get_list_orderings(),
				'shapes'	=> fire_department_get_list_shapes(),
				'sizes'		=> fire_department_get_list_sizes(),
				'sliders'	=> fire_department_get_list_sliders(),
				'controls'	=> fire_department_get_list_controls(),
				'categories'=> fire_department_get_list_categories(),
				'columns'	=> fire_department_get_list_columns(),
				'images'	=> array_merge(array('none'=>"none"), fire_department_get_list_images("images/icons", "png")),
				'icons'		=> array_merge(array("inherit", "none"), fire_department_get_list_icons()),
				'locations'	=> fire_department_get_list_dedicated_locations(),
				'filters'	=> fire_department_get_list_portfolio_filters(),
				'formats'	=> fire_department_get_list_post_formats_filters(),
				'hovers'	=> fire_department_get_list_hovers(true),
				'hovers_dir'=> fire_department_get_list_hovers_directions(true),
				'schemes'	=> fire_department_get_list_color_schemes(true),
				'animations'		=> fire_department_get_list_animations_in(),
				'margins' 			=> fire_department_get_list_margins(true),
				'blogger_styles'	=> fire_department_get_list_templates_blogger(),
				'forms'				=> fire_department_get_list_templates_forms(),
				'posts_types'		=> fire_department_get_list_posts_types(),
				'googlemap_styles'	=> fire_department_get_list_googlemap_styles(),
				'field_types'		=> fire_department_get_list_field_types(),
				'label_positions'	=> fire_department_get_list_label_positions()
				)
			);

			// Common params
			fire_department_set_sc_param('animation', array(
				"title" => esc_html__("Animation",  'fire-department'),
				"desc" => wp_kses_data( __('Select animation while object enter in the visible area of page',  'fire-department') ),
				"value" => "none",
				"type" => "select",
				"options" => fire_department_get_sc_param('animations')
				)
			);
			fire_department_set_sc_param('top', array(
				"title" => esc_html__("Top margin",  'fire-department'),
				"divider" => true,
				"value" => "inherit",
				"type" => "select",
				"options" => fire_department_get_sc_param('margins')
				)
			);
			fire_department_set_sc_param('bottom', array(
				"title" => esc_html__("Bottom margin",  'fire-department'),
				"value" => "inherit",
				"type" => "select",
				"options" => fire_department_get_sc_param('margins')
				)
			);
			fire_department_set_sc_param('left', array(
				"title" => esc_html__("Left margin",  'fire-department'),
				"value" => "inherit",
				"type" => "select",
				"options" => fire_department_get_sc_param('margins')
				)
			);
			fire_department_set_sc_param('right', array(
				"title" => esc_html__("Right margin",  'fire-department'),
				"desc" => wp_kses_data( __("Margins around this shortcode", 'fire-department') ),
				"value" => "inherit",
				"type" => "select",
				"options" => fire_department_get_sc_param('margins')
				)
			);

			fire_department_storage_set('sc_params', apply_filters('fire_department_filter_shortcodes_params', fire_department_storage_get('sc_params')));

			// Shortcodes list
			//------------------------------------------------------------------
			fire_department_storage_set('shortcodes', array());
			
			// Register shortcodes
			do_action('fire_department_action_shortcodes_list');

			// Sort shortcodes list
			$tmp = fire_department_storage_get('shortcodes');
			uasort($tmp, 'fire_department_compare_sc_title');
			fire_department_storage_set('shortcodes', $tmp);
		}
	}
}
?>