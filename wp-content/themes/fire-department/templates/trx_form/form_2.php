<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_form_2_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_form_2_theme_setup', 1 );
	function fire_department_template_form_2_theme_setup() {
		fire_department_add_template(array(
			'layout' => 'form_2',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 2', 'fire-department')
			));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_form_2_output' ) ) {
	function fire_department_template_form_2_output($post_options, $post_data) {
		$address_1 = fire_department_get_theme_option('contact_address_1');
		$address_2 = fire_department_get_theme_option('contact_address_2');
		$phone = fire_department_get_theme_option('contact_phone');
		$fax = fire_department_get_theme_option('contact_fax');
		$email = fire_department_get_theme_option('contact_email');
		$open_hours = fire_department_get_theme_option('contact_open_hours');
		?>
		<div class="sc_columns columns_wrap">
			<div class="sc_form_fields column-1_2">


				<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'"' : ''; ?> data-formtype="<?php echo esc_attr($post_options['layout']); ?>" method="post" action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
					<?php fire_department_sc_form_show_fields($post_options['fields']); ?>
					<div class="sc_form_info">
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_username"><?php esc_html_e('Name', 'fire-department'); ?></label><input id="sc_form_username" type="text" name="username" aria-required="true" placeholder="<?php esc_attr_e('Name *', 'fire-department'); ?>"></div>
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_email"><?php esc_html_e('E-mail', 'fire-department'); ?></label><input id="sc_form_email" type="text" name="email" aria-required="true" placeholder="<?php esc_attr_e('E-mail *', 'fire-department'); ?>"></div>
						<div class="sc_form_item sc_form_field label_over"><label class="required" for="sc_form_subj"><?php esc_html_e('Subject', 'fire-department'); ?></label><input id="sc_form_subj" type="hidden" name="subject" value="subject" placeholder=""></div>
					</div>
					<div class="sc_form_item sc_form_message label_over"><label class="required" for="sc_form_message"><?php esc_html_e('Message', 'fire-department'); ?></label><textarea id="sc_form_message" name="message" placeholder="<?php esc_attr_e('Message', 'fire-department'); ?>"></textarea></div>
					<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Send Message', 'fire-department'); ?></button></div>
					<div class="result sc_infobox"></div>
				</form>
			</div><div class="sc_form_address column-1_2">
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Address:', 'fire-department'); ?></span>
					<span class="sc_form_address_data"><?php echo trim($address_1) . (!empty($address_1) && !empty($address_2) ? ', ' : '') . $address_2; ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Phone number:', 'fire-department'); ?></span>
					<span class="sc_form_address_data sc_form_phone"><?php echo trim($phone) . (!empty($phone) && !empty($fax) ? ', ' : '') . $fax; ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('Mail:', 'fire-department'); ?></span>
					<span class="sc_form_address_data"><?php echo trim($email); ?></span>
				</div>
				<div class="sc_form_address_field">
					<span class="sc_form_address_label"><?php esc_html_e('We are open:', 'fire-department'); ?></span>
					<span class="sc_form_address_data"><?php echo trim($open_hours); ?></span>
				</div>
				
				<?php echo do_shortcode('[trx_socials shape="round" size="tiny"][/trx_socials]'); ?>
			</div>
		</div>
		<?php
	}
}
?>