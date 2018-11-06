<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_toggles_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_toggles_theme_setup' );
	function fire_department_sc_toggles_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_toggles_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_toggles_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

if (!function_exists('fire_department_sc_toggles')) {	
	function fire_department_sc_toggles($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"counter" => "off",
			"icon_closed" => "icon-plus",
			"icon_opened" => "icon-minus",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		fire_department_storage_set('sc_toggle_data', array(
			'counter' => 0,
            'show_counter' => fire_department_param_is_on($counter),
            'icon_closed' => empty($icon_closed) || fire_department_param_is_inherit($icon_closed) ? "icon-plus" : $icon_closed,
            'icon_opened' => empty($icon_opened) || fire_department_param_is_inherit($icon_opened) ? "icon-minus" : $icon_opened
            )
        );
		fire_department_enqueue_script('jquery-effects-slide', false, array('jquery','jquery-effects-core'), null, true);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_toggles'
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. (fire_department_param_is_on($counter) ? ' sc_show_counter' : '') 
					. '"'
				. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. '>'
				. do_shortcode($content)
				. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_toggles', $atts, $content);
	}
	fire_department_require_shortcode('trx_toggles', 'fire_department_sc_toggles');
}


if (!function_exists('fire_department_sc_toggles_item')) {	
	function fire_department_sc_toggles_item($atts, $content=null) {
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts( array(
			// Individual params
			"title" => "",
			"open" => "",
			"icon_closed" => "",
			"icon_opened" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		fire_department_storage_inc_array('sc_toggle_data', 'counter');
		if (empty($icon_closed) || fire_department_param_is_inherit($icon_closed)) $icon_closed = fire_department_storage_get_array('sc_toggles_data', 'icon_closed', '', "icon-plus");
		if (empty($icon_opened) || fire_department_param_is_inherit($icon_opened)) $icon_opened = fire_department_storage_get_array('sc_toggles_data', 'icon_opened', '', "icon-minus");
		$css .= fire_department_param_is_on($open) ? 'display:block;' : '';
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_toggles_item'.(fire_department_param_is_on($open) ? ' sc_active' : '')
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. (fire_department_storage_get_array('sc_toggle_data', 'counter') % 2 == 1 ? ' odd' : ' even')
					. (fire_department_storage_get_array('sc_toggle_data', 'counter') == 1 ? ' first' : '')
					. '">'
					. '<h5 class="sc_toggles_title'.(fire_department_param_is_on($open) ? ' ui-state-active' : '').'">'
					. (!fire_department_param_is_off($icon_closed) ? '<span class="sc_toggles_icon sc_toggles_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
					. (!fire_department_param_is_off($icon_opened) ? '<span class="sc_toggles_icon sc_toggles_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
					. (fire_department_storage_get_array('sc_toggle_data', 'show_counter') ? '<span class="sc_items_counter">'.(fire_department_storage_get_array('sc_toggle_data', 'counter')).'</span>' : '')
					. ($title) 
					. '</h5>'
					. '<div class="sc_toggles_content"'
						. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
						.'>' 
						. do_shortcode($content) 
					. '</div>'
				. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_toggles_item', $atts, $content);
	}
	fire_department_require_shortcode('trx_toggles_item', 'fire_department_sc_toggles_item');
}


/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_toggles_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_toggles_reg_shortcodes');
	function fire_department_sc_toggles_reg_shortcodes() {
	
		fire_department_sc_map("trx_toggles", array(
			"title" => esc_html__("Toggles", 'fire-department'),
			"desc" => wp_kses_data( __("Toggles items", 'fire-department') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"counter" => array(
					"title" => esc_html__("Counter", 'fire-department'),
					"desc" => wp_kses_data( __("Display counter before each toggles title", 'fire-department') ),
					"value" => "off",
					"type" => "switch",
					"options" => fire_department_get_sc_param('on_off')
				),
				"icon_closed" => array(
					"title" => esc_html__("Icon while closed",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the closed toggles item from Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"icon_opened" => array(
					"title" => esc_html__("Icon while opened",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the opened toggles item from Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"top" => fire_department_get_sc_param('top'),
				"bottom" => fire_department_get_sc_param('bottom'),
				"left" => fire_department_get_sc_param('left'),
				"right" => fire_department_get_sc_param('right'),
				"id" => fire_department_get_sc_param('id'),
				"class" => fire_department_get_sc_param('class'),
				"animation" => fire_department_get_sc_param('animation'),
				"css" => fire_department_get_sc_param('css')
			),
			"children" => array(
				"name" => "trx_toggles_item",
				"title" => esc_html__("Toggles item", 'fire-department'),
				"desc" => wp_kses_data( __("Toggles item", 'fire-department') ),
				"container" => true,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Toggles item title", 'fire-department'),
						"desc" => wp_kses_data( __("Title for current toggles item", 'fire-department') ),
						"value" => "",
						"type" => "text"
					),
					"open" => array(
						"title" => esc_html__("Open on show", 'fire-department'),
						"desc" => wp_kses_data( __("Open current toggles item on show", 'fire-department') ),
						"value" => "no",
						"type" => "switch",
						"options" => fire_department_get_sc_param('yes_no')
					),
					"icon_closed" => array(
						"title" => esc_html__("Icon while closed",  'fire-department'),
						"desc" => wp_kses_data( __('Select icon for the closed toggles item from Fontello icons set',  'fire-department') ),
						"value" => "",
						"type" => "icons",
						"options" => fire_department_get_sc_param('icons')
					),
					"icon_opened" => array(
						"title" => esc_html__("Icon while opened",  'fire-department'),
						"desc" => wp_kses_data( __('Select icon for the opened toggles item from Fontello icons set',  'fire-department') ),
						"value" => "",
						"type" => "icons",
						"options" => fire_department_get_sc_param('icons')
					),
					"_content_" => array(
						"title" => esc_html__("Toggles item content", 'fire-department'),
						"desc" => wp_kses_data( __("Current toggles item content", 'fire-department') ),
						"rows" => 4,
						"value" => "",
						"type" => "textarea"
					),
					"id" => fire_department_get_sc_param('id'),
					"class" => fire_department_get_sc_param('class'),
					"css" => fire_department_get_sc_param('css')
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_toggles_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_toggles_reg_shortcodes_vc');
	function fire_department_sc_toggles_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_toggles",
			"name" => esc_html__("Toggles", 'fire-department'),
			"description" => wp_kses_data( __("Toggles items", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_toggles',
			"class" => "trx_sc_collection trx_sc_toggles",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"as_parent" => array('only' => 'trx_toggles_item'),
			"params" => array(
				array(
					"param_name" => "counter",
					"heading" => esc_html__("Counter", 'fire-department'),
					"description" => wp_kses_data( __("Display counter before each toggles title", 'fire-department') ),
					"class" => "",
					"value" => array("Add item numbers before each element" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the closed toggles item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the opened toggles item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			),
			'default_content' => '
				[trx_toggles_item title="' . esc_html__( 'Item 1 title', 'fire-department' ) . '"][/trx_toggles_item]
				[trx_toggles_item title="' . esc_html__( 'Item 2 title', 'fire-department' ) . '"][/trx_toggles_item]
			',
			"custom_markup" => '
				<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
					%content%
				</div>
				<div class="tab_controls">
					<button class="add_tab" title="'.esc_attr__("Add item", 'fire-department').'">'.esc_html__("Add item", 'fire-department').'</button>
				</div>
			',
			'js_view' => 'VcTrxTogglesView'
		) );
		
		
		vc_map( array(
			"base" => "trx_toggles_item",
			"name" => esc_html__("Toggles item", 'fire-department'),
			"description" => wp_kses_data( __("Single toggles item", 'fire-department') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => true,
			'icon' => 'icon_trx_toggles_item',
			"as_child" => array('only' => 'trx_toggles'),
			"as_parent" => array('except' => 'trx_toggles'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Title for current toggles item", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "open",
					"heading" => esc_html__("Open on show", 'fire-department'),
					"description" => wp_kses_data( __("Open current toggle item on show", 'fire-department') ),
					"class" => "",
					"value" => array("Opened" => "yes" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the closed toggles item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the opened toggles item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('css')
			),
			'js_view' => 'VcTrxTogglesTabView'
		) );
		class WPBakeryShortCode_Trx_Toggles extends FIRE_DEPARTMENT_VC_ShortCodeToggles {}
		class WPBakeryShortCode_Trx_Toggles_Item extends FIRE_DEPARTMENT_VC_ShortCodeTogglesItem {}
	}
}
?>