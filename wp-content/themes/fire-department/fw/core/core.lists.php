<?php
/**
 * Fire Department Framework: return lists
 *
 * @package fire_department
 * @since fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'fire_department_get_list_styles' ) ) {
	function fire_department_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'fire-department'), $i);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'fire_department_get_list_margins' ) ) {
	function fire_department_get_list_margins($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'fire-department'),
				'tiny'		=> esc_html__('Tiny',		'fire-department'),
				'small'		=> esc_html__('Small',		'fire-department'),
				'medium'	=> esc_html__('Medium',		'fire-department'),
				'large'		=> esc_html__('Large',		'fire-department'),
				'huge'		=> esc_html__('Huge',		'fire-department'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'fire-department'),
				'small-'	=> esc_html__('Small (negative)',	'fire-department'),
				'medium-'	=> esc_html__('Medium (negative)',	'fire-department'),
				'large-'	=> esc_html__('Large (negative)',	'fire-department'),
				'huge-'		=> esc_html__('Huge (negative)',	'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_margins', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'fire_department_get_list_line_styles' ) ) {
	function fire_department_get_list_line_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'fire-department'),
				'dashed'=> esc_html__('Dashed', 'fire-department'),
				'dotted'=> esc_html__('Dotted', 'fire-department'),
				'double'=> esc_html__('Double', 'fire-department'),
				'image'	=> esc_html__('Image', 'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_line_styles', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'fire_department_get_list_animations' ) ) {
	function fire_department_get_list_animations($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'fire-department'),
				'bounce'		=> esc_html__('Bounce',		'fire-department'),
				'elastic'		=> esc_html__('Elastic',	'fire-department'),
				'flash'			=> esc_html__('Flash',		'fire-department'),
				'flip'			=> esc_html__('Flip',		'fire-department'),
				'pulse'			=> esc_html__('Pulse',		'fire-department'),
				'rubberBand'	=> esc_html__('Rubber Band','fire-department'),
				'shake'			=> esc_html__('Shake',		'fire-department'),
				'swing'			=> esc_html__('Swing',		'fire-department'),
				'tada'			=> esc_html__('Tada',		'fire-department'),
				'wobble'		=> esc_html__('Wobble',		'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_animations', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'fire_department_get_list_animations_in' ) ) {
	function fire_department_get_list_animations_in($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'fire-department'),
				'bounceIn'			=> esc_html__('Bounce In',			'fire-department'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'fire-department'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'fire-department'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'fire-department'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'fire-department'),
				'elastic'			=> esc_html__('Elastic In',			'fire-department'),
				'fadeIn'			=> esc_html__('Fade In',			'fire-department'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'fire-department'),
				'fadeInUpSmall'		=> esc_html__('Fade In Up Small',	'fire-department'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'fire-department'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'fire-department'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'fire-department'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'fire-department'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'fire-department'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'fire-department'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'fire-department'),
				'flipInX'			=> esc_html__('Flip In X',			'fire-department'),
				'flipInY'			=> esc_html__('Flip In Y',			'fire-department'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'fire-department'),
				'rotateIn'			=> esc_html__('Rotate In',			'fire-department'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','fire-department'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'fire-department'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'fire-department'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','fire-department'),
				'rollIn'			=> esc_html__('Roll In',			'fire-department'),
				'slideInUp'			=> esc_html__('Slide In Up',		'fire-department'),
				'slideInDown'		=> esc_html__('Slide In Down',		'fire-department'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'fire-department'),
				'slideInRight'		=> esc_html__('Slide In Right',		'fire-department'),
				'wipeInLeftTop'		=> esc_html__('Wipe In Left Top',	'fire-department'),
				'zoomIn'			=> esc_html__('Zoom In',			'fire-department'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'fire-department'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'fire-department'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'fire-department'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_animations_in', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'fire_department_get_list_animations_out' ) ) {
	function fire_department_get_list_animations_out($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'fire-department'),
				'bounceOut'			=> esc_html__('Bounce Out',			'fire-department'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'fire-department'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',	'fire-department'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',	'fire-department'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'fire-department'),
				'fadeOut'			=> esc_html__('Fade Out',			'fire-department'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',		'fire-department'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',	'fire-department'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'fire-department'),
				'fadeOutDownSmall'	=> esc_html__('Fade Out Down Small','fire-department'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'fire-department'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'fire-department'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'fire-department'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'fire-department'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'fire-department'),
				'flipOutX'			=> esc_html__('Flip Out X',			'fire-department'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'fire-department'),
				'hinge'				=> esc_html__('Hinge Out',			'fire-department'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',	'fire-department'),
				'rotateOut'			=> esc_html__('Rotate Out',			'fire-department'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left','fire-department'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right','fire-department'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',	'fire-department'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right','fire-department'),
				'rollOut'			=> esc_html__('Roll Out',			'fire-department'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'fire-department'),
				'slideOutDown'		=> esc_html__('Slide Out Down',		'fire-department'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',		'fire-department'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'fire-department'),
				'zoomOut'			=> esc_html__('Zoom Out',			'fire-department'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'fire-department'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',		'fire-department'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',		'fire-department'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',		'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_animations_out', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('fire_department_get_animation_classes')) {
	function fire_department_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return fire_department_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!fire_department_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of the main menu hover effects
if ( !function_exists( 'fire_department_get_list_menu_hovers' ) ) {
	function fire_department_get_list_menu_hovers($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_menu_hovers'))=='') {
			$list = array(
				'fade'			=> esc_html__('Fade',		'fire-department'),
				'slide_line'	=> esc_html__('Slide Line',	'fire-department'),
				'slide_box'		=> esc_html__('Slide Box',	'fire-department'),
				'zoom_line'		=> esc_html__('Zoom Line',	'fire-department'),
				'path_line'		=> esc_html__('Path Line',	'fire-department'),
				'roll_down'		=> esc_html__('Roll Down',	'fire-department'),
				'color_line'	=> esc_html__('Color Line',	'fire-department'),
				);
			$list = apply_filters('fire_department_filter_list_menu_hovers', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_menu_hovers', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the button's hover effects
if ( !function_exists( 'fire_department_get_list_button_hovers' ) ) {
	function fire_department_get_list_button_hovers($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_button_hovers'))=='') {
			$list = array(
				'default'		=> esc_html__('Default',			'fire-department'),
				'fade'			=> esc_html__('Fade',				'fire-department'),
				'slide_left'	=> esc_html__('Slide from Left',	'fire-department'),
				'slide_top'		=> esc_html__('Slide from Top',		'fire-department'),
				'arrow'			=> esc_html__('Arrow',				'fire-department'),
				);
			$list = apply_filters('fire_department_filter_list_button_hovers', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_button_hovers', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the input field's hover effects
if ( !function_exists( 'fire_department_get_list_input_hovers' ) ) {
	function fire_department_get_list_input_hovers($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_input_hovers'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'fire-department'),
				'accent'	=> esc_html__('Accented',	'fire-department'),
				'path'		=> esc_html__('Path',		'fire-department'),
				'jump'		=> esc_html__('Jump',		'fire-department'),
				'underline'	=> esc_html__('Underline',	'fire-department'),
				'iconed'	=> esc_html__('Iconed',		'fire-department'),
				);
			$list = apply_filters('fire_department_filter_list_input_hovers', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_input_hovers', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the search field's styles
if ( !function_exists( 'fire_department_get_list_search_styles' ) ) {
	function fire_department_get_list_search_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_search_styles'))=='') {
			$list = array(
				'default'	=> esc_html__('Default',	'fire-department'),
				'fullscreen'=> esc_html__('Fullscreen',	'fire-department'),
				'slide'		=> esc_html__('Slide',		'fire-department'),
				'expand'	=> esc_html__('Expand',		'fire-department'),
				);
			$list = apply_filters('fire_department_filter_list_search_styles', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_search_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of categories
if ( !function_exists( 'fire_department_get_list_categories' ) ) {
	function fire_department_get_list_categories($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'fire_department_get_list_terms' ) ) {
	function fire_department_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = fire_department_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = fire_department_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'fire_department_get_list_posts_types' ) ) {
	function fire_department_get_list_posts_types($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_posts_types'))=='') {
			// Return only theme inheritance supported post types
			$list = apply_filters('fire_department_filter_list_post_types', array());
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'fire_department_get_list_posts' ) ) {
	function fire_department_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = fire_department_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'fire-department');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set($hash, $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'fire_department_get_list_pages' ) ) {
	function fire_department_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return fire_department_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'fire_department_get_list_users' ) ) {
	function fire_department_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = fire_department_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'fire-department');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_users', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'fire_department_get_list_sliders' ) ) {
	function fire_department_get_list_sliders($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'fire-department')
			);
			$list = apply_filters('fire_department_filter_list_sliders', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'fire_department_get_list_slider_controls' ) ) {
	function fire_department_get_list_slider_controls($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'fire-department'),
				'side'		=> esc_html__('Side', 'fire-department'),
				'bottom'	=> esc_html__('Bottom', 'fire-department'),
				'pagination'=> esc_html__('Pagination', 'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_slider_controls', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'fire_department_get_slider_controls_classes' ) ) {
	function fire_department_get_slider_controls_classes($controls) {
		if (fire_department_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'fire_department_get_list_popup_engines' ) ) {
	function fire_department_get_list_popup_engines($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'fire-department'),
				"magnific"	=> esc_html__("Magnific popup", 'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_popup_engines', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'fire_department_get_list_menus' ) ) {
	function fire_department_get_list_menus($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'fire-department');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'fire_department_get_list_sidebars' ) ) {
	function fire_department_get_list_sidebars($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_sidebars'))=='') {
			if (($list = fire_department_storage_get('registered_sidebars'))=='') $list = array();
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'fire_department_get_list_sidebars_positions' ) ) {
	function fire_department_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'fire-department'),
				'left'  => esc_html__('Left',  'fire-department'),
				'right' => esc_html__('Right', 'fire-department')
				);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'fire_department_get_sidebar_class' ) ) {
	function fire_department_get_sidebar_class() {
		$sb_main = fire_department_get_custom_option('show_sidebar_main');
		$sb_outer = fire_department_get_custom_option('show_sidebar_outer');
		return (fire_department_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (fire_department_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_body_styles' ) ) {
	function fire_department_get_list_body_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'fire-department'),
				'wide'	=> esc_html__('Wide',		'fire-department')
				);
			if (fire_department_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'fire-department');
				$list['fullscreen']	= esc_html__('Fullscreen',	'fire-department');
			}
			$list = apply_filters('fire_department_filter_list_body_styles', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return templates list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates' ) ) {
	function fire_department_get_list_templates($mode='') {
		if (($list = fire_department_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = fire_department_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: fire_department_strtoproper($v['layout'])
										);
				}
			}
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates_blog' ) ) {
	function fire_department_get_list_templates_blog($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_templates_blog'))=='') {
			$list = fire_department_get_list_templates('blog');
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates_blogger' ) ) {
	function fire_department_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_templates_blogger'))=='') {
			$list = fire_department_array_merge(fire_department_get_list_templates('blogger'), fire_department_get_list_templates('blog'));
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates_single' ) ) {
	function fire_department_get_list_templates_single($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_templates_single'))=='') {
			$list = fire_department_get_list_templates('single');
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates_header' ) ) {
	function fire_department_get_list_templates_header($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_templates_header'))=='') {
			$list = fire_department_get_list_templates('header');
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_templates_forms' ) ) {
	function fire_department_get_list_templates_forms($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_templates_forms'))=='') {
			$list = fire_department_get_list_templates('forms');
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_article_styles' ) ) {
	function fire_department_get_list_article_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'fire-department'),
				"stretch" => esc_html__('Stretch', 'fire-department')
				);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'fire_department_get_list_post_formats_filters' ) ) {
	function fire_department_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'fire-department'),
				"thumbs"  => esc_html__('With thumbs', 'fire-department'),
				"reviews" => esc_html__('With reviews', 'fire-department'),
				"video"   => esc_html__('With videos', 'fire-department'),
				"audio"   => esc_html__('With audios', 'fire-department'),
				"gallery" => esc_html__('With galleries', 'fire-department')
				);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'fire_department_get_list_portfolio_filters' ) ) {
	function fire_department_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'fire-department'),
				"tags"		=> esc_html__('Tags', 'fire-department'),
				"categories"=> esc_html__('Categories', 'fire-department')
				);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_hovers' ) ) {
	function fire_department_get_list_hovers($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'fire-department');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'fire-department');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'fire-department');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'fire-department');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'fire-department');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'fire-department');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'fire-department');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'fire-department');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'fire-department');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'fire-department');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'fire-department');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'fire-department');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'fire-department');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'fire-department');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'fire-department');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'fire-department');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'fire-department');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'fire-department');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'fire-department');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'fire-department');
			$list['square effect1']  = esc_html__('Square Effect 1',  'fire-department');
			$list['square effect2']  = esc_html__('Square Effect 2',  'fire-department');
			$list['square effect3']  = esc_html__('Square Effect 3',  'fire-department');
			$list['square effect5']  = esc_html__('Square Effect 5',  'fire-department');
			$list['square effect6']  = esc_html__('Square Effect 6',  'fire-department');
			$list['square effect7']  = esc_html__('Square Effect 7',  'fire-department');
			$list['square effect8']  = esc_html__('Square Effect 8',  'fire-department');
			$list['square effect9']  = esc_html__('Square Effect 9',  'fire-department');
			$list['square effect10'] = esc_html__('Square Effect 10',  'fire-department');
			$list['square effect11'] = esc_html__('Square Effect 11',  'fire-department');
			$list['square effect12'] = esc_html__('Square Effect 12',  'fire-department');
			$list['square effect13'] = esc_html__('Square Effect 13',  'fire-department');
			$list['square effect14'] = esc_html__('Square Effect 14',  'fire-department');
			$list['square effect15'] = esc_html__('Square Effect 15',  'fire-department');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'fire-department');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'fire-department');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'fire-department');
			$list['square effect_more']  = esc_html__('Square Effect More',  'fire-department');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'fire-department');
			$list['square effect_pull']  = esc_html__('Square Effect Pull',  'fire-department');
			$list['square effect_slide'] = esc_html__('Square Effect Slide', 'fire-department');
			$list['square effect_border'] = esc_html__('Square Effect Border', 'fire-department');
			$list = apply_filters('fire_department_filter_portfolio_hovers', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'fire_department_get_list_blog_counters' ) ) {
	function fire_department_get_list_blog_counters($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'fire-department'),
				'likes'		=> esc_html__('Likes', 'fire-department'),
				'rating'	=> esc_html__('Rating', 'fire-department'),
				'comments'	=> esc_html__('Comments', 'fire-department')
				);
			$list = apply_filters('fire_department_filter_list_blog_counters', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'fire_department_get_list_alter_sizes' ) ) {
	function fire_department_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'fire-department'),
					'1_2' => esc_html__('1x2', 'fire-department'),
					'2_1' => esc_html__('2x1', 'fire-department'),
					'2_2' => esc_html__('2x2', 'fire-department'),
					'1_3' => esc_html__('1x3', 'fire-department'),
					'2_3' => esc_html__('2x3', 'fire-department'),
					'3_1' => esc_html__('3x1', 'fire-department'),
					'3_2' => esc_html__('3x2', 'fire-department'),
					'3_3' => esc_html__('3x3', 'fire-department')
					);
			$list = apply_filters('fire_department_filter_portfolio_alter_sizes', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'fire_department_get_list_hovers_directions' ) ) {
	function fire_department_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'fire-department'),
				'right_to_left' => esc_html__('Right to Left',  'fire-department'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'fire-department'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'fire-department'),
				'scale_up'      => esc_html__('Scale Up',  'fire-department'),
				'scale_down'    => esc_html__('Scale Down',  'fire-department'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'fire-department'),
				'from_left_and_right' => esc_html__('From Left and Right',  'fire-department'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'fire-department')
			);
			$list = apply_filters('fire_department_filter_portfolio_hovers_directions', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'fire_department_get_list_label_positions' ) ) {
	function fire_department_get_list_label_positions($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'fire-department'),
				'bottom'	=> esc_html__('Bottom',		'fire-department'),
				'left'		=> esc_html__('Left',		'fire-department'),
				'over'		=> esc_html__('Over',		'fire-department')
			);
			$list = apply_filters('fire_department_filter_label_positions', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'fire_department_get_list_bg_image_positions' ) ) {
	function fire_department_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'fire-department'),
				'center top'   => esc_html__("Center Top", 'fire-department'),
				'right top'    => esc_html__("Right Top", 'fire-department'),
				'left center'  => esc_html__("Left Center", 'fire-department'),
				'center center'=> esc_html__("Center Center", 'fire-department'),
				'right center' => esc_html__("Right Center", 'fire-department'),
				'left bottom'  => esc_html__("Left Bottom", 'fire-department'),
				'center bottom'=> esc_html__("Center Bottom", 'fire-department'),
				'right bottom' => esc_html__("Right Bottom", 'fire-department')
			);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'fire_department_get_list_bg_image_repeats' ) ) {
	function fire_department_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'fire-department'),
				'repeat-x'	=> esc_html__('Repeat X', 'fire-department'),
				'repeat-y'	=> esc_html__('Repeat Y', 'fire-department'),
				'no-repeat'	=> esc_html__('No Repeat', 'fire-department')
			);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'fire_department_get_list_bg_image_attachments' ) ) {
	function fire_department_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'fire-department'),
				'fixed'		=> esc_html__('Fixed', 'fire-department'),
				'local'		=> esc_html__('Local', 'fire-department')
			);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'fire_department_get_list_bg_tints' ) ) {
	function fire_department_get_list_bg_tints($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'fire-department'),
				'light'	=> esc_html__('Light', 'fire-department'),
				'dark'	=> esc_html__('Dark', 'fire-department')
			);
			$list = apply_filters('fire_department_filter_bg_tints', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'fire_department_get_list_field_types' ) ) {
	function fire_department_get_list_field_types($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'fire-department'),
				'textarea' => esc_html__('Text Area','fire-department'),
				'password' => esc_html__('Password',  'fire-department'),
				'radio'    => esc_html__('Radio',  'fire-department'),
				'checkbox' => esc_html__('Checkbox',  'fire-department'),
				'select'   => esc_html__('Select',  'fire-department'),
				'date'     => esc_html__('Date','fire-department'),
				'time'     => esc_html__('Time','fire-department'),
				'button'   => esc_html__('Button','fire-department')
			);
			$list = apply_filters('fire_department_filter_field_types', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'fire_department_get_list_googlemap_styles' ) ) {
	function fire_department_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'fire-department')
			);
			$list = apply_filters('fire_department_filter_googlemap_styles', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return images list
if (!function_exists('fire_department_get_list_images')) {
	function fire_department_get_list_images($folder, $ext='', $only_names=false) {
		return function_exists('trx_utils_get_folder_list') ? trx_utils_get_folder_list($folder, $ext, $only_names) : array();
	}
}

// Return iconed classes list
if ( !function_exists( 'fire_department_get_list_icons' ) ) {
	function fire_department_get_list_icons($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_icons'))=='') {
			$list = fire_department_parse_icons_classes(fire_department_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? array_merge(array('inherit'), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'fire_department_get_list_socials' ) ) {
	function fire_department_get_list_socials($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_socials'))=='') {
			$list = fire_department_get_list_images("images/socials", "png");
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'fire_department_get_list_yesno' ) ) {
	function fire_department_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'fire-department'),
			'no'  => esc_html__("No", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'fire_department_get_list_onoff' ) ) {
	function fire_department_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'fire-department'),
			"off" => esc_html__("Off", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'fire_department_get_list_showhide' ) ) {
	function fire_department_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'fire-department'),
			"hide" => esc_html__("Hide", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'fire_department_get_list_orderings' ) ) {
	function fire_department_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'fire-department'),
			"desc" => esc_html__("Descending", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'fire_department_get_list_directions' ) ) {
	function fire_department_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'fire-department'),
			"vertical" => esc_html__("Vertical", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'fire_department_get_list_shapes' ) ) {
	function fire_department_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'fire-department'),
			"square" => esc_html__("Square", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'fire_department_get_list_sizes' ) ) {
	function fire_department_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'fire-department'),
			"small"  => esc_html__("Small", 'fire-department'),
			"medium" => esc_html__("Medium", 'fire-department'),
			"large"  => esc_html__("Large", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'fire_department_get_list_controls' ) ) {
	function fire_department_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'fire-department'),
			"side" => esc_html__("Side", 'fire-department'),
			"bottom" => esc_html__("Bottom", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'fire_department_get_list_floats' ) ) {
	function fire_department_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'fire-department'),
			"left" => esc_html__("Float Left", 'fire-department'),
			"right" => esc_html__("Float Right", 'fire-department')
		);
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'fire_department_get_list_alignments' ) ) {
	function fire_department_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'fire-department'),
			"left" => esc_html__("Left", 'fire-department'),
			"center" => esc_html__("Center", 'fire-department'),
			"right" => esc_html__("Right", 'fire-department')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'fire-department');
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'fire_department_get_list_hpos' ) ) {
	function fire_department_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'fire-department');
		if ($center) $list['center'] = esc_html__("Center", 'fire-department');
		$list['right'] = esc_html__("Right", 'fire-department');
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'fire_department_get_list_vpos' ) ) {
	function fire_department_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'fire-department');
		if ($center) $list['center'] = esc_html__("Center", 'fire-department');
		$list['bottom'] = esc_html__("Bottom", 'fire-department');
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'fire_department_get_list_sortings' ) ) {
	function fire_department_get_list_sortings($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'fire-department'),
				"title" => esc_html__("Alphabetically", 'fire-department'),
				"views" => esc_html__("Popular (views count)", 'fire-department'),
				"comments" => esc_html__("Most commented (comments count)", 'fire-department'),
				"author_rating" => esc_html__("Author rating", 'fire-department'),
				"users_rating" => esc_html__("Visitors (users) rating", 'fire-department'),
				"random" => esc_html__("Random", 'fire-department')
			);
			$list = apply_filters('fire_department_filter_list_sortings', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'fire_department_get_list_columns' ) ) {
	function fire_department_get_list_columns($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'fire-department'),
				"1_1" => esc_html__("100%", 'fire-department'),
				"1_2" => esc_html__("1/2", 'fire-department'),
				"1_3" => esc_html__("1/3", 'fire-department'),
				"2_3" => esc_html__("2/3", 'fire-department'),
				"1_4" => esc_html__("1/4", 'fire-department'),
				"3_4" => esc_html__("3/4", 'fire-department'),
				"1_5" => esc_html__("1/5", 'fire-department'),
				"2_5" => esc_html__("2/5", 'fire-department'),
				"3_5" => esc_html__("3/5", 'fire-department'),
				"4_5" => esc_html__("4/5", 'fire-department'),
				"1_6" => esc_html__("1/6", 'fire-department'),
				"5_6" => esc_html__("5/6", 'fire-department'),
				"1_7" => esc_html__("1/7", 'fire-department'),
				"2_7" => esc_html__("2/7", 'fire-department'),
				"3_7" => esc_html__("3/7", 'fire-department'),
				"4_7" => esc_html__("4/7", 'fire-department'),
				"5_7" => esc_html__("5/7", 'fire-department'),
				"6_7" => esc_html__("6/7", 'fire-department'),
				"1_8" => esc_html__("1/8", 'fire-department'),
				"3_8" => esc_html__("3/8", 'fire-department'),
				"5_8" => esc_html__("5/8", 'fire-department'),
				"7_8" => esc_html__("7/8", 'fire-department'),
				"1_9" => esc_html__("1/9", 'fire-department'),
				"2_9" => esc_html__("2/9", 'fire-department'),
				"4_9" => esc_html__("4/9", 'fire-department'),
				"5_9" => esc_html__("5/9", 'fire-department'),
				"7_9" => esc_html__("7/9", 'fire-department'),
				"8_9" => esc_html__("8/9", 'fire-department'),
				"1_10"=> esc_html__("1/10", 'fire-department'),
				"3_10"=> esc_html__("3/10", 'fire-department'),
				"7_10"=> esc_html__("7/10", 'fire-department'),
				"9_10"=> esc_html__("9/10", 'fire-department'),
				"1_11"=> esc_html__("1/11", 'fire-department'),
				"2_11"=> esc_html__("2/11", 'fire-department'),
				"3_11"=> esc_html__("3/11", 'fire-department'),
				"4_11"=> esc_html__("4/11", 'fire-department'),
				"5_11"=> esc_html__("5/11", 'fire-department'),
				"6_11"=> esc_html__("6/11", 'fire-department'),
				"7_11"=> esc_html__("7/11", 'fire-department'),
				"8_11"=> esc_html__("8/11", 'fire-department'),
				"9_11"=> esc_html__("9/11", 'fire-department'),
				"10_11"=> esc_html__("10/11", 'fire-department'),
				"1_12"=> esc_html__("1/12", 'fire-department'),
				"5_12"=> esc_html__("5/12", 'fire-department'),
				"7_12"=> esc_html__("7/12", 'fire-department'),
				"10_12"=> esc_html__("10/12", 'fire-department'),
				"11_12"=> esc_html__("11/12", 'fire-department')
			);
			$list = apply_filters('fire_department_filter_list_columns', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'fire_department_get_list_dedicated_locations' ) ) {
	function fire_department_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'fire-department'),
				"center"  => esc_html__('Above the text of the post', 'fire-department'),
				"left"    => esc_html__('To the left the text of the post', 'fire-department'),
				"right"   => esc_html__('To the right the text of the post', 'fire-department'),
				"alter"   => esc_html__('Alternates for each post', 'fire-department')
			);
			$list = apply_filters('fire_department_filter_list_dedicated_locations', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'fire_department_get_post_format_name' ) ) {
	function fire_department_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'fire-department') : esc_html__('galleries', 'fire-department');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'fire-department') : esc_html__('videos', 'fire-department');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'fire-department') : esc_html__('audios', 'fire-department');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'fire-department') : esc_html__('images', 'fire-department');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'fire-department') : esc_html__('quotes', 'fire-department');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'fire-department') : esc_html__('links', 'fire-department');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'fire-department') : esc_html__('statuses', 'fire-department');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'fire-department') : esc_html__('asides', 'fire-department');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'fire-department') : esc_html__('chats', 'fire-department');
		else						$name = $single ? esc_html__('standard', 'fire-department') : esc_html__('standards', 'fire-department');
		return apply_filters('fire_department_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'fire_department_get_post_format_icon' ) ) {
	function fire_department_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('fire_department_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'fire_department_get_list_fonts_styles' ) ) {
	function fire_department_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','fire-department'),
				'u' => esc_html__('U', 'fire-department')
			);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'fire_department_get_list_fonts' ) ) {
	function fire_department_get_list_fonts($prepend_inherit=false) {
		if (($list = fire_department_storage_get('list_fonts'))=='') {
			$list = array();
			$list = fire_department_array_merge($list, fire_department_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>fire_department_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list = fire_department_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('fire_department_filter_list_fonts', $list);
			if (fire_department_get_theme_setting('use_list_cache')) fire_department_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? fire_department_array_merge(array('inherit' => esc_html__("Inherit", 'fire-department')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'fire_department_get_list_font_faces' ) ) {
	function fire_department_get_list_font_faces($prepend_inherit=false) {
		static $list = false;
		if (is_array($list)) return $list;
		$fonts = fire_department_storage_get('required_custom_fonts');
		$list = array();
		if (is_array($fonts)) {
			foreach ($fonts as $font) {
				if (($url = fire_department_get_file_url('css/font-face/'.trim($font).'/stylesheet.css'))!='') {
					$list[sprintf(esc_html__('%s (uploaded font)', 'fire-department'), $font)] = array('css' => $url);
				}
			}
		}
		return $list;
	}
}
?>