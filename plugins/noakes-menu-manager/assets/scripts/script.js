/*! Primary plugin JavaScript. * @since 2.0.0 * @package Nav Menu Manager */

/**
 * Options object.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var nmm_script_options = nmm_script_options || {};

/**
 * Current WordPress admin page ID.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
var pagenow = pagenow || '';

/**
 * WordPress postboxes object.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var postboxes = postboxes || {};

/**
 * Main WordPress utilities object.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var wp = window.wp || {};

/**
 * Main WordPress nav menus object.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var wpNavMenu = wpNavMenu || {};

/**
 * Nav menu item currently being dragged.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var nmm_dragged_item = null;

/**
 * Last nav menu item dropped.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var nmm_dropped_item = null;

/**
 * Item currently hovered over.
 * 
 * @since 2.0.0
 * 
 * @var object
 */
var nmm_hovered_item = null;

/**
 * WordPress AJAX URL.
 * 
 * @since 2.0.0
 * 
 * @var string
 */
var ajaxurl = ajaxurl || '';

(function ($)
{
	'use strict';
	
	$.fn.extend(
	{
		/**
		 * Add a custom event to all provided elements.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.fn.nmm_add_event
		 * @this   object     Elements to add the event to.
		 * @param  string   e Event name to add to all elements.
		 * @param  function f Function executed when the event is fired.
		 * @return object     Updated elements.
		 */
		"nmm_add_event": function (e, f)
		{
			return this.addClass(e).on(e, f).nmm_trigger_all(e);
		},
		
		/**
		 * Fire an event on all provided elements.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.fn.nmm_trigger_all
		 * @this   object      Elements to fire the event on.
		 * @param  string e    Event name to fire on all elements.
		 * @param  array  args Extra arguments to pass to the event call.
		 * @return object      Triggered elements.
		 */
		"nmm_trigger_all": function (e, args)
		{
			args = ($.type(args) === 'undefined') ? [] : args;
			args = ($.isArray(args)) ? args : [args];
			
			return this
			.each(function ()
			{
				$(this).triggerHandler(e, args);
			});
		},
		
		/**
		 * Check for and return unprepared elements.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.fn.nmm_unprepared
		 * @this   object              Elements to check.
		 * @param  string class_suffix Suffix to add to the prepared class name.
		 * @return object              Unprepared elements.
		 */
		"nmm_unprepared": function (class_suffix)
		{
			var class_name = 'nmm-prepared';
			class_name += (class_suffix) ? '-' + class_suffix : '';
			
			return this.not('.' + class_name).addClass(class_name);
		}
	});
	
	/**
	 * General variables.
	 * 
	 * @since 2.0.0
	 * 
	 * @access jQuery.nmm
	 * @var    object
	 */
	$.nmm = $.nmm || {};

	$.extend($.nmm,
	{
		"body": $(document.body),
		"document": $(document),
		"options": nmm_script_options,
		"window": $(window),
		
		"scroll_element": $('html,body')
		.on('DOMMouseScroll keyup mousedown mousewheel scroll touchmove wheel', function ()
		{
			$(this).stop();
		})
	});
	
	/**
	 * Custom data variable names.
	 * 
	 * @since 2.0.0
	 * 
	 * @access jQuery.nmm.data
	 * @var    object
	 */
	$.nmm.data = $.nmm.data || {};

	$.extend($.nmm.data,
	{
		"help_tab_id": 'nmm-help-tab-id'
	});

	/**
	 * Custom event names.
	 * 
	 * @since 2.0.0
	 * 
	 * @access jQuery.nmm.events
	 * @var    object
	 */
	$.nmm.events = $.nmm.events || {};
	
	$.extend($.nmm.events,
	{
		"setup": 'nmm-setup'
	});
	
	/**
	 * Global JSON object.
	 * 
	 * @since 2.0.0
	 * 
	 * @access jQuery.nmm.global
	 * @var    object
	 */
	$.nmm.global = $.nmm.global || {};
	
	$.extend($.nmm.global,
	{
		/**
		 * Prepare plugin help buttons.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.global.help_buttons
		 * @param  object parent Parent object that contains the help buttons to prepare.
		 * @return void
		 */
		"help_buttons": function (parent)
		{
			var buttons = (typeof parent === 'undefined') ? $('#contextual-help-wrap .nmm-help-button[data-' + $.nmm.data.help_tab_id + '],.wrap .nmm-help-button[data-' + $.nmm.data.help_tab_id + ']').not('.nmm-disabled') : parent.find('.nmm-help-button');
			
			buttons.nmm_unprepared()
			.css(
			{
				"display": 'inline-block',
				"opacity": '1'
			})
			.click(function (e)
			{
				e.stopPropagation();
				
				$.nmm.scroll_element
				.animate(
				{
					"scrollTop": '0px'
				},
				{
					"queue": false
				});
				
				var clicked = $(this);
				var screen_options = $('#show-settings-link');
				
				var open_help = function ()
				{
					$('#tab-link-' + clicked.data($.nmm.data.help_tab_id) + ' > a').click();
					$('#contextual-help-link').not('.screen-meta-active').click();
				};
				
				if (screen_options.hasClass('screen-meta-active'))
				{
					screen_options.click();
					
					setTimeout(open_help, 250);
				}
				else
				{
					open_help();
				}
			});

			$('#screen-options-wrap .nmm-help-button').remove();
		},
		
		/**
		 * Prepare plugin help tabs.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.global.help_tabs
		 * @return void
		 */
		"help_tabs": function ()
		{
			var help = $('#contextual-help-columns');

			help.find('li[id^="tab-link-nmm-"],.help-tab-content[id^="tab-panel-nmm-"]')
			.each(function ()
			{
				var current = $(this);
				current.appendTo(current.parent());
			});

			help.find('.contextual-help-tabs > ul,.contextual-help-tabs-wrap')
			.each(function ()
			{
				$(this).children().removeClass('active').first().addClass('active');
			});
		}
	});
	
	$.nmm.document
	.ready(function ()
	{
		$.nmm.global.help_buttons();
		$.nmm.global.help_tabs();
	});
	
	if ($.nmm.options.is_settings)
	{
		/**
		 * Custom data variable names specific to settings.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.data
		 * @var    object
		 */
		$.extend($.nmm.data,
		{
			"compare": 'nmm-compare',
			"conditional": 'nmm-conditional',
			"field": 'nmm-field',
			"identifier": 'nmm-identifier',
			"index": 'nmm-index',
			"last_index": 'nmm-last-index',
			"value": 'nmm-value'
		});
		
		/**
		 * Custom event names specific to settings.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.events
		 * @var    object
		 */
		$.extend($.nmm.events,
		{
			"check_conditions": 'nmm-check-conditions',
			"display": 'nmm-display',
			"set_index": 'nmm-set-index'
		});
		
		/**
		 * Settings JSON object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.settings
		 * @var    object
		 */
		$.nmm.settings = $.nmm.settings || {};
		
		$.extend($.nmm.settings,
		{
			/**
			 * Prepare the code fields.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.settings.code_fields
			 * @return void
			 */
			"code_fields": function ()
			{
				$('.nmm-code-wrapper')
				.each(function ()
				{
					var current = $(this);

					current.find('.nmm-copied')
					.on($.nmm.events.display, function ()
					{
						var displayed = $(this);

						if (displayed.is(':hidden'))
						{
							displayed
							.fadeIn(125, function ()
							{
								setTimeout(function ()
								{
									displayed.fadeOut(125);
								},
								1000);
							});
						}
					});

					current.find('button')
					.each(function (index)
					{
						$(this).data($.nmm.data.index, index);
					})
					.click(function ()
					{
						var clicked = $(this).addClass('button-primary');
						clicked.siblings('button').removeClass('button-primary');
						clicked.siblings('pre').hide().eq(clicked.data($.nmm.data.index)).show();
					});

					current.find('pre')
					.click(function ()
					{
						var range, selection;

						if (document.body.createTextRange)
						{
							range = document.body.createTextRange();
							range.moveToElementText(this);
							range.select();
						}
						else if (window.getSelection)
						{
							selection = window.getSelection();        
							range = document.createRange();
							range.selectNodeContents(this);
							selection.removeAllRanges();
							selection.addRange(range);
						}

						document.execCommand('copy');

						$(this).siblings('.nmm-copied').triggerHandler($.nmm.events.display);
					});
				});
			},

			/**
			 * Prepare fields with conditional logic.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.settings.conditional_logic
			 * @return void
			 */
			"conditional_logic": function ()
			{
				$('.nmm-condition[data-' + $.nmm.data.conditional + '][data-' + $.nmm.data.field + '][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
				.each(function ()
				{
					var condition = $(this);
					var conditional = $('[name="' + condition.data($.nmm.data.conditional) + '"]');
					var field = $('[name="' + condition.data($.nmm.data.field) + '"]');

					if (!conditional.hasClass($.nmm.events.check_conditions))
					{
						conditional
						.nmm_add_event($.nmm.events.check_conditions, function ()
						{
							var current_conditional = $(this);
							var show_field = true;

							$('.nmm-condition[data-' + $.nmm.data.conditional + '="' + current_conditional.attr('name') + '"][data-' + $.nmm.data.field + '][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
							.each(function ()
							{
								var current_condition = $(this);
								var current_field = $('[name="' + current_condition.data($.nmm.data.field) + '"]');
								var current_value = (current_field.is(':radio')) ? current_field.filter(':checked').val() : current_field.val();
								var compare = current_condition.data($.nmm.data.compare);
								var compare_matched = false;

								if (current_field.is(':checkbox'))
								{
									current_value = (current_field.is(':checked')) ? current_value : '';
								}

								if (compare === '!=')
								{
									compare_matched = (current_condition.data($.nmm.data.value) + '' !== current_value + '');
								}
								else
								{
									compare_matched = (current_condition.data($.nmm.data.value) + '' === current_value + '');
								}

								show_field = (show_field && compare_matched);
							});

							var parent = current_conditional.closest('.nmm-field');
							parent.next('.nmm-field-spacer').remove();

							if (show_field)
							{
								parent.stop(true).slideDown(125);
							}
							else
							{
								parent.stop(true).slideUp(125).after($('<div/>').addClass('nmm-hidden nmm-field-spacer'));
							}
						});
					}

					if (!field.hasClass('nmm-has-condition'))
					{
						field.addClass('nmm-has-condition')
						.on('change', function ()
						{
							$('.nmm-condition[data-' + $.nmm.data.conditional + '][data-' + $.nmm.data.field + '="' + $(this).attr('name') + '"][data-' + $.nmm.data.value + '][data-' + $.nmm.data.compare + ']')
							.each(function ()
							{
								$('[name="' + $(this).data($.nmm.data.conditional) + '"]').nmm_trigger_all($.nmm.events.check_conditions);
							});
						});
					}
				});
			},

			/**
			 * Prepare the form.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.settings.form
			 * @return void
			 */
			"form": function ()
			{
				$.extend($.validator.messages, $.nmm.options.validator);

				$('.wrap > form')
				.each(function ()
				{
					$(this)
					.validate(
					{
						"errorClass": 'nmm-error',
						"errorElement": 'div',
						"focusInvalid": false,

						"invalidHandler": function (e, validator)
						{
							if (!validator.numberOfInvalids())
							{
								return;
							}

							var admin_bar_height = $('#wpadminbar').height();
							var window_height = $.nmm.window.height() - admin_bar_height;
							var element = $(validator.errorList[0].element);
							var element_height = element.outerHeight();

							var scroll_top = element.offset().top - admin_bar_height;
							scroll_top -= (element_height > window_height) ? 0 : Math.floor((window_height - element_height) / 2);

							$.nmm.scroll_element
							.animate(
							{
								"scrollTop": Math.max(0, Math.min($.nmm.document.height() - window_height, scroll_top)) + 'px'
							},
							{
								"queue": false
							});
						},

						"submitHandler": function (form)
						{
							$(form).find('[type="submit"]').prop('disabled', true);

							form.submit();
						}
					});
				})
				.find('[type="submit"]').prop('disabled', false);
			},

			/**
			 * Include postboxes functionality.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.settings.postboxes
			 * @return void
			 */
			"postboxes": function ()
			{
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');

				if ($.type(postboxes) !== 'undefined' && $.type(pagenow) !== 'undefined')
				{
					postboxes.add_postbox_toggles(pagenow);
				}
			},
			
			/**
			 * Prepare repeatable fields.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.settings.repeatables
			 * @return void
			 */
			"repeatables": function ()
			{
				var repeatables = $('.nmm-repeatable');
				
				if (repeatables.length > 0)
				{
					repeatables
					.on($.nmm.events.setup, function ()
					{
						var repeatable = $(this);

						if (!repeatable.hasClass('ui-sortable') && repeatable.is(':visible'))
						{
							repeatable
							.mousedown(function ()
							{
								var clicked = $(this);
								clicked.height(clicked.height());
							})
							.mouseup(function ()
							{
								$(this).css('height', '');
							})
							.sortable(
							{
								"containment": 'parent',
								"cursor": 'move',
								"forcePlaceholderSize": true,
								"handle": '> .nmm-repeatable-move',
								"items": '> .nmm-repeatable-item',
								"opacity": 0.75,
								"placeholder": 'nmm-repeatable-placeholder',
								"revert": 125,
								"tolerance": 'pointer',

								"stop": function (e, ui)
								{
									ui.item.parent('.nmm-repeatable').children('.nmm-repeatable-item').first().triggerHandler($.nmm.events.set_index, [0]);
								}
							});
						}

						if (repeatable.children('.nmm-repeatable-item').not('.nmm-repeatable-template').length <= 1)
						{
							repeatable.sortable('disable');
						}
						else
						{
							repeatable.sortable('enable');
						}
					})
					.nmm_trigger_all($.nmm.events.setup);

					var items = $('.nmm-repeatable-item')
					.on($.nmm.events.set_index, function (e, index, force_rebuild)
					{
						var current = $(this);

						if (!$.isNumeric(index) || index < 0)
						{
							index = current.parent().children('.nmm-repeatable-item').not('nmm-repeatable-template').index(current);
						}

						if (force_rebuild || index !== current.data($.nmm.data.last_index))
						{
							current.data($.nmm.data.last_index, index);

							var placeholder = $('<div/>').addClass('nmm-repeatable-placeholder').insertBefore(current);

							current.detach().find('[data-' + $.nmm.data.identifier + ']').not('.nmm-input-template')
							.each(function ()
							{
								var field = $(this);
								var identifier = field.data($.nmm.data.identifier).replace('[__i__]', '[' + index + ']');

								if (field.is('label'))
								{
									field.attr('for', identifier);
								}
								else
								{
									field
									.attr(
									{
										"id": identifier,
										"name": identifier
									});
								}
							});

							current.insertBefore(placeholder).children('.nmm-repeatable-move').children('.nmm-repeatable-count').text(index + 1);
							placeholder.remove();
							current.find('.nmm-repeatable-item:visible').first().triggerHandler($.nmm.events.set_index, [0, true]);
						}

						current.next('.nmm-repeatable-item:visible').triggerHandler($.nmm.events.set_index, [index + 1]);
					});

					$('.nmm-repeatable-add button')
					.click(function (e, insert_before)
					{
						var template = $(this).parent().prev();

						var adding = template.clone(true).removeClass('nmm-repeatable-template');
						adding.find('.nmm-input-template').removeClass('nmm-input-template');

						if (insert_before instanceof $ && insert_before.length > 0)
						{
							adding.insertBefore(insert_before);
						}
						else
						{
							adding.insertBefore(template);
						}

						adding.triggerHandler($.nmm.events.set_index);

						var height = adding.innerHeight();

						adding
						.css(
						{
							"height": '0',
							"opacity": '0'
						})
						.animate(
						{
							"height": height + 'px',
							"opacity": '1'
						},
						{
							"duration": 125,
							"queue": false,

							"complete": function ()
							{
								$(this).css('height', '');
							}
						});

						adding.parent().triggerHandler($.nmm.events.setup);
					});

					var buttons = $(wp.template('nmm-repeatable-buttons')())
					.click(function (e)
					{
						if ($(this).closest('.nmm-repeatable').is(':animated'))
						{
							e.stopImmediatePropagation();
						}
					});

					buttons.filter('.nmm-repeatable-move-up')
					.click(function ()
					{
						var parent = $(this).parent();
						var prev = parent.prev('.nmm-repeatable-item');

						if (prev.length > 0)
						{
							parent.insertBefore(prev).triggerHandler($.nmm.events.set_index);
						}
					});

					buttons.filter('.nmm-repeatable-move-down')
					.click(function ()
					{
						var parent = $(this).parent();
						var next = parent.next('.nmm-repeatable-item').not('.nmm-repeatable-template');

						if (next.length > 0)
						{
							parent.insertAfter(next);
							next.triggerHandler($.nmm.events.set_index);
						}
					});

					buttons.filter('.nmm-repeatable-insert')
					.click(function ()
					{
						var parent = $(this).parent();
						parent.parent().children('.nmm-repeatable-add').children('button').triggerHandler('click', [parent]);
					});

					buttons.filter('.nmm-repeatable-remove')
					.click(function ()
					{
						var parent = $(this).parent();
						var repeatable = parent.parent();
						var next = parent.next('.nmm-repeatable-item').not('.nmm-repeatable-template');

						parent
						.animate(
						{
							"height": '0px',
							"opacity": '0'
						},
						{
							"duration": 125,
							"queue": false,

							"complete": function ()
							{
								$(this).remove();

								if (next.length > 0)
								{
									next.triggerHandler($.nmm.events.set_index);
								}

								repeatable.triggerHandler($.nmm.events.setup);
							}
						});
					});

					items
					.each(function ()
					{
						buttons.clone(true).appendTo($(this));
					})
					.first().triggerHandler($.nmm.events.set_index);
				}
			}
		});
		
		$.nmm.document
		.ready(function ()
		{
			$.nmm.settings.code_fields();
			$.nmm.settings.conditional_logic();
			$.nmm.settings.form();
			$.nmm.settings.postboxes();
			$.nmm.settings.repeatables();
		});
	}
	else if ($.nmm.options.is_nav_menus && ($.nmm.options.custom_fields !== '0' || $.nmm.options.collapsed !== '0'))
	{
		$.fn.extend(
		{
			/**
			 * Return the direct children for the provided nav menu item.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.fn.nmm_direct_child_menu_items
			 * @this   object Nav menu item to get children for.
			 * @return object Direct nav menu item children.
			 */
			"nmm_direct_child_menu_items": function ()
			{
				var result = $();

				this
				.each(function ()
				{
					var menu_item = $(this);
					var depth = menu_item.menuItemDepth();
					var next = menu_item.next('.menu-item');
					var target_depth = (next.length === 0) ? depth : next.menuItemDepth();
					var current_depth = target_depth;

					while (next.length > 0 && current_depth > depth)
					{
						if (next.hasClass('deleting'))
						{
							result = result.add(next.nmm_direct_child_menu_items());
						}
						else if (current_depth === target_depth)
						{
							result = result.add(next);
						}

						next = next.next('.menu-item');
						current_depth = (next.length === 0) ? depth : next.menuItemDepth();
					}
				});

				return result;
			}
		});

		/**
		 * Functionality to store and fire callbacks.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.callbacks
		 * @var    object
		 */
		$.nmm.callbacks = $.nmm.callbacks || {};
		
		$.extend($.nmm.callbacks,
		{
			/**
			 * Array of stored callbacks.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.callbacks.stored
			 * @var    array
			 */
			"stored": [],

			/**
			 * Store a callback.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.callbacks.add
			 * @param  function callback Callback to store.
			 * @return void
			 */
			"add": function (callback)
			{
				if (typeof callback === 'function')
				{
					$.nmm.callbacks.stored[$.nmm.callbacks.stored.length] = callback;
				}
			},

			/**
			 * Fire the first stored callback.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.callbacks.fire
			 * @return void
			 */
			"fire": function ()
			{
				if ($.nmm.callbacks.stored.length > 0)
				{
					$.nmm.callbacks.stored.shift()();
				}
			}
		});

		/**
		 * Custom data variable names specific to nav menus.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.data
		 * @var    object
		 */
		$.extend($.nmm.data,
		{
			"timeout": 'nmm-timeout'
		});

		/**
		 * Custom event names specific to nav menus.
		 * 
		 * @since 2.0.2 Removed unused 'update' event.
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.events
		 * @var    object
		 */
		$.extend($.nmm.events,
		{
			"extend": 'nmm-extend'
		});

		$.nmm.nav_menus = $.nmm.nav_menus || {};

		/**
		 * Nav menus JSON object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.nav_menus
		 * @var    object
		 */
		$.extend($.nmm.nav_menus,
		{
			/**
			 * Override WordPress nav menu functionality.
			 * 
			 * @since 2.0.1 Fixed logic to allow nav menus functionality to load correctly.
			 * @since 2.0.0
			 * 
			 * @see wp-admin/js/nav-menu.js
			 * @access jQuery.nmm.nav_menus.global_override
			 * @return void
			 */
			"global_override": function ()
			{
				wpNavMenu.default_addItemToMenu = wpNavMenu.addItemToMenu;

				$.extend(wpNavMenu,
				{
					"addItemToMenu": function (menu_item, process_method, callback)
					{
						$('.menu-item.pending:hidden').addClass('nmm-hidden');

						$.nmm.callbacks.add(callback);

						callback = function ()
						{
							$('.menu-item.nmm-hidden').stop(true, true).hide().removeClass('nmm-hidden');

							$.nmm.callbacks.fire();
							
							if ($.type($.nmm.nav_menus.custom_fields) === 'function')
							{
								$.nmm.nav_menus.custom_fields();
							}
							
							if ($.type($.nmm.nav_menus.collapse_expand) === 'function')
							{
								$.nmm.nav_menus.collapse_expand();
							}
						};

						wpNavMenu.default_addItemToMenu(menu_item, process_method, callback);
					}
				});
			},

			/**
			 * Setup the nav menu item custom fields.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.custom_fields
			 * @return void
			 */
			"custom_fields": function ()
			{
				var custom_fields = $(wp.template('nmm-custom-fields')());

				if (custom_fields)
				{
					if (!$('#noakes-id-hide').is(':checked'))
					{
						custom_fields.filter('.field-noakes-id').addClass('hidden-field');
					}
					
					if (!$('#noakes-query-string-hide').is(':checked'))
					{
						custom_fields.filter('.field-noakes-query-string').addClass('hidden-field');
					}
					
					if (!$('#noakes-anchor-hide').is(':checked'))
					{
						custom_fields.filter('.field-noakes-anchor').addClass('hidden-field');
					}
					
					$('#menu-to-edit > .menu-item').nmm_unprepared('custom-fields')
					.each(function ()
					{
						var menu_item = $(this);
						var menu_item_id = menu_item.find('.menu-item-data-db-id').val();
						var fields = custom_fields.clone();
						
						fields.find('label[for$="__i__"]')
						.each(function ()
						{
							var label = $(this);
							label.attr('for', label.attr('for').replace('__i__', menu_item_id));
						});
						
						fields.find('input[id$="__i__"]')
						.each(function ()
						{
							var input = $(this);
							
							input
							.attr(
							{
								"id": input.attr('id').replace('__i__', menu_item_id),
								"name": input.attr('name').replace('__i__', menu_item_id)
							});
						});
						
						if ($.nmm.options.custom_fields[menu_item_id])
						{
							fields.find('.edit-menu-item-noakes-id').val($.nmm.options.custom_fields[menu_item_id].id);
							fields.find('.edit-menu-item-noakes-query-string').val($.nmm.options.custom_fields[menu_item_id].query_string);
							fields.find('.edit-menu-item-noakes-anchor').val($.nmm.options.custom_fields[menu_item_id].anchor);
						}
						
						fields.insertAfter(menu_item.find('.field-description'));
					});
					
					$.nmm.global.help_buttons();
				}
			},
			
			/**
			 * Override WordPress nav menu functionality specific to collapse/expand.
			 * 
			 * @since 2.0.0
			 * 
			 * @see wp-admin/js/nav-menu.js
			 * @access jQuery.nmm.nav_menus.collapse_expand_override
			 * @return void
			 */
			"collapse_expand_override": function ()
			{
				$.fn.default_shiftDepthClass = $.fn.shiftDepthClass;

				$.fn.shiftDepthClass = function (change)
				{
					this.default_shiftDepthClass(change);

					return this
					.each(function ()
					{
						var current = $(this);

						if (current.menuItemDepth() === 0)
						{
							current.find('.is-submenu').hide();
						}
					});
				};

				wpNavMenu.menuList
				.on('sortstart', function (e, ui)
				{
					nmm_dragged_item = ui.item;

					$.nmm.window.mousemove($.nmm.nav_menus.mousemove);
				})
				.on('sortstop', function (e, ui)
				{
					$.nmm.window.unbind('mousemove', $.nmm.nav_menus.mousemove);
					$.nmm.nav_menus.clear_hovered();

					nmm_dragged_item = null;
					nmm_dropped_item = ui.item;
				});

				$.extend(wpNavMenu,
				{
					"default_eventOnClickMenuItemDelete": wpNavMenu.eventOnClickMenuItemDelete,
					"default_registerChange": wpNavMenu.registerChange,
					"default_eventOnClickMenuSave": wpNavMenu.eventOnClickMenuSave
				});

				$.extend(wpNavMenu,
				{
					"eventOnClickMenuItemDelete": function (clicked)
					{
						var menu_item = $(clicked).closest('.menu-item');

						if (menu_item.is('.nmm-collapsed'))
						{
							menu_item.find('.nmm-collapse-expand').nmm_trigger_all('click');
						}
						
						$.nmm.nav_menus.check_all_buttons();

						wpNavMenu.default_eventOnClickMenuItemDelete(clicked);

						return false;
					},

					"registerChange": function ()
					{
						wpNavMenu.default_registerChange();

						$.nmm.nav_menus.check_collapsibility();

						if (nmm_dropped_item !== null)
						{
							var current_depth = nmm_dropped_item.menuItemDepth();

							while (current_depth > 0)
							{
								current_depth -= 1;

								var parent = nmm_dropped_item.prevAll('.menu-item-depth-' + current_depth).first();

								if (parent.hasClass('nmm-collapsed'))
								{
									parent.find('.nmm-collapse-expand').triggerHandler('click');
								}
							}

							nmm_dropped_item = null;
						}
						
						$.nmm.nav_menus.check_all_buttons();
					},

					"eventOnClickMenuSave": function (target)
					{
						if ($.nmm.options.collapsed !== '1' && !$.nmm.body.hasClass('nmm-ajax'))
						{
							$.nmm.body.addClass('nmm-ajax');

							var collapsed = [];

							$('.menu-item.nmm-collapsed')
							.each(function ()
							{
								collapsed.push($(this).find('input.menu-item-data-db-id').val());
							});

							$.post(
							{
								"url": ajaxurl,
								"async": false,
								"dataType": 'json',

								"data": 
								{
									"action": 'nmm_collapsed',
									"menu_id": $('#menu').val(),
									"collapsed": collapsed
								},

								"complete": function ()
								{
									$.nmm.body.removeClass('nmm-ajax');
								}
							});
						}

						return wpNavMenu.default_eventOnClickMenuSave(target);
					}
				});
			},

			/**
			 * Prepare the collapse/expand all buttons.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.collapse_expand_all
			 * @return void
			 */
			"collapse_expand_all": function ()
			{
				var collapse_expand_all = $(wp.template('nmm-collapse-expand-all')());

				if (collapse_expand_all)
				{
					collapse_expand_all.insertBefore($('#menu-to-edit')).find('.nmm-collapse-all')
					.click(function ()
					{
						$(this).prop('disabled', true).siblings().prop('disabled', false);

						$('.nmm-collapsible').not('.nmm-collapsed').find('.nmm-collapse-expand').nmm_trigger_all('click', [true]);
					});

					collapse_expand_all.find('.nmm-expand-all')
					.click(function ()
					{
						$(this).prop('disabled', true).siblings().prop('disabled', false);

						$('.nmm-collapsed').find('.nmm-collapse-expand').nmm_trigger_all('click', [true]);
					});

					$.nmm.global.help_buttons();
				}
			},

			/**
			 * Prepare collapse/expand functionality.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.collapse_expand
			 * @return void
			 */
			"collapse_expand": function ()
			{
				var collapse_expand = $(wp.template('nmm-collapse-expand')());
				
				if (collapse_expand)
				{
					collapse_expand
					.click(function (e, skip_all_buttons_check)
					{
						var menu_item = $(this).closest('.menu-item');

						var complete = function ()
						{
							$(this).css('height', '');
						};

						if (menu_item.hasClass('nmm-collapsed'))
						{
							menu_item.removeClass('nmm-collapsed');

							var children = menu_item.nmm_direct_child_menu_items();

							while (children.length > 0)
							{
								children.stop(true).slideDown(125, complete);
								children = children.filter('.nmm-collapsible').not('.nmm-collapsed').nmm_direct_child_menu_items();
							}
						}
						else
						{
							menu_item.addClass('nmm-collapsed');
							menu_item.childMenuItems().stop(true).slideUp(125, complete);
						}

						if (skip_all_buttons_check !== true)
						{
							$.nmm.nav_menus.check_all_buttons();
						}
					});

					$('#menu-to-edit > .menu-item').nmm_unprepared('collapse-expand')
					.each(function ()
					{
						collapse_expand.clone(true).appendTo($(this).find('.item-controls'));
					})
					.on($.nmm.events.extend, function ()
					{
						var current = $(this);
						var is_null = (nmm_hovered_item === null);

						if (is_null || !nmm_hovered_item.is(current))
						{
							if (!is_null)
							{
								$.nmm.nav_menus.clear_hovered();
							}

							nmm_hovered_item = current;

							nmm_hovered_item
							.data($.nmm.data.timeout, setTimeout(function ()
							{
								nmm_hovered_item.find('.nmm-collapse-expand').triggerHandler('click');

								$.nmm.nav_menus.clear_hovered();
							},
							1000));
						}
					});

					$.nmm.nav_menus.check_collapsibility();
				}
			},

			/**
			 * Set the collapsed items.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.override_nav_menus
			 * @return void
			 */
			"set_collapsed": function ()
			{
				if ($.isPlainObject($.nmm.options.collapsed))
				{
					var menu_id = $('#menu').val();

					if (menu_id in $.nmm.options.collapsed)
					{
						$.each($.nmm.options.collapsed[menu_id], function (index, value)
						{
							$('input.menu-item-data-db-id[value=' + value + ']').closest('.menu-item').find('.nmm-collapse-expand').triggerHandler('click');
						});
					}
				}
				else
				{
					$('#nmm-collapse-expand-all .nmm-collapse-all').triggerHandler('click');
				}
			},
			
			/**
			 * Check the disabled states for the collapse/expand all buttons.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.check_all_buttons
			 * @return void
			 */
			"check_all_buttons": function ()
			{
				$('#nmm-collapse-expand-all .nmm-collapse-all').prop('disabled', ($('#menu-to-edit > .menu-item.nmm-collapsible').not('.deleting').not('.nmm-collapsed').length === 0));
				$('#nmm-collapse-expand-all .nmm-expand-all').prop('disabled', ($('#menu-to-edit > .menu-item.nmm-collapsible.nmm-collapsed').not('.deleting').length === 0));
			},

			/**
			 * Check nav menu items for collapsibility.
			 * 
			 * @since 2.0.2 Removed reference to unused 'update' event.
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.check_collapsibility
			 * @return void
			 */
			"check_collapsibility": function ()
			{
				var has_collapsible = false;

				$('#menu-to-edit > .menu-item')
				.each(function ()
				{
					var menu_item = $(this);

					if (menu_item.hasClass('deleting') || menu_item.nmm_direct_child_menu_items().length === 0)
					{
						menu_item.removeClass('nmm-collapsible nmm-collapsed');
					}
					else
					{
						has_collapsible = true;

						menu_item.addClass('nmm-collapsible');
					}
					
					var child_count = menu_item.childMenuItems().length;
					var title = menu_item.find('.menu-item-title');
					var counter = title.next('.nmm-counter').hide().removeAttr('title').empty();

					if (child_count > 0)
					{
						counter = (counter.length === 0) ? $('<abbr/>').addClass('nmm-counter').insertAfter(title) : counter;
						counter.attr('title', $.nmm.options.nested.replace('%d', child_count)).html('(' + child_count + ')').show();
					}
				});

				var all_buttons = $('#nmm-collapse-expand-all').stop(true);
				var is_visible = all_buttons.is(':visible');

				if (has_collapsible && !is_visible)
				{
					all_buttons
					.slideDown(125, function ()
					{
						$(this).css('height', '');
					});
				}
				else if (!has_collapsible && is_visible)
				{
					all_buttons
					.slideUp(125, function ()
					{
						$(this).css('height', '');
					});
				}
			},

			/**
			 * Clear the timeout when hovering out of a nav menu item.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.clear_hovered
			 * @return void
			 */
			"clear_hovered": function ()
			{
				if (nmm_hovered_item !== null)
				{
					clearTimeout(nmm_hovered_item.data($.nmm.data.timeout));

					nmm_hovered_item = null;
				}
			},

			/**
			 * Check the position of the dragged item.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.nav_menus.mousemove
			 * @return void
			 */
			"mousemove": function ()
			{
				var dragged_position = nmm_dragged_item.position();
				dragged_position.right = dragged_position.left + nmm_dragged_item.width();
				dragged_position.bottom = dragged_position.top + nmm_dragged_item.height();

				var collapsed = wpNavMenu.menuList.children('.menu-item.nmm-collapsed:visible').not(nmm_dragged_item)
				.filter(function ()
				{
					var current = $(this);
					var position = current.position();

					return (position.top <= dragged_position.bottom && position.top + current.height() >= dragged_position.top && position.left <= dragged_position.right && position.left + current.width() >= dragged_position.left);
				})
				.first();

				if (collapsed.length === 0)
				{
					$.nmm.nav_menus.clear_hovered();
				}
				else if (!collapsed.is(nmm_hovered_item))
				{
					collapsed.triggerHandler($.nmm.events.extend);
				}
			}
		});

		$.nmm.document
		.ready(function ()
		{
			$.nmm.nav_menus.global_override();
			
			if ($.nmm.options.custom_fields !== '0')
			{
				$.nmm.nav_menus.custom_fields();
			}
			
			if ($.nmm.options.collapsed !== '0')
			{
				$.nmm.nav_menus.collapse_expand_override();
				$.nmm.nav_menus.collapse_expand_all();
				$.nmm.nav_menus.collapse_expand();
				$.nmm.nav_menus.set_collapsed();
			}
		});
	}
	else if ($.nmm.options.is_widgets)
	{
		/**
		 * Custom data variable names specific to widgets.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.data
		 * @var    object
		 */
		$.extend($.nmm.data,
		{
			"sibling": 'nmm-sibling'
		});
		
		/**
		 * Widgets JSON object.
		 * 
		 * @since 2.0.0
		 * 
		 * @access jQuery.nmm.widgets
		 * @var    object
		 */
		$.nmm.widgets = $.nmm.widgets || {};
		
		$.extend($.nmm.widgets,
		{
			/**
			 * Setup the fields functionality.
			 * 
			 * @since 2.0.0
			 * 
			 * @access jQuery.nmm.widgets.fields
			 * @param  object widget Widget that is currently being handled.
			 * @return void
			 */
			"fields": function (widget)
			{
				widget = ($.type(widget) === 'undefined') ? $('.widget[id*="' + $.nmm.options.menu_id + '"]') : widget;
				widget = (widget.length === 0) ? $('.' + $.nmm.options.menu_id + '-wrapper') : widget.not('[id$="__i__"]');

				widget
				.each(function ()
				{
					var current = $(this);
					var theme_location = current.find('select[name$="[theme_location]"]').nmm_unprepared();
					
					if (theme_location.length > 0)
					{
						var menu = current.find('select[name$="[nav_menu]"]').data($.nmm.data.sibling, theme_location);

						theme_location.data($.nmm.data.sibling, menu).add(menu)
						.change(function ()
						{
							var changed = $(this);

							if (changed.val() !== '')
							{
								var sibling = changed.data($.nmm.data.sibling);

								if (sibling.val() !== '')
								{
									sibling
									.fadeOut(125, function ()
									{
										$(this).val('').fadeIn(125);
									});
								}
							}
						});

						var container_fields = current.find('input[name$="[container_class]"]').parent();
						container_fields = container_fields.add(current.find('input[name$="[container_id]"]').parent());

						current.find('select[name$="[container]"]').data($.nmm.data.sibling, container_fields)
						.change(function (e, duration)
						{
							duration = ($.type(duration) === 'number') ? duration : 125;

							var changed = $(this);
							var siblings = changed.data($.nmm.data.sibling).stop(true);

							if (changed.val())
							{
								siblings.slideDown(duration);
							}
							else
							{
								siblings.slideUp(duration);
							}
						})
						.triggerHandler('change', [0]);
						
						current.find('.nmm-help-button').removeClass('nmm-disabled');
					}
				});
			}
		});
		
		$.nmm.document
		.ready(function ()
		{
			var widget_event = function (e, widget)
			{
				$.nmm.widgets.fields(widget);
				$.nmm.global.help_buttons(widget);
			};

			widget_event();

			$(this).on('widget-added widget-updated', widget_event);
		});
	}
})(jQuery);
