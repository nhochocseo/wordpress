<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_br_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_br_theme_setup' );
	function fire_department_sc_br_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_br_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_br clear="left|right|both"]
*/

if (!function_exists('fire_department_sc_br')) {	
	function fire_department_sc_br($atts, $content = null) {
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			"clear" => ""
		), $atts)));
		$output = in_array($clear, array('left', 'right', 'both', 'all')) 
			? '<div class="clearfix" style="clear:' . str_replace('all', 'both', $clear) . '"></div>'
			: '<br />';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_br', $atts, $content);
	}
	fire_department_require_shortcode("trx_br", "fire_department_sc_br");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_br_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_br_reg_shortcodes');
	function fire_department_sc_br_reg_shortcodes() {
	
		fire_department_sc_map("trx_br", array(
			"title" => esc_html__("Break", 'fire-department'),
			"desc" => wp_kses_data( __("Line break with clear floating (if need)", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"clear" => 	array(
					"title" => esc_html__("Clear floating", 'fire-department'),
					"desc" => wp_kses_data( __("Clear floating (if need)", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"options" => array(
						'none' => esc_html__('None', 'fire-department'),
						'left' => esc_html__('Left', 'fire-department'),
						'right' => esc_html__('Right', 'fire-department'),
						'both' => esc_html__('Both', 'fire-department')
					)
				)
			)
		));
	}
}
?>