<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('fire_department_mailchimp_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_mailchimp_theme_setup', 1 );
	function fire_department_mailchimp_theme_setup() {
		if (fire_department_exists_mailchimp()) {
			if (is_admin()) {
				add_filter( 'fire_department_filter_importer_options',				'fire_department_mailchimp_importer_set_options' );
				add_action( 'fire_department_action_importer_params',				'fire_department_mailchimp_importer_show_params', 10, 1 );
				add_filter( 'fire_department_filter_importer_import_row',			'fire_department_mailchimp_importer_check_row', 9, 4);
			}
		}
		if (is_admin()) {
			add_filter( 'fire_department_filter_importer_required_plugins',		'fire_department_mailchimp_importer_required_plugins', 10, 2 );
			add_filter( 'fire_department_filter_required_plugins',					'fire_department_mailchimp_required_plugins' );
		}
	}
}

// Check if Instagram Feed installed and activated
if ( !function_exists( 'fire_department_exists_mailchimp' ) ) {
	function fire_department_exists_mailchimp() {
		return function_exists('mc4wp_load_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'fire_department_mailchimp_required_plugins' ) ) {
	//add_filter('fire_department_filter_required_plugins',	'fire_department_mailchimp_required_plugins');
	function fire_department_mailchimp_required_plugins($list=array()) {
		if (in_array('mailchimp', fire_department_storage_get('required_plugins')))
			$list[] = array(
				'name' 		=> esc_html__('MailChimp for WP', 'fire-department'),
				'slug' 		=> 'mailchimp-for-wp',
				'required' 	=> false
			);
		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Mail Chimp in the required plugins
if ( !function_exists( 'fire_department_mailchimp_importer_required_plugins' ) ) {
	//add_filter( 'fire_department_filter_importer_required_plugins',	'fire_department_mailchimp_importer_required_plugins', 10, 2 );
	function fire_department_mailchimp_importer_required_plugins($not_installed='', $list='') {
		if (fire_department_strpos($list, 'mailchimp')!==false && !fire_department_exists_mailchimp() )
			$not_installed .= '<br>' . esc_html__('Mail Chimp', 'fire-department');
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'fire_department_mailchimp_importer_set_options' ) ) {
	//add_filter( 'fire_department_filter_importer_options',	'fire_department_mailchimp_importer_set_options' );
	function fire_department_mailchimp_importer_set_options($options=array()) {
		if ( in_array('mailchimp', fire_department_storage_get('required_plugins')) && fire_department_exists_mailchimp() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'mc4wp_lite_checkbox';
			$options['additional_options'][] = 'mc4wp_lite_form';
		}
		return $options;
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'fire_department_mailchimp_importer_show_params' ) ) {
	//add_action( 'fire_department_action_importer_params',	'fire_department_mailchimp_importer_show_params', 10, 1 );
	function fire_department_mailchimp_importer_show_params($importer) {
		if ( fire_department_exists_mailchimp() && in_array('mailchimp', fire_department_storage_get('required_plugins')) ) {
			$importer->show_importer_params(array(
				'slug' => 'mailchimp',
				'title' => esc_html__('Import MailChimp for WP', 'fire-department'),
				'part' => 1
			));
		}
	}
}

// Check if the row will be imported
if ( !function_exists( 'fire_department_mailchimp_importer_check_row' ) ) {
	//add_filter('fire_department_filter_importer_import_row', 'fire_department_mailchimp_importer_check_row', 9, 4);
	function fire_department_mailchimp_importer_check_row($flag, $table, $row, $list) {
		if ($flag || strpos($list, 'mailchimp')===false) return $flag;
		if ( fire_department_exists_mailchimp() ) {
			if ($table == 'posts')
				$flag = $row['post_type']=='mc4wp-form';
		}
		return $flag;
	}
}
?>