<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_socials_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_socials_theme_setup' );
	function fire_department_sc_socials_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_socials_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_socials_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_socials id="unique_id" size="small"]
	[trx_social_item name="facebook" url="profile url" icon="path for the icon"]
	[trx_social_item name="twitter" url="profile url"]
[/trx_socials]
*/

if (!function_exists('fire_department_sc_socials')) {	
	function fire_department_sc_socials($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"size" => "small",		// tiny | small | medium | large
			"shape" => "square",	// round | square
			"type" => fire_department_get_theme_setting('socials_type'),	// icons | images
			"socials" => "",
			"custom" => "no",
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
		fire_department_storage_set('sc_social_data', array(
			'icons' => false,
            'type' => $type
            )
        );
		if (!empty($socials)) {
			$allowed = explode('|', $socials);
			$list = array();
			for ($i=0; $i<count($allowed); $i++) {
				$s = explode('=', $allowed[$i]);
				if (!empty($s[1])) {
					$list[] = array(
						'icon'	=> $type=='images' ? fire_department_get_socials_url($s[0]) : 'icon-'.trim($s[0]),
						'url'	=> $s[1]
						);
				}
			}
			if (count($list) > 0) fire_department_storage_set_array('sc_social_data', 'icons', $list);
		} else if (fire_department_param_is_on($custom))
			$content = do_shortcode($content);
		if (fire_department_storage_get_array('sc_social_data', 'icons')===false) fire_department_storage_set_array('sc_social_data', 'icons', fire_department_get_custom_option('social_icons'));
		$output = fire_department_prepare_socials(fire_department_storage_get_array('sc_social_data', 'icons'));
		$output = $output
			? '<div' . ($id ? ' id="'.esc_attr($id).'"' : '') 
				. ' class="sc_socials sc_socials_type_' . esc_attr($type) . ' sc_socials_shape_' . esc_attr($shape) . ' sc_socials_size_' . esc_attr($size) . (!empty($class) ? ' '.esc_attr($class) : '') . '"' 
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '') 
				. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
				. '>' 
				. ($output)
				. '</div>'
			: '';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_socials', $atts, $content);
	}
	fire_department_require_shortcode('trx_socials', 'fire_department_sc_socials');
}


if (!function_exists('fire_department_sc_social_item')) {	
	function fire_department_sc_social_item($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"name" => "",
			"url" => "",
			"icon" => ""
		), $atts)));
		if (empty($icon)) {
			if (!empty($name)) {
				$type = fire_department_storage_get_array('sc_social_data', 'type');
				if ($type=='images') {
					if (file_exists(fire_department_get_socials_dir($name.'.png')))
						$icon = fire_department_get_socials_url($name.'.png');
				} else
					$icon = 'icon-'.esc_attr($name);
			}
		} else if ((int) $icon > 0) {
			$attach = wp_get_attachment_image_src( $icon, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$icon = $attach[0];
		}
		if (!empty($icon) && !empty($url)) {
			if (fire_department_storage_get_array('sc_social_data', 'icons')===false) fire_department_storage_set_array('sc_social_data', 'icons', array());
			fire_department_storage_set_array2('sc_social_data', 'icons', '', array(
				'icon' => $icon,
				'url' => $url
				)
			);
		}
		return '';
	}
	fire_department_require_shortcode('trx_social_item', 'fire_department_sc_social_item');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_socials_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_socials_reg_shortcodes');
	function fire_department_sc_socials_reg_shortcodes() {
	
		fire_department_sc_map("trx_socials", array(
			"title" => esc_html__("Social icons", 'fire-department'),
			"desc" => wp_kses_data( __("List of social icons (with hovers)", 'fire-department') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"type" => array(
					"title" => esc_html__("Icon's type", 'fire-department'),
					"desc" => wp_kses_data( __("Type of the icons - images or font icons", 'fire-department') ),
					"value" => fire_department_get_theme_setting('socials_type'),
					"options" => array(
						'icons' => esc_html__('Icons', 'fire-department'),
						'images' => esc_html__('Images', 'fire-department')
					),
					"type" => "checklist"
				), 
				"size" => array(
					"title" => esc_html__("Icon's size", 'fire-department'),
					"desc" => wp_kses_data( __("Size of the icons", 'fire-department') ),
					"value" => "small",
					"options" => fire_department_get_sc_param('sizes'),
					"type" => "checklist"
				), 
				"shape" => array(
					"title" => esc_html__("Icon's shape", 'fire-department'),
					"desc" => wp_kses_data( __("Shape of the icons", 'fire-department') ),
					"value" => "square",
					"options" => fire_department_get_sc_param('shapes'),
					"type" => "checklist"
				), 
				"socials" => array(
					"title" => esc_html__("Manual socials list", 'fire-department'),
					"desc" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"custom" => array(
					"title" => esc_html__("Custom socials", 'fire-department'),
					"desc" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'fire-department') ),
					"divider" => true,
					"value" => "no",
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
			),
			"children" => array(
				"name" => "trx_social_item",
				"title" => esc_html__("Custom social item", 'fire-department'),
				"desc" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'fire-department') ),
				"decorate" => false,
				"container" => false,
				"params" => array(
					"name" => array(
						"title" => esc_html__("Social name", 'fire-department'),
						"desc" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'fire-department') ),
						"value" => "",
						"type" => "text"
					),
					"url" => array(
						"title" => esc_html__("Your profile URL", 'fire-department'),
						"desc" => wp_kses_data( __("URL of your profile in specified social network", 'fire-department') ),
						"value" => "",
						"type" => "text"
					),
					"icon" => array(
						"title" => esc_html__("URL (source) for icon file", 'fire-department'),
						"desc" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'fire-department') ),
						"readonly" => false,
						"value" => "",
						"type" => "media"
					)
				)
			)
		));
	}
}


/* Register shortcode in the VC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_socials_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_socials_reg_shortcodes_vc');
	function fire_department_sc_socials_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_socials",
			"name" => esc_html__("Social icons", 'fire-department'),
			"description" => wp_kses_data( __("Custom social icons", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_socials',
			"class" => "trx_sc_collection trx_sc_socials",
			"content_element" => true,
			"is_container" => true,
			"show_settings_on_create" => true,
			"as_parent" => array('only' => 'trx_social_item'),
			"params" => array_merge(array(
				array(
					"param_name" => "type",
					"heading" => esc_html__("Icon's type", 'fire-department'),
					"description" => wp_kses_data( __("Type of the icons - images or font icons", 'fire-department') ),
					"class" => "",
					"std" => fire_department_get_theme_setting('socials_type'),
					"value" => array(
						esc_html__('Icons', 'fire-department') => 'icons',
						esc_html__('Images', 'fire-department') => 'images'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "size",
					"heading" => esc_html__("Icon's size", 'fire-department'),
					"description" => wp_kses_data( __("Size of the icons", 'fire-department') ),
					"class" => "",
					"std" => "small",
					"value" => array_flip(fire_department_get_sc_param('sizes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "shape",
					"heading" => esc_html__("Icon's shape", 'fire-department'),
					"description" => wp_kses_data( __("Shape of the icons", 'fire-department') ),
					"class" => "",
					"std" => "square",
					"value" => array_flip(fire_department_get_sc_param('shapes')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "socials",
					"heading" => esc_html__("Manual socials list", 'fire-department'),
					"description" => wp_kses_data( __("Custom list of social networks. For example: twitter=http://twitter.com/my_profile|facebook=http://facebook.com/my_profile. If empty - use socials from Theme options.", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "custom",
					"heading" => esc_html__("Custom socials", 'fire-department'),
					"description" => wp_kses_data( __("Make custom icons from inner shortcodes (prepare it on tabs)", 'fire-department') ),
					"class" => "",
					"value" => array(esc_html__('Custom socials', 'fire-department') => 'yes'),
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
			))
		) );
		
		
		vc_map( array(
			"base" => "trx_social_item",
			"name" => esc_html__("Custom social item", 'fire-department'),
			"description" => wp_kses_data( __("Custom social item: name, profile url and icon url", 'fire-department') ),
			"show_settings_on_create" => true,
			"content_element" => true,
			"is_container" => false,
			'icon' => 'icon_trx_social_item',
			"class" => "trx_sc_single trx_sc_social_item",
			"as_child" => array('only' => 'trx_socials'),
			"as_parent" => array('except' => 'trx_socials'),
			"params" => array(
				array(
					"param_name" => "name",
					"heading" => esc_html__("Social name", 'fire-department'),
					"description" => wp_kses_data( __("Name (slug) of the social network (twitter, facebook, linkedin, etc.)", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Your profile URL", 'fire-department'),
					"description" => wp_kses_data( __("URL of your profile in specified social network", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("URL (source) for icon file", 'fire-department'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for the current social icon", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				)
			)
		) );
		
		class WPBakeryShortCode_Trx_Socials extends FIRE_DEPARTMENT_VC_ShortCodeCollection {}
		class WPBakeryShortCode_Trx_Social_Item extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>