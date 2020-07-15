( function( wp ) {
	var registerBlockType = wp.blocks.registerBlockType;
	var el = wp.element.createElement;
	var __ = wp.i18n.__;
	
	var get_theme_group_label = function(theme_group_key) {
		if ( typeof(easy_faqs_admin_list_faqs.theme_group_labels[theme_group_key]) !== 'undefined' ) {
			return easy_faqs_admin_list_faqs.theme_group_labels[theme_group_key];
		}
		return 'Themes';
	};	

	var build_category_options = function(categories) {
		var opts = [
			{
				label: 'All Categories',
				value: ''
			}
		];

		// build list of options from goals
		for( var i in categories ) {
			cat = categories[i];
			opts.push( 
			{
				label: cat.name,
				value: cat.slug
			});
		}
		return opts;
	};	

	var get_theme_options = function() {
		var theme_opts = [];
		for( theme_group in easy_faqs_admin_list_faqs.themes ) {
			//theme_group_label = get_theme_group_label(theme_group);
			for ( theme_name in easy_faqs_admin_list_faqs.themes[theme_group] ) {
				theme_opts.push({
					label: easy_faqs_admin_list_faqs.themes[theme_group][theme_name],
					value: theme_name,
				});				
			}
		}
		return theme_opts;
	};
	
	var extract_label_from_options = function (opts, val) {
		var label = '';
		for (j in opts) {
			if ( opts[j].value == val ) {
				label = opts[j].label;
				break;
			}										
		}
		return label;
	};
	
	var checkbox_control = function (label, checked, onChangeFn) {
		// add checkboxes for which fields to display
		var controlOptions = {
			checked: checked,
			label: label,
			value: '1',
			onChange: onChangeFn,
		};	
		return el(  wp.components.CheckboxControl, controlOptions );
	};
	
	var text_control = function (label, value, className, onChangeFn) {
		var controlOptions = {
			label: label,
			value: value,
			className: className,
			onChange: onChangeFn,
		};
		return el(  wp.components.TextControl, controlOptions );
	};

	var radio_control = function (label, value, options, className, onChangeFn) {
		var controlOptions = {
			label: label,
			onChange: onChangeFn,
			options: options,
			selected: value,
			className: '',
		};
		return el(  wp.components.RadioControl, controlOptions );
	};

	var update_paginate_panel = function () {
		setTimeout( function () {
			var field_groups =  jQuery('.janus_editor_field_group');
			field_groups.each(function () {
				field_group = jQuery(this);
				var val = field_group.find(':checked').val();
				if ( 'max' == val ) {
					field_group.find('.field_per_page').show();
					field_group.find('.field_count').hide();
				}
				else if ( 'paginate' == val ) {
					field_group.find('.field_per_page').hide();
					field_group.find('.field_count').show();
				}
				else {
					field_group.find('.field_per_page').hide();
					field_group.find('.field_count').hide();
				}			
				
				return true;
			});
		}, 100 );
	};
	
	var iconGroup = [];
	iconGroup.push(	el(
			'path',
			{ d: "M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"}
		)
	);
	iconGroup.push(	el(
			'path',
			{ d: "M0 0h24v24H0z", fill: 'none' }
		)
	);
	
	var iconEl = el(
		'svg', 
		{ width: 24, height: 24 },
		iconGroup
	);

	registerBlockType( 'easy-faqs-pro/search-faqs', {
		title: __( 'Search FAQs' ),
		category: 'easy-faqs',
		supports: {
			// Removes support for an HTML mode.
			html: false,
		},
		edit: function( props ) {
			var retval = [],
				inspector_controls = [],
				display_fields = [],
				title = props.attributes.title || '',
				show_category_select = typeof(props.attributes.show_category_select) != 'undefined' ? props.attributes.show_category_select : false,
				focus = props.isSelected;
				
				display_fields.push( 
					text_control( __('Title'), title, '', function( newVal ) {
						props.setAttributes({
							title: newVal,
						});
					})
				);

				display_fields.push( 
					checkbox_control( __('Allow the user to select a category'), show_category_select, function( newVal ) {
						props.setAttributes({
							show_category_select: newVal,
						});
					})
				);
				
				inspector_controls.push( 
					el (
						wp.components.PanelBody,
						{
							title: __('Form Options'),
							className: 'gp-panel-body',
							initialOpen: false,
						},
						el('div', { className: 'janus_editor_field_group' }, display_fields)
					)
				);

				retval.push(
					el( wp.editor.InspectorControls, {}, inspector_controls ) 
				);

				var inner_fields = [];
				inner_fields.push( el('h3', { className: 'block-heading' }, 'Easy FAQs - Search FAQs') );
				inner_fields.push( el('blockquote', { className: 'faq-list-placeholder' }, __('A form to search the FAQs in your database.') ) );
				retval.push( el('div', {'className': 'easy-faqs-editor-not-selected'}, inner_fields ) );
				return el( 'div', { className: 'easy-faqs-faqs-by-category-editor'}, retval );						
		},
		save: function() {
			return null;
		},
		attributes: {
			title: {
				type: 'string',
			},
			show_category_select: {
				type: 'boolean',
			},
		},
		icon: iconEl,
	} );
} )(
	window.wp
);
