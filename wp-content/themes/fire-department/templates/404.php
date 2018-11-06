<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_404_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_404_theme_setup', 1 );
	function fire_department_template_404_theme_setup() {
		fire_department_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_404_output' ) ) {
	function fire_department_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
                <img class="image-404" src="<?php echo( get_template_directory_uri()); ?>/images/404.png" alt="404">
                <h2 class="page_subtitle"><?php esc_html_e('The requested page cannot be found', 'fire-department'); ?></h2>
                <p class="page_description"><?php echo wp_kses_data( sprintf( __('Can\'t find what you need? Take a moment and do a search below or start from <a href="%s">our homepage</a>.', 'fire-department'), esc_url(home_url('/')) ) ); ?></p>
                <div class="page_search"><?php fire_department_show_layout(fire_department_sc_search(array('state'=>'fixed', 'title'=>__('To search type and hit enter', 'fire-department')))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>