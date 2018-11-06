<?php
if (!function_exists('fire_department_theme_shortcodes_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_theme_shortcodes_setup', 1 );
	function fire_department_theme_shortcodes_setup() {
		add_filter('fire_department_filter_googlemap_styles', 'fire_department_theme_shortcodes_googlemap_styles');
	}
}


// Add theme-specific Google map styles
if ( !function_exists( 'fire_department_theme_shortcodes_googlemap_styles' ) ) {
	function fire_department_theme_shortcodes_googlemap_styles($list) {
		$list['simple']		= esc_html__('Simple', 'fire-department');
		$list['greyscale']	= esc_html__('Greyscale', 'fire-department');
		$list['inverse']	= esc_html__('Inverse', 'fire-department');
		$list['apple']		= esc_html__('Apple', 'fire-department');
		return $list;
	}
}
?>