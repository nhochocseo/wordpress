<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_header_2_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_header_2_theme_setup', 1 );
	function fire_department_template_header_2_theme_setup() {
		fire_department_add_template(array(
			'layout' => 'header_2',
			'mode'   => 'header',
			'title'  => esc_html__('Header 2', 'fire-department'),
			'icon'   => fire_department_get_file_url('templates/headers/images/2.jpg')
			));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_header_2_output' ) ) {
	function fire_department_template_header_2_output($post_options, $post_data) {

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

		<header class="top_panel_wrap top_panel_style_2 scheme_<?php echo esc_attr($post_options['scheme']); ?>">
			<div class="top_panel_wrap_inner top_panel_inner_style_2 top_panel_position_<?php echo esc_attr(fire_department_get_custom_option('top_panel_position')); ?>">
			
			<?php if (fire_department_get_custom_option('show_top_panel_top')=='yes') { ?>
				<div class="top_panel_top">
					<div class="content_wrap clearfix">
						<?php
                        fire_department_template_set_args('top-panel-top', array(
                            'top_panel_top_components' => array('contact_info', 'open_hours', 'login', 'socials', 'currency', 'bookmarks')
                        ));
                        get_template_part(fire_department_get_file_slug('templates/headers/_parts/top-panel-top.php'));
						?>
					</div>
				</div>
			<?php } ?>

			<div class="top_panel_middle" <?php fire_department_show_layout($header_css); ?>>
				<div class="content_wrap">
					<div class="columns_wrap columns_fluid"><?php
					
						?><div class="column-1_2 contact_logo">
							<?php fire_department_show_logo(); ?>
						</div><?php
						// Woocommerce Cart
						if (function_exists('fire_department_exists_woocommerce') && fire_department_exists_woocommerce() && (fire_department_is_woocommerce_page() && fire_department_get_custom_option('show_cart')=='shop' || fire_department_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) {
							?><div class="column-1_4 contact_field contact_cart"><?php require_once fire_department_get_file_dir('templates/headers/_parts/contact-info-cart.php'); ?></div><?php
						}
						?></div>
				</div>
			</div>

			<div class="top_panel_bottom">
				<div class="content_wrap clearfix">
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