<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_hide_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_hide_theme_setup' );
	function fire_department_sc_hide_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_hide_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_hide selector="unique_id"]
*/

if (!function_exists('fire_department_sc_hide')) {	
	function fire_department_sc_hide($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"selector" => "",
			"hide" => "on",
			"delay" => 0
		), $atts)));
		$selector = trim(chop($selector));
		if (!empty($selector)) {
			fire_department_storage_concat('js_code', '
				'.($delay>0 ? 'setTimeout(function() {' : '').'
					jQuery("'.esc_attr($selector).'").' . ($hide=='on' ? 'hide' : 'show') . '();
				'.($delay>0 ? '},'.($delay).');' : '').'
			');
		}
		return apply_filters('fire_department_shortcode_output', $output, 'trx_hide', $atts, $content);
	}
	fire_department_require_shortcode('trx_hide', 'fire_department_sc_hide');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_hide_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_hide_reg_shortcodes');
	function fire_department_sc_hide_reg_shortcodes() {
	
		fire_department_sc_map("trx_hide", array(
			"title" => esc_html__("Hide/Show any block", 'fire-department'),
			"desc" => wp_kses_data( __("Hide or Show any block with desired CSS-selector", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"selector" => array(
					"title" => esc_html__("Selector", 'fire-department'),
					"desc" => wp_kses_data( __("Any block's CSS-selector", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"hide" => array(
					"title" => esc_html__("Hide or Show", 'fire-department'),
					"desc" => wp_kses_data( __("New state for the block: hide or show", 'fire-department') ),
					"value" => "yes",
					"size" => "small",
					"options" => fire_department_get_sc_param('yes_no'),
					"type" => "switch"
				)
			)
		));
	}
}
?>