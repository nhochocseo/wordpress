<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_intro_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_intro_theme_setup' );
	function fire_department_sc_intro_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_intro_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_intro_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

if (!function_exists('fire_department_sc_intro')) {	
	function fire_department_sc_intro($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"style" => 1,
			"align" => "none",
			"image" => "",
			"bg_color" => "",
			"icon" => "",
			"scheme" => "",
			"title" => "",
			"subtitle" => "",
			"description" => "",
			"link" => '',
			"link_caption" => esc_html__('Read more', 'fire-department'),
			"link2" => '',
			"link2_caption" => '',
			"url" => "",
			"content_position" => "",
			"content_width" => "",
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
	
		if ($image > 0) {
			$attach = wp_get_attachment_image_src($image, 'full');
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		
		$width  = fire_department_prepare_css_value($width);
		$height = fire_department_prepare_css_value($height);
		
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);

		$css .= fire_department_get_css_dimensions_from_values($width,$height);
		$css .= ($image ? 'background: url('.$image.');' : '');
		$css .= ($bg_color ? 'background-color: '.$bg_color.';' : '');
		
		$buttons = (!empty($link) || !empty($link2) 
						? '<div class="sc_intro_buttons sc_item_buttons">'
							. (!empty($link) 
								? '<div class="sc_intro_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link).'" size="medium"]'.esc_html($link_caption).'[/trx_button]').'</div>' 
								: '')
							. (!empty($link2) && $style==2 
								? '<div class="sc_intro_button sc_item_button">'.do_shortcode('[trx_button link="'.esc_url($link2).'" size="medium"]'.esc_html($link2_caption).'[/trx_button]').'</div>' 
								: '')
							. '</div>'
						: '');
						
		$output = '<div '.(!empty($url) ? 'data-href="'.esc_url($url).'"' : '') 
					. ($id ? ' id="'.esc_attr($id).'"' : '') 
					. ' class="sc_intro' 
						. ($class ? ' ' . esc_attr($class) : '') 
						. ($content_position && $style==1 ? ' sc_intro_position_' . esc_attr($content_position) : '') 
						. ($style==5 ? ' small_padding' : '') 
						. ($scheme && !fire_department_param_is_off($scheme) && !fire_department_param_is_inherit($scheme) ? ' scheme_'.esc_attr($scheme) : '') 
						. ($align && $align!='none' ? ' align'.esc_attr($align) : '') 
						. '"'
					. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
					. ($css ? ' style="'.esc_attr($css).'"' : '')
					.'>' 
					. '<div class="sc_intro_inner '.($style ? ' sc_intro_style_' . esc_attr($style) : '').'"'.(!empty($content_width) ? ' style="width:'.esc_attr($content_width).';"' : '').'>'
						. (!empty($icon) && $style==5 ? '<div class="sc_intro_icon '.esc_attr($icon).'"></div>' : '')
						. '<div class="sc_intro_content">'
							. (!empty($subtitle) && $style!=4 && $style!=5 ? '<h6 class="sc_intro_subtitle">' . trim(fire_department_strmacros($subtitle)) . '</h6>' : '')
							. (!empty($title) ? '<h2 class="sc_intro_title">' . trim(fire_department_strmacros($title)) . '</h2>' : '')
							. (!empty($description) && $style!=1 ? '<div class="sc_intro_descr">' . trim(fire_department_strmacros($description)) . '</div>' : '')
							. ($style==2 || $style==3 ? $buttons : '')
						. '</div>'
					. '</div>'
				.'</div>';
	
	
	
		return apply_filters('fire_department_shortcode_output', $output, 'trx_intro', $atts, $content);
	}
	fire_department_require_shortcode('trx_intro', 'fire_department_sc_intro');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_intro_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_intro_reg_shortcodes');
	function fire_department_sc_intro_reg_shortcodes() {
	
		fire_department_sc_map("trx_intro", array(
			"title" => esc_html__("Intro", 'fire-department'),
			"desc" => wp_kses_data( __("Insert Intro block in your page (post)", 'fire-department') ),
			"decorate" => true,
			"container" => false,
			"params" => array(
				"style" => array(
					"title" => esc_html__("Style", 'fire-department'),
					"desc" => wp_kses_data( __("Select style to display block", 'fire-department') ),
					"value" => "1",
					"type" => "checklist",
					"options" => fire_department_get_list_styles(1, 5)
				),
				"align" => array(
					"title" => esc_html__("Alignment of the intro block", 'fire-department'),
					"desc" => wp_kses_data( __("Align whole intro block to left or right side of the page or parent container", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('float')
				), 
				"image" => array(
					"title" => esc_html__("Image URL", 'fire-department'),
					"desc" => wp_kses_data( __("Select the intro image from the library for this section", 'fire-department') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"bg_color" => array(
					"title" => esc_html__("Background color", 'fire-department'),
					"desc" => wp_kses_data( __("Select background color for the intro", 'fire-department') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Icon',  'fire-department'),
					"desc" => wp_kses_data( __("Select icon from Fontello icons set",  'fire-department') ),
					"dependency" => array(
						'style' => array(5)
					),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"content_position" => array(
					"title" => esc_html__('Content position', 'fire-department'),
					"desc" => wp_kses_data( __("Select content position", 'fire-department') ),
					"dependency" => array(
						'style' => array(1)
					),
					"value" => "top_left",
					"type" => "checklist",
					"options" => array(
						'top_left' => esc_html__('Top Left', 'fire-department'),
						'top_right' => esc_html__('Top Right', 'fire-department'),
						'bottom_right' => esc_html__('Bottom Right', 'fire-department'),
						'bottom_left' => esc_html__('Bottom Left', 'fire-department')
					)
				),
				"content_width" => array(
					"title" => esc_html__('Content width', 'fire-department'),
					"desc" => wp_kses_data( __("Select content width", 'fire-department') ),
					"dependency" => array(
						'style' => array(1)
					),
					"value" => "100%",
					"type" => "checklist",
					"options" => array(
						'100%' => esc_html__('100%', 'fire-department'),
						'90%' => esc_html__('90%', 'fire-department'),
						'80%' => esc_html__('80%', 'fire-department'),
						'70%' => esc_html__('70%', 'fire-department'),
						'60%' => esc_html__('60%', 'fire-department'),
						'50%' => esc_html__('50%', 'fire-department'),
						'40%' => esc_html__('40%', 'fire-department'),
						'30%' => esc_html__('30%', 'fire-department')
					)
				),
				"subtitle" => array(
					"title" => esc_html__("Subtitle", 'fire-department'),
					"desc" => wp_kses_data( __("Subtitle for the block", 'fire-department') ),
					"divider" => true,
					"dependency" => array(
						'style' => array(1,2,3)
					),
					"value" => "",
					"type" => "text"
				),
				"title" => array(
					"title" => esc_html__("Title", 'fire-department'),
					"desc" => wp_kses_data( __("Title for the block", 'fire-department') ),
					"value" => "",
					"type" => "textarea"
				),
				"description" => array(
					"title" => esc_html__("Description", 'fire-department'),
					"desc" => wp_kses_data( __("Short description for the block", 'fire-department') ),
					"dependency" => array(
						'style' => array(2,3,4,5),
					),
					"value" => "",
					"type" => "textarea"
				),
				"link" => array(
					"title" => esc_html__("Button URL", 'fire-department'),
					"desc" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'fire-department') ),
					"dependency" => array(
						'style' => array(2,3),
					),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link_caption" => array(
					"title" => esc_html__("Button caption", 'fire-department'),
					"desc" => wp_kses_data( __("Caption for the button at the bottom of the block", 'fire-department') ),
					"dependency" => array(
						'style' => array(2,3),
					),
					"value" => "",
					"type" => "text"
				),
				"link2" => array(
					"title" => esc_html__("Button 2 URL", 'fire-department'),
					"desc" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'fire-department') ),
					"dependency" => array(
						'style' => array(2)
					),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"link2_caption" => array(
					"title" => esc_html__("Button 2 caption", 'fire-department'),
					"desc" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'fire-department') ),
					"dependency" => array(
						'style' => array(2)
					),
					"value" => "",
					"type" => "text"
				),
				"url" => array(
					"title" => esc_html__("Link", 'fire-department'),
					"desc" => wp_kses_data( __("Link of the intro block", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"scheme" => array(
					"title" => esc_html__("Color scheme", 'fire-department'),
					"desc" => wp_kses_data( __("Select color scheme for the section with text", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"options" => fire_department_get_sc_param('schemes')
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
if ( !function_exists( 'fire_department_sc_intro_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_intro_reg_shortcodes_vc');
	function fire_department_sc_intro_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_intro",
			"name" => esc_html__("Intro", 'fire-department'),
			"description" => wp_kses_data( __("Insert Intro block", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_intro',
			"class" => "trx_sc_single trx_sc_intro",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "style",
					"heading" => esc_html__("Style of the block", 'fire-department'),
					"description" => wp_kses_data( __("Select style to display this block", 'fire-department') ),
					"class" => "",
					"admin_label" => true,
					"value" => array_flip(fire_department_get_list_styles(1, 5)),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment of the block", 'fire-department'),
					"description" => wp_kses_data( __("Align whole intro block to left or right side of the page or parent container", 'fire-department') ),
					"class" => "",
					"std" => 'none',
					"value" => array_flip(fire_department_get_sc_param('float')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Image URL", 'fire-department'),
					"description" => wp_kses_data( __("Select the intro image from the library for this section", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "bg_color",
					"heading" => esc_html__("Background color", 'fire-department'),
					"description" => wp_kses_data( __("Select background color for the intro", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Icon", 'fire-department'),
					"description" => wp_kses_data( __("Select icon from Fontello icons set", 'fire-department') ),
					"class" => "",
					'dependency' => array(
						'element' => 'style',
						'value' => array('5')
					),
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content_position",
					"heading" => esc_html__("Content position", 'fire-department'),
					"description" => wp_kses_data( __("Select content position", 'fire-department') ),
					"class" => "",
					"admin_label" => true,
					"value" => array(
						esc_html__('Top Left', 'fire-department') => 'top_left',
						esc_html__('Top Right', 'fire-department') => 'top_right',
						esc_html__('Bottom Right', 'fire-department') => 'bottom_right',
						esc_html__('Bottom Left', 'fire-department') => 'bottom_left'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "content_width",
					"heading" => esc_html__("Content width", 'fire-department'),
					"description" => wp_kses_data( __("Select content width", 'fire-department') ),
					"class" => "",
					"admin_label" => true,
					"value" => array(
						esc_html__('100%', 'fire-department') => '100%',
						esc_html__('90%', 'fire-department') => '90%',
						esc_html__('80%', 'fire-department') => '80%',
						esc_html__('70%', 'fire-department') => '70%',
						esc_html__('60%', 'fire-department') => '60%',
						esc_html__('50%', 'fire-department') => '50%',
						esc_html__('40%', 'fire-department') => '40%',
						esc_html__('30%', 'fire-department') => '30%'
					),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1')
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "subtitle",
					"heading" => esc_html__("Subtitle", 'fire-department'),
					"description" => wp_kses_data( __("Subtitle for the block", 'fire-department') ),
					'dependency' => array(
						'element' => 'style',
						'value' => array('1','2','3')
					),
					"group" => esc_html__('Captions', 'fire-department'),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Title for the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "description",
					"heading" => esc_html__("Description", 'fire-department'),
					"description" => wp_kses_data( __("Description for the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3','4','5')
					),
					"class" => "",
					"value" => "",
					"type" => "textarea"
				),
				array(
					"param_name" => "link",
					"heading" => esc_html__("Button URL", 'fire-department'),
					"description" => wp_kses_data( __("Link URL for the button at the bottom of the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link_caption",
					"heading" => esc_html__("Button caption", 'fire-department'),
					"description" => wp_kses_data( __("Caption for the button at the bottom of the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2','3')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2",
					"heading" => esc_html__("Button 2 URL", 'fire-department'),
					"description" => wp_kses_data( __("Link URL for the second button at the bottom of the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "link2_caption",
					"heading" => esc_html__("Button 2 caption", 'fire-department'),
					"description" => wp_kses_data( __("Caption for the second button at the bottom of the block", 'fire-department') ),
					"group" => esc_html__('Captions', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('2')
					),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "url",
					"heading" => esc_html__("Link", 'fire-department'),
					"description" => wp_kses_data( __("Link of the intro block", 'fire-department') ),
					"value" => '',
					"type" => "textfield"
				),
				array(
					"param_name" => "scheme",
					"heading" => esc_html__("Color scheme", 'fire-department'),
					"description" => wp_kses_data( __("Select color scheme for the section with text", 'fire-department') ),
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('schemes')),
					"type" => "dropdown"
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
			)
		) );
		
		class WPBakeryShortCode_Trx_Intro extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>