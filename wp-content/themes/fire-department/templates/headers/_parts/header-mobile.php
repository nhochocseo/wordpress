<?php
$header_options = fire_department_storage_get('header_mobile');
$contact_address_1 = trim(fire_department_get_custom_option('contact_address_1'));
$contact_address_2 = trim(fire_department_get_custom_option('contact_address_2'));
$contact_phone = trim(fire_department_get_custom_option('contact_phone'));
$contact_email = trim(fire_department_get_custom_option('contact_email'));
?>
	<div class="header_mobile">
		<div class="content_wrap">
			<div class="menu_button icon-menu"></div>
			<?php 
			fire_department_show_logo(); 
			if ($header_options['woo_cart']){
				if (function_exists('fire_department_exists_woocommerce') && fire_department_exists_woocommerce() && (fire_department_is_woocommerce_page() && fire_department_get_custom_option('show_cart')=='shop' || fire_department_get_custom_option('show_cart')=='always') && !(is_checkout() || is_cart() || defined('WOOCOMMERCE_CHECKOUT') || defined('WOOCOMMERCE_CART'))) { 
					?>
					<div class="menu_main_cart top_panel_icon">
						<?php get_template_part(fire_department_get_file_slug('templates/headers/_parts/contact-info-cart.php')); ?>
					</div>
					<?php
				}
			}
			?>
		</div>
		<div class="side_wrap">
			<div class="close"><?php esc_html_e('Close', 'fire-department'); ?></div>
			<div class="panel_top">
				<nav class="menu_main_nav_area">
					<?php
						$menu_main = fire_department_get_nav_menu('menu_main');
						if (empty($menu_main)) $menu_main = fire_department_get_nav_menu();
						$menu_main = fire_department_set_tag_attrib($menu_main, '<ul>', 'id', 'menu_mobile');
						fire_department_show_layout($menu_main);
					?>
				</nav>
				<?php 
				if ($header_options['search'] && fire_department_get_custom_option('show_search')=='yes')
					fire_department_show_layout(fire_department_sc_search(array()));
				
				if ($header_options['login']) {
					if ( is_user_logged_in() ) { 
						?>
						<div class="login"><a href="<?php echo esc_url(wp_logout_url(home_url('/'))); ?>" class="popup_link"><?php esc_html_e('Logout', 'fire-department'); ?></a></div>
						<?php
					} else {
						// Load core messages
						fire_department_enqueue_messages();
						// Load Popup engine
						fire_department_enqueue_popup();
						?><div class="login"><?php do_action('trx_utils_action_login'); ?></div><?php
						// Anyone can register ?
						if ( (int) get_option('users_can_register') > 0) {
							?><div class="login"><?php do_action('trx_utils_action_register'); ?></div><?php 
						}
					}
				}
				?>
			</div>
			
			<?php if ($header_options['contact_address'] || $header_options['contact_phone_email'] || $header_options['open_hours']) { ?>
			<div class="panel_middle">
				<?php
				if ($header_options['contact_address'] && (!empty($contact_address_1) || !empty($contact_address_2))) {
					?><div class="contact_field contact_address">
								<span class="contact_icon icon-home"></span>
								<span class="contact_label contact_address_1"><?php echo force_balance_tags($contact_address_1); ?></span>
								<span class="contact_address_2"><?php echo force_balance_tags($contact_address_2); ?></span>
							</div><?php
				}
						
				if ($header_options['contact_phone_email'] && (!empty($contact_phone) || !empty($contact_email))) {
					?><div class="contact_field contact_phone">
						<span class="contact_icon icon-phone"></span>
						<span class="contact_label contact_phone"><?php echo force_balance_tags($contact_phone); ?></span>
						<span class="contact_email"><?php echo force_balance_tags($contact_email); ?></span>
					</div><?php
				}
				
				fire_department_template_set_args('top-panel-top', array(
					'menu_user_id' => 'menu_user_mobile',
					'top_panel_top_components' => array(
						($header_options['open_hours'] ? 'open_hours' : '')
					)
				));
				get_template_part(fire_department_get_file_slug('templates/headers/_parts/top-panel-top.php'));
				?>
			</div>
			<?php } ?>

			<div class="panel_bottom">
				<?php if ($header_options['socials'] && fire_department_get_custom_option('show_socials')=='yes') { ?>
					<div class="contact_socials">
						<?php fire_department_show_layout(fire_department_sc_socials(array('size'=>'small'))); ?>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="mask"></div>
	</div>