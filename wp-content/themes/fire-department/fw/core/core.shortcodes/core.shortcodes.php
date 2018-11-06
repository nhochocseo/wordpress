<?php
/**
 * Fire Department Framework: shortcodes manipulations
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('fire_department_sc_theme_setup')) {
	add_action( 'fire_department_action_init_theme', 'fire_department_sc_theme_setup', 1 );
	function fire_department_sc_theme_setup() {
		// Add sc stylesheets
		add_action('fire_department_action_add_styles', 'fire_department_sc_add_styles', 1);
	}
}

if (!function_exists('fire_department_sc_theme_setup2')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_sc_theme_setup2' );
	function fire_department_sc_theme_setup2() {

		if ( !is_admin() || isset($_POST['action']) ) {
			// Enable/disable shortcodes in excerpt
			add_filter('the_excerpt', 					'fire_department_sc_excerpt_shortcodes');
	
			// Prepare shortcodes in the content
			if (function_exists('fire_department_sc_prepare_content')) fire_department_sc_prepare_content();
		}

		// Add init script into shortcodes output in VC frontend editor
		add_filter('fire_department_shortcode_output', 'fire_department_sc_add_scripts', 10, 4);

		// AJAX: Send contact form data
		add_action('wp_ajax_send_form',			'fire_department_sc_form_send');
		add_action('wp_ajax_nopriv_send_form',	'fire_department_sc_form_send');

		// Show shortcodes list in admin editor
		add_action('media_buttons',				'fire_department_sc_selector_add_in_toolbar', 11);

	}
}


// Register shortcodes styles
if ( !function_exists( 'fire_department_sc_add_styles' ) ) {
	//add_action('fire_department_action_add_styles', 'fire_department_sc_add_styles', 1);
	function fire_department_sc_add_styles() {
		// Shortcodes
		fire_department_enqueue_style( 'fire_department-shortcodes-style',	fire_department_get_file_url('shortcodes/theme.shortcodes.css'), array(), null );
	}
}


// Register shortcodes init scripts
if ( !function_exists( 'fire_department_sc_add_scripts' ) ) {
	//add_filter('fire_department_shortcode_output', 'fire_department_sc_add_scripts', 10, 4);
	function fire_department_sc_add_scripts($output, $tag='', $atts=array(), $content='') {

		if (fire_department_storage_empty('shortcodes_scripts_added')) {
			fire_department_storage_set('shortcodes_scripts_added', true);
			fire_department_enqueue_script( 'fire_department-shortcodes-script', fire_department_get_file_url('shortcodes/theme.shortcodes.js'), array('jquery'), null, true );	
		}
		
		return $output;
	}
}


/* Prepare text for shortcodes
-------------------------------------------------------------------------------- */

// Prepare shortcodes in content
if (!function_exists('fire_department_sc_prepare_content')) {
	function fire_department_sc_prepare_content() {
		if (function_exists('fire_department_sc_clear_around')) {
			$filters = array(
				array('fire_department', 'sc', 'clear', 'around'),
				array('widget', 'text'),
				array('the', 'excerpt'),
				array('the', 'content')
			);
			if (function_exists('fire_department_exists_woocommerce') && fire_department_exists_woocommerce()) {
				$filters[] = array('woocommerce', 'template', 'single', 'excerpt');
				$filters[] = array('woocommerce', 'short', 'description');
			}
			if (is_array($filters) && count($filters) > 0) {
				foreach ($filters as $flt)
					add_filter(join('_', $flt), 'fire_department_sc_clear_around', 1);	// Priority 1 to clear spaces before do_shortcodes()
			}
		}
	}
}

// Enable/Disable shortcodes in the excerpt
if (!function_exists('fire_department_sc_excerpt_shortcodes')) {
	//add_filter('the_excerpt', 'fire_department_sc_excerpt_shortcodes');
	function fire_department_sc_excerpt_shortcodes($content) {
		if (!empty($content)) {
			$content = do_shortcode($content);
		}
		return $content;
	}
}



/*
// Remove spaces and line breaks between close and open shortcode brackets ][:
[trx_columns]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
	[trx_column_item]Column text ...[/trx_column_item]
[/trx_columns]

convert to

[trx_columns][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][trx_column_item]Column text ...[/trx_column_item][/trx_columns]
*/
if (!function_exists('fire_department_sc_clear_around')) {
	function fire_department_sc_clear_around($content) {
		if (!empty($content)) $content = preg_replace("/\](\s|\n|\r)*\[/", "][", $content);
		return $content;
	}
}






/* Shortcodes support utils
---------------------------------------------------------------------- */

// Fire Department shortcodes load scripts
if (!function_exists('fire_department_sc_load_scripts')) {
	function fire_department_sc_load_scripts() {
		static $loaded = false;
		if (!$loaded) {
			fire_department_enqueue_script( 'fire_department-shortcodes_admin-script', fire_department_get_file_url('core/core.shortcodes/shortcodes_admin.js'), array('jquery'), null, true );
			fire_department_enqueue_script( 'fire_department-selection-script',  fire_department_get_file_url('js/jquery.selection.js'), array('jquery'), null, true );
			wp_localize_script( 'fire_department-shortcodes_admin-script', 'FIRE_DEPARTMENT_SHORTCODES_DATA', fire_department_storage_get('shortcodes') );
			$loaded = true;
		}
	}
}

// Fire Department shortcodes prepare scripts
if (!function_exists('fire_department_sc_prepare_scripts')) {
	function fire_department_sc_prepare_scripts() {
		static $prepared = false;
		if (!$prepared) {
			fire_department_storage_set_array('js_vars', 'shortcodes_cp', is_admin() ? (!fire_department_storage_empty('to_colorpicker') ? fire_department_storage_get('to_colorpicker') : 'wp') : 'custom');	// wp | tiny | custom
			$prepared = true;
		}
	}
}

// Show shortcodes list in admin editor
if (!function_exists('fire_department_sc_selector_add_in_toolbar')) {
	//add_action('media_buttons','fire_department_sc_selector_add_in_toolbar', 11);
	function fire_department_sc_selector_add_in_toolbar(){

		if ( !fire_department_options_is_used() ) return;

		fire_department_sc_load_scripts();
		fire_department_sc_prepare_scripts();

		$shortcodes = fire_department_storage_get('shortcodes');
		$shortcodes_list = '<select class="sc_selector"><option value="">&nbsp;'.esc_html__('- Select Shortcode -', 'fire-department').'&nbsp;</option>';

		if (is_array($shortcodes) && count($shortcodes) > 0) {
			foreach ($shortcodes as $idx => $sc) {
				$shortcodes_list .= '<option value="'.esc_attr($idx).'" title="'.esc_attr($sc['desc']).'">'.esc_html($sc['title']).'</option>';
			}
		}

		$shortcodes_list .= '</select>';

		fire_department_show_layout($shortcodes_list);
	}
}

// Fire Department shortcodes builder settings
require_once FIRE_DEPARTMENT_FW_PATH . 'core/core.shortcodes/shortcodes_settings.php';

// VC shortcodes settings
if ( class_exists('WPBakeryShortCode') ) {
	require_once FIRE_DEPARTMENT_FW_PATH . 'core/core.shortcodes/shortcodes_vc.php';
}

// Fire Department shortcodes implementation
// Using get_template_part(), because shortcodes can be replaced in the child theme
get_template_part('shortcodes/trx_basic/anchor');
get_template_part('shortcodes/trx_basic/audio');
get_template_part('shortcodes/trx_basic/blogger');
get_template_part('shortcodes/trx_basic/br');
get_template_part('shortcodes/trx_basic/call_to_action');
get_template_part('shortcodes/trx_basic/chat');
get_template_part('shortcodes/trx_basic/columns');
get_template_part('shortcodes/trx_basic/content');
get_template_part('shortcodes/trx_basic/form');
get_template_part('shortcodes/trx_basic/googlemap');
get_template_part('shortcodes/trx_basic/hide');
get_template_part('shortcodes/trx_basic/image');
get_template_part('shortcodes/trx_basic/infobox');
get_template_part('shortcodes/trx_basic/intro');
get_template_part('shortcodes/trx_basic/line');
get_template_part('shortcodes/trx_basic/list');
get_template_part('shortcodes/trx_basic/price_block');
get_template_part('shortcodes/trx_basic/promo');
get_template_part('shortcodes/trx_basic/quote');
get_template_part('shortcodes/trx_basic/reviews');
get_template_part('shortcodes/trx_basic/search');
get_template_part('shortcodes/trx_basic/section');
get_template_part('shortcodes/trx_basic/skills');
get_template_part('shortcodes/trx_basic/slider');
get_template_part('shortcodes/trx_basic/socials');
get_template_part('shortcodes/trx_basic/table');
get_template_part('shortcodes/trx_basic/title');
get_template_part('shortcodes/trx_basic/twitter');
get_template_part('shortcodes/trx_basic/video');

get_template_part('shortcodes/trx_optional/accordion');
get_template_part('shortcodes/trx_optional/button');
get_template_part('shortcodes/trx_optional/countdown');
get_template_part('shortcodes/trx_optional/dropcaps');
get_template_part('shortcodes/trx_optional/gap');
get_template_part('shortcodes/trx_optional/highlight');
get_template_part('shortcodes/trx_optional/icon');
get_template_part('shortcodes/trx_optional/number');
get_template_part('shortcodes/trx_optional/parallax');
get_template_part('shortcodes/trx_optional/popup');
get_template_part('shortcodes/trx_optional/price');
get_template_part('shortcodes/trx_optional/tabs');
get_template_part('shortcodes/trx_optional/toggles');
get_template_part('shortcodes/trx_optional/tooltip');
get_template_part('shortcodes/trx_optional/zoom');
?>