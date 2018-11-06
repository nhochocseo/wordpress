<?php
// Get template args
extract(fire_department_template_get_args('counters'));

$show_all_counters = false;
$counters_tag = is_single() ? 'span' : 'a';


// Views
if ($show_all_counters || fire_department_strpos($post_options['counters'], 'views')!==false) {
	?>
	<<?php echo trim($counters_tag); ?> class="post_counters_item post_counters_views icon-eye" title="<?php echo esc_attr( sprintf(__('Views - %s', 'fire-department'), $post_data['post_views']) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php echo trim($post_data['post_views']); ?></span><?php if (fire_department_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Views', 'fire-department'); ?></<?php echo trim($counters_tag); ?>>
	<?php
}

// Comments
if ($show_all_counters || fire_department_strpos($post_options['counters'], 'comments')!==false) {
	// if (fire_department_strpos($post_options['counters'], 'captions')!==false)
?>
	<a class="post_counters_item post_counters_comments" title="<?php echo esc_attr( sprintf(__('Comments - %s', 'fire-department'), $post_data['post_comments']) ); ?>" href="<?php echo esc_url($post_data['post_comments_link']); ?>"><span class="icon-chat-empty"></span><span class="post_counters_number"><?php echo trim($post_data['post_comments']); ?></span><?php  echo ' '.esc_html__('Comments', 'fire-department'); ?></a>  
	<?php 
}
 
// Rating
$rating = $post_data['post_reviews_'.(fire_department_get_theme_option('reviews_first')=='author' ? 'author' : 'users')];
if ($rating > 0 && ($show_all_counters || fire_department_strpos($post_options['counters'], 'rating')!==false)) { 
	?>
	<<?php echo trim($counters_tag); ?> class="post_counters_item post_counters_rating icon-star" title="<?php echo esc_attr( sprintf(__('Rating - %s', 'fire-department'), $rating) ); ?>" href="<?php echo esc_url($post_data['post_link']); ?>"><span class="post_counters_number"><?php echo trim($rating); ?></span></<?php echo trim($counters_tag); ?>>
	<?php
}

// Likes
if ($show_all_counters || fire_department_strpos($post_options['counters'], 'likes')!==false) {
	// Load core messages
	fire_department_enqueue_messages();
	$likes = isset($_COOKIE['fire_department_likes']) ? $_COOKIE['fire_department_likes'] : '';
	$allow = fire_department_strpos($likes, ','.($post_data['post_id']).',')===false;
	?>
	<a class="post_counters_item post_counters_likes icon-heart <?php echo !empty($allow) ? 'enabled' : 'disabled'; ?>" title="<?php echo !empty($allow) ? esc_attr__('Like', 'fire-department') : esc_attr__('Dislike', 'fire-department'); ?>" href="#"
		data-postid="<?php echo esc_attr($post_data['post_id']); ?>"
		data-likes="<?php echo esc_attr($post_data['post_likes']); ?>"
		data-title-like="<?php esc_attr_e('Like', 'fire-department'); ?>"
		data-title-dislike="<?php esc_attr_e('Dislike', 'fire-department'); ?>"><span class="post_counters_number"><?php echo trim($post_data['post_likes']); ?></span><?php if (fire_department_strpos($post_options['counters'], 'captions')!==false) echo ' '.esc_html__('Likes', 'fire-department'); ?></a>
	<?php
}

// Edit page link
if (fire_department_strpos($post_options['counters'], 'edit')!==false) {
	edit_post_link( esc_html__( 'Edit', 'fire-department' ), '<span class="post_edit edit-link">', '</span>' );
}

// Markup for search engines
if (is_single() && fire_department_strpos($post_options['counters'], 'markup')!==false) {
	?>
	<meta itemprop="interactionCount" content="User<?php echo esc_attr(fire_department_strpos($post_options['counters'],'comments')!==false ? 'Comments' : 'PageVisits'); ?>:<?php echo esc_attr(fire_department_strpos($post_options['counters'], 'comments')!==false ? $post_data['post_comments'] : $post_data['post_views']); ?>" />
	<?php
}
?>