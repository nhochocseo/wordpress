<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_search_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_search_theme_setup' );
	function fire_department_sc_search_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_search_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_search_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_search id="unique_id" open="yes|no"]
*/

if (!function_exists('fire_department_sc_search')) {	
	function fire_department_sc_search($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"style" => "",
			"state" => "",
			"ajax" => "",
			"title" => esc_html__('Search', 'fire-department'),
			"scheme" => "original",
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
		if ($style == 'fullscreen') {
			if (empty($ajax)) $ajax = "no";
			if (empty($state)) $state = "closed";
		} else if ($style == 'expand') {
			if (empty($ajax)) $ajax = fire_department_get_theme_option('use_ajax_search');
			if (empty($state)) $state = "closed";
		} else if ($style == 'slide') {
			if (empty($ajax)) $ajax = fire_department_get_theme_option('use_ajax_search');
			if (empty($state)) $state = "closed";
		} else {
			if (empty($ajax)) $ajax = fire_department_get_theme_option('use_ajax_search');
			if (empty($state)) $state = "fixed";
		}
		// Load core messages
		fire_department_enqueue_messages();
		$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') . ' class="search_wrap search_style_'.esc_attr($style).' search_state_'.esc_attr($state)
						. (fire_department_param_is_on($ajax) ? ' search_ajax' : '')
						. ($class ? ' '.esc_attr($class) : '')
						. '"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
					. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
					. '>
						<div class="search_form_wrap">
							<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
								<button type="submit" class="search_submit icon-search-light" title="' . ($state=='closed' ? esc_attr__('Open search', 'fire-department') : esc_attr__('Start search', 'fire-department')) . '"></button>
								<input type="text" class="search_field" placeholder="' . esc_attr($title) . '" value="' . esc_attr(get_search_query()) . '" name="s" />'
								. ($style == 'fullscreen' ? '<a class="search_close icon-cancel"></a>' : '')
							. '</form>
						</div>'
						. (fire_department_param_is_on($ajax) ? '<div class="search_results widget_area' . ($scheme && !fire_department_param_is_off($scheme) && !fire_department_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') . '"><a class="search_results_close icon-cancel"></a><div class="search_results_content"></div></div>' : '')
					. '</div>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_search', $atts, $content);
	}
	fire_department_require_shortcode('trx_search', 'fire_department_sc_search');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_search_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_search_reg_shortcodes');
	function fire_department_sc_search_reg_shortcodes() {
	
		fire_department_sc_map("trx_search", array(
			"title" => esc_html__("Search", 'fire-department'),
			"desc" => wp_kses_data( __("Show search form", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'fire-department'),
					"desc" => wp_kses_data( __("Select style to display search field", 'fire-department') ),
					"value" => "regular",
					"options" => fire_department_get_list_search_styles(),
					"type" => "checklist"
				),
				"state" => array(
					"title" => esc_html__("State", 'fire-department'),
					"desc" => wp_kses_data( __("Select search field initial state", 'fire-department') ),
					"value" => "fixed",
					"options" => array(
						"fixed"  => esc_html__('Fixed',  'fire-department'),
						"opened" => esc_html__('Opened', 'fire-department'),
						"closed" => esc_html__('Closed', 'fire-department')
					),
					"type" => "checklist"
				),
				"title" => array(
					"title" => esc_html__("Title", 'fire-department'),
					"desc" => wp_kses_data( __("Title (placeholder) for the search field", 'fire-department') ),
					"value" => esc_html__("Search &hellip;", 'fire-department'),
					"type" => "text"
				),
				"ajax" => array(
					"title" => esc_html__("AJAX", 'fire-department'),
					"desc" => wp_kses_data( __("Search via AJAX or reload page", 'fire-department') ),
					"value" => "yes",
					"options" => fire_department_get_sc_param('yes_no'),
					"type" => "switch"
				),
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
if ( !function_exists( 'fire_department_sc_search_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_search_reg_shortcodes_vc');
	function fire_department_sc_search_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_search",
			"name" => esc_html__("Search form", 'fire-department'),
			"description" => wp_kses_data( __("Insert search form", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_search',
			"class" => "trx_sc_single trx_sc_search",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style", 'fire-department'),
					"description" => wp_kses_data( __("Select style to display search field", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_list_search_styles(),
					"type" => "dropdown"
				),
				array(
					"param_name" => "state",
					"heading" => esc_html__("State", 'fire-department'),
					"description" => wp_kses_data( __("Select search field initial state", 'fire-department') ),
					"class" => "",
					"value" => array(
						esc_html__('Fixed', 'fire-department')  => "fixed",
						esc_html__('Opened', 'fire-department') => "opened",
						esc_html__('Closed', 'fire-department') => "closed"
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Title (placeholder) for the search field", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => esc_html__("Search &hellip;", 'fire-department'),
					"type" => "textfield"
				),
				array(
					"param_name" => "ajax",
					"heading" => esc_html__("AJAX", 'fire-department'),
					"description" => wp_kses_data( __("Search via AJAX or reload page", 'fire-department') ),
					"class" => "",
					"value" => array(esc_html__('Use AJAX search', 'fire-department') => 'yes'),
					"type" => "checkbox"
				),
				fire_department_get_vc_param('id'),
				fire_department_get_vc_param('class'),
				fire_department_get_vc_param('animation'),
				fire_department_get_vc_param('css'),
				fire_department_get_vc_param('margin_top'),
				fire_department_get_vc_param('margin_bottom'),
				fire_department_get_vc_param('margin_left'),
				fire_department_get_vc_param('margin_right')
			)
		) );
		
		class WPBakeryShortCode_Trx_Search extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>