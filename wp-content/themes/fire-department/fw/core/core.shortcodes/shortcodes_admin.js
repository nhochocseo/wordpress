// Init scripts
jQuery(document).ready(function(){
	"use strict";
	
	// Settings and constants
	FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter'] = ',';		// Delimiter for multiple values
	FIRE_DEPARTMENT_STORAGE['shortcodes_popup'] = null;		// Popup with current shortcode settings
	FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx'] = '';	// Current shortcode's index
	FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_tab'] = '<li id="fire_department_shortcodes_tab_{id}" data-id="{id}"><a href="#fire_department_shortcodes_tab_{id}_content"><span class="iconadmin-{icon}"></span>{title}</a></li>';
	FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_content'] = '';

	// Shortcode selector - "change" event handler - add selected shortcode in editor
	jQuery('body').on('change', ".sc_selector", function() {
		"use strict";
		FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx'] = jQuery(this).find(":selected").val();
		if (FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx'] == '') return;
		var sc = fire_department_clone_object(FIRE_DEPARTMENT_SHORTCODES_DATA[FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx']]);
		var hdr = sc.title;
		var content = "";
		try {
			content = tinyMCE.activeEditor ? tinyMCE.activeEditor.selection.getContent({format : 'raw'}) : jQuery('#wp-content-editor-container textarea').selection();
		} catch(e) {};
		if (content) {
			for (var i in sc.params) {
				if (i == '_content_') {
					sc.params[i].value = content;
					break;
				}
			}
		}
		var html = (!fire_department_empty(sc.desc) ? '<p>'+sc.desc+'</p>' : '')
			+ fire_department_shortcodes_prepare_layout(sc);


		// Show Dialog popup
		FIRE_DEPARTMENT_STORAGE['shortcodes_popup'] = fire_department_message_dialog(html, hdr,
			function(popup) {
				"use strict";
				fire_department_options_init(popup);
				popup.find('.fire_department_options_tab_content').css({
					maxHeight: jQuery(window).height() - 300 + 'px',
					overflow: 'auto'
				});
			},
			function(btn, popup) {
				"use strict";
				if (btn != 1) return;
				var sc = fire_department_shortcodes_get_code(FIRE_DEPARTMENT_STORAGE['shortcodes_popup']);
				if (tinyMCE.activeEditor) {
					if ( !tinyMCE.activeEditor.isHidden() )
						tinyMCE.activeEditor.execCommand( 'mceInsertContent', false, sc );
					else
						send_to_editor(sc);
				} else
					send_to_editor(sc);
			});

		// Set first item active
		jQuery(this).get(0).options[0].selected = true;

		// Add new child tab
		FIRE_DEPARTMENT_STORAGE['shortcodes_popup'].find('.fire_department_shortcodes_tab').on('tabsbeforeactivate', function (e, ui) {
			if (ui.newTab.data('id')=='add') {
				fire_department_shortcodes_add_tab(ui.newTab);
				e.stopImmediatePropagation();
				e.preventDefault();
				return false;
			}
		});

		// Delete child tab
		FIRE_DEPARTMENT_STORAGE['shortcodes_popup'].find('.fire_department_shortcodes_tab > ul').on('click', '> li+li > a > span', function (e) {
			var tab = jQuery(this).parents('li');
			var idx = tab.data('id');
			if (parseInt(idx) > 1) {
				if (tab.hasClass('ui-state-active')) {
					tab.prev().find('a').trigger('click');
				}
				tab.parents('.fire_department_shortcodes_tab').find('.fire_department_options_tab_content').eq(idx).remove();
				tab.remove();
				e.preventDefault();
				return false;
			}
		});

		return false;
	});

});



// Return result code
//------------------------------------------------------------------------------------------
function fire_department_shortcodes_get_code(popup) {
	FIRE_DEPARTMENT_STORAGE['sc_custom'] = '';
	
	var sc_name = FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx'];
	var sc = FIRE_DEPARTMENT_SHORTCODES_DATA[sc_name];
	var tabs = popup.find('.fire_department_shortcodes_tab > ul > li');
	var decor = !fire_department_isset(sc.decorate) || sc.decorate;
	var rez = '[' + sc_name + fire_department_shortcodes_get_code_from_tab(popup.find('#fire_department_shortcodes_tab_0_content').eq(0)) + ']';
	if (fire_department_isset(sc.children)) {
		if (FIRE_DEPARTMENT_STORAGE['sc_custom']!='no') {
			var decor2 = !fire_department_isset(sc.children.decorate) || sc.children.decorate;
			for (var i=0; i<tabs.length; i++) {
				var tab = tabs.eq(i);
				var idx = tab.data('id');
				if (isNaN(idx) || parseInt(idx) < 1) continue;
				var content = popup.find('#fire_department_shortcodes_tab_' + idx + '_content').eq(0);
				rez += (decor2 ? '\n\t' : '') + '[' + sc.children.name + fire_department_shortcodes_get_code_from_tab(content) + ']';	// + (decor2 ? '\n' : '');
				if (fire_department_isset(sc.children.container) && sc.children.container) {
					if (content.find('[data-param="_content_"]').length > 0) {
						rez += content.find('[data-param="_content_"]').val();
					}
					rez += 
						//(decor2 ? '\t' : '') + 
						'[/' + sc.children.name + ']'
						// + (decor ? '\n' : '')
						;
				}
			}
		}
	} else if (fire_department_isset(sc.container) && sc.container && popup.find('#fire_department_shortcodes_tab_0_content [data-param="_content_"]').length > 0) {
		rez += popup.find('#fire_department_shortcodes_tab_0_content [data-param="_content_"]').val();
	}
	if (fire_department_isset(sc.container) && sc.container || fire_department_isset(sc.children))
		rez += 
			(fire_department_isset(sc.children) && decor && FIRE_DEPARTMENT_STORAGE['sc_custom']!='no' ? '\n' : '')
			+ '[/' + sc_name + ']';
	return rez;
}

// Collect all parameters from tab into string
function fire_department_shortcodes_get_code_from_tab(tab) {
	var rez = ''
	var mainTab = tab.attr('id').indexOf('tab_0') > 0;
	tab.find('[data-param]').each(function () {
		var field = jQuery(this);
		var param = field.data('param');
		if (!field.parents('.fire_department_options_field').hasClass('fire_department_options_no_use') && param.substr(0, 1)!='_' && !fire_department_empty(field.val()) && field.val()!='none' && (field.attr('type') != 'checkbox' || field.get(0).checked)) {
			rez += ' '+param+'="'+fire_department_shortcodes_prepare_value(field.val())+'"';
		}
		// On main tab detect param "custom"
		if (mainTab && param=='custom') {
			FIRE_DEPARTMENT_STORAGE['sc_custom'] = field.val();
		}
	});
	// Get additional params for general tab from items tabs
	if (FIRE_DEPARTMENT_STORAGE['sc_custom']!='no' && mainTab) {
		var sc = FIRE_DEPARTMENT_SHORTCODES_DATA[FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx']];
		var sc_name = FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx'];
		if (sc_name == 'trx_columns' || sc_name == 'trx_skills' || sc_name == 'trx_team' || sc_name == 'trx_price_table') {	// Determine "count" parameter
			var cnt = 0;
			tab.siblings('div').each(function() {
				var item_tab = jQuery(this);
				var merge = parseInt(item_tab.find('[data-param="span"]').val());
				cnt += !isNaN(merge) && merge > 0 ? merge : 1;
			});
			rez += ' count="'+cnt+'"';
		}
	}
	return rez;
}


// Shortcode parameters builder
//-------------------------------------------------------------------------------------------

// Prepare layout from shortcode object (array)
function fire_department_shortcodes_prepare_layout(field) {
	"use strict";
	// Make params cloneable
	field['params'] = [field['params']];
	if (!fire_department_empty(field.children)) {
		field.children['params'] = [field.children['params']];
	}
	// Prepare output
	var output = '<div class="fire_department_shortcodes_body fire_department_options_body"><form>';
	output += fire_department_shortcodes_show_tabs(field);
	output += fire_department_shortcodes_show_field(field, 0);
	if (!fire_department_empty(field.children)) {
		FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_content'] = fire_department_shortcodes_show_field(field.children, 1);
		output += FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_content'];
	}
	output += '</div></form></div>';
	return output;
}



// Show tabs
function fire_department_shortcodes_show_tabs(field) {
	"use strict";
	// html output
	var output = '<div class="fire_department_shortcodes_tab fire_department_options_container fire_department_options_tab">'
		+ '<ul>'
		+ FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_tab'].replace(/{id}/g, 0).replace('{icon}', 'cog').replace('{title}', 'General');
	if (fire_department_isset(field.children)) {
		for (var i=0; i<field.children.params.length; i++)
			output += FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_tab'].replace(/{id}/g, i+1).replace('{icon}', 'cancel').replace('{title}', field.children.title + ' ' + (i+1));
		output += FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_tab'].replace(/{id}/g, 'add').replace('{icon}', 'list-add').replace('{title}', '');
	}
	output += '</ul>';
	return output;
}

// Add new tab
function fire_department_shortcodes_add_tab(tab) {
	"use strict";
	var idx = 0;
	tab.siblings().each(function () {
		"use strict";
		var i = parseInt(jQuery(this).data('id'));
		if (i > idx) idx = i;
	});
	idx++;
	tab.before( FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_tab'].replace(/{id}/g, idx).replace('{icon}', 'cancel').replace('{title}', FIRE_DEPARTMENT_SHORTCODES_DATA[FIRE_DEPARTMENT_STORAGE['shortcodes_current_idx']].children.title + ' ' + idx) );
	tab.parents('.fire_department_shortcodes_tab').append(FIRE_DEPARTMENT_STORAGE['shortcodes_tab_clone_content'].replace(/tab_1_/g, 'tab_' + idx + '_'));
	tab.parents('.fire_department_shortcodes_tab').tabs('refresh');
	fire_department_options_init(tab.parents('.fire_department_shortcodes_tab').find('.fire_department_options_tab_content').eq(idx));
	tab.prev().find('a').trigger('click');
}



// Show one field layout
function fire_department_shortcodes_show_field(field, tab_idx) {
	"use strict";
	
	// html output
	var output = '';

	// Parse field params
	for (var clone_num in field['params']) {
		var tab_id = 'tab_' + (parseInt(tab_idx) + parseInt(clone_num));
		output += '<div id="fire_department_shortcodes_' + tab_id + '_content" class="fire_department_options_content fire_department_options_tab_content">';

		for (var param_num in field['params'][clone_num]) {
			
			var param = field['params'][clone_num][param_num];
			var id = tab_id + '_' + param_num;
	
			// Divider after field
			var divider = fire_department_isset(param['divider']) && param['divider'] ? ' fire_department_options_divider' : '';
		
			// Setup default parameters
			if (param['type']=='media') {
				if (!fire_department_isset(param['before'])) param['before'] = {};
				param['before'] = fire_department_merge_objects({
						'title': 'Choose image',
						'action': 'media_upload',
						'type': 'image',
						'multiple': false,
						'sizes': false,
						'linked_field': '',
						'captions': { 	
							'choose': 'Choose image',
							'update': 'Select image'
							}
					}, param['before']);
				if (!fire_department_isset(param['after'])) param['after'] = {};
				param['after'] = fire_department_merge_objects({
						'icon': 'iconadmin-cancel',
						'action': 'media_reset'
					}, param['after']);
			}
			if (param['type']=='color' && (FIRE_DEPARTMENT_STORAGE['shortcodes_cp']=='tiny' || (fire_department_isset(param['style']) && param['style']!='wp'))) {
				if (!fire_department_isset(param['after'])) param['after'] = {};
				param['after'] = fire_department_merge_objects({
						'icon': 'iconadmin-cancel',
						'action': 'color_reset'
					}, param['after']);
			}
		
			// Buttons before and after field
			var before = '', after = '', buttons_classes = '', rez, rez2, i, key, opt;
			
			if (fire_department_isset(param['before'])) {
				rez = fire_department_shortcodes_action_button(param['before'], 'before');
				before = rez[0];
				buttons_classes += rez[1];
			}
			if (fire_department_isset(param['after'])) {
				rez = fire_department_shortcodes_action_button(param['after'], 'after');
				after = rez[0];
				buttons_classes += rez[1];
			}
			if (fire_department_in_array(param['type'], ['list', 'select', 'fonts']) || (param['type']=='socials' && (fire_department_empty(param['style']) || param['style']=='icons'))) {
				buttons_classes += ' fire_department_options_button_after_small';
			}

			if (param['type'] != 'hidden') {
				output += '<div class="fire_department_options_field'
					+ ' fire_department_options_field_' + (fire_department_in_array(param['type'], ['list','fonts']) ? 'select' : param['type'])
					+ (fire_department_in_array(param['type'], ['media', 'fonts', 'list', 'select', 'socials', 'date', 'time']) ? ' fire_department_options_field_text'  : '')
					+ (param['type']=='socials' && !fire_department_empty(param['style']) && param['style']=='images' ? ' fire_department_options_field_images'  : '')
					+ (param['type']=='socials' && (fire_department_empty(param['style']) || param['style']=='icons') ? ' fire_department_options_field_icons'  : '')
					+ (fire_department_isset(param['dir']) && param['dir']=='vertical' ? ' fire_department_options_vertical' : '')
					+ (!fire_department_empty(param['multiple']) ? ' fire_department_options_multiple' : '')
					+ (fire_department_isset(param['size']) ? ' fire_department_options_size_'+param['size'] : '')
					+ (fire_department_isset(param['class']) ? ' ' + param['class'] : '')
					+ divider 
					+ '">' 
					+ "\n"
					+ '<label class="fire_department_options_field_label" for="' + id + '">' + param['title']
					+ '</label>'
					+ "\n"
					+ '<div class="fire_department_options_field_content'
					+ buttons_classes
					+ '">'
					+ "\n";
			}
			
			if (!fire_department_isset(param['value'])) {
				param['value'] = '';
			}
			

			switch ( param['type'] ) {
	
			case 'hidden':
				output += '<input class="fire_department_options_input fire_department_options_input_hidden" name="' + id + '" id="' + id + '" type="hidden" value="' + fire_department_shortcodes_prepare_value(param['value']) + '" data-param="' + fire_department_shortcodes_prepare_value(param_num) + '" />';
			break;

			case 'date':
				if (fire_department_isset(param['style']) && param['style']=='inline') {
					output += '<div class="fire_department_options_input_date"'
						+ ' id="' + id + '_calendar"'
						+ ' data-format="' + (!fire_department_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!fire_department_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-linked-field="' + (!fire_department_empty(data['linked_field']) ? data['linked_field'] : id) + '"'
						+ '></div>'
						+ '<input id="' + id + '"'
							+ ' name="' + id + '"'
							+ ' type="hidden"'
							+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
							+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
							+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
							+ ' />';
				} else {
					output += '<input class="fire_department_options_input fire_department_options_input_date' + (!fire_department_empty(param['mask']) ? ' fire_department_options_input_masked' : '') + '"'
						+ ' name="' + id + '"'
						+ ' id="' + id + '"'
						+ ' type="text"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-format="' + (!fire_department_empty(param['format']) ? param['format'] : 'yy-mm-dd') + '"'
						+ ' data-months="' + (!fire_department_empty(param['months']) ? max(1, min(3, param['months'])) : 1) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
						+ before 
						+ after;
				}
			break;

			case 'text':
				output += '<input class="fire_department_options_input fire_department_options_input_text' + (!fire_department_empty(param['mask']) ? ' fire_department_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
					+ (!fire_department_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '') 
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
				+ before 
				+ after;
			break;
		
			case 'textarea':
				var cols = fire_department_isset(param['cols']) && param['cols'] > 10 ? param['cols'] : '40';
				var rows = fire_department_isset(param['rows']) && param['rows'] > 1 ? param['rows'] : '8';
				output += '<textarea class="fire_department_options_input fire_department_options_input_textarea"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' cols="' + cols + '"'
					+ ' rows="' + rows + '"'
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ '>'
					+ param['value']
					+ '</textarea>';
			break;

			case 'spinner':
				output += '<input class="fire_department_options_input fire_department_options_input_spinner' + (!fire_department_empty(param['mask']) ? ' fire_department_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"' 
					+ (!fire_department_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '') 
					+ (fire_department_isset(param['min']) ? ' data-min="'+param['min']+'"' : '') 
					+ (fire_department_isset(param['max']) ? ' data-max="'+param['max']+'"' : '') 
					+ (!fire_department_empty(param['step']) ? ' data-step="'+param['step']+'"' : '') 
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />' 
					+ '<span class="fire_department_options_arrows"><span class="fire_department_options_arrow_up iconadmin-up-dir"></span><span class="fire_department_options_arrow_down iconadmin-down-dir"></span></span>';
			break;

			case 'tags':
				var tags = param['value'].split(FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter']);
				if (tags.length > 0) {
					for (i=0; i<tags.length; i++) {
						if (fire_department_empty(tags[i])) continue;
						output += '<span class="fire_department_options_tag iconadmin-cancel">' + tags[i] + '</span>';
					}
				}
				output += '<input class="fire_department_options_input_tags"'
					+ ' type="text"'
					+ ' value=""'
					+ ' />'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case "checkbox": 
				output += '<input type="checkbox" class="fire_department_options_input fire_department_options_input_checkbox"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' value="true"' 
					+ (param['value'] == 'true' ? ' checked="checked"' : '') 
					+ (!fire_department_empty(param['disabled']) ? ' readonly="readonly"' : '') 
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<label for="' + id + '" class="' + (!fire_department_empty(param['disabled']) ? 'fire_department_options_state_disabled' : '') + (param['value']=='true' ? ' fire_department_options_state_checked' : '') + '"><span class="fire_department_options_input_checkbox_image iconadmin-check"></span>' + (!fire_department_empty(param['label']) ? param['label'] : param['title']) + '</label>';
			break;
		
			case "radio":
				for (key in param['options']) { 
					output += '<span class="fire_department_options_radioitem"><input class="fire_department_options_input fire_department_options_input_radio" type="radio"'
						+ ' name="' + id + '"'
						+ ' value="' + fire_department_shortcodes_prepare_value(key) + '"'
						+ ' data-value="' + fire_department_shortcodes_prepare_value(key) + '"'
						+ (param['value'] == key ? ' checked="checked"' : '') 
						+ ' id="' + id + '_' + key + '"'
						+ ' />'
						+ '<label for="' + id + '_' + key + '"' + (param['value'] == key ? ' class="fire_department_options_state_checked"' : '') + '><span class="fire_department_options_input_radio_image iconadmin-circle-empty' + (param['value'] == key ? ' iconadmin-dot-circled' : '') + '"></span>' + param['options'][key] + '</label></span>';
				}
				output += '<input type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';

			break;
		
			case "switch":
				opt = [];
				i = 0;
				for (key in param['options']) {
					opt[i++] = {'key': key, 'title': param['options'][key]};
					if (i==2) break;
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + fire_department_shortcodes_prepare_value(fire_department_empty(param['value']) ? opt[0]['key'] : param['value']) + '"'
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ '<span class="fire_department_options_switch' + (param['value']==opt[1]['key'] ? ' fire_department_options_state_off' : '') + '"><span class="fire_department_options_switch_inner iconadmin-circle"><span class="fire_department_options_switch_val1" data-value="' + opt[0]['key'] + '">' + opt[0]['title'] + '</span><span class="fire_department_options_switch_val2" data-value="' + opt[1]['key'] + '">' + opt[1]['title'] + '</span></span></span>';
			break;

			case 'media':
				output += '<input class="fire_department_options_input fire_department_options_input_text fire_department_options_input_media"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text"'
					+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
					+ (!fire_department_isset(param['readonly']) || param['readonly'] ? ' readonly="readonly"' : '')
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ before 
					+ after;
				if (!fire_department_empty(param['value'])) {
					var fname = fire_department_get_file_name(param['value']);
					var fext  = fire_department_get_file_ext(param['value']);
					output += '<a class="fire_department_options_image_preview" rel="prettyPhoto" target="_blank" href="' + param['value'] + '">' + (fext!='' && fire_department_in_list('jpg,png,gif', fext, ',') ? '<img src="'+param['value']+'" alt="" />' : '<span>'+fname+'</span>') + '</a>';
				}
			break;
		
			case 'button':
				rez = fire_department_shortcodes_action_button(param, 'button');
				output += rez[0];
			break;

			case 'range':
				output += '<div class="fire_department_options_input_range" data-step="'+(!fire_department_empty(param['step']) ? param['step'] : 1) + '">'
					+ '<span class="fire_department_options_range_scale"><span class="fire_department_options_range_scale_filled"></span></span>';
				if (param['value'].toString().indexOf(FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter']) == -1)
					param['value'] = Math.min(param['max'], Math.max(param['min'], param['value']));
				var sliders = param['value'].toString().split(FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter']);
				for (i=0; i<sliders.length; i++) {
					output += '<span class="fire_department_options_range_slider"><span class="fire_department_options_range_slider_value">' + sliders[i] + '</span><span class="fire_department_options_range_slider_button"></span></span>';
				}
				output += '<span class="fire_department_options_range_min">' + param['min'] + '</span><span class="fire_department_options_range_max">' + param['max'] + '</span>'
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />'
					+ '</div>';			
			break;
		
			case "checklist":
				for (key in param['options']) { 
					output += '<span class="fire_department_options_listitem'
						+ (fire_department_in_list(param['value'], key, FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter']) ? ' fire_department_options_state_checked' : '') + '"'
						+ ' data-value="' + fire_department_shortcodes_prepare_value(key) + '"'
						+ '>'
						+ param['options'][key]
						+ '</span>';
				}
				output += '<input name="' + id + '"'
					+ ' type="hidden"'
					+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />';
			break;
		
			case 'fonts':
				for (key in param['options']) {
					param['options'][key] = key;
				}
			case 'list':
			case 'select':
				if (!fire_department_isset(param['options']) && !fire_department_empty(param['from']) && !fire_department_empty(param['to'])) {
					param['options'] = [];
					for (i = param['from']; i <= param['to']; i+=(!fire_department_empty(param['step']) ? param['step'] : 1)) {
						param['options'][i] = i;
					}
				}
				rez = fire_department_shortcodes_menu_list(param);
				if (fire_department_empty(param['style']) || param['style']=='select') {
					output += '<input class="fire_department_options_input fire_department_options_input_select" type="text" value="' + fire_department_shortcodes_prepare_value(rez[1]) + '"'
						+ ' readonly="readonly"'
						+ ' />'
						+ '<span class="fire_department_options_field_after fire_department_options_with_action iconadmin-down-open" onchange="fire_department_options_action_show_menu(this);return false;"></span>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'images':
				rez = fire_department_shortcodes_menu_list(param);
				if (fire_department_empty(param['style']) || param['style']=='select') {
					output += '<div class="fire_department_options_caption_image iconadmin-down-open">'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;
		
			case 'icons':
				rez = fire_department_shortcodes_menu_list(param);
				if (fire_department_empty(param['style']) || param['style']=='select') {
					output += '<div class="fire_department_options_caption_icon iconadmin-down-open"><span class="' + rez[1] + '"></span></div>';
				}
				output += rez[0]
					+ '<input name="' + id + '"'
						+ ' type="hidden"'
						+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
						+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
						+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
						+ ' />';
			break;

			case 'socials':
				if (!fire_department_is_object(param['value'])) param['value'] = {'url': '', 'icon': ''};
				rez = fire_department_shortcodes_menu_list(param);
				if (fire_department_empty(param['style']) || param['style']=='icons') {
					rez2 = fire_department_shortcodes_action_button({
						'action': fire_department_empty(param['style']) || param['style']=='icons' ? 'select_icon' : '',
						'icon': (fire_department_empty(param['style']) || param['style']=='icons') && !fire_department_empty(param['value']['icon']) ? param['value']['icon'] : 'iconadmin-users'
						}, 'after');
				} else
					rez2 = ['', ''];
				output += '<input class="fire_department_options_input fire_department_options_input_text fire_department_options_input_socials' 
					+ (!fire_department_empty(param['mask']) ? ' fire_department_options_input_masked' : '') + '"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' type="text" value="' + fire_department_shortcodes_prepare_value(param['value']['url']) + '"' 
					+ (!fire_department_empty(param['mask']) ? ' data-mask="'+param['mask']+'"' : '') 
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ rez2[0];
				if (!fire_department_empty(param['style']) && param['style']=='images') {
					output += '<div class="fire_department_options_caption_image iconadmin-down-open">'
						+'<span style="background-image: url(' + rez[1] + ')"></span>'
						+'</div>';
				}
				output += rez[0]
					+ '<input name="' + id + '_icon' + '" type="hidden" value="' + fire_department_shortcodes_prepare_value(param['value']['icon']) + '" />';
			break;

			case "color":
				var cp_style = fire_department_isset(param['style']) ? param['style'] : FIRE_DEPARTMENT_STORAGE['shortcodes_cp'];
				output += '<input class="fire_department_options_input fire_department_options_input_color fire_department_options_input_color_'+cp_style +'"'
					+ ' name="' + id + '"'
					+ ' id="' + id + '"'
					+ ' data-param="' + fire_department_shortcodes_prepare_value(param_num) + '"'
					+ ' type="text"'
					+ ' value="' + fire_department_shortcodes_prepare_value(param['value']) + '"'
					+ (!fire_department_empty(param['action']) ? ' onchange="fire_department_options_action_'+param['action']+'(this);return false;"' : '')
					+ ' />'
					+ before;
				if (cp_style=='custom')
					output += '<span class="fire_department_options_input_colorpicker iColorPicker"></span>';
				else if (cp_style=='tiny')
					output += after;
			break;   
	
			}

			if (param['type'] != 'hidden') {
				output += '</div>';
				if (!fire_department_empty(param['desc']))
					output += '<div class="fire_department_options_desc">' + param['desc'] + '</div>' + "\n";
				output += '</div>' + "\n";
			}

		}

		output += '</div>';
	}

	
	return output;
}



// Return menu items list (menu, images or icons)
function fire_department_shortcodes_menu_list(field) {
	"use strict";
	if (field['type'] == 'socials') field['value'] = field['value']['icon'];
	var list = '<div class="fire_department_options_input_menu ' + (fire_department_empty(field['style']) ? '' : ' fire_department_options_input_menu_' + field['style']) + '">';
	var caption = '';
	for (var key in field['options']) {
		var value = field['options'][key];
		if (fire_department_in_array(field['type'], ['list', 'icons', 'socials'])) key = value;
		var selected = '';
		if (fire_department_in_list(field['value'], key, FIRE_DEPARTMENT_STORAGE['shortcodes_delimiter'])) {
			caption = value;
			selected = ' fire_department_options_state_checked';
		}
		list += '<span class="fire_department_options_menuitem' 
			+ selected 
			+ '" data-value="' + fire_department_shortcodes_prepare_value(key) + '"'
			+ '>';
		if (fire_department_in_array(field['type'], ['list', 'select', 'fonts']))
			list += value;
		else if (field['type'] == 'icons' || (field['type'] == 'socials' && field['style'] == 'icons'))
			list += '<span class="' + value + '"></span>';
		else if (field['type'] == 'images' || (field['type'] == 'socials' && field['style'] == 'images'))
			list += '<span style="background-image:url(' + value + ')" data-src="' + value + '" data-icon="' + key + '" class="fire_department_options_input_image"></span>';
		list += '</span>';
	}
	list += '</div>';
	return [list, caption];
}



// Return action button
function fire_department_shortcodes_action_button(data, type) {
	"use strict";
	var class_name = ' fire_department_options_button_' + type + (fire_department_empty(data['title']) ? ' fire_department_options_button_'+type+'_small' : '');
	var output = '<span class="' 
				+ (type == 'button' ? 'fire_department_options_input_button'  : 'fire_department_options_field_'+type)
				+ (!fire_department_empty(data['action']) ? ' fire_department_options_with_action' : '')
				+ (!fire_department_empty(data['icon']) ? ' '+data['icon'] : '')
				+ '"'
				+ (!fire_department_empty(data['icon']) && !fire_department_empty(data['title']) ? ' title="'+fire_department_shortcodes_prepare_value(data['title'])+'"' : '')
				+ (!fire_department_empty(data['action']) ? ' onclick="fire_department_options_action_'+data['action']+'(this);return false;"' : '')
				+ (!fire_department_empty(data['type']) ? ' data-type="'+data['type']+'"' : '')
				+ (!fire_department_empty(data['multiple']) ? ' data-multiple="'+data['multiple']+'"' : '')
				+ (!fire_department_empty(data['sizes']) ? ' data-sizes="'+data['sizes']+'"' : '')
				+ (!fire_department_empty(data['linked_field']) ? ' data-linked-field="'+data['linked_field']+'"' : '')
				+ (!fire_department_empty(data['captions']) && !fire_department_empty(data['captions']['choose']) ? ' data-caption-choose="'+fire_department_shortcodes_prepare_value(data['captions']['choose'])+'"' : '')
				+ (!fire_department_empty(data['captions']) && !fire_department_empty(data['captions']['update']) ? ' data-caption-update="'+fire_department_shortcodes_prepare_value(data['captions']['update'])+'"' : '')
				+ '>'
				+ (type == 'button' || (fire_department_empty(data['icon']) && !fire_department_empty(data['title'])) ? data['title'] : '')
				+ '</span>';
	return [output, class_name];
}

// Prepare string to insert as parameter's value
function fire_department_shortcodes_prepare_value(val) {
	return typeof val == 'string' ? val.replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/'/g, '&#039;').replace(/</g, '&lt;').replace(/>/g, '&gt;') : val;
}
