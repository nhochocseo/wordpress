<?php 
if (is_singular()) {
	if (fire_department_get_theme_option('use_ajax_views_counter')=='yes') {
		fire_department_storage_set_array('js_vars', 'ajax_views_counter', array(
			'post_id' => get_the_ID(),
			'post_views' => fire_department_get_post_views(get_the_ID())
		));
	} else
		fire_department_set_post_views(get_the_ID());
}
?>
