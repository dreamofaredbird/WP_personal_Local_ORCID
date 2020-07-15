( function( wp ) {
	/**
	 * Registers a new block provided a unique name and an object defining its behavior.
	 * @see https://github.com/WordPress/gutenberg/tree/master/blocks#api
	 */
	var registerBlockType = wp.blocks.registerBlockType;
	/**
	 * Returns a new element of given type. Element is an abstraction layer atop React.
	 * @see https://github.com/WordPress/gutenberg/tree/master/element#element
	 */
	var el = wp.element.createElement;
	/**
	 * Retrieves the translation of text.
	 * @see https://github.com/WordPress/gutenberg/tree/master/i18n#api
	 */
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
			{ d: "M0 0h24v24H0z", fill: 'none' }
		)
	);
	iconGroup.push(	el(
			'path',
			{ d: "M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z"}
		)
	);
	
	var iconEl = el(
		'svg', 
		{ width: 24, height: 24 },
		iconGroup
	);	

	registerBlockType( 'easy-faqs-pro/submit-faqs', {
		title: __( 'Submit Your Question Form' ),
		category: 'easy-faqs',
		supports: {
			html: false,
		},
		edit: function( props ) {
			var retval = [],
				inspector_controls = [],
				display_fields = [],
				title = props.attributes.title || '',
				focus = props.isSelected;
				
				display_fields.push( 
					text_control( __('Title'), title, '', function( newVal ) {
						props.setAttributes({
							title: newVal,
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
				inner_fields.push( el('blockquote', { className: 'faq-list-placeholder' }, __('A form for your visitors to submit new questions.') ) );
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
		},
		icon: iconEl,
	} );
} )(
	window.wp
);
