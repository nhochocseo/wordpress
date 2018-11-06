<?php

/* Theme setup section
-------------------------------------------------------------------- */
if (!function_exists('fire_department_sc_audio_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_audio_theme_setup' );
	function fire_department_sc_audio_theme_setup() {
		add_action('fire_department_action_shortcodes_list', 		'fire_department_sc_audio_reg_shortcodes');
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_sc_audio_reg_shortcodes_vc');
	}
}



/* Shortcode implementation
-------------------------------------------------------------------- */

/*
[trx_audio url="http://trex2.themerex.dnw/wp-content/uploads/2014/12/Dream-Music-Relax.mp3" image="http://trex2.themerex.dnw/wp-content/uploads/2014/10/post_audio.jpg" title="Insert Audio Title Here" author="Lily Hunter" controls="show" autoplay="off"]
*/

if (!function_exists('fire_department_sc_audio')) {	
	function fire_department_sc_audio($atts, $content = null) {
		if (fire_department_in_shortcode_blogger()) return '';
		extract(fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"author" => "",
			"image" => "",
			"mp3" => '',
			"wav" => '',
			"src" => '',
			"url" => '',
			"align" => '',
			"controls" => "",
			"autoplay" => "",
			"frame" => "on",
			// Common params
			"id" => "",
			"class" => "",
			"css" => "",
			"animation" => "",
			"width" => '',
			"height" => '',
			"top" => "",
			"bottom" => "",
			"left" => "",
			"right" => ""
		), $atts)));
		if ($src=='' && $url=='' && isset($atts[0])) {
			$src = $atts[0];
		}
		if ($src=='') {
			if ($url) $src = $url;
			else if ($mp3) $src = $mp3;
			else if ($wav) $src = $wav;
		}
		if ($image > 0) {
			$attach = wp_get_attachment_image_src( $image, 'full' );
			if (isset($attach[0]) && $attach[0]!='')
				$image = $attach[0];
		}
		$class .= ($class ? ' ' : '') . fire_department_get_css_position_as_classes($top, $right, $bottom, $left);
		$data = ($title != ''  ? ' data-title="'.esc_attr($title).'"'   : '')
				. ($author != '' ? ' data-author="'.esc_attr($author).'"' : '')
				. ($image != ''  ? ' data-image="'.esc_url($image).'"'   : '')
				. ($align && $align!='none' ? ' data-align="'.esc_attr($align).'"' : '')
				. (!fire_department_param_is_off($animation) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($animation)).'"' : '');
		$audio = '<audio'
			. ($id ? ' id="'.esc_attr($id).'"' : '')
			. ' class="sc_audio' . (!empty($class) ? ' '.esc_attr($class) : '') . '"'
			. ' src="'.esc_url($src).'"'
			. (fire_department_param_is_on($controls) ? ' controls="controls"' : '')
			. (fire_department_param_is_on($autoplay) && is_single() ? ' autoplay="autoplay"' : '')
			. ' width="'.esc_attr($width).'" height="'.esc_attr($height).'"'
			. ($css!='' ? ' style="'.esc_attr($css).'"' : '')
			. ($data)
			. '></audio>';
		if ( fire_department_get_custom_option('substitute_audio')=='no') {
			if (fire_department_param_is_on($frame)) {
				$audio = fire_department_get_audio_frame($audio, $image, $s);
			}
		} else {
			if ((isset($_GET['vc_editable']) && $_GET['vc_editable']=='true') && (isset($_POST['action']) && $_POST['action']=='vc_load_shortcode')) {
				$audio = fire_department_substitute_audio($audio, false);
			}
		}
		if (fire_department_get_theme_option('use_mediaelement')=='yes')
			fire_department_enqueue_script('wp-mediaelement');
		return apply_filters('fire_department_shortcode_output', $audio, 'trx_audio', $atts, $content);
	}
	fire_department_require_shortcode("trx_audio", "fire_department_sc_audio");
}



/* Register shortcode in the internal SC Builder
-------------------------------------------------------------------- */
if ( !function_exists( 'fire_department_sc_audio_reg_shortcodes' ) ) {
	//add_action('fire_department_action_shortcodes_list', 'fire_department_sc_audio_reg_shortcodes');
	function fire_department_sc_audio_reg_shortcodes() {
	
		fire_department_sc_map("trx_audio", array(
			"title" => esc_html__("Audio", 'fire-department'),
			"desc" => wp_kses_data( __("Insert audio player", 'fire-department') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"url" => array(
					"title" => esc_html__("URL for audio file", 'fire-department'),
					"desc" => wp_kses_data( __("URL for audio file", 'fire-department') ),
					"readonly" => false,
					"value" => "",
					"type" => "media",
					"before" => array(
						'title' => esc_html__('Choose audio', 'fire-department'),
						'action' => 'media_upload',
						'type' => 'audio',
						'multiple' => false,
						'linked_field' => '',
						'captions' => array( 	
							'choose' => esc_html__('Choose audio file', 'fire-department'),
							'update' => esc_html__('Select audio file', 'fire-department')
						)
					),
					"after" => array(
						'icon' => 'icon-cancel',
						'action' => 'media_reset'
					)
				),
				"image" => array(
					"title" => esc_html__("Cover image", 'fire-department'),
					"desc" => wp_kses_data( __("Select or upload image or write URL from other site for audio cover", 'fire-department') ),
					"readonly" => false,
					"value" => "",
					"type" => "media"
				),
				"title" => array(
					"title" => esc_html__("Title", 'fire-department'),
					"desc" => wp_kses_data( __("Title of the audio file", 'fire-department') ),
					"divider" => true,
					"value" => "",
					"type" => "text"
				),
				"author" => array(
					"title" => esc_html__("Author", 'fire-department'),
					"desc" => wp_kses_data( __("Author of the audio file", 'fire-department') ),
					"value" => "",
					"type" => "text"
				),
				"controls" => array(
					"title" => esc_html__("Show controls", 'fire-department'),
					"desc" => wp_kses_data( __("Show controls in audio player", 'fire-department') ),
					"divider" => true,
					"size" => "medium",
					"value" => "show",
					"type" => "switch",
					"options" => fire_department_get_sc_param('show_hide')
				),
				"autoplay" => array(
					"title" => esc_html__("Autoplay audio", 'fire-department'),
					"desc" => wp_kses_data( __("Autoplay audio on page load", 'fire-department') ),
					"value" => "off",
					"type" => "switch",
					"options" => fire_department_get_sc_param('on_off')
				),
				"align" => array(
					"title" => esc_html__("Align", 'fire-department'),
					"desc" => wp_kses_data( __("Select block alignment", 'fire-department') ),
					"value" => "none",
					"type" => "checklist",
					"dir" => "horizontal",
					"options" => fire_department_get_sc_param('align')
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
if ( !function_exists( 'fire_department_sc_audio_reg_shortcodes_vc' ) ) {
	//add_action('fire_department_action_shortcodes_list_vc', 'fire_department_sc_audio_reg_shortcodes_vc');
	function fire_department_sc_audio_reg_shortcodes_vc() {
	
		vc_map( array(
			"base" => "trx_audio",
			"name" => esc_html__("Audio", 'fire-department'),
			"description" => wp_kses_data( __("Insert audio player", 'fire-department') ),
			"category" => esc_html__('Content', 'fire-department'),
			'icon' => 'icon_trx_audio',
			"class" => "trx_sc_single trx_sc_audio",
			"content_element" => true,
			"is_container" => false,
			"show_settings_on_create" => true,
			"params" => array(
				array(
					"param_name" => "url",
					"heading" => esc_html__("URL for audio file", 'fire-department'),
					"description" => wp_kses_data( __("Put here URL for audio file", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "image",
					"heading" => esc_html__("Cover image", 'fire-department'),
					"description" => wp_kses_data( __("Select or upload image or write URL from other site for audio cover", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "attach_image"
				),
				array(
					"param_name" => "title",
					"heading" => esc_html__("Title", 'fire-department'),
					"description" => wp_kses_data( __("Title of the audio file", 'fire-department') ),
					"admin_label" => true,
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "author",
					"heading" => esc_html__("Author", 'fire-department'),
					"description" => wp_kses_data( __("Author of the audio file", 'fire-department') ),
					"class" => "",
					"value" => "",
					"type" => "textfield"
				),
				array(
					"param_name" => "controls",
					"heading" => esc_html__("Controls", 'fire-department'),
					"description" => wp_kses_data( __("Show/hide controls", 'fire-department') ),
					"class" => "",
					"value" => array("Hide controls" => "hide" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "autoplay",
					"heading" => esc_html__("Autoplay", 'fire-department'),
					"description" => wp_kses_data( __("Autoplay audio on page load", 'fire-department') ),
					"class" => "",
					"value" => array("Autoplay" => "on" ),
					"type" => "checkbox"
				),
				array(
					"param_name" => "align",
					"heading" => esc_html__("Alignment", 'fire-department'),
					"description" => wp_kses_data( __("Select block alignment", 'fire-department') ),
					"class" => "",
					"value" => array_flip(fire_department_get_sc_param('align')),
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
			),
		) );
		
		class WPBakeryShortCode_Trx_Audio extends FIRE_DEPARTMENT_VC_ShortCodeSingle {}
	}
}
?>