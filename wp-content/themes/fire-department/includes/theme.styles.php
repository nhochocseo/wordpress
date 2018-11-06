<?php
/**
 * Theme custom styles
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if (!function_exists('fire_department_action_theme_styles_theme_setup')) {
	add_action( 'fire_department_action_before_init_theme', 'fire_department_action_theme_styles_theme_setup', 1 );
	function fire_department_action_theme_styles_theme_setup() {
	
		// Add theme fonts in the used fonts list
		add_filter('fire_department_filter_used_fonts',			'fire_department_filter_theme_styles_used_fonts');
		// Add theme fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('fire_department_filter_list_fonts',			'fire_department_filter_theme_styles_list_fonts');

		// Add theme stylesheets
		add_action('fire_department_action_add_styles',			'fire_department_action_theme_styles_add_styles');
		// Add theme inline styles
		add_filter('fire_department_filter_add_styles_inline',		'fire_department_filter_theme_styles_add_styles_inline');

		// Add theme scripts
		add_action('fire_department_action_add_scripts',			'fire_department_action_theme_styles_add_scripts');
		// Add theme scripts inline
		add_filter('fire_department_filter_localize_script',		'fire_department_filter_theme_styles_localize_script');

		// Add theme less files into list for compilation
		add_filter('fire_department_filter_compile_less',			'fire_department_filter_theme_styles_compile_less');


		/* Color schemes
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		// Next settings are deprecated
		//bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		//bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Additional accented colors (if need)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		text_link		- links
		text_hover		- hover links
		
		// Inverse blocks
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Input colors - form fields
		input_text		- inactive text
		input_light		- placeholder text
		input_dark		- focused text
		input_bd_color	- inactive border
		input_bd_hover	- focused borde
		input_bg_color	- inactive background
		input_bg_hover	- focused background
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		// Next settings are deprecated
		//alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		fire_department_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'fire-department'),
			
			// Whole block border and background
			'bd_color'				=> '#cfc8c4',
			'bg_color'				=> '#ffffff',
			
			// Headers, text and links colors
			'text'					=> '#6e6a67',
			'text_light'			=> '#d3d3d3',
			'text_dark'				=> '#382e26',
			'text_link'				=> '#e78600', //accent1
			'text_hover'			=> '#ff9604', //accent1_hover

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#e43b1b', //accent2
			'inverse_hover'			=> '#261c18', //accent3
		
			// Input fields
			'input_text'			=> '#8a8a8a',
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#dddddd',
			'input_bd_hover'		=> '#bbbbbb',
			'input_bg_color'		=> '#f7f7f7',
			'input_bg_hover'		=> '#f0f0f0',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#cccccc',
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#b6b3b3',
			'alter_link'			=> '#e43b1b',
			'alter_hover'			=> '#f43611',
			'alter_bd_color'		=> '#cfc8c4',
			'alter_bd_hover'		=> '#382d26',
			'alter_bg_color'		=> '#ffffff',
			'alter_bg_hover'		=> '#ffffff',
			)
		);

		// Add color schemes
		fire_department_add_color_scheme('light', array(

			'title'					=> esc_html__('Light', 'fire-department'),

			// Whole block border and background
			'bd_color'				=> '#dddddd',
			'bg_color'				=> '#f7f7f7',
		
			// Headers, text and links colors
			'text'					=> '#8a8a8a',
			'text_light'			=> '#acb4b6',
			'text_dark'				=> '#232a34',
			'text_link'				=> '#20c7ca',
			'text_hover'			=> '#189799',

			// Inverse colors
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#ffffff',
		
			// Input fields
			'input_text'			=> '#8a8a8a',
			'input_light'			=> '#acb4b6',
			'input_dark'			=> '#232a34',
			'input_bd_color'		=> '#e7e7e7',
			'input_bd_hover'		=> '#dddddd',
			'input_bg_color'		=> '#ffffff',
			'input_bg_hover'		=> '#f0f0f0',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#8a8a8a',
			'alter_light'			=> '#acb4b6',
			'alter_dark'			=> '#232a34',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#189799',
			'alter_bd_color'		=> '#e7e7e7',
			'alter_bd_hover'		=> '#dddddd',
			'alter_bg_color'		=> '#ffffff',
			'alter_bg_hover'		=> '#f0f0f0',
			)
		);

		// Add color schemes
		fire_department_add_color_scheme('dark', array(

			'title'					=> esc_html__('Dark', 'fire-department'),
			
			// Whole block border and background
			'bd_color'				=> '#7d7d7d',
			'bg_color'				=> '#333333',

			// Headers, text and links colors
			'text'					=> '#909090',
			'text_light'			=> '#a0a0a0',
			'text_dark'				=> '#e0e0e0',
			'text_link'				=> '#20c7ca',
			'text_hover'			=> '#189799',

			// Inverse colors
			'inverse_text'			=> '#f0f0f0',
			'inverse_light'			=> '#e0e0e0',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#ffffff',
			'inverse_hover'			=> '#e5e5e5',
		
			// Input fields
			'input_text'			=> '#999999',
			'input_light'			=> '#aaaaaa',
			'input_dark'			=> '#d0d0d0',
			'input_bd_color'		=> '#909090',
			'input_bd_hover'		=> '#888888',
			'input_bg_color'		=> '#666666',
			'input_bg_hover'		=> '#505050',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#999999',
			'alter_light'			=> '#aaaaaa',
			'alter_dark'			=> '#d0d0d0',
			'alter_link'			=> '#20c7ca',
			'alter_hover'			=> '#29fbff',
			'alter_bd_color'		=> '#909090',
			'alter_bd_hover'		=> '#888888',
			'alter_bg_color'		=> '#666666',
			'alter_bg_hover'		=> '#505050',
			)
		);

		// Add color schemes
		fire_department_add_color_scheme('color_blocks', array(

			'title'					=> esc_html__('Color blocks', 'fire-department'),
			
			// Whole block border and background
			'bd_color'				=> '#1DB3B6',
			'bg_color'				=> '#20C7CA',

			// Headers, text and links colors
			'text'					=> '#F0F0F0',
			'text_light'			=> '#E0E0E0',
			'text_dark'				=> '#FFFFFF',
			'text_link'				=> '#1D9B9D',
			'text_hover'			=> '#23E8EB',

			// Inverse colors
			'inverse_text'			=> '#F0F0F0',
			'inverse_light'			=> '#E0F0F0',
			'inverse_dark'			=> '#FFFFFF',
			'inverse_link'			=> '#FCFFA3',
			'inverse_hover'			=> '#FFFF00',
		
			// Input fields
			'input_text'			=> '#DADADA',
			'input_light'			=> '#B4B8B8',
			'input_dark'			=> '#FFFFFF',
			'input_bd_color'		=> '#06564E',
			'input_bd_hover'		=> '#017E72',
			'input_bg_color'		=> '#0F7468',
			'input_bg_hover'		=> '#108678',
		
			// Alternative blocks (submenu items, etc.)
			'alter_text'			=> '#DADADA',
			'alter_light'			=> '#B4B8B8',
			'alter_dark'			=> '#FFFFFF',
			'alter_link'			=> '#CAB720',
			'alter_hover'			=> '#998B18',
			'alter_bd_color'		=> '#06564E',
			'alter_bd_hover'		=> '#017E72',
			'alter_bg_color'		=> '#0F7468',
			'alter_bg_hover'		=> '#108678',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

        // Add Custom fonts
        fire_department_add_custom_font('h1', array(
                'title'			=> esc_html__('Heading 1', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '4.68em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.35em',
                'margin-top'	=> '0.5em',
                'margin-bottom'	=> '0.2em'
            )
        );
        fire_department_add_custom_font('h2', array(
                'title'			=> esc_html__('Heading 2', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '3.1em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.3em',
                'margin-top'	=> '0.6667em',
                'margin-bottom'	=> '0.1em'
            )
        );
        fire_department_add_custom_font('h3', array(
                'title'			=> esc_html__('Heading 3', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '2.34em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.3em',
                'margin-top'	=> '0.6667em',
                'margin-bottom'	=> '0.2em'
            )
        );
        fire_department_add_custom_font('h4', array(
                'title'			=> esc_html__('Heading 4', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '1.313em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.3em',
                'margin-top'	=> '1.2em',
                'margin-bottom'	=> '0.8em'
            )
        );
        fire_department_add_custom_font('h5', array(
                'title'			=> esc_html__('Heading 5', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '1.125em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.3em',
                'margin-top'	=> '1.2em',
                'margin-bottom'	=> '0.77em'
            )
        );
        fire_department_add_custom_font('h6', array(
                'title'			=> esc_html__('Heading 6', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '1.125em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.3em',
                'margin-top'	=> '1.25em',
                'margin-bottom'	=> '0.77em'
            )
        );
        fire_department_add_custom_font('p', array(
                'title'			=> esc_html__('Text', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Lato',
                'font-size' 	=> '16px',
                'font-weight'	=> '400',
                'font-style'	=> '',
                'line-height'	=> '21px',
                'margin-top'	=> '',
                'margin-bottom'	=> '1em'
            )
        );
        fire_department_add_custom_font('link', array(
                'title'			=> esc_html__('Links', 'fire-department'),
                'description'	=> '',
                'font-family'	=> '',
                'font-size' 	=> '',
                'font-weight'	=> '',
                'font-style'	=> ''
            )
        );
        fire_department_add_custom_font('info', array(
                'title'			=> esc_html__('Post info', 'fire-department'),
                'description'	=> '',
                'font-family'	=> '',
                'font-size' 	=> '',
                'font-weight'	=> '',
                'font-style'	=> 'i',
                'line-height'	=> '1.2857em',
                'margin-top'	=> '',
                'margin-bottom'	=> '1.5em'
            )
        );
        fire_department_add_custom_font('menu', array(
                'title'			=> esc_html__('Main menu items', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '0.875em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '1.2857em',
                'margin-top'	=> '1.8em',
                'margin-bottom'	=> '1.8em'
            )
        );
        fire_department_add_custom_font('submenu', array(
                'title'			=> esc_html__('Dropdown menu items', 'fire-department'),
                'description'	=> '',
                'font-family'	=> '',
                'font-size' 	=> '',
                'font-weight'	=> '',
                'font-style'	=> '',
                'line-height'	=> '1.2857em',
                'margin-top'	=> '',
                'margin-bottom'	=> ''
            )
        );
        fire_department_add_custom_font('logo', array(
                'title'			=> esc_html__('Logo', 'fire-department'),
                'description'	=> '',
                'font-family'	=> '',
                'font-size' 	=> '2.8571em',
                'font-weight'	=> '700',
                'font-style'	=> '',
                'line-height'	=> '0.75em',
                'margin-top'	=> '2.5em',
                'margin-bottom'	=> '2em'
            )
        );
        fire_department_add_custom_font('button', array(
                'title'			=> esc_html__('Buttons', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Raleway',
                'font-size' 	=> '1em',
                'font-weight'	=> '',
                'font-style'	=> '',
                'line-height'	=> ''
            )
        );
        fire_department_add_custom_font('input', array(
                'title'			=> esc_html__('Input fields', 'fire-department'),
                'description'	=> '',
                'font-family'	=> 'Lato',
                'font-size' 	=> '',
                'font-weight'	=> '400',
                'font-style'	=> '',
                'line-height'	=> ''
            )
        );

	}
}





//------------------------------------------------------------------------------
// Theme fonts
//------------------------------------------------------------------------------

// Add theme fonts in the used fonts list
if (!function_exists('fire_department_filter_theme_styles_used_fonts')) {
	//add_filter('fire_department_filter_used_fonts', 'fire_department_filter_theme_styles_used_fonts');
	function fire_department_filter_theme_styles_used_fonts($theme_fonts) {
        $theme_fonts['Lato'] = 1;
        $theme_fonts['Raleway'] = 1;
        $theme_fonts['Open Sans'] = 1;
        $theme_fonts['Lora'] = 1;
		return $theme_fonts;
	}
}

// Add theme fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('fire_department_filter_theme_styles_list_fonts')) {
	//add_filter('fire_department_filter_list_fonts', 'fire_department_filter_theme_styles_list_fonts');
	function fire_department_filter_theme_styles_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => fire_department_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
        if (!isset($list['Raleway'])) {
            $list['Raleway'] = array(
                'family' => 'sans-serif',																						// (required) font family
                'link'   => 'Raleway:400,500,600,700,300',	// (optional) if you use Google font repository
            );
        }

        if (!isset($list['Open Sans'])) {
            $list['Open Sans'] = array(
                'family' => 'sans-serif',																						// (required) font family
                'link'   => 'Open+Sans:400,300italic,400italic,600,600italic,700,700italic&subset=latin,latin-ext',	// (optional) if you use Google font repository
            );
        }

        if (!isset($list['Lora'])) {
            $list['Lora'] = array(
                'family' => 'serif',																						// (required) font family
                'link'   => 'Lora:400,400italic,700,700italic',	// (optional) if you use Google font repository
            );
        }

        if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Theme stylesheets
//------------------------------------------------------------------------------

// Add theme.less into list files for compilation
if (!function_exists('fire_department_filter_theme_styles_compile_less')) {
	//add_filter('fire_department_filter_compile_less', 'fire_department_filter_theme_styles_compile_less');
	function fire_department_filter_theme_styles_compile_less($files) {
		if (file_exists(fire_department_get_file_dir('css/theme.less'))) {
		 	$files[] = fire_department_get_file_dir('css/theme.less');
		}
		return $files;	
	}
}

// Add theme stylesheets
if (!function_exists('fire_department_action_theme_styles_add_styles')) {
	//add_action('fire_department_action_add_styles', 'fire_department_action_theme_styles_add_styles');
	function fire_department_action_theme_styles_add_styles() {
		// Add stylesheet files only if LESS supported
		if ( fire_department_get_theme_setting('less_compiler') != 'no' ) {
			fire_department_enqueue_style( 'fire_department-theme-style', fire_department_get_file_url('css/theme.css'), array(), null );
			wp_add_inline_style( 'fire_department-theme-style', fire_department_get_inline_css() );
		}
	}
}

// Add theme inline styles
if (!function_exists('fire_department_filter_theme_styles_add_styles_inline')) {
	//add_filter('fire_department_filter_add_styles_inline', 'fire_department_filter_theme_styles_add_styles_inline');
	function fire_department_filter_theme_styles_add_styles_inline($custom_style) {
		// Todo: add theme specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = fire_department_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = fire_department_get_scheme_color('text_link');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_default .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_default .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}

		// Submenu width
		$menu_width = fire_department_get_theme_option('menu_width');
		if (!empty($menu_width)) {
			$custom_style .= "
				/* Submenu width */
				.menu_side_nav > li ul,
				.menu_main_nav > li ul {
					width: ".intval($menu_width)."px;
				}
				.menu_side_nav > li > ul ul,
				.menu_main_nav > li > ul ul {
					left:".intval($menu_width+4)."px;
				}
				.menu_side_nav > li > ul ul.submenu_left,
				.menu_main_nav > li > ul ul.submenu_left {
					left:-".intval($menu_width+1)."px;
				}
			";
		}
	
		// Logo height
		$logo_height = fire_department_get_custom_option('logo_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo header height */
				.sidebar_outer_logo .logo_main,
				.top_panel_wrap .logo_main,
				.top_panel_wrap .logo_fixed {
					height:".intval($logo_height)."px;
				}
			";
		}
	
		// Logo top offset
		$logo_offset = fire_department_get_custom_option('logo_offset');
		if (!empty($logo_offset)) {
			$custom_style .= "
				/* Logo header top offset */
				.top_panel_wrap .logo {
					margin-top:".intval($logo_offset)."px;
				}
			";
		}

		// Logo footer height
		$logo_height = fire_department_get_theme_option('logo_footer_height');
		if (!empty($logo_height)) {
			$custom_style .= "
				/* Logo footer height */
				.contacts_wrap .logo img {
					height:".intval($logo_height)."px;
				}
			";
		}

		// Custom css from theme options
		$custom_style .= fire_department_get_custom_option('custom_css');

		return $custom_style;	
	}
}


//------------------------------------------------------------------------------
// Theme scripts
//------------------------------------------------------------------------------

// Add theme scripts
if (!function_exists('fire_department_action_theme_styles_add_scripts')) {
	//add_action('fire_department_action_add_scripts', 'fire_department_action_theme_styles_add_scripts');
	function fire_department_action_theme_styles_add_scripts() {
		if (fire_department_get_theme_option('show_theme_customizer') == 'yes' && file_exists(fire_department_get_file_dir('js/theme.customizer.js')))
			fire_department_enqueue_script( 'fire_department-theme_styles-customizer-script', fire_department_get_file_url('js/theme.customizer.js'), array(), null );
	}
}

// Add theme scripts inline
if (!function_exists('fire_department_filter_theme_styles_localize_script')) {
	//add_filter('fire_department_filter_localize_script',		'fire_department_filter_theme_styles_localize_script');
	function fire_department_filter_theme_styles_localize_script($vars) {
		if (empty($vars['theme_font']))
			$vars['theme_font'] = fire_department_get_custom_font_settings('p', 'font-family');
		$vars['theme_color'] = fire_department_get_scheme_color('text_dark');
		$vars['theme_bg_color'] = fire_department_get_scheme_color('bg_color');
		return $vars;
	}
}
?>