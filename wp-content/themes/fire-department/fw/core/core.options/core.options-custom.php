<?php
/**
 * Fire Department Framework: Theme options custom fields
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_options_custom_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_options_custom_theme_setup' );
	function fire_department_options_custom_theme_setup() {

		if ( is_admin() ) {
			add_action("admin_enqueue_scripts",	'fire_department_options_custom_load_scripts');
		}
		
	}
}

// Load required styles and scripts for custom options fields
if ( !function_exists( 'fire_department_options_custom_load_scripts' ) ) {
	//add_action("admin_enqueue_scripts", 'fire_department_options_custom_load_scripts');
	function fire_department_options_custom_load_scripts() {
		fire_department_enqueue_script( 'fire_department-options-custom-script',	fire_department_get_file_url('core/core.options/js/core.options-custom.js'), array(), null, true );	
	}
}


// Show theme specific fields in Post (and Page) options
if ( !function_exists( 'fire_department_show_custom_field' ) ) {
	function fire_department_show_custom_field($id, $field, $value) {
		$output = '';
		switch ($field['type']) {
			case 'reviews':
				$output .= '<div class="reviews_block">' . trim(fire_department_reviews_get_markup($field, $value, true)) . '</div>';
				break;

			case 'mediamanager':
				wp_enqueue_media( );
				$output .= '<a id="'.esc_attr($id).'" class="button mediamanager fire_department_media_selector"
					data-param="' . esc_attr($id) . '"
					data-choose="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'fire-department') : esc_html__( 'Choose Image', 'fire-department')).'"
					data-update="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Add to Gallery', 'fire-department') : esc_html__( 'Choose Image', 'fire-department')).'"
					data-multiple="'.esc_attr(isset($field['multiple']) && $field['multiple'] ? 'true' : 'false').'"
					data-linked-field="'.esc_attr($field['media_field_id']).'"
					>' . (isset($field['multiple']) && $field['multiple'] ? esc_html__( 'Choose Images', 'fire-department') : esc_html__( 'Choose Image', 'fire-department')) . '</a>';
				break;
		}
		return apply_filters('fire_department_filter_show_custom_field', $output, $id, $field, $value);
	}
}
?>