<?php
/**
 * Theme Widget: Banner
 */

// Theme init
if (!function_exists('fire_department_widget_banner_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_widget_banner_theme_setup', 1 );
	function fire_department_widget_banner_theme_setup() {

		// Register shortcodes in the shortcodes list
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_widget_banner_reg_shortcodes_vc');
	}
}

// Load widget
if (!function_exists('fire_department_widget_banner_load')) {
	add_action( 'widgets_init', 'fire_department_widget_banner_load' );
	function fire_department_widget_banner_load() {
		register_widget( 'fire_department_widget_banner' );
	}
}

// Widget Class
class fire_department_widget_banner extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_banner', 'description' => esc_html__('Banner', 'fire-department') );
		parent::__construct( 'fire_department_widget_banner', esc_html__('Fire Department - Banner', 'fire-department'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {
		
		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );
		$banner_image = isset($instance['banner_image']) ? $instance['banner_image'] : '';
		$banner_link = isset($instance['banner_link']) ? $instance['banner_link'] : '';
		$banner_code = isset($instance['banner_code']) ? $instance['banner_code'] : '';

		// Before widget (defined by themes)
		fire_department_show_layout($before_widget);

		// Display the widget title if one was input (before and after defined by themes)
		if ($title) fire_department_show_layout($title, $before_title, $after_title);
		?>			
		<div class="widget_banner_inner">
			<?php
			if ($banner_image!='') {
				if ((int) $banner_image > 0) {
					$attach = wp_get_attachment_image_src( $banner_image, 'full' );
					if (isset($attach[0]) && $attach[0]!='')
						$banner_image = $attach[0];
				}
				$attr = fire_department_getimagesize($banner_image);
				echo (!empty($banner_link) ? '<a href="' . esc_url($banner_link) . '"' : '<span') . ' class="image_wrap"><img src="' . esc_url($banner_image) . '" alt="' . esc_attr($title) . '"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>' . (!empty($banner_link) ? '</a>': '</span>');
			}
			if ($banner_code!='') {
				echo force_balance_tags(fire_department_substitute_all($banner_code));
			}
			?>
		</div>
		<?php
		
		// After widget (defined by themes)
		fire_department_show_layout($after_widget);
	}

	// Update the widget settings.
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['banner_image'] = strip_tags( $new_instance['banner_image'] );
		$instance['banner_link'] = strip_tags( $new_instance['banner_link'] );
		$instance['banner_code'] = $new_instance['banner_code'];
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title' => '',
			'banner_image' => '',
			'banner_link' => '',
			'banner_code' => ''
			)
		);
		$title = $instance['title'];
		$banner_image = $instance['banner_image'];
		$banner_link = $instance['banner_link'];
		$banner_code = $instance['banner_code'];
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'fire-department'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($title); ?>" class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_image' )); ?>"><?php echo wp_kses_data( __('Image source URL:<br />(leave empty if you paste banner code)', 'fire-department') ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'banner_image' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_image' )); ?>" value="<?php echo esc_attr($banner_image); ?>"  class="widgets_param_fullwidth widgets_param_img_selector" />
            <?php
			fire_department_show_layout(fire_department_show_custom_field($this->get_field_id( 'banner_media' ), array('type'=>'mediamanager', 'media_field_id'=>$this->get_field_id( 'banner_image' )), null));
			if ($banner_image) {
			?>
	            <br /><br /><img src="<?php echo esc_url($banner_image); ?>"  class="widgets_param_maxwidth" alt="" />
			<?php
			}
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>"><?php echo wp_kses_data( __('Image link URL:<br />(leave empty if you paste banner code)', 'fire-department') ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'banner_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_link' )); ?>" value="<?php echo esc_attr($banner_link); ?>"  class="widgets_param_fullwidth" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'banner_code' )); ?>"><?php esc_html_e('or paste Banner Widget HTML Code:', 'fire-department'); ?></label>
			<textarea id="<?php echo esc_attr($this->get_field_id( 'banner_code' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'banner_code' )); ?>" rows="5"  class="widgets_param_fullwidth"><?php echo htmlspecialchars($banner_code); ?></textarea>
		</p>
	<?php
	}
}



// trx_widget_banner
//-------------------------------------------------------------
/*
[trx_widget_banner id="unique_id" title="Widget title" fullwidth="0|1" image="image_url" link="Image_link_url" code="html & js code"]
*/
if ( !function_exists( 'fire_department_sc_widget_banner' ) ) {
	function fire_department_sc_widget_banner($atts, $content=null){	
		$atts = fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title" => "",
			"image" => "",
			"link" => "",
			"code" => "",
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts));
		extract($atts);
		$type = 'fire_department_widget_banner';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$atts['banner_image'] = $image;
			$atts['banner_link'] = $link;
			$atts['banner_code'] = $code;
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_banner' 
								. (fire_department_exists_visual_composer() ? ' vc_widget_banner wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
						. '">';
			ob_start();
			the_widget( $type, $atts, fire_department_prepare_widgets_args(fire_department_storage_get('widgets_args'), $id ? $id.'_widget' : 'widget_banner', 'widget_banner') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('fire_department_shortcode_output', $output, 'trx_widget_banner', $atts, $content);
	}
	fire_department_require_shortcode("trx_widget_banner", "fire_department_sc_widget_banner");
}


// Add [trx_widget_banner] in the VC shortcodes list
if (!function_exists('fire_department_widget_banner_reg_shortcodes_vc')) {
	//add_action('fire_department_action_shortcodes_list_vc','fire_department_widget_banner_reg_shortcodes_vc');
	function fire_department_widget_banner_reg_shortcodes_vc() {
		
		vc_map( array(
				"base" => "trx_widget_banner",
				"name" => esc_html__("Widget Banner", 'fire-department'),
				"description" => wp_kses_data( __("Insert widget with banner or any HTML and/or Javascript code", 'fire-department') ),
				"category" => esc_html__('Content', 'fire-department'),
				"icon" => 'icon_trx_widget_banner',
				"class" => "trx_widget_banner",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "title",
						"heading" => esc_html__("Widget title", 'fire-department'),
						"description" => wp_kses_data( __("Title of the widget", 'fire-department') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "image",
						"heading" => esc_html__("Image", 'fire-department'),
						"description" => wp_kses_data( __("Select or upload image or write URL from other site for the banner (leave empty if you paste banner code)", 'fire-department') ),
						"class" => "",
						"value" => "",
						"type" => "attach_image"
					),
					array(
						"param_name" => "link",
						"heading" => esc_html__("Banner's link", 'fire-department'),
						"description" => wp_kses_data( __("Link URL for the banner (leave empty if you paste banner code)", 'fire-department') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "code",
						"heading" => esc_html__("or paste Banner Widget HTML Code", 'fire-department'),
						"description" => wp_kses_data( __("Widget's HTML and/or JS code", 'fire-department') ),
						"class" => "",
						"value" => "",
						"type" => "textarea"
					),
					fire_department_get_vc_param('id'),
					fire_department_get_vc_param('class'),
					fire_department_get_vc_param('css')
				)
			) );
			
		class WPBakeryShortCode_Trx_Widget_Banner extends WPBakeryShortCode {}

	}
}
?>