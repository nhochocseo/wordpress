<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_anchor_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_anchor_theme_setup' );
	function fire_department_sc_anchor_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_anchor_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_anchor_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_anchor id="unique_id" description="Anchor description" title="Short Caption" icon="icon-class"]
*/

if (!function_exists('fire_department_sc_anchor')) {	
	function fire_department_sc_anchor($atts, $content = null) {
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"description" => '',
			"icon" => '',
			"url" => "",
			"separator" => "no",
			// Common params
			"id" => ""
		), $atts)));
		$output = $id 
			? '<a id="'.esc_attr($id).'"'
				. ' class="sc_anchor"' 
				. ' title="' . ($title ? esc_attr($title) : '') . '"'
				. ' data-description="' . ($description ? esc_attr(fire_department_strmacros($description)) : ''). '"'
				. ' data-icon="' . ($icon ? $icon : '') . '"' 
				. ' data-url="' . ($url ? esc_attr($url) : '') . '"' 
				. ' data-separator="' . (fire_department_param_is_on($separator) ? 'yes' : 'no') . '"'
				. '></a>'
			: '';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_anchor', $atts, $content);
	}
	fire_department_require_shortcode("trx_anchor", "fire_department_sc_anchor");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_anchor_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_anchor_reg_shortcodes');
	function fire_department_sc_anchor_reg_shortcodes() {
	
		fire_department_sc_map("trx_anchor", array(
			"title" => esc_html__("Anchor", 'fire-department'),
			"desc" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"icon" => array(
					"title" => esc_html__("Anchor's icon",  'fire-department'),
					"desc" => wp_kses_data( __('Select icon for the anchor from Fontello icons set',  'fire-department') ),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"title" => array(
					"title" => esc_html__("Short title", 'fire-department'),
					"desc" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"description" => array(
					"title" => esc_html__("Long description", 'fire-department'),
					"desc" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"url" => array(
					"title" => esc_html__("External URL", 'fire-department'),
					"desc" => wp_kses_data( __("External URL for this TOC item", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"separator" => array(
					"title" => esc_html__("Add separator", 'fire-department'),
					"desc" => wp_kses_data( __("Add separator under item in the TOC", 'fire-department') ),
					"value" => "no",
					"type" => "switch",
					"options" => fire_department_get_sc_param('yes_no')
				),
				"id" => fire_department_get_sc_param('id')
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_anchor_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_anchor_reg_shortcodes_vc');
	function fire_department_sc_anchor_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_anchor",
			"name" => esc_html__("Anchor", 'fire-department'),
			"description" => wp_kses_data( __("Insert anchor for the TOC (table of content)", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_anchor',
			"class" => "trx_sc_single trx_sc_anchor",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Anchor's icon", 'fire-department'),
					"description" => wp_kses_data( __("Select icon for the anchor from Fontello icons set", 'fire-department') ),
					"class" => "",
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Short title", 'fire-department'),
					"description" => wp_kses_data( __("Short title of the anchor (for the table of content)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Long description", 'fire-department'),
					"description" => wp_kses_data( __("Description for the popup (then hover on the icon). You can use:<br>'{{' and '}}' - to make the text italic,<br>'((' and '))' - to make the text bold,<br>'||' - to insert line break", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("External URL", 'fire-department'),
					"description" => wp_kses_data( __("External URL for this TOC item", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "separator",
					"heading" => esc_html__("Add separator", 'fire-department'),
					"description" => wp_kses_data( __("Add separator under item in the TOC", 'fire-department') ),
					"class" => "",
					"value" => array("Add separator" => "yes" ),
					"type" => "checkbox"
				),
				fire_department_get_vc_param('id')
			),
		) );
		
		class WPBakeryShortCode_Trx_Anchor extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>