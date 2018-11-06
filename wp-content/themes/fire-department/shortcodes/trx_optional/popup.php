<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_popup_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_popup_theme_setup' );
	function fire_department_sc_popup_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_popup_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_popup_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_popup id="unique_id" class="class_name" style="css_styles"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_popup]
*/

if (!function_exists('fire_department_sc_popup')) {	
	function fire_department_sc_popup($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		fire_department_enqueue_popup('magnific');
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_popup mfp-with-anim mfp-hide' . ($class ? ' '.esc_attr($class) : '') . '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_popup', $atts, $content);
	}
	fire_department_require_shortcode('trx_popup', 'fire_department_sc_popup');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_popup_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_popup_reg_shortcodes');
	function fire_department_sc_popup_reg_shortcodes() {
	
		fire_department_sc_map("trx_popup", array(
			"title" => esc_html__("Popup window", 'fire-department'),
			"desc" => wp_kses_data( __("Container for any html-block with desired class and style for popup window", 'fire-department') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Container content", 'fire-department'),
					"desc" => wp_kses_data( __("Content for section container", 'fire-department') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"top" => fire_department_get_sc_param('top'),
				"bottom" => fire_department_get_sc_param('bottom'),
				"left" => fire_department_get_sc_param('left'),
				"right" => fire_department_get_sc_param('right'),
				"id" => fire_department_get_sc_param('id'),
				"class" => fire_department_get_sc_param('class'),
				"css" => fire_department_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_popup_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_popup_reg_shortcodes_vc');
	function fire_department_sc_popup_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_popup",
			"name" => esc_html__("Popup window", 'fire-department'),
			"description" => wp_kses_data( __("Container for any html-block with desired class and style for popup window", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_popup',
			"class" => "trx_sc_collection trx_sc_popup",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"params" => array(
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('css'),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Popup extends FIRE_DEPARTMENT_VC_ShortCodeCollection {}
	}
}
?>