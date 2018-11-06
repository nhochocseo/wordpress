<?php
/**
 * Fire Department Framework: Theme specific actions
 *
 * @package	fire_department
 * @since	fire_department 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'fire_department_core_theme_setup' ) ) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_core_theme_setup', 11 );
	function fire_department_core_theme_setup() {

		// Add default posts and comments RSS feed links to head 
		add_theme_support( 'automatic-feed-links' );
		
		// Enable support for Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		
		// Custom header setup
		add_theme_support( 'custom-header', array('header-text'=>false));
		
		// Custom backgrounds setup
		add_theme_support( 'custom-background');
		
		// Supported posts formats
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') ); 
 
 		// Autogenerate title tag
		add_theme_support('title-tag');
 		
		// Add user menu
		add_theme_support('nav-menus');
		
		// WooCommerce Support
		add_theme_support( 'woocommerce' );
		
		// Editor custom stylesheet - for user
		add_editor_style(fire_department_get_file_url('css/editor-style.css'));	
		
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		load_theme_textdomain( 'fire-department', fire_department_get_folder_dir('languages') );


		/* Front and Admin actions and filters:
		------------------------------------------------------------------------ */

		if ( !is_admin() ) {
			
			/* Front actions and filters:
			------------------------------------------------------------------------ */
	
			// Filters wp_title to print a neat <title> tag based on what is being viewed
			if (floatval(get_bloginfo('version')) < "4.1") {
				add_action('wp_head',						'fire_department_wp_title_show');
				add_filter('wp_title',						'fire_department_wp_title_modify', 10, 2);
			}

			// Prepare logo text
			add_filter('fire_department_filter_prepare_logo_text',	'fire_department_prepare_logo_text', 10, 1);
	
			// Add class "widget_number_#' for each widget
			add_filter('dynamic_sidebar_params', 			'fire_department_add_widget_number', 10, 1);

			// Enqueue scripts and styles
			add_action('wp_enqueue_scripts', 				'fire_department_core_frontend_scripts');
			add_filter('fire_department_filter_localize_script',	'fire_department_core_localize_script');

			// Additional data to the footer
			add_action('wp_footer',		 					'fire_department_core_frontend_add_code', 1);
			add_action('wp_footer',		 					'fire_department_core_frontend_add_vars', 2);
			add_action('fire_department_action_add_code',			'fire_department_core_action_add_code');

			add_filter('style_loader_tag', 					'fire_department_core_add_property_to_link', 10, 3);

			// Prepare theme core global variables
			add_action('fire_department_action_prepare_globals',	'fire_department_core_prepare_globals');
		}

		// Frontend editor: Save post data
		add_action('wp_ajax_frontend_editor_save',		'fire_department_callback_frontend_editor_save');
		add_action('wp_ajax_nopriv_frontend_editor_save', 'fire_department_callback_frontend_editor_save');

		// Frontend editor: Delete post
		add_action('wp_ajax_frontend_editor_delete', 	'fire_department_callback_frontend_editor_delete');
		add_action('wp_ajax_nopriv_frontend_editor_delete', 'fire_department_callback_frontend_editor_delete');

		// Register theme specific nav menus
		fire_department_register_theme_menus();

		// Register theme specific sidebars
		fire_department_register_theme_sidebars();
	}
}




/* Theme init
------------------------------------------------------------------------ */

// Init theme template
function fire_department_core_init_theme() {
	if (fire_department_storage_get('theme_inited')===true) return;
	fire_department_storage_set('theme_inited', true);

	// Load custom options from GET and post/page/cat options
	if (isset($_GET['set']) && $_GET['set']==1) {
		foreach ($_GET as $k=>$v) {
			if (fire_department_get_theme_option($k, null) !== null) {
				setcookie($k, $v, 0, '/');
				$_COOKIE[$k] = $v;
			}
		}
	}

	// Get custom options from current category / page / post / shop / event
	fire_department_load_custom_options();

	// Fire init theme actions (after custom options are loaded)
	do_action('fire_department_action_init_theme');

	// Prepare theme core global variables
	do_action('fire_department_action_prepare_globals');

	// Fire after init theme actions
	do_action('fire_department_action_after_init_theme');
}


// Prepare theme global variables
if ( !function_exists( 'fire_department_core_prepare_globals' ) ) {
	function fire_department_core_prepare_globals() {
		if (!is_admin()) {
			// Logo text and slogan
			fire_department_storage_set('logo_text', apply_filters('fire_department_filter_prepare_logo_text', fire_department_get_custom_option('logo_text')));
			fire_department_storage_set('logo_slogan', get_bloginfo('description'));
			
			// Logo image and icons
			$logo        = fire_department_get_logo_icon('logo');
			$logo_side   = fire_department_get_logo_icon('logo_side');
			$logo_fixed  = fire_department_get_logo_icon('logo_fixed');
			$logo_footer = fire_department_get_logo_icon('logo_footer');
			fire_department_storage_set('logo', $logo);
			fire_department_storage_set('logo_icon',   fire_department_get_logo_icon('logo_icon'));
			fire_department_storage_set('logo_side',   $logo_side   ? $logo_side   : $logo);
			fire_department_storage_set('logo_fixed',  $logo_fixed  ? $logo_fixed  : $logo);
			fire_department_storage_set('logo_footer', $logo_footer ? $logo_footer : $logo);
	
			$shop_mode = '';
			if (fire_department_get_custom_option('show_mode_buttons')=='yes')
				$shop_mode = fire_department_get_value_gpc('fire_department_shop_mode');
			if (empty($shop_mode))
				$shop_mode = fire_department_get_custom_option('shop_mode', '');
			if (empty($shop_mode) || !is_archive())
				$shop_mode = 'thumbs';
			fire_department_storage_set('shop_mode', $shop_mode);
		}
	}
}


// Return url for the uploaded logo image
if ( !function_exists( 'fire_department_get_logo_icon' ) ) {
	function fire_department_get_logo_icon($slug) {
		// This way to load retina logo only if 'Retina' enabled in the Theme Options
		//$mult = fire_department_get_retina_multiplier();
		// This way ignore the 'Retina' setting and load retina logo on any display with retina support
		$mult = (int) fire_department_get_value_gpc('fire_department_retina', 0) > 0 ? 2 : 1;
		$logo_icon = '';
		if ($mult > 1) 			$logo_icon = fire_department_get_custom_option($slug.'_retina');
		if (empty($logo_icon))	$logo_icon = fire_department_get_custom_option($slug);
		return $logo_icon;
	}
}


// Display logo image with text and slogan (if specified)
if ( !function_exists( 'fire_department_show_logo' ) ) {
	function fire_department_show_logo($logo_main=true, $logo_fixed=false, $logo_footer=false, $logo_side=false, $logo_text=true, $logo_slogan=true) {
		if ($logo_main===true) 		$logo_main   = fire_department_storage_get('logo');
		if ($logo_fixed===true)		$logo_fixed  = fire_department_storage_get('logo_fixed');
		if ($logo_footer===true)	$logo_footer = fire_department_storage_get('logo_footer');
		if ($logo_side===true)		$logo_side   = fire_department_storage_get('logo_side');
		if ($logo_text===true)		$logo_text   = fire_department_storage_get('logo_text');
		if ($logo_slogan===true)	$logo_slogan = fire_department_storage_get('logo_slogan');
		if (empty($logo_main) && empty($logo_fixed) && empty($logo_footer) && empty($logo_side) && empty($logo_text))
			 $logo_text = get_bloginfo('name');
		if ($logo_main || $logo_fixed || $logo_footer || $logo_side || $logo_text) {
		?>
		<div class="logo">
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php
				if (!empty($logo_main)) {
					$attr = fire_department_getimagesize($logo_main);
					echo '<img src="'.esc_url($logo_main).'" class="logo_main" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_fixed)) {
					$attr = fire_department_getimagesize($logo_fixed);
					echo '<img src="'.esc_url($logo_fixed).'" class="logo_fixed" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_footer)) {
					$attr = fire_department_getimagesize($logo_footer);
					echo '<img src="'.esc_url($logo_footer).'" class="logo_footer" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_side)) {
					$attr = fire_department_getimagesize($logo_side);
					echo '<img src="'.esc_url($logo_side).'" class="logo_side" alt=""'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				echo !empty($logo_text) ? '<div class="logo_text">'.trim($logo_text).'</div>' : '';
				echo !empty($logo_slogan) ? '<br><div class="logo_slogan">' . esc_html($logo_slogan) . '</div>' : '';
			?></a>
		</div>
		<?php 
		}
	} 
}


// Add menu locations
if ( !function_exists( 'fire_department_register_theme_menus' ) ) {
	function fire_department_register_theme_menus() {
		register_nav_menus(apply_filters('fire_department_filter_add_theme_menus', array(
			'menu_main'		=> esc_html__('Main Menu', 'fire-department'),
			'menu_user'		=> esc_html__('User Menu', 'fire-department'),
			'menu_footer'	=> esc_html__('Footer Menu', 'fire-department'),
			'menu_side'		=> esc_html__('Side Menu', 'fire-department')
		)));
	}
}


// Register widgetized area
if ( !function_exists( 'fire_department_register_theme_sidebars' ) ) {
	function fire_department_register_theme_sidebars($sidebars=array()) {
		if (!is_array($sidebars)) $sidebars = array();
		// Custom sidebars
		$custom = fire_department_get_theme_option('custom_sidebars');
		if (is_array($custom) && count($custom) > 0) {
			foreach ($custom as $i => $sb) {
				if (trim(chop($sb))=='') continue;
				$sidebars['sidebar_custom_'.($i)]  = $sb;
			}
		}
		$sidebars = apply_filters( 'fire_department_filter_add_theme_sidebars', $sidebars );
		fire_department_storage_set('registered_sidebars', $sidebars);
		if (is_array($sidebars) && count($sidebars) > 0) {
			foreach ($sidebars as $id=>$name) {
				register_sidebar( array_merge( array(
													'name'          => $name,
													'id'            => $id
												),
												fire_department_storage_get('widgets_args')
									)
				);
			}
		}
	}
}





/* Front actions and filters:
------------------------------------------------------------------------ */

//  Enqueue scripts and styles
if ( !function_exists( 'fire_department_core_frontend_scripts' ) ) {
	function fire_department_core_frontend_scripts() {
		
		// Modernizr will load in head before other scripts and styles
		// Use older version (from photostack)
		fire_department_enqueue_script( 'fire_department-core-modernizr-script', fire_department_get_file_url('js/photostack/modernizr.min.js'), array(), null, false );
		
		// Enqueue styles
		//-----------------------------------------------------------------------------------------------------
		
		// Prepare custom fonts
	    if ( 'off' !== _x( 'on', 'Google fonts: on or off', 'fire-department' ) ) {
			$fonts = fire_department_get_list_fonts(false);
			$theme_fonts = array();
			$custom_fonts = fire_department_get_custom_fonts();
			if (is_array($custom_fonts) && count($custom_fonts) > 0) {
				foreach ($custom_fonts as $s=>$f) {
					if (!empty($f['font-family']) && !fire_department_is_inherit_option($f['font-family'])) $theme_fonts[$f['font-family']] = 1;
				}
			}
			// Prepare current theme fonts
			$theme_fonts = apply_filters('fire_department_filter_used_fonts', $theme_fonts);
			// Link to selected fonts
			if (is_array($theme_fonts) && count($theme_fonts) > 0) {
				$google_fonts = '';
				foreach ($theme_fonts as $font=>$v) {
					if (isset($fonts[$font])) {
						$font_name = ($pos=fire_department_strpos($font,' ('))!==false ? fire_department_substr($font, 0, $pos) : $font;
						if (!empty($fonts[$font]['css'])) {
							$css = $fonts[$font]['css'];
							fire_department_enqueue_style( 'fire_department-font-'.str_replace(' ', '-', $font_name).'-style', $css, array(), null );
						} else {
							$google_fonts .= ($google_fonts ? '|' : '') // %7C = |
								. (!empty($fonts[$font]['link']) ? $fonts[$font]['link'] : str_replace(' ', '+', $font_name).':300,300italic,400,400italic,700,700italic');
						}
					}
				}
				if ($google_fonts) {
					fire_department_enqueue_style( 'fire_department-font-google_fonts-style', add_query_arg( 'family', urlencode( $google_fonts.'&subset='.fire_department_get_theme_option('fonts_subset') ), "//fonts.googleapis.com/css" ), array(), null );
				}
			}
		}
		
		// Fontello styles must be loaded before main stylesheet
		fire_department_enqueue_style( 'fire_department-fontello-style',  fire_department_get_file_url('css/fontello/css/fontello.css'),  array(), null);

		// Main stylesheet
		fire_department_enqueue_style( 'fire_department-main-style', get_stylesheet_uri(), array(), null );
		
		// Animations
		if (fire_department_get_theme_option('css_animation')=='yes' && (fire_department_get_theme_option('animation_on_mobile')=='yes' || !wp_is_mobile()) && !fire_department_vc_is_frontend())
			fire_department_enqueue_style( 'fire_department-animation-style',	fire_department_get_file_url('css/core.animation.css'), array(), null );

		// Theme stylesheets
		do_action('fire_department_action_add_styles');

		// Responsive
		if (fire_department_get_theme_option('responsive_layouts') == 'yes') {
			$suffix = fire_department_param_is_off(fire_department_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
			fire_department_enqueue_style( 'fire_department-responsive-style', fire_department_get_file_url('css/responsive'.($suffix).'.css'), array(), null );
			do_action('fire_department_action_add_responsive');
			$css = apply_filters('fire_department_filter_add_responsive_inline', '');
			if (!empty($css)) wp_add_inline_style( 'fire_department-responsive-style', $css );
		}

		// Disable loading JQuery UI CSS
		wp_deregister_style('jquery_ui');
		wp_deregister_style('date-picker-css');


		// Enqueue scripts	
		//----------------------------------------------------------------------------------------------------------------------------
		
		// Load separate theme scripts
		fire_department_enqueue_script( 'superfish', fire_department_get_file_url('js/superfish.js'), array('jquery'), null, true );
		if (in_array(fire_department_get_theme_option('menu_hover'), array('slide_line', 'slide_box'))) {
			fire_department_enqueue_script( 'fire_department-slidemenu-script', fire_department_get_file_url('js/jquery.slidemenu.js'), array('jquery'), null, true );
		}

		if ( is_single() && fire_department_get_custom_option('show_reviews')=='yes' ) {
			fire_department_enqueue_script( 'fire_department-core-reviews-script', fire_department_get_file_url('js/core.reviews.js'), array('jquery'), null, true );
		}

		fire_department_enqueue_script( 'fire_department-core-utils-script',	fire_department_get_file_url('js/core.utils.js'), array('jquery'), null, true );
		fire_department_enqueue_script( 'fire_department-core-init-script',	fire_department_get_file_url('js/core.init.js'), array('jquery'), null, true );	
		fire_department_enqueue_script( 'fire_department-theme-init-script',	fire_department_get_file_url('js/theme.init.js'), array('jquery'), null, true );	

		// Media elements library	
		if (fire_department_get_theme_option('use_mediaelement')=='yes') {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		}
		
		// Video background
		if (fire_department_get_custom_option('show_video_bg') == 'yes' && fire_department_get_custom_option('video_bg_youtube_code') != '') {
			fire_department_enqueue_script( 'fire_department-video-bg-script', fire_department_get_file_url('js/jquery.tubular.1.0.js'), array('jquery'), null, true );
		}

		// Google map
		if ( fire_department_get_custom_option('show_googlemap')=='yes' ) {
			$api_key = fire_department_get_theme_option('api_google');
			fire_department_enqueue_script( 'googlemap', fire_department_get_protocol().'://maps.google.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
			fire_department_enqueue_script( 'fire_department-googlemap-script', fire_department_get_file_url('js/core.googlemap.js'), array(), null, true );
		}

			
		// Social share buttons
		if (is_singular() && !fire_department_storage_get('blog_streampage') && fire_department_get_custom_option('show_share')!='hide') {
			fire_department_enqueue_script( 'fire_department-social-share-script', fire_department_get_file_url('js/social/social-share.js'), array('jquery'), null, true );
		}

		// Comments
		if ( is_singular() && !fire_department_storage_get('blog_streampage') && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), null, true );
		}

		// Custom panel
		if (fire_department_get_theme_option('show_theme_customizer') == 'yes') {
			if (file_exists(fire_department_get_file_dir('core/core.customizer/front.customizer.css')))
				fire_department_enqueue_style(  'fire_department-customizer-style',  fire_department_get_file_url('core/core.customizer/front.customizer.css'), array(), null );
			if (file_exists(fire_department_get_file_dir('core/core.customizer/front.customizer.js')))
				fire_department_enqueue_script( 'fire_department-customizer-script', fire_department_get_file_url('core/core.customizer/front.customizer.js'), array(), null, true );	
		}
		
		//Debug utils
		if (fire_department_get_theme_option('debug_mode')=='yes') {
			fire_department_enqueue_script( 'fire_department-core-debug-script', fire_department_get_file_url('js/core.debug.js'), array(), null, true );
		}

		// Theme scripts
		do_action('fire_department_action_add_scripts');
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'fire_department_enqueue_slider' ) ) {
	function fire_department_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			fire_department_enqueue_style(  'fire_department-swiperslider-style', 			fire_department_get_file_url('js/swiper/swiper.css'), array(), null );
			// jQuery version of Swiper conflict with Revolution Slider!!! Use DOM version
			fire_department_enqueue_script( 'fire_department-swiperslider-script', 			fire_department_get_file_url('js/swiper/swiper.js'), array(), null, true );
		}
	}
}

//  Enqueue Photostack gallery
if ( !function_exists( 'fire_department_enqueue_polaroid' ) ) {
	function fire_department_enqueue_polaroid() {
		fire_department_enqueue_style(  'fire_department-polaroid-style', 	fire_department_get_file_url('js/photostack/component.css'), array(), null );
		fire_department_enqueue_script( 'fire_department-classie-script',		fire_department_get_file_url('js/photostack/classie.js'), array(), null, true );
		fire_department_enqueue_script( 'fire_department-polaroid-script',	fire_department_get_file_url('js/photostack/photostack.js'), array(), null, true );
	}
}

//  Enqueue Messages scripts and styles
if ( !function_exists( 'fire_department_enqueue_messages' ) ) {
	function fire_department_enqueue_messages() {
		fire_department_enqueue_style(  'fire_department-messages-style',		fire_department_get_file_url('js/core.messages/core.messages.css'), array(), null );
		fire_department_enqueue_script( 'fire_department-messages-script',	fire_department_get_file_url('js/core.messages/core.messages.js'),  array('jquery'), null, true );
	}
}

//  Enqueue Portfolio hover scripts and styles
if ( !function_exists( 'fire_department_enqueue_portfolio' ) ) {
	function fire_department_enqueue_portfolio($hover='') {
		fire_department_enqueue_style( 'fire_department-portfolio-style',  fire_department_get_file_url('css/core.portfolio.css'), array(), null );
		if (fire_department_strpos($hover, 'effect_dir')!==false)
			fire_department_enqueue_script( 'hoverdir', fire_department_get_file_url('js/hover/jquery.hoverdir.js'), array(), null, true );
	}
}

//  Enqueue Charts and Diagrams scripts and styles
if ( !function_exists( 'fire_department_enqueue_diagram' ) ) {
	function fire_department_enqueue_diagram($type='all') {
		if ($type=='all' || $type=='pie') fire_department_enqueue_script( 'fire_department-diagram-chart-script',	fire_department_get_file_url('js/diagram/chart.min.js'), array(), null, true );
		if ($type=='all' || $type=='arc') fire_department_enqueue_script( 'fire_department-diagram-raphael-script',	fire_department_get_file_url('js/diagram/diagram.raphael.min.js'), array(), 'no-compose', true );
	}
}

// Enqueue Theme Popup scripts and styles
// Link must have attribute: data-rel="popup" or data-rel="popup[gallery]"
if ( !function_exists( 'fire_department_enqueue_popup' ) ) {
	function fire_department_enqueue_popup($engine='') {
		if ($engine=='pretty' || (empty($engine) && fire_department_get_theme_option('popup_engine')=='pretty')) {
			fire_department_enqueue_style(  'fire_department-prettyphoto-style',	fire_department_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			fire_department_enqueue_script( 'fire_department-prettyphoto-script',	fire_department_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else if ($engine=='magnific' || (empty($engine) && fire_department_get_theme_option('popup_engine')=='magnific')) {
			fire_department_enqueue_style(  'fire_department-magnific-style',	fire_department_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			fire_department_enqueue_script( 'fire_department-magnific-script',fire_department_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), '', true );
		} else if ($engine=='internal' || (empty($engine) && fire_department_get_theme_option('popup_engine')=='internal')) {
			fire_department_enqueue_messages();
		}
	}
}

//  Add inline scripts in the footer hook
if ( !function_exists( 'fire_department_core_frontend_add_code' ) ) {
	//add_action('wp_footer', 'fire_department_core_frontend_add_code', 1);
	function fire_department_core_frontend_add_code() {
		do_action('fire_department_action_add_code');
	}
}

//  Localize scripts in the footer hook
if ( !function_exists( 'fire_department_core_frontend_add_vars' ) ) {
	//add_action('wp_footer', 'fire_department_core_frontend_add_vars', 2);
	function fire_department_core_frontend_add_vars() {
		$vars = apply_filters( 'fire_department_filter_localize_script', fire_department_storage_empty('js_vars') ? array() : fire_department_storage_get('js_vars'));
		if (!empty($vars)) wp_localize_script( 'fire_department-core-init-script', 'FIRE_DEPARTMENT_STORAGE', $vars);
		if (!fire_department_storage_empty('js_code')) {
			$holder = 'script';
			?><<?php fire_department_show_layout($holder); ?>>
				jQuery(document).ready(function() {
					<?php fire_department_show_layout(fire_department_minify_js(fire_department_storage_get('js_code'))); ?>
				});
			</<?php fire_department_show_layout($holder); ?>><?php
		}
	}
}


//  Add property="stylesheet" into all tags <link> in the footer
if (!function_exists('fire_department_core_add_property_to_link')) {
	//add_filter('style_loader_tag', 'fire_department_core_add_property_to_link', 10, 3);
	function fire_department_core_add_property_to_link($link, $handle='', $href='') {
		return str_replace('<link ', '<link property="stylesheet" ', $link);
	}
}

//  Add inline scripts in the footer
if (!function_exists('fire_department_core_action_add_code')) {
	//add_action('fire_department_action_add_code','fire_department_core_action_add_code');
	function fire_department_core_action_add_code() {
		// System message
		$msg = fire_department_get_system_message(true); 
		if (!empty($msg['message'])) fire_department_enqueue_messages();
		fire_department_storage_set_array('js_vars', 'system_message',	$msg);
	}
}

//  Localize script
if (!function_exists('fire_department_core_localize_script')) {
	//add_filter('fire_department_filter_localize_script',	'fire_department_core_localize_script');
	function fire_department_core_localize_script($vars) {

		// AJAX parameters
		$vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
		$vars['ajax_nonce'] = wp_create_nonce(admin_url('admin-ajax.php'));

		// Site base url
		$vars['site_url'] = esc_url(get_site_url());

		// Site protocol
		$vars['site_protocol'] = fire_department_get_protocol();
			
		// VC frontend edit mode
		$vars['vc_edit_mode'] = function_exists('fire_department_vc_is_frontend') && fire_department_vc_is_frontend();
			
		// Theme base font
		$vars['theme_font'] = fire_department_get_custom_font_settings('p', 'font-family');
			
		// Theme colors
		$vars['theme_color'] = fire_department_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = fire_department_get_scheme_color('bg_color');
		$vars['accent1_color'] = fire_department_get_scheme_color('text_link');
		$vars['accent1_hover'] = fire_department_get_scheme_color('text_hover');
			
		// Slider height
		$vars['slider_height'] = max(100, fire_department_get_custom_option('slider_height'));
			
		// User logged in
		$vars['user_logged_in'] = is_user_logged_in();
			
		// Show table of content for the current page
		$vars['toc_menu'] = fire_department_get_custom_option('menu_toc');
		$vars['toc_menu_home'] = fire_department_get_custom_option('menu_toc')!='hide' && fire_department_get_custom_option('menu_toc_home')=='yes';
		$vars['toc_menu_top'] = fire_department_get_custom_option('menu_toc')!='hide' && fire_department_get_custom_option('menu_toc_top')=='yes';

		// Fix main menu
		$vars['menu_fixed'] = fire_department_get_theme_option('menu_attachment')=='fixed';
			
		// Use responsive version for main menu
		$vars['menu_mobile'] = fire_department_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) fire_department_get_theme_option('menu_mobile')) : 0;
		$vars['menu_hover'] = fire_department_get_theme_option('menu_hover');

		// Theme's buttons hover
		$vars['button_hover'] = fire_department_get_theme_option('button_hover');

		// Theme's form fields style
		$vars['input_hover'] = fire_department_get_theme_option('input_hover');

		// Right panel demo timer
		$vars['demo_time'] = fire_department_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) fire_department_get_theme_option('customizer_demo')) : 0;

		// Video and Audio tag wrapper
		$vars['media_elements_enabled'] = fire_department_get_theme_option('use_mediaelement')=='yes';
			
		// Use AJAX search
		$vars['ajax_search_enabled'] = fire_department_get_theme_option('use_ajax_search')=='yes';
		$vars['ajax_search_min_length'] = min(3, fire_department_get_theme_option('ajax_search_min_length'));
		$vars['ajax_search_delay'] = min(200, max(1000, fire_department_get_theme_option('ajax_search_delay')));

		// Use CSS animation
		$vars['css_animation'] = fire_department_get_theme_option('css_animation')=='yes';
		$vars['menu_animation_in'] = fire_department_get_theme_option('menu_animation_in');
		$vars['menu_animation_out'] = fire_department_get_theme_option('menu_animation_out');

		// Popup windows engine
		$vars['popup_engine'] = fire_department_get_theme_option('popup_engine');

		// E-mail mask
		$vars['email_mask'] = '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';
			
		// Messages max length
		$vars['contacts_maxlength'] = fire_department_get_theme_option('message_maxlength_contacts');
		$vars['comments_maxlength'] = fire_department_get_theme_option('message_maxlength_comments');

		// Remember visitors settings
		$vars['remember_visitors_settings'] = fire_department_get_theme_option('remember_visitors_settings')=='yes';

		// Internal vars - do not change it!
		// Flag for review mechanism
		$vars['admin_mode'] = false;
		// Max scale factor for the portfolio and other isotope elements before relayout
		$vars['isotope_resize_delta'] = 0.3;
		// jQuery object for the message box in the form
		$vars['error_message_box'] = null;
		// Waiting for the viewmore results
		$vars['viewmore_busy'] = false;
		$vars['video_resize_inited'] = false;
		$vars['top_panel_height'] = 0;

		return $vars;
	}
}

// Show content with the html layout (if not empty)
if ( !function_exists('fire_department_show_layout') ) {
	function fire_department_show_layout($str, $before='', $after='') {
        if ($str != '') {
			printf("%s%s%s", $before, $str, $after);
		}
	}
}

// Add class "widget_number_#' for each widget
if ( !function_exists( 'fire_department_add_widget_number' ) ) {
	//add_filter('dynamic_sidebar_params', 'fire_department_add_widget_number', 10, 1);
	function fire_department_add_widget_number($prm) {
		if (is_admin()) return $prm;
		static $num=0, $last_sidebar='', $last_sidebar_id='', $last_sidebar_columns=0, $last_sidebar_count=0, $sidebars_widgets=array();
		$cur_sidebar = fire_department_storage_get('current_sidebar');
		if (empty($cur_sidebar)) $cur_sidebar = 'undefined';
		if (count($sidebars_widgets) == 0)
			$sidebars_widgets = wp_get_sidebars_widgets();
		if ($last_sidebar != $cur_sidebar) {
			$num = 0;
			$last_sidebar = $cur_sidebar;
			$last_sidebar_id = $prm[0]['id'];
			$last_sidebar_columns = max(1, (int) fire_department_get_custom_option('sidebar_'.($cur_sidebar).'_columns'));
			$last_sidebar_count = count($sidebars_widgets[$last_sidebar_id]);
		}
		$num++;
		$prm[0]['before_widget'] = str_replace(' class="', ' class="widget_number_'.esc_attr($num).($last_sidebar_columns > 1 ? ' column-1_'.esc_attr($last_sidebar_columns) : '').' ', $prm[0]['before_widget']);
		return $prm;
	}
}


// Show <title> tag under old WP (version < 4.1)
if ( !function_exists( 'fire_department_wp_title_show' ) ) {
	// add_action('wp_head', 'fire_department_wp_title_show');
	function fire_department_wp_title_show() {
		?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
	}
}

// Filters wp_title to print a neat <title> tag based on what is being viewed.
if ( !function_exists( 'fire_department_wp_title_modify' ) ) {
	// add_filter( 'wp_title', 'fire_department_wp_title_modify', 10, 2 );
	function fire_department_wp_title_modify( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) return $title;
		// Add the blog name
		$title .= get_bloginfo( 'name' );
		// Add the blog description for the home/front page.
		if ( is_home() || is_front_page() ) {
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description )
				$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'fire-department' ), max( $paged, $page ) );
		return $title;
	}
}

// Add main menu classes
if ( !function_exists( 'fire_department_add_mainmenu_classes' ) ) {
	// add_filter('wp_nav_menu_objects', 'fire_department_add_mainmenu_classes', 10, 2);
	function fire_department_add_mainmenu_classes($items, $args) {
		if (is_admin()) return $items;
		if ($args->menu_id == 'mainmenu' && fire_department_get_theme_option('menu_colored')=='yes' && is_array($items) && count($items) > 0) {
			foreach($items as $k=>$item) {
				if ($item->menu_item_parent==0) {
					if ($item->type=='taxonomy' && $item->object=='category') {
						$cur_tint = fire_department_taxonomy_get_inherited_property('category', $item->object_id, 'bg_tint');
						if (!empty($cur_tint) && !fire_department_is_inherit_option($cur_tint))
							$items[$k]->classes[] = 'bg_tint_'.esc_attr($cur_tint);
					}
				}
			}
		}
		return $items;
	}
}


// Save post data from frontend editor
if ( !function_exists( 'fire_department_callback_frontend_editor_save' ) ) {
	function fire_department_callback_frontend_editor_save() {

		if ( !wp_verify_nonce( fire_department_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
		$response = array('error'=>'');

		parse_str($_REQUEST['data'], $output);
		$post_id = $output['frontend_editor_post_id'];

		if ( fire_department_get_theme_option("allow_editor")=='yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id)) ) {
			if ($post_id > 0) {
				$title   = stripslashes($output['frontend_editor_post_title']);
				$content = stripslashes($output['frontend_editor_post_content']);
				$excerpt = stripslashes($output['frontend_editor_post_excerpt']);
				$rez = wp_update_post(array(
					'ID'           => $post_id,
					'post_content' => $content,
					'post_excerpt' => $excerpt,
					'post_title'   => $title
				));
				if ($rez == 0) 
					$response['error'] = esc_html__('Post update error!', 'fire-department');
			} else {
				$response['error'] = esc_html__('Post update error!', 'fire-department');
			}
		} else
			$response['error'] = esc_html__('Post update denied!', 'fire-department');
		
		echo json_encode($response);
		die();
	}
}

// Delete post from frontend editor
if ( !function_exists( 'fire_department_callback_frontend_editor_delete' ) ) {
	function fire_department_callback_frontend_editor_delete() {

		if ( !wp_verify_nonce( fire_department_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();

		$response = array('error'=>'');
		
		$post_id = $_REQUEST['post_id'];

		if ( fire_department_get_theme_option("allow_editor")=='yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id)) ) {
			if ($post_id > 0) {
				$rez = wp_delete_post($post_id);
				if ($rez === false) 
					$response['error'] = esc_html__('Post delete error!', 'fire-department');
			} else {
				$response['error'] = esc_html__('Post delete error!', 'fire-department');
			}
		} else
			$response['error'] = esc_html__('Post delete denied!', 'fire-department');

		echo json_encode($response);
		die();
	}
}


// Prepare logo text
if ( !function_exists( 'fire_department_prepare_logo_text' ) ) {
	function fire_department_prepare_logo_text($text) {
		$text = str_replace(array('[', ']'), array('<span class="theme_accent">', '</span>'), $text);
		$text = str_replace(array('{', '}'), array('<strong>', '</strong>'), $text);
		return $text;
	}
}
?>
