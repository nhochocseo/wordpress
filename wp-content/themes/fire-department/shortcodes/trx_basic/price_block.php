<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_price_block_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_price_block_theme_setup' );
	function fire_department_sc_price_block_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_price_block_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_price_block_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

if (!function_exists('fire_department_sc_price_block')) {	
	function fire_department_sc_price_block($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"style" => 1,
			"title" => "",
			"link" => "",
			"link_text" => "",
			"icon" => "",
			"money" => "",
			"currency" => "$",
			"period" => "",
			"align" => "",
			"scheme" => "",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"height" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$output = '';
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= fire_department_get_css_dimensions_from_values($width, $height);
		if ($money) $money = do_shortcode('[trx_price money="'.esc_attr($money).'" period="'.esc_attr($period).'"'.($currency ? ' currency="'.esc_attr($currency).'"' : '').']');
		$content = do_shortcode(fire_department_sc_clear_around($content));
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_price_block sc_price_block_style_'.max(1, min(3, $style))
						. (!empty($class) ? ' '.esc_attr($class) : '')
						. ($scheme && !fire_department_param_is_off($scheme) && !fire_department_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
					. '>'
				. (!empty($title) ? '<div class="sc_price_block_title">'.($title).'</div>' : '')
				. '<div class="sc_price_block_money">'
					. (!empty($icon) ? '<div class="sc_price_block_icon '.esc_attr($icon).'"></div>' : '')
					. ($money)
				. '</div>'
				. (!empty($content) ? '<div class="sc_price_block_description">'.($content).'</div>' : '')
				. (!empty($link_text) ? '<div class="sc_price_block_link">'.do_shortcode('[trx_button link="'.($link ? esc_url($link) : '#').'"]'.($link_text).'[/trx_button]').'</div>' : '')
			. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_price_block', $atts, $content);
	}
	fire_department_require_shortcode('trx_price_block', 'fire_department_sc_price_block');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_price_block_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_price_block_reg_shortcodes');
	function fire_department_sc_price_block_reg_shortcodes() {
	
		fire_department_sc_map("trx_price_block", array(
			"title" => esc_html__("Price block", 'fire-department'),
			"desc" => wp_kses_data( __("Insert price block with title, price and description", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Block style", 'fire-department'),
					"desc" => wp_kses_data( __("Select style for this price block", 'fire-department') ),
					"value" => 1,
					"options" => fire_department_get_list_styles(1, 3),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", 'fire-department'),
					"desc" => wp_kses_data( __("Block title", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"link" => array(
					"title" => esc_html__("Link URL", 'fire-department'),
					"desc" => wp_kses_data( __("URL for link from button (at bottom of the block)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"link_text" => array(
					"title" => esc_html__("Link text", 'fire-department'),
					"desc" => wp_kses_data( __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"icon" => array(
					"title" => esc_html__("Icon",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon from Fontello icons set (placed before/instead price)',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"money" => array(
					"title" => esc_html__("Money", 'fire-department'),
					"desc" => wp_kses_data( __("Money value (dot or comma separated)", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"currency" => array(
					"title" => esc_html__("Currency", 'fire-department'),
					"desc" => wp_kses_data( __("Currency character", 'fire-department') ),
					"value" => "$",
					"type" => "text"
				),
				"period" => array(
					"title" => esc_html__("Period", 'fire-department'),
					"desc" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'fire-department'),
					"desc" => wp_kses_data( __("Select color scheme for this block", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"options" => fire_department_get_sc_param('schemes')
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'fire-department'),
					"desc" => wp_kses_data( __("Align price to left or right side", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('float')
				), 
				"_content_" => array(
					"title" => esc_html__("Description", 'fire-department'),
					"desc" => wp_kses_data( __("Description for this price block", 'fire-department') ),
					"divider" => true,
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
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
if ( !function_exists( 'fire_department_sc_price_block_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_price_block_reg_shortcodes_vc');
	function fire_department_sc_price_block_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_price_block",
			"name" => esc_html__("Price block", 'fire-department'),
			"description" => wp_kses_data( __("Insert price block with title, price and description", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_price_block',
			"class" => "trx_sc_single trx_sc_price_block",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Block style", 'fire-department'),
					"desc" => wp_kses_data( __("Select style of this price block", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"std" => 1,
					"value" => array_flip(fire_department_get_list_styles(1, 3)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Block title", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Link URL", 'fire-department'),
					"description" => wp_kses_data( __("URL for link from button (at bottom of the block)", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_text",
					"heading" => esc_html__("Link text", 'fire-department'),
					"description" => wp_kses_data( __("Text (caption) for the link button (at bottom of the block). If empty - button not showed", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'fire-department'),
					"description" => wp_kses_data( __("Select icon from Fontello icons set (placed before/instead price)", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "money",
					"heading" => esc_html__("Money", 'fire-department'),
					"description" => wp_kses_data( __("Money value (dot or comma separated)", 'fire-department') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'fire-department'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "currency",
					"heading" => esc_html__("Currency symbol", 'fire-department'),
					"description" => wp_kses_data( __("Currency character", 'fire-department') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'fire-department'),
					"class" => "",
					"value" => "$",
					"type" => "textfield"
				),
				array(
					"param_name" => "period",
					"heading" => esc_html__("Period", 'fire-department'),
					"description" => wp_kses_data( __("Period text (if need). For example: monthly, daily, etc.", 'fire-department') ),
					"admin_label" => true,
					"group" => esc_html__('Money', 'fire-department'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'fire-department'),
					"description" => wp_kses_data( __("Select color scheme for this block", 'fire-department') ),
					"group" => esc_html__('Colors and Images', 'fire-department'),
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('schemes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'fire-department'),
					"description" => wp_kses_data( __("Align price to left or right side", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content",
					"heading" => esc_html__("Description", 'fire-department'),
					"description" => wp_kses_data( __("Description for this price block", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
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
		
		class WPBakeryShortCode_Trx_PriceBlock extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>