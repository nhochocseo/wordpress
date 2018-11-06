<?php
/**
 * Fire Department Framework: messages subsystem
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('fire_department_messages_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_messages_theme_setup' );
	function fire_department_messages_theme_setup() {
		// Core messages strings
		add_filter('fire_department_filter_localize_script', 'fire_department_messages_localize_script');
	}
}


/* Session messages
------------------------------------------------------------------------------------- */

if (!function_exists('fire_department_get_error_msg')) {
	function fire_department_get_error_msg() {
		return fire_department_storage_get('error_msg');
	}
}

if (!function_exists('fire_department_set_error_msg')) {
	function fire_department_set_error_msg($msg) {
		$msg2 = fire_department_get_error_msg();
		fire_department_storage_set('error_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('fire_department_get_success_msg')) {
	function fire_department_get_success_msg() {
		return fire_department_storage_get('success_msg');
	}
}

if (!function_exists('fire_department_set_success_msg')) {
	function fire_department_set_success_msg($msg) {
		$msg2 = fire_department_get_success_msg();
		fire_department_storage_set('success_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}

if (!function_exists('fire_department_get_notice_msg')) {
	function fire_department_get_notice_msg() {
		return fire_department_storage_get('notice_msg');
	}
}

if (!function_exists('fire_department_set_notice_msg')) {
	function fire_department_set_notice_msg($msg) {
		$msg2 = fire_department_get_notice_msg();
		fire_department_storage_set('notice_msg', trim($msg2) . ($msg2=='' ? '' : '<br />') . trim($msg));
	}
}


/* System messages (save when page reload)
------------------------------------------------------------------------------------- */
if (!function_exists('fire_department_set_system_message')) {
	function fire_department_set_system_message($msg, $status='info', $hdr='') {
		update_option(fire_department_storage_get('options_prefix') . '_message', array('message' => $msg, 'status' => $status, 'header' => $hdr));
	}
}

if (!function_exists('fire_department_get_system_message')) {
	function fire_department_get_system_message($del=false) {
		$msg = get_option(fire_department_storage_get('options_prefix') . '_message', false);
		if (!$msg)
			$msg = array('message' => '', 'status' => '', 'header' => '');
		else if ($del)
			fire_department_del_system_message();
		return $msg;
	}
}

if (!function_exists('fire_department_del_system_message')) {
	function fire_department_del_system_message() {
		delete_option(fire_department_storage_get('options_prefix') . '_message');
	}
}


/* Messages strings
------------------------------------------------------------------------------------- */

if (!function_exists('fire_department_messages_localize_script')) {
	//add_filter('fire_department_filter_localize_script', 'fire_department_messages_localize_script');
	function fire_department_messages_localize_script($vars) {
		$vars['strings'] = array(
			'ajax_error'		=> esc_html__('Invalid server answer', 'fire-department'),
			'bookmark_add'		=> esc_html__('Add the bookmark', 'fire-department'),
            'bookmark_added'	=> esc_html__('Current page has been successfully added to the bookmarks. You can see it in the right panel on the tab \'Bookmarks\'', 'fire-department'),
            'bookmark_del'		=> esc_html__('Delete this bookmark', 'fire-department'),
            'bookmark_title'	=> esc_html__('Enter bookmark title', 'fire-department'),
            'bookmark_exists'	=> esc_html__('Current page already exists in the bookmarks list', 'fire-department'),
			'search_error'		=> esc_html__('Error occurs in AJAX search! Please, type your query and press search icon for the traditional search way.', 'fire-department'),
			'email_confirm'		=> esc_html__('On the e-mail address "%s" we sent a confirmation email. Please, open it and click on the link.', 'fire-department'),
			'reviews_vote'		=> esc_html__('Thanks for your vote! New average rating is:', 'fire-department'),
			'reviews_error'		=> esc_html__('Error saving your vote! Please, try again later.', 'fire-department'),
			'error_like'		=> esc_html__('Error saving your like! Please, try again later.', 'fire-department'),
			'error_global'		=> esc_html__('Global error text', 'fire-department'),
			'name_empty'		=> esc_html__('The name can\'t be empty', 'fire-department'),
			'name_long'			=> esc_html__('Too long name', 'fire-department'),
			'email_empty'		=> esc_html__('Too short (or empty) email address', 'fire-department'),
			'email_long'		=> esc_html__('Too long email address', 'fire-department'),
			'email_not_valid'	=> esc_html__('Invalid email address', 'fire-department'),
			'subject_empty'		=> esc_html__('The subject can\'t be empty', 'fire-department'),
			'subject_long'		=> esc_html__('Too long subject', 'fire-department'),
			'text_empty'		=> esc_html__('The message text can\'t be empty', 'fire-department'),
			'text_long'			=> esc_html__('Too long message text', 'fire-department'),
			'send_complete'		=> esc_html__("Send message complete!", 'fire-department'),
			'send_error'		=> esc_html__('Transmit failed!', 'fire-department'),
			'geocode_error'			=> esc_html__('Geocode was not successful for the following reason:', 'fire-department'),
			'googlemap_not_avail'	=> esc_html__('Google map API not available!', 'fire-department'),
			'editor_save_success'	=> esc_html__("Post content saved!", 'fire-department'),
			'editor_save_error'		=> esc_html__("Error saving post data!", 'fire-department'),
			'editor_delete_post'	=> esc_html__("You really want to delete the current post?", 'fire-department'),
			'editor_delete_post_header'	=> esc_html__("Delete post", 'fire-department'),
			'editor_delete_success'	=> esc_html__("Post deleted!", 'fire-department'),
			'editor_delete_error'	=> esc_html__("Error deleting post!", 'fire-department'),
			'editor_caption_cancel'	=> esc_html__('Cancel', 'fire-department'),
			'editor_caption_close'	=> esc_html__('Close', 'fire-department')
			);
		return $vars;
	}
}
?>