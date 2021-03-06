<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_accordion_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_accordion_theme_setup' );
	function fire_department_sc_accordion_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_accordion_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_accordion_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_accordion counter="off" initial="1"]
	[trx_accordion_item title="Accordion Title 1"]Lorem ipsum dolor sit amet, consectetur adipisicing elit[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 2"]Proin dignissim commodo magna at luctus. Nam molestie justo augue, nec eleifend urna laoreet non.[/trx_accordion_item]
	[trx_accordion_item title="Accordion Title 3 with custom icons" icon_closed="icon-check" icon_opened="icon-delete"]Curabitur tristique tempus arcu a placerat.[/trx_accordion_item]
[/trx_accordion]
*/
if (!function_exists('fire_department_sc_accordion')) {	
	function fire_department_sc_accordion($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"picture" => "",
			"initial" => "1",
			"counter" => "off",
			"icon_closed" => "icon-plus",
			"icon_opened" => "icon-minus",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$initial = max(0, (int) $initial);
		fire_department_storage_set('sc_accordion_data', array(
			'counter' => 0,
            'show_counter' => fire_department_param_is_on($counter),
            'icon_closed' => empty($icon_closed) || fire_department_param_is_inherit($icon_closed) ? "icon-plus" : $icon_closed,
            'icon_opened' => empty($icon_opened) || fire_department_param_is_inherit($icon_opened) ? "icon-minus" : $icon_opened
            )
        );
		fire_department_enqueue_script('jquery-ui-accordion', false, array('jquery','jquery-ui-core'), null, true);
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion'
					. (!empty($class) ? ' '.esc_attr($class) : '')
					. (fire_department_param_is_on($counter) ? ' sc_show_counter' : '') 
				. '"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. ' data-active="' . ($initial-1) . '"'
				. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
				. '>'
				. do_shortcode($content)
				. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_accordion', $atts, $content);
	}
	fire_department_require_shortcode('trx_accordion', 'fire_department_sc_accordion');
}


if (!function_exists('fire_department_sc_accordion_item')) {	
	function fire_department_sc_accordion_item($atts, $content=null) {
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts( array(
			// Individual params
			"picture" => "",
			"icon_closed" => "",
			"icon_opened" => "",
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
        fire_department_storage_inc_array('sc_accordion_data', 'counter');
        if (empty($icon_closed) || fire_department_param_is_inherit($icon_closed)) $icon_closed = fire_department_storage_get_array('sc_accordion_data', 'icon_closed', '', "icon-plus");
        if (empty($icon_opened) || fire_department_param_is_inherit($icon_opened)) $icon_opened = fire_department_storage_get_array('sc_accordion_data', 'icon_opened', '', "icon-minus");
		
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic =  '<span class="sc_title_icon sc_tab_title_icon  "'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="ffff" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(fire_department_strpos($image, 'http:')!==false ? $image : fire_department_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';

		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_accordion_item' 
				. (!empty($class) ? ' '.esc_attr($class) : '')
				. (fire_department_storage_get_array('sc_accordion_data', 'counter') % 2 == 1 ? ' odd' : ' even')
				. (fire_department_storage_get_array('sc_accordion_data', 'counter') == 1 ? ' first' : '')
				. '">'
				. '<h5 class="sc_accordion_title">'
				. ($pic)
				. (!fire_department_param_is_off($icon_closed) ? '<span class="sc_accordion_icon sc_accordion_icon_closed '.esc_attr($icon_closed).'"></span>' : '')
				. (!fire_department_param_is_off($icon_opened) ? '<span class="sc_accordion_icon sc_accordion_icon_opened '.esc_attr($icon_opened).'"></span>' : '')
				. (fire_department_storage_get_array('sc_accordion_data', 'show_counter') ? '<span class="sc_items_counter">'.(fire_department_storage_get_array('sc_accordion_data', 'counter')).'</span>' : '')
				. ($title)
				. '</h5>'
				. '<div class="sc_accordion_content"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
					. do_shortcode($content) 
				. '</div>'
				. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_accordion_item', $atts, $content);
	}
	fire_department_require_shortcode('trx_accordion_item', 'fire_department_sc_accordion_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_accordion_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_accordion_reg_shortcodes');
	function fire_department_sc_accordion_reg_shortcodes() {
	
		fire_department_sc_map("trx_accordion", array(
			"title" => esc_html__("Accordion", 'fire-department'),
			"desc" => wp_kses_data( __("Accordion items", 'fire-department') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"counter" => array(
					"title" => esc_html__("Counter", 'fire-department'),
					"desc" => wp_kses_data( __("Display counter before each accordion title", 'fire-department') ),
					"value" => "off",
					"type" => "switch",
					"options" => fire_department_get_sc_param('on_off')
				),
				"initial" => array(
					"title" => esc_html__("Initially opened item", 'fire-department'),
					"desc" => wp_kses_data( __("Number of initially opened item", 'fire-department') ),
					"value" => 1,
					"min" => 0,
					"type" => "spinner"
				),
				"icon_closed" => array(
					"title" => esc_html__("Icon while closed",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the closed accordion item from Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"icon_opened" => array(
					"title" => esc_html__("Icon while opened",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the opened accordion item from Fontello icons set',  'fire-department') ),
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
				"name" => "trx_accordion_item",
				"title" => esc_html__("Item", 'fire-department'),
				"desc" => wp_kses_data( __("Accordion item", 'fire-department') ),
				"container" => true,
				"params" => array(
					"title" => array(
						"title" => esc_html__("Accordion item title", 'fire-department'),
						"desc" => wp_kses_data( __("Title for current accordion item", 'fire-department') ),
						"value" => "",
						"type" => "text"
					),
					"icon_closed" => array(
						"title" => esc_html__("Icon while closed",  'fire-department'),
						"desc" => wp_kses_data( __('Select icon for the closed accordion item from Fontello icons set',  'fire-department') ),
						"value" => "",
						"type" => "icons",
						"options" => fire_department_get_sc_param('icons')
					),
					"icon_opened" => array(
						"title" => esc_html__("Icon while opened",  'fire-department'),
						"desc" => wp_kses_data( __('Select icon for the opened accordion item from Fontello icons set',  'fire-department') ),
						"value" => "",
						"type" => "icons",
                      "options" => fire_department_get_sc_param('icons')
					),
					"picture" => array(
						"title" => __('or URL for image file', 'fire-department'),
						"desc" => __("Select or upload image or write URL from other site (if style=iconed)", 'fire-department'),
						"dependency" => array(
							'style' => array('iconed')
						),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					),
					"_content_" => array(
						"title" => esc_html__("Accordion item content", 'fire-department'),
						"desc" => wp_kses_data( __("Current accordion item content", 'fire-department') ),
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
if ( !function_exists( 'fire_department_sc_accordion_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_accordion_reg_shortcodes_vc');
	function fire_department_sc_accordion_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_accordion",
			"name" => esc_html__("Accordion", 'fire-department'),
			"description" => wp_kses_data( __("Accordion items", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_accordion',
			"class" => "trx_sc_collection trx_sc_accordion",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"as_parent" => array('only' => 'trx_accordion_item'),	// Use only|except attributes to limit child shortcodes (separate multiple values with comma)
			"params" => array(
				array(
					"param_name" => "counter",
					"heading" => esc_html__("Counter", 'fire-department'),
					"description" => wp_kses_data( __("Display counter before each accordion title", 'fire-department') ),
					"class" => "",
					"value" => array("Add item numbers before each element" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "initial",
					"heading" => esc_html__("Initially opened item", 'fire-department'),
					"description" => wp_kses_data( __("Number of initially opened item", 'fire-department') ),
					"class" => "",
					"value" => 1,
					"type" => "textfield"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the closed accordion item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the opened accordion item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('animation'),
				fire_department_get_vc_param('css'),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			),
			'default_content' => '
				[trx_accordion_item title="' . esc_html__( 'Item 1 title', 'fire-department' ) . '"][/trx_accordion_item]
				[trx_accordion_item title="' . esc_html__( 'Item 2 title', 'fire-department' ) . '"][/trx_accordion_item]
			',
			"custom_markup" => '
				<div class="wpb_accordion_holder wpb_holder clearfix vc_container_for_children">
					%content%
				</div>
				<div class="tab_controls">
					<button class="add_tab" title="'.esc_attr__("Add item", 'fire-department').'">'.esc_html__("Add item", 'fire-department').'</button>
				</div>
			',
			'js_view' => 'VcTrxAccordionView'
		) );
		
		
		vc_map( array(
			"base" => "trx_accordion_item",
			"name" => esc_html__("Accordion item", 'fire-department'),
			"description" => wp_kses_data( __("Inner accordion item", 'fire-department') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => true,
			'icon' => 'icon_trx_accordion_item',
			"as_child" => array('only' => 'trx_accordion'), 	// Use only|except attributes to limit parent (separate multiple values with comma)
			"as_parent" => array('except' => 'trx_accordion'),
			"params" => array(
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Title for current accordion item", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "picture",
					"heading" => __("or select uploaded image", 'fire-department'),
					"description" => __("Select or upload image or write URL from other site (if style=iconed)", 'fire-department'),
					"group" => __('Icon &amp; Image', 'fire-department'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "icon_closed",
					"heading" => esc_html__("Icon while closed", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the closed accordion item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "icon_opened",
					"heading" => esc_html__("Icon while opened", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the opened accordion item from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('css')
			),
		  'js_view' => 'VcTrxAccordionTabView'
		) );

		class WPBakeryShortCode_Trx_Accordion extends FIRE_DEPARTMENT_VC_ShortCodeAccordion {}
		class WPBakeryShortCode_Trx_Accordion_Item extends FIRE_DEPARTMENT_VC_ShortCodeAccordionItem {}
	}
}
?>