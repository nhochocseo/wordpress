<?php
/**
 * Theme Widget: Advanced Calendar
 */

// Theme init
if (!function_exists('fire_department_widget_categories_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_widget_categories_theme_setup', 1 );
	function fire_department_widget_categories_theme_setup() {

		// Register shortcodes in the shortcodes list
		if (function_exists('fire_department_exists_visual_composer') && fire_department_exists_visual_composer())
			add_action('fire_department_action_shortcodes_list_vc','fire_department_widget_categories_reg_shortcodes_vc');
	}
}

// Load widget
if (!function_exists('fire_department_widget_categories_load')) {
	add_action( 'widgets_init', 'fire_department_widget_categories_load' );
	function fire_department_widget_categories_load() {
		register_widget( 'fire_department_widget_categories' );
	}
}

// Widget Class
class fire_department_widget_categories extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_subcategories', 'description' => esc_html__('Display subcategories list', 'fire-department') );
		parent::__construct( 'fire_department_widget_subcategories', esc_html__('Fire Department - Subcategories list', 'fire-department'), $widget_ops );
	}

	// Show widget
	function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : '' );

		$post_type = isset($instance['post_type']) ? $instance['post_type'] : 'post';
		$taxonomy = fire_department_get_taxonomy_categories_by_post_type($post_type);

		$c = !empty( $instance['count'] ) && (int) $instance['count'] == 1 ? '1' : '0';
		$h = !empty( $instance['hierarchical'] ) && (int) $instance['hierarchical'] == 1 ? '1' : '0';
		$d = !empty( $instance['dropdown'] ) && (int) $instance['dropdown'] == 1 ? '1' : '0';

		$root = isset($instance['root']) && (int) $instance['root'] > 0 ? (int) $instance['root'] : 0;

		$cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => $taxonomy);

		if ($root > 0) $cat_args['child_of'] = $root;

		// Before widget (defined by themes)
		fire_department_show_layout($before_widget);

		if ($title) fire_department_show_layout($title, $before_title, $after_title);
		?>			
		<div class="widget_subcategories_inner">
			<?php
			if ( $d ) {
				$cat_args['show_option_none'] = esc_html__('Select Category', 'fire-department');
				wp_dropdown_categories( apply_filters( 'widget_categories_dropdown_args', $cat_args ) );
			} else {
				?>
				<ul>
					<?php
					$cat_args['title_li'] = '';
					wp_list_categories( apply_filters( 'widget_categories_args', $cat_args ) );
					?>
				</ul>
				<?php
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
		$instance['title'] 			= strip_tags( $new_instance['title'] );
		$instance['count'] 			= !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] 	= !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] 		= !empty($new_instance['dropdown']) ? 1 : 0;
		$instance['root'] 			= (int) $new_instance['root'];
		$instance['post_type'] 		= strip_tags( $new_instance['post_type'] );
		return $instance;
	}

	// Displays the widget settings controls on the widget panel.
	function form( $instance ) {

		// Set up some default widget settings
		$instance = wp_parse_args( (array) $instance, array(
			'title'			=> '',
			'count'			=> 0,
			'dropdown'		=> 0,
			'hierarchical'	=> 0,
			'root' 			=> 0,
			'post_type'		=> 'post'
			)
		);

		$title = $instance['title'];
		$root = (int) $instance['root'];
		$post_type = $instance['post_type'];
		$count = (bool) $instance['count'];
		$hierarchical = (bool) $instance['hierarchical'];
		$dropdown = (bool) $instance['dropdown'];
		
		$posts_types = fire_department_get_list_posts_types(false);
		$categories = fire_department_get_list_terms(false, fire_department_get_taxonomy_categories_by_post_type($post_type));
		?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e( 'Title:', 'fire-department' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_type')); ?>"><?php esc_html_e('Post type:', 'fire-department'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('post_type')); ?>" name="<?php echo esc_attr($this->get_field_name('post_type')); ?>" class="widgets_param_fullwidth widgets_param_post_type_selector">
			<?php
				if (is_array($posts_types) && count($posts_types) > 0) {
					foreach ($posts_types as $type => $type_name) {
						echo '<option value="'.esc_attr($type).'"'.($post_type==$type ? ' selected="selected"' : '').'>'.esc_html($type_name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('root')); ?>"><?php esc_html_e('Root category:', 'fire-department'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id('root')); ?>" name="<?php echo esc_attr($this->get_field_name('root')); ?>" class="widgets_param_fullwidth">
				<option value="0"><?php esc_html_e('-- Any category --', 'fire-department'); ?></option> 
			<?php
				if (is_array($categories) && count($categories) > 0) {
					foreach ($categories as $cat_id => $cat_name) {
						echo '<option value="'.esc_attr($cat_id).'"'.($root==$cat_id ? ' selected="selected"' : '').'>'.($cat_name).'</option>';
					}
				}
			?>
			</select>
		</p>

		<p>
		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('dropdown')); ?>" name="<?php echo esc_attr($this->get_field_name('dropdown')); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('dropdown')); ?>"><?php esc_html_e( 'Display as dropdown', 'fire-department' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('count')); ?>" name="<?php echo esc_attr($this->get_field_name('count')); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('count')); ?>"><?php esc_html_e( 'Show post counts', 'fire-department' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>" name="<?php echo esc_attr($this->get_field_name('hierarchical')); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo esc_attr($this->get_field_id('hierarchical')); ?>"><?php esc_html_e( 'Show hierarchy', 'fire-department' ); ?></label>
		</p>
		<?php
	}
}



// trx_widget_categories
//-------------------------------------------------------------
/*
[trx_widget_categories id="unique_id" title="Widget title" weekdays="short|initial"]
*/
if ( !function_exists( 'fire_department_sc_widget_categories' ) ) {
	function fire_department_sc_widget_categories($atts, $content=null){	
		$atts = fire_department_html_decode(shortcode_atts(array(
			// Individual params
			"title"			=> "",
			'count'			=> 1,
			'dropdown'		=> 0,
			'hierarchical'	=> 1,
			'root' 			=> '',
			'cat' 			=> 0,
			'post_type'		=> 'post',
			// Common params
			"id" => "",
			"class" => "",
			"css" => ""
		), $atts));
		if ($atts['post_type']=='') $atts['post_type'] = 'post';
		if ($atts['cat']!='' && $atts['root']=='') $atts['root'] = $atts['cat'];
		extract($atts);
		$type = 'fire_department_widget_categories';
		$output = '';
		global $wp_widget_factory;
		if ( is_object( $wp_widget_factory ) && isset( $wp_widget_factory->widgets, $wp_widget_factory->widgets[ $type ] ) ) {
			$output = '<div' . ($id ? ' id="'.esc_attr($id).'"' : '')
							. ' class="widget_area sc_widget_categories' 
								. (fire_department_exists_visual_composer() ? ' vc_widget_categories wpb_content_element' : '') 
								. (!empty($class) ? ' ' . esc_attr($class) : '') 
						. '">';
			ob_start();
			the_widget( $type, $atts, fire_department_prepare_widgets_args(fire_department_storage_get('widgets_args'), $id ? $id.'_widget' : 'widget_categories', 'widget_categories') );
			$output .= ob_get_contents();
			ob_end_clean();
			$output .= '</div>';
		}
		return apply_filters('fire_department_shortcode_output', $output, 'trx_widget_categories', $atts, $content);
	}
	fire_department_require_shortcode("trx_widget_categories", "fire_department_sc_widget_categories");
}


// Add [trx_widget_categories] in the VC shortcodes list
if (!function_exists('fire_department_widget_categories_reg_shortcodes_vc')) {
	//add_action('fire_department_action_shortcodes_list_vc','fire_department_widget_categories_reg_shortcodes_vc');
	function fire_department_widget_categories_reg_shortcodes_vc() {

		$posts_types = fire_department_get_list_posts_types(false);
		$categories = fire_department_get_list_terms(false, fire_department_get_taxonomy_categories_by_post_type('post'));

		vc_map( array(
				"base" => "trx_widget_categories",
				"name" => esc_html__("Widget Categories", 'fire-department'),
				"description" => wp_kses_data( __("Display the subcategories list for the specified category", 'fire-department') ),
				"category" => esc_html__('Content', 'fire-department'),
				"icon" => 'icon_trx_widget_categories',
				"class" => "trx_widget_categories",
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
						"param_name" => "count",
						"heading" => esc_html__("Show posts", 'fire-department'),
						"description" => wp_kses_data( __("Show posts number in the each category", 'fire-department') ),
						"class" => "",
						"std" => "1",
						"value" => array(esc_html__('Show posts number', 'fire-department') => "1"),
						"type" => "checkbox"
					),
					array(
						"param_name" => "dropdown",
						"heading" => esc_html__("Show dropdown", 'fire-department'),
						"description" => wp_kses_data( __("Show categories as dropdown list", 'fire-department') ),
						"class" => "",
						"std" => "0",
						"value" => array(esc_html__('Show dropdown', 'fire-department') => "1"),
						"type" => "checkbox"
					),
					array(
						"param_name" => "hierarchical",
						"heading" => esc_html__("Show hierarchical", 'fire-department'),
						"description" => wp_kses_data( __("Show categories as hierarchical list", 'fire-department') ),
						"class" => "",
						"std" => "1",
						"value" => array(esc_html__('Show hierarchical', 'fire-department') => "1"),
						"type" => "checkbox"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'fire-department'),
						"description" => wp_kses_data( __("Select post type to show", 'fire-department') ),
						"class" => "",
						"std" => "post",
						"value" => array_flip($posts_types),
						"type" => "dropdown"
					),
					array(
						"param_name" => "cat",
						"heading" => esc_html__("Parent category", 'fire-department'),
						"description" => wp_kses_data( __("Select parent category. If empty - show all categories", 'fire-department') ),
						"class" => "",
						"value" => array_flip(fire_department_array_merge(array(0 => esc_html__('- Select category -', 'fire-department')), $categories)),
						"type" => "dropdown"
					),
					fire_department_get_vc_param('id'),
					fire_department_get_vc_param('class'),
					fire_department_get_vc_param('css')
				)
			) );
			
		class WPBakeryShortCode_Trx_Widget_Categories extends WPBakeryShortCode {}

	}
}
?>