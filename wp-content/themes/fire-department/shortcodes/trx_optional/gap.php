<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_gap_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_gap_theme_setup' );
	function fire_department_sc_gap_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_gap_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_gap_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

//[trx_gap]Fullwidth content[/trx_gap]

if (!function_exists('fire_department_sc_gap')) {	
	function fire_department_sc_gap($atts, $content = null) {
		if (fire_department_in_shortcode_blogger()) return '';
		$output = fire_department_gap_start() . do_shortcode($content) . fire_department_gap_end();
		return apply_filters('fire_department_shortcode_output', $output, 'trx_gap', $atts, $content);
	}
	fire_department_require_shortcode("trx_gap", "fire_department_sc_gap");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_gap_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_gap_reg_shortcodes');
	function fire_department_sc_gap_reg_shortcodes() {
	
		fire_department_sc_map("trx_gap", array(
			"title" => esc_html__("Gap", 'fire-department'),
			"desc" => wp_kses_data( __("Insert gap (fullwidth area) in the post content. Attention! Use the gap only in the posts (pages) without left or right sidebar", 'fire-department') ),
			"decorate" => true,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Gap content", 'fire-department'),
					"desc" => wp_kses_data( __("Gap inner content", 'fire-department') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_gap_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_gap_reg_shortcodes_vc');
	function fire_department_sc_gap_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_gap",
			"name" => esc_html__("Gap", 'fire-department'),
			"description" => wp_kses_data( __("Insert gap (fullwidth area) in the post content", 'fire-department') ),
			"category" => esc_html__('Structure', 'fire-department'),
			'icon' => 'icon_trx_gap',
			"class" => "trx_sc_collection trx_sc_gap",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => false,
			"params" => array(
			)
		) );
		
		class WPBakeryShortCode_Trx_Gap extends FIRE_DEPARTMENT_VC_ShortCodeCollection {}
	}
}
?>