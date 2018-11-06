<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_highlight_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_highlight_theme_setup' );
	function fire_department_sc_highlight_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_highlight_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_highlight_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_highlight id="unique_id" color="fore_color's_name_or_#rrggbb" backcolor="back_color's_name_or_#rrggbb" style="custom_style"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_highlight]
*/

if (!function_exists('fire_department_sc_highlight')) {	
	function fire_department_sc_highlight($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"color" => "",
			"bg_color" => "",
			"font_size" => "",
			"type" => "1",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$css .= ($color != '' ? 'color:' . esc_attr($color) . ';' : '')
			.($bg_color != '' ? 'background-color:' . esc_attr($bg_color) . ';' : '')
			.($font_size != '' ? 'font-size:' . esc_attr(fire_department_prepare_css_value($font_size)) . '; line-height: 1em;' : '');
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_highlight'.($type>0 ? ' sc_highlight_style_'.esc_attr($type) : ''). (!empty($class) ? ' '.esc_attr($class) : '').'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. '>' 
				. do_shortcode($content) 
				. '</span>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_highlight', $atts, $content);
	}
	fire_department_require_shortcode('trx_highlight', 'fire_department_sc_highlight');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_highlight_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_highlight_reg_shortcodes');
	function fire_department_sc_highlight_reg_shortcodes() {
	
		fire_department_sc_map("trx_highlight", array(
			"title" => esc_html__("Highlight text", 'fire-department'),
			"desc" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Type", 'fire-department'),
					"desc" => wp_kses_data( __("Highlight type", 'fire-department') ),
					"value" => "1",
					"type" => "checklist",
					"options" => array(
						0 => esc_html__('Custom', 'fire-department'),
						1 => esc_html__('Type 1', 'fire-department'),
						2 => esc_html__('Type 2', 'fire-department'),
						3 => esc_html__('Type 3', 'fire-department')
					)
				),
				"color" => array(
					"title" => esc_html__("Color", 'fire-department'),
					"desc" => wp_kses_data( __("Color for the highlighted text", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'fire-department'),
					"desc" => wp_kses_data( __("Background color for the highlighted text", 'fire-department') ),
					"value" => "",
					"type" => "color"
				),
				"font_size" => array(
					"title" => esc_html__("Font size", 'fire-department'),
					"desc" => wp_kses_data( __("Font size of the highlighted text (default - in pixels, allows any CSS units of measure)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Highlighting content", 'fire-department'),
					"desc" => wp_kses_data( __("Content for highlight", 'fire-department') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"id" => fire_department_get_sc_param('id'),
				"class" => fire_department_get_sc_param('class'),
				"css" => fire_department_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_highlight_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_highlight_reg_shortcodes_vc');
	function fire_department_sc_highlight_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_highlight",
			"name" => esc_html__("Highlight text", 'fire-department'),
			"description" => wp_kses_data( __("Highlight text with selected color, background color and other styles", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_highlight',
			"class" => "trx_sc_single trx_sc_highlight",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Type", 'fire-department'),
					"description" => wp_kses_data( __("Highlight type", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
							esc_html__('Custom', 'fire-department') => 0,
							esc_html__('Type 1', 'fire-department') => 1,
							esc_html__('Type 2', 'fire-department') => 2,
							esc_html__('Type 3', 'fire-department') => 3
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Text color", 'fire-department'),
					"description" => wp_kses_data( __("Color for the highlighted text", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'fire-department'),
					"description" => wp_kses_data( __("Background color for the highlighted text", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'fire-department'),
					"description" => wp_kses_data( __("Font size for the highlighted text (default - in pixels, allows any CSS units of measure)", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Highlight text", 'fire-department'),
					"description" => wp_kses_data( __("Content for highlight", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('css')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Highlight extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>