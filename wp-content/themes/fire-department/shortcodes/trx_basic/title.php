<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_title_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_title_theme_setup' );
	function fire_department_sc_title_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_title_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_title_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_title id="unique_id" style='regular|iconed' icon='' image='' background="on|off" type="1-6"]Et adipiscing integer, scelerisque pid, augue mus vel tincidunt porta[/trx_title]
*/

if (!function_exists('fire_department_sc_title')) {	
	function fire_department_sc_title($atts, $content=null){	
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"type" => "1",
			"style" => "regular",
			"align" => "",
			"font_weight" => "",
			"font_size" => "",
			"color" => "",
			"icon" => "",
			"image" => "",
			"picture" => "",
			"image_size" => "small",
			"position" => "left",
			// Common params
			"id" => "",
			"class" => "",
			"animation" => "",
			"css" => "",
			"width" => "",
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$css .= fire_department_get_css_dimensions_from_values($width)
			.($align && $align!='none' && !fire_department_param_is_inherit($align) ? 'text-align:' . esc_attr($align) .';' : '')
			.($color ? 'color:' . esc_attr($color) .';' : '')
			.($font_weight && !fire_department_param_is_inherit($font_weight) ? 'font-weight:' . esc_attr($font_weight) .';' : '')
			.($font_size   ? 'font-size:' . esc_attr($font_size) .';' : '')
			;
		$type = min(6, max(1, $type));
		if ($picture > 0) {
			$attach = wp_get_attachment_image_src( $picture, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$picture = $attach[0];
		}
		$pic = $style!='iconed' 
			? '' 
			: '<span class="sc_title_icon sc_title_icon_'.esc_attr($position).'  sc_title_icon_'.esc_attr($image_size).($icon!='' && $icon!='none' ? ' '.esc_attr($icon) : '').'"'.'>'
				.($picture ? '<img src="'.esc_url($picture).'" alt="" />' : '')
				.(empty($picture) && $image && $image!='none' ? '<img src="'.esc_url(fire_department_strpos($image, 'http')===0 ? $image : fire_department_get_file_url('images/icons/'.($image).'.png')).'" alt="" />' : '')
				.'</span>';
		$output = '<h' . esc_attr($type) . ($id ? ' id="'.esc_attr($id).'"' : '')
				. ' class="sc_title sc_title_'.esc_attr($style)
					.($align && $align!='none' && !fire_department_param_is_inherit($align) ? ' sc_align_' . esc_attr($align) : '')
					.(!empty($class) ? ' '.esc_attr($class) : '')
					.'"'
				. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
				. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '')
				. '>'
					. ($pic)
					. ($style=='divider' ? '<span class="sc_title_divider_before"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
					. do_shortcode($content) 
					. ($style=='divider' ? '<span class="sc_title_divider_after"'.($color ? ' style="background-color: '.esc_attr($color).'"' : '').'></span>' : '')
				. '</h' . esc_attr($type) . '>';
		return apply_filters('fire_department_shortcode_output', $output, 'trx_title', $atts, $content);
	}
	fire_department_require_shortcode('trx_title', 'fire_department_sc_title');
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_title_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_title_reg_shortcodes');
	function fire_department_sc_title_reg_shortcodes() {
	
		fire_department_sc_map("trx_title", array(
			"title" => esc_html__("Title", 'fire-department'),
			"desc" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'fire-department') ),
			"decorate" => false,
			"container" => true,
			"params" => array(
				"_content_" => array(
					"title" => esc_html__("Title content", 'fire-department'),
					"desc" => wp_kses_data( __("Title content", 'fire-department') ),
					"rows" => 4,
					"value" => "",
					"type" => "textarea"
				),
				"type" => array(
					"title" => esc_html__("Title type", 'fire-department'),
					"desc" => wp_kses_data( __("Title type (header level)", 'fire-department') ),
					"divider" => true,
					"value" => "1",
					"type" => "select",
					"options" => array(
						'1' => esc_html__('Header 1', 'fire-department'),
						'2' => esc_html__('Header 2', 'fire-department'),
						'3' => esc_html__('Header 3', 'fire-department'),
						'4' => esc_html__('Header 4', 'fire-department'),
						'5' => esc_html__('Header 5', 'fire-department'),
						'6' => esc_html__('Header 6', 'fire-department'),
					)
				),
				"style" => array(
					"title" => esc_html__("Title style", 'fire-department'),
					"desc" => wp_kses_data( __("Title style", 'fire-department') ),
					"value" => "regular",
					"type" => "select",
					"options" => array(
						'regular' => esc_html__('Regular', 'fire-department'),
						'underline' => esc_html__('Underline', 'fire-department'),
						'divider' => esc_html__('Divider', 'fire-department'),
						'iconed' => esc_html__('With icon (image)', 'fire-department')
					)
				),
				"align" => array(
					"title" => esc_html__("Alignment", 'fire-department'),
					"desc" => wp_kses_data( __("Title text alignment", 'fire-department') ),
					"value" => "",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('align')
				), 
				"font_size" => array(
					"title" => esc_html__("Font_size", 'fire-department'),
					"desc" => wp_kses_data( __("Custom font size. If empty - use theme default", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"font_weight" => array(
					"title" => esc_html__("Font weight", 'fire-department'),
					"desc" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'fire-department') ),
					"value" => "",
					"type" => "select",
					"size" => "medium",
					"options" => array(
						'inherit' => esc_html__('Default', 'fire-department'),
						'100' => esc_html__('Thin (100)', 'fire-department'),
						'300' => esc_html__('Light (300)', 'fire-department'),
						'400' => esc_html__('Normal (400)', 'fire-department'),
						'600' => esc_html__('Semibold (600)', 'fire-department'),
						'700' => esc_html__('Bold (700)', 'fire-department'),
						'900' => esc_html__('Black (900)', 'fire-department')
					)
				),
				"color" => array(
					"title" => esc_html__("Title color", 'fire-department'),
					"desc" => wp_kses_data( __("Select color for the title", 'fire-department') ),
					"value" => "",
					"type" => "color"
				),
				"icon" => array(
					"title" => esc_html__('Title font icon',  'fire-department'),
					"desc" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)",  'fire-department') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "icons",
					"options" => fire_department_get_sc_param('icons')
				),
				"image" => array(
					"title" => esc_html__('or image icon',  'fire-department'),
					"desc" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)",  'fire-department') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "",
					"type" => "images",
					"size" => "small",
					"options" => fire_department_get_sc_param('images')
				),
				"picture" => array(
					"title" => esc_html__('or URL for image file', 'fire-department'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'fire-department') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"image_size" => array(
					"title" => esc_html__('Image (picture) size', 'fire-department'),
					"desc" => wp_kses_data( __("Select image (picture) size (if style='iconed')", 'fire-department') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "small",
					"type" => "checklist",
					"options" => array(
						'small' => esc_html__('Small', 'fire-department'),
						'medium' => esc_html__('Medium', 'fire-department'),
						'large' => esc_html__('Large', 'fire-department')
					)
				),
				"position" => array(
					"title" => esc_html__('Icon (image) position', 'fire-department'),
					"desc" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'fire-department') ),
					"dependency" => array(
						'style' => array('iconed')
					),
					"value" => "left",
					"type" => "checklist",
					"options" => array(
						'top' => esc_html__('Top', 'fire-department'),
						'left' => esc_html__('Left', 'fire-department')
					)
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
if ( !function_exists( 'fire_department_sc_title_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_title_reg_shortcodes_vc');
	function fire_department_sc_title_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_title",
			"name" => esc_html__("Title", 'fire-department'),
			"description" => wp_kses_data( __("Create header tag (1-6 level) with many styles", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_title',
			"class" => "trx_sc_single trx_sc_title",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "content",
					"heading" => esc_html__("Title content", 'fire-department'),
					"description" => wp_kses_data( __("Title content", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textarea_html"
				),
				array(
					"param_name" => "type",
					"heading" => esc_html__("Title type", 'fire-department'),
					"description" => wp_kses_data( __("Title type (header level)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Header 1', 'fire-department') => '1',
						esc_html__('Header 2', 'fire-department') => '2',
						esc_html__('Header 3', 'fire-department') => '3',
						esc_html__('Header 4', 'fire-department') => '4',
						esc_html__('Header 5', 'fire-department') => '5',
						esc_html__('Header 6', 'fire-department') => '6'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "style",
					"heading" => esc_html__("Title style", 'fire-department'),
					"description" => wp_kses_data( __("Title style: only text (regular) or with icon/image (iconed)", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array(
						esc_html__('Regular', 'fire-department') => 'regular',
						esc_html__('Underline', 'fire-department') => 'underline',
						esc_html__('Divider', 'fire-department') => 'divider',
						esc_html__('With icon (image)', 'fire-department') => 'iconed'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'fire-department'),
					"description" => wp_kses_data( __("Title text alignment", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('align')),
					"type" => "dropdown"
				),
				array(
					"param_name" => "font_size",
					"heading" => esc_html__("Font size", 'fire-department'),
					"description" => wp_kses_data( __("Custom font size. If empty - use theme default", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "font_weight",
					"heading" => esc_html__("Font weight", 'fire-department'),
					"description" => wp_kses_data( __("Custom font weight. If empty or inherit - use theme default", 'fire-department') ),
					"class" => "",
					"value" => array(
						esc_html__('Default', 'fire-department') => 'inherit',
						esc_html__('Thin (100)', 'fire-department') => '100',
						esc_html__('Light (300)', 'fire-department') => '300',
						esc_html__('Normal (400)', 'fire-department') => '400',
						esc_html__('Semibold (600)', 'fire-department') => '600',
						esc_html__('Bold (700)', 'fire-department') => '700',
						esc_html__('Black (900)', 'fire-department') => '900'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "color",
					"heading" => esc_html__("Title color", 'fire-department'),
					"description" => wp_kses_data( __("Select color for the title", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "colorpicker"
				),
				array(
					"param_name" => "icon",
					"heading" => esc_html__("Title font icon", 'fire-department'),
					"description" => wp_kses_data( __("Select font icon for the title from Fontello icons set (if style=iconed)", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => fire_department_get_sc_param('icons'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("or image icon", 'fire-department'),
					"description" => wp_kses_data( __("Select image icon for the title instead icon above (if style=iconed)", 'fire-department') ),
					"class" => "",
					"group" => esc_html__('Icon &amp; Image', 'fire-department'),
					'dependency' => array(
						'element' => 'style',
						'value' => array('iconed')
					),
					"value" => fire_department_get_sc_param('images'),
					"type" => "dropdown"
				),
				array(
					"param_name" => "picture",
					"heading" => esc_html__("or select uploaded image", 'fire-department'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site (if style=iconed)", 'fire-department') ),
					"group" => esc_html__('Icon &amp; Image', 'fire-department'),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "image_size",
					"heading" => esc_html__("Image (picture) size", 'fire-department'),
					"description" => wp_kses_data( __("Select image (picture) size (if style=iconed)", 'fire-department') ),
					"group" => esc_html__('Icon &amp; Image', 'fire-department'),
					"class" => "",
					"value" => array(
						esc_html__('Small', 'fire-department') => 'small',
						esc_html__('Medium', 'fire-department') => 'medium',
						esc_html__('Large', 'fire-department') => 'large'
					),
					"type" => "dropdown"
				),
				array(
					"param_name" => "position",
					"heading" => esc_html__("Icon (image) position", 'fire-department'),
					"description" => wp_kses_data( __("Select icon (image) position (if style=iconed)", 'fire-department') ),
					"group" => esc_html__('Icon &amp; Image', 'fire-department'),
					"class" => "",
					"std" => "left",
					"value" => array(
						esc_html__('Top', 'fire-department') => 'top',
						esc_html__('Left', 'fire-department') => 'left'
					),
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
			'js_view' => 'VcTrxTextView'
		) );
		
		class WPBakeryShortCode_Trx_Title extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>