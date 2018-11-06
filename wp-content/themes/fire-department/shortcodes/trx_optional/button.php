<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_button_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_button_theme_setup' );
	function fire_department_sc_button_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_button_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_button_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_button id="unique_id" type="square|round" fullsize="0|1" style="global|light|dark" size="mini|medium|big|huge|banner" icon="icon-name" link='#' target='']Button caption[/trx_button]
*/

if (!function_exists('fire_department_sc_button')) {	
	function fire_department_sc_button($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "square",
			"style" => "filled",
			"size" => "small",
			"icon" => "",
			"color" => "",
			"bg_color" => "",
			"link" => "",
			"target" => "",
			"align" => "",
			"rel" => "",
			"popup" => "no",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= fire_department_get_css_dimensions_from_values($width, $height)
			. ($color !== '' ? 'color:' . esc_attr($color) .';' : '')
			. ($bg_color !== '' ? 'background-color:' . esc_attr($bg_color) . '; border-color:'. esc_attr($bg_color) .';' : '');
		if (fire_department_param_is_on($popup)) fire_department_enqueue_popup('magnific');
		$output = '<a href="' . (empty($link) ? '#' : $link) . '"'
			. (!empty($target) ? ' target="'.esc_attr($target).'"' : '')
			. (!empty($rel) ? ' rel="'.esc_attr($rel).'"' : '')
			. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
			. ' class="sc_button sc_button_' . esc_attr($type) 
					. ' sc_button_style_' . esc_attr($style) 
					. ' sc_button_size_' . esc_attr($size)
					. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. ($icon!='' ? '  sc_button_iconed '. esc_attr($icon) : '') 
					. (fire_department_param_is_on($popup) ? ' sc_popup_link' : '') 
					. '"'
			. ($id ? ' id="'.esc_attr($id).'"' : '') 
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
			. '>'
			. do_shortcode($content)
			. '</a>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_button', $atts, $content);
	}
	fire_department_require_shortcode('trx_button', 'fire_department_sc_button');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_button_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_button_reg_shortcodes');
	function fire_department_sc_button_reg_shortcodes() {
	
		fire_department_sc_map("trx_button", array(
			"title" => esc_html__("Button", 'fire-department'),
			"desc" => wp_kses_data( __("Button with link", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Caption", 'fire-department'),
					"desc" => wp_kses_data( __("Button caption", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"type" => array(
					"title" => esc_html__("Button's shape", 'fire-department'),
					"desc" => wp_kses_data( __("Select button's shape", 'fire-department') ),
					"value" => "square",
					"size" => "medium",
					"options" => array(
						'square' => esc_html__('Square', 'fire-department'),
						'round' => esc_html__('Round', 'fire-department')
					),
					"type" => "switch"
				), 
				"style" => array(
					"title" => esc_html__("Button's style", 'fire-department'),
					"desc" => wp_kses_data( __("Select button's style", 'fire-department') ),
					"value" => "default",
					"dir" => "horizontal",
					"options" => array(
						'filled' => esc_html__('Filled', 'fire-department'),
						'border' => esc_html__('Border', 'fire-department')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Button's size", 'fire-department'),
					"desc" => wp_kses_data( __("Select button's size", 'fire-department') ),
					"value" => "small",
					"dir" => "horizontal",
					"options" => array(
						'small' => esc_html__('Small', 'fire-department'),
						'medium' => esc_html__('Medium', 'fire-department'),
						'large' => esc_html__('Large', 'fire-department')
					),
					"type" => "checklist"
				), 
				"icon" => array(
					"title" => esc_html__("Button's icon",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the title from Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"color" => array(
					"title" => esc_html__("Button's text color", 'fire-department'),
					"desc" => wp_kses_data( __("Any color for button's caption", 'fire-department') ),
					"std" => "",
					"value" => "",
					"type" => "color"
				),
				"bg_color" => array(
					"title" => esc_html__("Button's backcolor", 'fire-department'),
					"desc" => wp_kses_data( __("Any color for button's background", 'fire-department') ),
					"value" => "",
					"type" => "color"
				),
				"align" => array(
					"title" => esc_html__("Button's alignment", 'fire-department'),
					"desc" => wp_kses_data( __("Align button to left, center or right", 'fire-department') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('align')
				), 
				"link" => array(
					"title" => esc_html__("Link URL", 'fire-department'),
					"desc" => wp_kses_data( __("URL for link on button click", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"target" => array(
					"title" => esc_html__("Link target", 'fire-department'),
					"desc" => wp_kses_data( __("Target for link on button click", 'fire-department') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"popup" => array(
					"title" => esc_html__("Open link in popup", 'fire-department'),
					"desc" => wp_kses_data( __("Open link target in popup window", 'fire-department') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "no",
					"type" => "switch",
					"options" => fire_department_get_sc_param('yes_no')
				), 
				"rel" => array(
					"title" => esc_html__("Rel attribute", 'fire-department'),
					"desc" => wp_kses_data( __("Rel attribute for button's link (if need)", 'fire-department') ),
					"dependency" => array(
						'link' => array('not_empty')
					),
					"value" => "",
					"type" => "text"
				),
				"width" => fire_department_shortcodes_width(),
				"height" => fire_department_shortcodes_height(),
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
if ( !function_exists( 'fire_department_sc_button_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_button_reg_shortcodes_vc');
	function fire_department_sc_button_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_button",
			"name" => esc_html__("Button", 'fire-department'),
			"description" => wp_kses_data( __("Button with link", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_button',
			"class" => "trx_sc_single trx_sc_button",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Caption", 'fire-department'),
					"description" => wp_kses_data( __("Button caption", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Button's shape", 'fire-department'),
					"description" => wp_kses_data( __("Select button's shape", 'fire-department') ),
					"class" => "",
					"value" => array(
						esc_html__('Square', 'fire-department') => 'square',
						esc_html__('Round', 'fire-department') => 'round'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Button's style", 'fire-department'),
					"description" => wp_kses_data( __("Select button's style", 'fire-department') ),
					"class" => "",
					"value" => array(
						esc_html__('Filled', 'fire-department') => 'filled',
						esc_html__('Border', 'fire-department') => 'border'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Button's size", 'fire-department'),
					"description" => wp_kses_data( __("Select button's size", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Small', 'fire-department') => 'small',
						esc_html__('Medium', 'fire-department') => 'medium',
						esc_html__('Large', 'fire-department') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Button's icon", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the title from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Button's text color", 'fire-department'),
					"description" => wp_kses_data( __("Any color for button's caption", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Button's backcolor", 'fire-department'),
					"description" => wp_kses_data( __("Any color for button's background", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Button's alignment", 'fire-department'),
					"description" => wp_kses_data( __("Align button to left, center or right", 'fire-department') ),
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'fire-department'),
					"description" => wp_kses_data( __("URL for the link on button click", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Link', 'fire-department'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "target",
					"heading" => esc_html__("Link target", 'fire-department'),
					"description" => wp_kses_data( __("Target for the link on button click", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Link', 'fire-department'),
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "popup",
					"heading" => esc_html__("Open link in popup", 'fire-department'),
					"description" => wp_kses_data( __("Open link target in popup window", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Link', 'fire-department'),
					"value" => array(esc_html__('Open in popup', 'fire-department') => 'yes'),
					"type" => "checkbox"
				),
				array(
					"param_name" => "rel",
					"heading" => esc_html__("Rel attribute", 'fire-department'),
					"description" => wp_kses_data( __("Rel attribute for the button's link (if need", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Link', 'fire-department'),
					"value" => "",
					"type" => "textfield"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('animation'),
				fire_department_get_vc_param('css'),
				fire_department_vc_width(),
				fire_department_vc_height(),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			),
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Button extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>