<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_icon_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_icon_theme_setup' );
	function fire_department_sc_icon_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_icon_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_icon_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_icon id="unique_id" style='round|square' icon='' color="" bg_color="" size="" weight=""]
*/

if (!function_exists('fire_department_sc_icon')) {	
	function fire_department_sc_icon($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"bg_shape" => "",
			"font_size" => "",
			"font_weight" => "",
			"align" => "",
			"link" => "",
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
		$css2 = ($font_weight != '' && !fire_department_is_inherit_option($font_weight) ? 'font-weight:'. esc_attr($font_weight).';' : '')
			. ($font_size != '' ? 'font-size:' . esc_attr(fire_department_prepare_css_value($font_size)) . '; line-height: ' . (!$bg_shape || fire_department_param_is_inherit($bg_shape) ? '1' : '1.2') . 'em;' : '')
			. ($color != '' ? 'color:'.esc_attr($color).';' : '')
			. ($bg_color != '' ? 'background-color:'.esc_attr($bg_color).';border-color:'.esc_attr($bg_color).';' : '')
		;
		$output = $icon!='' 
			? ($link ? '<a href="'.esc_url($link).'"' : '<span') . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_icon '.esc_attr($icon)
					. ($bg_shape && !fire_department_param_is_inherit($bg_shape) ? ' sc_icon_shape_'.esc_attr($bg_shape) : '')
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
				.'"'
				.($css || $css2 ? ' style="'.($class ? 'display:block;' : '') . ($css) . ($css2) . '"' : '')
				.'>'
				.($link ? '</a>' : '</span>')
			: '';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_icon', $atts, $content);
	}
	fire_department_require_shortcode('trx_icon', 'fire_department_sc_icon');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_icon_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_icon_reg_shortcodes');
	function fire_department_sc_icon_reg_shortcodes() {
	
		fire_department_sc_map("trx_icon", array(
			"title" => esc_html__("Icon", 'fire-department'),
			"desc" => wp_kses_data( __("Insert icon", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__('Icon',  'fire-department'),
					"desc" => wp_kses_data( __('Select font icon from the Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Icon's color", 'fire-department'),
					"desc" => wp_kses_data( __("Icon's color", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "color"
				),
				"bg_shape" => array(
					"title" => esc_html__("Background shape", 'fire-department'),
					"desc" => wp_kses_data( __("Shape of the icon background", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "none",
					"type" => "radio",
					"options" => array(
						'none' => esc_html__('None', 'fire-department'),
						'round' => esc_html__('Round', 'fire-department'),
						'square' => esc_html__('Square', 'fire-department')
					)
				),
				"bg_color" => array(
					"title" => esc_html__("Icon's background color", 'fire-department'),
					"desc" => wp_kses_data( __("Icon's background color", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty'),
						'background' => array('round','square')
					),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'fire-department'),
					"desc" => wp_kses_data( __("Icon's font size", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "spinner",
					"min" => 8,
					"max" => 240
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'fire-department'),
					"desc" => wp_kses_data( __("Icon font weight", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'100' => esc_html__('Thin (100)', 'fire-department'),
						'300' => esc_html__('Light (300)', 'fire-department'),
						'400' => esc_html__('Normal (400)', 'fire-department'),
						'700' => esc_html__('Bold (700)', 'fire-department')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'fire-department'),
					"desc" => wp_kses_data( __("Icon text alignment", 'fire-department') ),
					"dependency" => array(
						'icon' => array('not_empty')
					),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'fire-department'),
					"desc" => wp_kses_data( __("Link URL from this icon (if not empty)", 'fire-department') ),
					"value" => "",
					"type" => "text"
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
if ( !function_exists( 'fire_department_sc_icon_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_icon_reg_shortcodes_vc');
	function fire_department_sc_icon_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_icon",
			"name" => esc_html__("Icon", 'fire-department'),
			"description" => wp_kses_data( __("Insert the icon", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_icon',
			"class" => "trx_sc_single trx_sc_icon",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'fire-department'),
					"description" => wp_kses_data( __("Select icon class from Fontello icons set", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'fire-department'),
					"description" => wp_kses_data( __("Icon's color", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'fire-department'),
					"description" => wp_kses_data( __("Background color for the icon", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_shape",
					"heading" => esc_html__("Background shape", 'fire-department'),
					"description" => wp_kses_data( __("Shape of the icon background", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('None', 'fire-department') => 'none',
						esc_html__('Round', 'fire-department') => 'round',
						esc_html__('Square', 'fire-department') => 'square'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'fire-department'),
					"description" => wp_kses_data( __("Icon's font size", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'fire-department'),
					"description" => wp_kses_data( __("Icon's font weight", 'fire-department') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'fire-department') => 'inherit',
						esc_html__('Thin (100)', 'fire-department') => '100',
						esc_html__('Light (300)', 'fire-department') => '300',
						esc_html__('Normal (400)', 'fire-department') => '400',
						esc_html__('Bold (700)', 'fire-department') => '700'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Icon's alignment", 'fire-department'),
					"description" => wp_kses_data( __("Align icon to left, center or right", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'fire-department'),
					"description" => wp_kses_data( __("Link URL from this icon (if not empty)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('css'),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			),
		) );
		
		class WPBakeryShortCode_Trx_Icon extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>