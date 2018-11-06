<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_template_form_1_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_template_form_1_theme_setup', 1 );
	function fire_department_template_form_1_theme_setup() {
		fire_department_add_template(array(
			'layout' => 'form_1',
			'mode'   => 'forms',
			'title'  => esc_html__('Contact Form 1', 'fire-department')
			));
	}
}

// Template output
if ( !function_exists( 'fire_department_template_form_1_output' ) ) {
	function fire_department_template_form_1_output($post_options, $post_data) {
		$form_style = fire_department_get_theme_option('input_hover');
		?>
		<form <?php echo !empty($post_options['id']) ? ' id="'.esc_attr($post_options['id']).'_form"' : ''; ?>
			class="sc_input_hover_<?php echo esc_attr($form_style); ?>"
			data-formtype="<?php echo esc_attr($post_options['layout']); ?>"
			method="post"
			action="<?php echo esc_url($post_options['action'] ? $post_options['action'] : admin_url('admin-ajax.php')); ?>">
			<?php fire_department_sc_form_show_fields($post_options['fields']); ?>
			<div class="sc_form_info">
				<div class="sc_form_item sc_form_field label_over"><input id="sc_form_username" aria-required="true" type="text" name="username"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Name *', 'fire-department').'"'; ?> aria-required="true"><?php
					if ($form_style!='default') {
						?><label class="required" for="sc_form_username"><?php
							if ($form_style == 'path') {
								?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
							} else if ($form_style == 'iconed') {
								?><i class="sc_form_label_icon icon-user"></i><?php
							}
							?><span class="sc_form_label_content" data-content="<?php esc_html_e('Name', 'fire-department'); ?>"><?php esc_html_e('Name', 'fire-department'); ?></span><?php
						?></label><?php
					}
				?></div>
				<div class="sc_form_item sc_form_field label_over"><input id="sc_form_email" aria-required="true" type="text" name="email"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('E-mail *', 'fire-department').'"'; ?> aria-required="true"><?php
					if ($form_style!='default') {
						?><label class="required" for="sc_form_email"><?php
							if ($form_style == 'path') {
								?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
							} else if ($form_style == 'iconed') {
								?><i class="sc_form_label_icon icon-mail-empty"></i><?php
							}
							?><span class="sc_form_label_content" data-content="<?php esc_html_e('E-mail', 'fire-department'); ?>"><?php esc_html_e('E-mail', 'fire-department'); ?></span><?php
						?></label><?php
					}
				?></div>
<?php
// Remove condition to enable field 'Subject' in this form
if (false) { ?>
				<div class="sc_form_item sc_form_field label_over"><input id="sc_form_subj" type="text" name="subject"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Subject', 'fire-department').'"'; ?> aria-required="true"><?php
					if ($form_style!='default') {
						?><label class="required" for="sc_form_subj"><?php
							if ($form_style == 'path') {
								?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
							} else if ($form_style == 'iconed') {
								?><i class="sc_form_label_icon icon-menu"></i><?php
							}
							?><span class="sc_form_label_content" data-content="<?php esc_html_e('Subject', 'fire-department'); ?>"><?php esc_html_e('Subject', 'fire-department'); ?></span><?php
						?></label><?php
					}
				?></div>
<?php } ?>
			</div>
			<div class="sc_form_item sc_form_message"><textarea id="sc_form_message" name="message"<?php if ($form_style=='default') echo ' placeholder="'.esc_attr__('Message', 'fire-department').'"'; ?> aria-required="true"></textarea><?php
				if ($form_style!='default') {
					?><label class="required" for="sc_form_message"><?php
						if ($form_style == 'path') {
							?><svg class="sc_form_graphic" preserveAspectRatio="none" viewBox="0 0 404 77" height="100%" width="100%"><path d="m0,0l404,0l0,77l-404,0l0,-77z"></svg><?php
						} else if ($form_style == 'iconed') {
							?><i class="sc_form_label_icon icon-feather"></i><?php
						}
						?><span class="sc_form_label_content" data-content="<?php esc_html_e('Message', 'fire-department'); ?>"><?php esc_html_e('Message', 'fire-department'); ?></span><?php
					?></label><?php
				}
			?></div>
			<div class="sc_form_item sc_form_button"><button><?php esc_html_e('Send Message', 'fire-department'); ?></button></div>
			<div class="result sc_infobox"></div>
		</form>
		<?php
	}
}
?>