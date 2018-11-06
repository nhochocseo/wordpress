<?php
/**
 * Single post
 */
get_header(); 

$single_style = fire_department_storage_get('single_style');
if (empty($single_style)) $single_style = fire_department_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	fire_department_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !fire_department_param_is_off(fire_department_get_custom_option('show_sidebar_main')),
			'content' => fire_department_get_template_property($single_style, 'need_content'),
			'terms_list' => fire_department_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>