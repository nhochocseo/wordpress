<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_tooltip_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_tooltip_theme_setup' );
	function fire_department_sc_tooltip_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_tooltip_reg_shortcodes');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_tooltip id="unique_id" title="Tooltip text here"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/tooltip]
*/

if (!function_exists('fire_department_sc_tooltip')) {	
	function fire_department_sc_tooltip($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts)));
		$output = '<span' . ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_tooltip_parent'. (!empty($class) ? ' '.esc_attr($class) : '').'"'
					. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
					. '>'
						. do_shortcode($content)
						. '<span class="sc_tooltip">' . ($title) . '</span>'
					. '</span>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_tooltip', $atts, $content);
	}
	fire_department_require_shortcode('trx_tooltip', 'fire_department_sc_tooltip');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_tooltip_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_tooltip_reg_shortcodes');
	function fire_department_sc_tooltip_reg_shortcodes() {
	
		fire_department_sc_map("trx_tooltip", array(
			"title" => esc_html__("Tooltip", 'fire-department'),
			"desc" => wp_kses_data( __("Create tooltip for selected text", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"title" => array(
					"title" => esc_html__("Title", 'fire-department'),
					"desc" => wp_kses_data( __("Tooltip title (required)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"_content_" => array(
					"title" => esc_html__("Tipped content", 'fire-department'),
					"desc" => wp_kses_data( __("Highlighted content with tooltip", 'fire-department') ),
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
?>