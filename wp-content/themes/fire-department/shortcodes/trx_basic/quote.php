<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_quote_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_quote_theme_setup' );
	function fire_department_sc_quote_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_quote_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_quote_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_quote id="unique_id" cite="url" title=""]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/quote]
*/

if (!function_exists('fire_department_sc_quote')) {	
	function fire_department_sc_quote($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"position" => "",
			"style" =>"",
			"cite" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= fire_department_get_css_dimensions_from_values($width);
		$cite_param = $cite != '' ? ' cite="'.esc_attr($cite).'"' : '';
		$title = $title=='' ? $cite : $title;
		$content = do_shortcode($content);
		if (fire_department_substr($content, 0, 2)!='<p') $content = '<p>' . ($content) . '</p>';
		$output = '<blockquote' 
			. ($id ? ' id="'.esc_attr($id).'"' : '') . ($cite_param) 
			. ' class="sc_quote'. (!empty($class) ? ' '.esc_attr($class) : '') . (!empty($style) ? ' '.esc_attr($style) : '').'"'
			. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
				. ($content)
				. ($title == '' ? '' : ('<p class="sc_quote_title">' . ($cite!='' ? '<a href="'.esc_url($cite).'">' : '') . ($title) . ($cite!='' ? '</a>' : '') . '</p>'))
				. ($position == '' ? '' : ('<p class="position">' . ($cite!='' ? '<a href="'.esc_url($cite).'">' : '') . ($position) . ($cite!='' ? '</a>' : '') . '</p>'))
			.'</blockquote>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_quote', $atts, $content);
	}
	fire_department_require_shortcode('trx_quote', 'fire_department_sc_quote');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_quote_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_quote_reg_shortcodes');
	function fire_department_sc_quote_reg_shortcodes() {
	
		fire_department_sc_map("trx_quote", array(
			"title" => esc_html__("Quote", 'fire-department'),
			"desc" => wp_kses_data( __("Quote text", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"cite" => array(
					"title" => esc_html__("Quote cite", 'fire-department'),
					"desc" => wp_kses_data( __("URL for quote cite", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"style" => array(
					"title" => esc_html__("Style", 'fire-department'),
					"desc" => wp_kses_data( __("Choose style for quote", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"options" => array(
						'style_1' => esc_html__('Style 1', 'fire-department'),
						'style_2' => esc_html__('Style 2', 'fire-department'),
						'style_3' => esc_html__('Style 3', 'fire-department')
					)
				),
				"title" => array(
					"title" => esc_html__("Title (author)", 'fire-department'),
					"desc" => wp_kses_data( __("Quote title (author name)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Quote content", 'fire-department'),
					"desc" => wp_kses_data( __("Quote content", 'fire-department') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"width" => fire_department_shortcodes_width(),
				"top" => fire_department_get_sc_param('top'),
				"bottom" => fire_department_get_sc_param('bottom'),
				"left" => fire_department_get_sc_param('left'),
				"right" => fire_department_get_sc_param('right'),
				"id" => fire_department_get_sc_param('id'),
				"class" => fire_department_get_sc_param('class'),
				"animation" => fire_department_get_sc_param('animation'),
				"css" => fire_department_get_sc_param('css')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_quote_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_quote_reg_shortcodes_vc');
	function fire_department_sc_quote_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_quote",
			"name" => esc_html__("Quote", 'fire-department'),
			"description" => wp_kses_data( __("Quote text", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_quote',
			"class" => "trx_sc_single trx_sc_quote",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "cite",
					"heading" => esc_html__("Quote cite", 'fire-department'),
					"description" => wp_kses_data( __("URL for the quote cite link", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'fire-department'),
					"description" => wp_kses_data( __("Quote style", 'fire-department') ),
					"class" => "",
					"value" => array(
							esc_html__('Style 1', 'fire-department') => 'style_1',
							esc_html__('Style 2', 'fire-department') => 'style_2',
							esc_html__('Style 3', 'fire-department') => 'style_3',
						),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
                    "heading" => esc_html__("Title (author)", 'fire-department'),
                    "description" => wp_kses_data( __("Quote title (author name)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Position (author)", 'fire-department'),
					"description" => wp_kses_data( __("Position title  (author position)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Quote content", 'fire-department'),
					"description" => wp_kses_data( __("Quote content", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('animation'),
				fire_department_get_vc_param('css'),
				fire_department_vc_width(),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Quote extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>