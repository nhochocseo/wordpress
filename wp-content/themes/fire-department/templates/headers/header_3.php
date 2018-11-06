<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_header_3_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_header_3_theme_setup', 1 );
	function fire_department_template_header_3_theme_setup() {
		fire_department_add_template(array(
			'layout' => 'header_3',
			'mode'   => 'header',
			'title'  => esc_html__('Header 3', 'fire-department'),
			'icon'   => fire_department_get_file_url('templates/headers/images/3.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_header_3_output' ) ) {
	function fire_department_template_header_3_output($post_options, $post_data) {

		// WP custom header
		$header_css = '';
		if ($post_options['position'] != 'over') {
			$header_image = get_header_image();
			$header_css = $header_image!='' 
				? ' style="background: url('.esc_url($header_image).') repeat center top"' 
				: '';
		}
		?>
		
		<div class="top_panel_fixed_wrap"></div>

		<header class="top_panel_wrap top_panel_style_3 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_3 top_panel_position_<?php echo esc_attr(fire_department_get_custom_option('top_panel_position')); ?>">
			
			<?php if (fire_department_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
                        fire_department_template_set_args('top-panel-top', array(
                            'top_panel_top_components' => array('contact_info', 'search', 'login', 'socials', 'currency', 'bookmarks')
                        ));
                        get_template_part(fire_department_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php fire_department_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><div
						class="column-1_3 contact_logo">
							<?php fire_department_show_logo(true, true); ?>
						</div><div 
						class="column-2_3 menu_main_wrap">
							<a href="#" class="menu_main_responsive_button icon-menu"></a>
                            <nav class="menu_main_nav_area menu_hover_<?php echo esc_attr(fire_department_get_theme_option('menu_hover')); ?>">
                                <?php
                                $menu_main = fire_department_get_nav_menu('menu_main');
                                if (empty($menu_main)) $menu_main = fire_department_get_nav_menu();
                                fire_department_show_layout($menu_main);
                                ?>
                            </nav>
						
						</div>
					</div>
				</div>
			</div>

			</div>
		</header>

		<?php
		fire_department_storage_set('header_mobile', array(
                'open_hours' => false,
                'login' => false,
                'socials' => true,
                'bookmarks' => false,
                'contact_address' => false,
                'contact_phone_email' => false,
                'woo_cart' => false,
                'search' => false
			)
		);
	}
}
?>