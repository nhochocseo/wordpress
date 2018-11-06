<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_matches_1_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_matches_1_theme_setup', 1 );
	function fire_department_template_matches_1_theme_setup() {
		fire_department_add_template(array(
			'layout' => 'matches-1',
			'template' => 'matches-1',
			'mode'   => 'matches',
			'title'  => esc_html__('Matches /Style 1/', 'fire-department'),
			'thumb_title'  => esc_html__('Medium square image (crop)', 'fire-department'),
			'w' => 370,
			'h' => 370
		));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_matches_1_output' ) ) {
	function fire_department_template_matches_1_output($post_options, $post_data) {
		$show_title = true;
		$parts = explode('_', $post_options['layout']);
		$style = $parts[0];
		$columns = max(1, min(12, empty($parts[1]) ? (!empty($post_options['columns_count']) ? $post_options['columns_count'] : 1) : (int) $parts[1]));

		?>
			<li<?php echo !empty($post_options['tag_id']) ? ' id="'.esc_attr($post_options['tag_id']).'"' : ''; ?>
				class="sc_match sc_match_<?php echo esc_attr($post_options['number']) . ($post_options['number'] % 2 == 1 ? ' odd' : ' even') . ($post_options['number'] == 1 ? ' first' : '') . (!empty($post_options['tag_class']) ? ' '.esc_attr($post_options['tag_class']) : ''); ?>"
				<?php echo (!empty($post_options['tag_css']) ? ' style="'.esc_attr($post_options['tag_css']).'"' : '') 
					. (!fire_department_param_is_off($post_options['tag_animation']) ? ' data-animation="'.esc_attr(fire_department_get_animation_classes($post_options['tag_animation'])).'"' : ''); ?>>			
				<?php
				if (!$post_data['post_protected']) {
					$post_options['info_parts'] = array('snippets'=>true);
					fire_department_template_set_args('post-info', array(
						'post_options' => $post_options,
						'post_data' => $post_data
					));
					get_template_part(fire_department_get_file_slug('templates/trx_matches/_parts/match-info.php'));
					
					$post_meta = get_post_meta($post_data['post_id'], fire_department_storage_get('options_prefix') . '_post_options', true);
					$match_preview = !empty($post_meta['match_link']) && !fire_department_param_is_inherit($post_meta['match_link']) ? $post_meta['match_link'] : '';	
					$start_date = $post_meta['match_date'].' '.$post_meta['match_time'];
					$today = date("Y-m-d G:i");  
					$match_passed = false;
					if ($start_date > $today) {
						$match_passed = true;
					}
					if(!empty($match_preview) && $match_passed){
					?>
						<div class="match_preview"><a href="<?php echo esc_url($match_preview); ?>"><?php echo esc_html__("Go to the announcement &#8594;", 'fire-department'); ?></a></div>
					<?php
					} 
				}	
				?>
			</li>
		<?php
	}
}
?>