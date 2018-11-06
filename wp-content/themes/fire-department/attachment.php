<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move fire_department_set_post_views to the javascript - counter will work under cache system
	if (fire_department_get_custom_option('use_ajax_views_counter')=='no') {
		fire_department_set_post_views(get_the_ID());
	}

	fire_department_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !fire_department_param_is_off(fire_department_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>