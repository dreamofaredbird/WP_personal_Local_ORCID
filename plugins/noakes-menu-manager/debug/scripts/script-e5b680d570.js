/*! jQuery Validation Plugin v1.19.0 * https://jqueryvalidation.org/ * Copyright (c) 2018 Jörn Zaefferer * Released under the MIT license */
(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

$.extend( $.fn, {

	// https://jqueryvalidation.org/validate/
	validate: function( options ) {

		// If nothing is selected, return nothing; can't chain anyway
		if ( !this.length ) {
			if ( options && options.debug && window.console ) {
				console.warn( "Nothing selected, can't validate, returning nothing." );
			}
			return;
		}

		// Check if a validator for this form was already created
		var validator = $.data( this[ 0 ], "validator" );
		if ( validator ) {
			return validator;
		}

		// Add novalidate tag if HTML5.
		this.attr( "novalidate", "novalidate" );

		validator = new $.validator( options, this[ 0 ] );
		$.data( this[ 0 ], "validator", validator );

		if ( validator.settings.onsubmit ) {

			this.on( "click.validate", ":submit", function( event ) {

				// Track the used submit button to properly handle scripted
				// submits later.
				validator.submitButton = event.currentTarget;

				// Allow suppressing validation by adding a cancel class to the submit button
				if ( $( this ).hasClass( "cancel" ) ) {
					validator.cancelSubmit = true;
				}

				// Allow suppressing validation by adding the html5 formnovalidate attribute to the submit button
				if ( $( this ).attr( "formnovalidate" ) !== undefined ) {
					validator.cancelSubmit = true;
				}
			} );

			// Validate the form on submit
			this.on( "submit.validate", function( event ) {
				if ( validator.settings.debug ) {

					// Prevent form submit to be able to see console output
					event.preventDefault();
				}

				function handle() {
					var hidden, result;

					// Insert a hidden input as a replacement for the missing submit button
					// The hidden input is inserted in two cases:
					//   - A user defined a `submitHandler`
					//   - There was a pending request due to `remote` method and `stopRequest()`
					//     was called to submit the form in case it's valid
					if ( validator.submitButton && ( validator.settings.submitHandler || validator.formSubmitted ) ) {
						hidden = $( "<input type='hidden'/>" )
							.attr( "name", validator.submitButton.name )
							.val( $( validator.submitButton ).val() )
							.appendTo( validator.currentForm );
					}

					if ( validator.settings.submitHandler && !validator.settings.debug ) {
						result = validator.settings.submitHandler.call( validator, validator.currentForm, event );
						if ( hidden ) {

							// And clean up afterwards; thanks to no-block-scope, hidden can be referenced
							hidden.remove();
						}
						if ( result !== undefined ) {
							return result;
						}
						return false;
					}
					return true;
				}

				// Prevent submit for invalid forms or custom submit handlers
				if ( validator.cancelSubmit ) {
					validator.cancelSubmit = false;
					return handle();
				}
				if ( validator.form() ) {
					if ( validator.pendingRequest ) {
						validator.formSubmitted = true;
						return false;
					}
					return handle();
				} else {
					validator.focusInvalid();
					return false;
				}
			} );
		}

		return validator;
	},

	// https://jqueryvalidation.org/valid/
	valid: function() {
		var valid, validator, errorList;

		if ( $( this[ 0 ] ).is( "form" ) ) {
			valid = this.validate().form();
		} else {
			errorList = [];
			valid = true;
			validator = $( this[ 0 ].form ).validate();
			this.each( function() {
				valid = validator.element( this ) && valid;
				if ( !valid ) {
					errorList = errorList.concat( validator.errorList );
				}
			} );
			validator.errorList = errorList;
		}
		return valid;
	},

	// https://jqueryvalidation.org/rules/
	rules: function( command, argument ) {
		var element = this[ 0 ],
			isContentEditable = typeof this.attr( "contenteditable" ) !== "undefined" && this.attr( "contenteditable" ) !== "false",
			settings, staticRules, existingRules, data, param, filtered;

		// If nothing is selected, return empty object; can't chain anyway
		if ( element == null ) {
			return;
		}

		if ( !element.form && isContentEditable ) {
			element.form = this.closest( "form" )[ 0 ];
			element.name = this.attr( "name" );
		}

		if ( element.form == null ) {
			return;
		}

		if ( command ) {
			settings = $.data( element.form, "validator" ).settings;
			staticRules = settings.rules;
			existingRules = $.validator.staticRules( element );
			switch ( command ) {
			case "add":
				$.extend( existingRules, $.validator.normalizeRule( argument ) );

				// Remove messages from rules, but allow them to be set separately
				delete existingRules.messages;
				staticRules[ element.name ] = existingRules;
				if ( argument.messages ) {
					settings.messages[ element.name ] = $.extend( settings.messages[ element.name ], argument.messages );
				}
				break;
			case "remove":
				if ( !argument ) {
					delete staticRules[ element.name ];
					return existingRules;
				}
				filtered = {};
				$.each( argument.split( /\s/ ), function( index, method ) {
					filtered[ method ] = existingRules[ method ];
					delete existingRules[ method ];
				} );
				return filtered;
			}
		}

		data = $.validator.normalizeRules(
		$.extend(
			{},
			$.validator.classRules( element ),
			$.validator.attributeRules( element ),
			$.validator.dataRules( element ),
			$.validator.staticRules( element )
		), element );

		// Make sure required is at front
		if ( data.required ) {
			param = data.required;
			delete data.required;
			data = $.extend( { required: param }, data );
		}

		// Make sure remote is at back
		if ( data.remote ) {
			param = data.remote;
			delete data.remote;
			data = $.extend( data, { remote: param } );
		}

		return data;
	}
} );

// Custom selectors
$.extend( $.expr.pseudos || $.expr[ ":" ], {		// '|| $.expr[ ":" ]' here enables backwards compatibility to jQuery 1.7. Can be removed when dropping jQ 1.7.x support

	// https://jqueryvalidation.org/blank-selector/
	blank: function( a ) {
		return !$.trim( "" + $( a ).val() );
	},

	// https://jqueryvalidation.org/filled-selector/
	filled: function( a ) {
		var val = $( a ).val();
		return val !== null && !!$.trim( "" + val );
	},

	// https://jqueryvalidation.org/unchecked-selector/
	unchecked: function( a ) {
		return !$( a ).prop( "checked" );
	}
} );

// Constructor for validator
$.validator = function( options, form ) {
	this.settings = $.extend( true, {}, $.validator.defaults, options );
	this.currentForm = form;
	this.init();
};

// https://jqueryvalidation.org/jQuery.validator.format/
$.validator.format = function( source, params ) {
	if ( arguments.length === 1 ) {
		return function() {
			var args = $.makeArray( arguments );
			args.unshift( source );
			return $.validator.format.apply( this, args );
		};
	}
	if ( params === undefined ) {
		return source;
	}
	if ( arguments.length > 2 && params.constructor !== Array  ) {
		params = $.makeArray( arguments ).slice( 1 );
	}
	if ( params.constructor !== Array ) {
		params = [ params ];
	}
	$.each( params, function( i, n ) {
		source = source.replace( new RegExp( "\\{" + i + "\\}", "g" ), function() {
			return n;
		} );
	} );
	return source;
};

$.extend( $.validator, {

	defaults: {
		messages: {},
		groups: {},
		rules: {},
		errorClass: "error",
		pendingClass: "pending",
		validClass: "valid",
		errorElement: "label",
		focusCleanup: false,
		focusInvalid: true,
		errorContainer: $( [] ),
		errorLabelContainer: $( [] ),
		onsubmit: true,
		ignore: ":hidden",
		ignoreTitle: false,
		onfocusin: function( element ) {
			this.lastActive = element;


			// Hide error label and remove error class on focus if enabled
			if ( this.settings.focusCleanup ) {
				if ( this.settings.unhighlight ) {
					this.settings.unhighlight.call( this, element, this.settings.errorClass, this.settings.validClass );
				}
				this.hideThese( this.errorsFor( element ) );
			}
		},
		onfocusout: function( element ) {
			if ( !this.checkable( element ) && ( element.name in this.submitted || !this.optional( element ) ) ) {
				this.element( element );
			}
		},
		onkeyup: function( element, event ) {

			// Avoid revalidate the field when pressing one of the following keys
			// Shift       => 16
			// Ctrl        => 17
			// Alt         => 18
			// Caps lock   => 20
			// End         => 35
			// Home        => 36
			// Left arrow  => 37
			// Up arrow    => 38
			// Right arrow => 39
			// Down arrow  => 40
			// Insert      => 45
			// Num lock    => 144
			// AltGr key   => 225
			var excludedKeys = [
				16, 17, 18, 20, 35, 36, 37,
				38, 39, 40, 45, 144, 225
			];

			if ( event.which === 9 && this.elementValue( element ) === "" || $.inArray( event.keyCode, excludedKeys ) !== -1 ) {
				return;
			} else if ( element.name in this.submitted || element.name in this.invalid ) {
				this.element( element );
			}
		},
		onclick: function( element ) {

			// Click on selects, radiobuttons and checkboxes
			if ( element.name in this.submitted ) {
				this.element( element );

			// Or option elements, check parent select in that case
			} else if ( element.parentNode.name in this.submitted ) {
				this.element( element.parentNode );
			}
		},
		highlight: function( element, errorClass, validClass ) {
			if ( element.type === "radio" ) {
				this.findByName( element.name ).addClass( errorClass ).removeClass( validClass );
			} else {
				$( element ).addClass( errorClass ).removeClass( validClass );
			}
		},
		unhighlight: function( element, errorClass, validClass ) {
			if ( element.type === "radio" ) {
				this.findByName( element.name ).removeClass( errorClass ).addClass( validClass );
			} else {
				$( element ).removeClass( errorClass ).addClass( validClass );
			}
		}
	},

	// https://jqueryvalidation.org/jQuery.validator.setDefaults/
	setDefaults: function( settings ) {
		$.extend( $.validator.defaults, settings );
	},

	messages: {
		required: "This field is required.",
		remote: "Please fix this field.",
		email: "Please enter a valid email address.",
		url: "Please enter a valid URL.",
		date: "Please enter a valid date.",
		dateISO: "Please enter a valid date (ISO).",
		number: "Please enter a valid number.",
		digits: "Please enter only digits.",
		equalTo: "Please enter the same value again.",
		maxlength: $.validator.format( "Please enter no more than {0} characters." ),
		minlength: $.validator.format( "Please enter at least {0} characters." ),
		rangelength: $.validator.format( "Please enter a value between {0} and {1} characters long." ),
		range: $.validator.format( "Please enter a value between {0} and {1}." ),
		max: $.validator.format( "Please enter a value less than or equal to {0}." ),
		min: $.validator.format( "Please enter a value greater than or equal to {0}." ),
		step: $.validator.format( "Please enter a multiple of {0}." )
	},

	autoCreateRanges: false,

	prototype: {

		init: function() {
			this.labelContainer = $( this.settings.errorLabelContainer );
			this.errorContext = this.labelContainer.length && this.labelContainer || $( this.currentForm );
			this.containers = $( this.settings.errorContainer ).add( this.settings.errorLabelContainer );
			this.submitted = {};
			this.valueCache = {};
			this.pendingRequest = 0;
			this.pending = {};
			this.invalid = {};
			this.reset();

			var currentForm = this.currentForm,
				groups = ( this.groups = {} ),
				rules;
			$.each( this.settings.groups, function( key, value ) {
				if ( typeof value === "string" ) {
					value = value.split( /\s/ );
				}
				$.each( value, function( index, name ) {
					groups[ name ] = key;
				} );
			} );
			rules = this.settings.rules;
			$.each( rules, function( key, value ) {
				rules[ key ] = $.validator.normalizeRule( value );
			} );

			function delegate( event ) {
				var isContentEditable = typeof $( this ).attr( "contenteditable" ) !== "undefined" && $( this ).attr( "contenteditable" ) !== "false";

				// Set form expando on contenteditable
				if ( !this.form && isContentEditable ) {
					this.form = $( this ).closest( "form" )[ 0 ];
					this.name = $( this ).attr( "name" );
				}

				// Ignore the element if it belongs to another form. This will happen mainly
				// when setting the `form` attribute of an input to the id of another form.
				if ( currentForm !== this.form ) {
					return;
				}

				var validator = $.data( this.form, "validator" ),
					eventType = "on" + event.type.replace( /^validate/, "" ),
					settings = validator.settings;
				if ( settings[ eventType ] && !$( this ).is( settings.ignore ) ) {
					settings[ eventType ].call( validator, this, event );
				}
			}

			$( this.currentForm )
				.on( "focusin.validate focusout.validate keyup.validate",
					":text, [type='password'], [type='file'], select, textarea, [type='number'], [type='search'], " +
					"[type='tel'], [type='url'], [type='email'], [type='datetime'], [type='date'], [type='month'], " +
					"[type='week'], [type='time'], [type='datetime-local'], [type='range'], [type='color'], " +
					"[type='radio'], [type='checkbox'], [contenteditable], [type='button']", delegate )

				// Support: Chrome, oldIE
				// "select" is provided as event.target when clicking a option
				.on( "click.validate", "select, option, [type='radio'], [type='checkbox']", delegate );

			if ( this.settings.invalidHandler ) {
				$( this.currentForm ).on( "invalid-form.validate", this.settings.invalidHandler );
			}
		},

		// https://jqueryvalidation.org/Validator.form/
		form: function() {
			this.checkForm();
			$.extend( this.submitted, this.errorMap );
			this.invalid = $.extend( {}, this.errorMap );
			if ( !this.valid() ) {
				$( this.currentForm ).triggerHandler( "invalid-form", [ this ] );
			}
			this.showErrors();
			return this.valid();
		},

		checkForm: function() {
			this.prepareForm();
			for ( var i = 0, elements = ( this.currentElements = this.elements() ); elements[ i ]; i++ ) {
				this.check( elements[ i ] );
			}
			return this.valid();
		},

		// https://jqueryvalidation.org/Validator.element/
		element: function( element ) {
			var cleanElement = this.clean( element ),
				checkElement = this.validationTargetFor( cleanElement ),
				v = this,
				result = true,
				rs, group;

			if ( checkElement === undefined ) {
				delete this.invalid[ cleanElement.name ];
			} else {
				this.prepareElement( checkElement );
				this.currentElements = $( checkElement );

				// If this element is grouped, then validate all group elements already
				// containing a value
				group = this.groups[ checkElement.name ];
				if ( group ) {
					$.each( this.groups, function( name, testgroup ) {
						if ( testgroup === group && name !== checkElement.name ) {
							cleanElement = v.validationTargetFor( v.clean( v.findByName( name ) ) );
							if ( cleanElement && cleanElement.name in v.invalid ) {
								v.currentElements.push( cleanElement );
								result = v.check( cleanElement ) && result;
							}
						}
					} );
				}

				rs = this.check( checkElement ) !== false;
				result = result && rs;
				if ( rs ) {
					this.invalid[ checkElement.name ] = false;
				} else {
					this.invalid[ checkElement.name ] = true;
				}

				if ( !this.numberOfInvalids() ) {

					// Hide error containers on last error
					this.toHide = this.toHide.add( this.containers );
				}
				this.showErrors();

				// Add aria-invalid status for screen readers
				$( element ).attr( "aria-invalid", !rs );
			}

			return result;
		},

		// https://jqueryvalidation.org/Validator.showErrors/
		showErrors: function( errors ) {
			if ( errors ) {
				var validator = this;

				// Add items to error list and map
				$.extend( this.errorMap, errors );
				this.errorList = $.map( this.errorMap, function( message, name ) {
					return {
						message: message,
						element: validator.findByName( name )[ 0 ]
					};
				} );

				// Remove items from success list
				this.successList = $.grep( this.successList, function( element ) {
					return !( element.name in errors );
				} );
			}
			if ( this.settings.showErrors ) {
				this.settings.showErrors.call( this, this.errorMap, this.errorList );
			} else {
				this.defaultShowErrors();
			}
		},

		// https://jqueryvalidation.org/Validator.resetForm/
		resetForm: function() {
			if ( $.fn.resetForm ) {
				$( this.currentForm ).resetForm();
			}
			this.invalid = {};
			this.submitted = {};
			this.prepareForm();
			this.hideErrors();
			var elements = this.elements()
				.removeData( "previousValue" )
				.removeAttr( "aria-invalid" );

			this.resetElements( elements );
		},

		resetElements: function( elements ) {
			var i;

			if ( this.settings.unhighlight ) {
				for ( i = 0; elements[ i ]; i++ ) {
					this.settings.unhighlight.call( this, elements[ i ],
						this.settings.errorClass, "" );
					this.findByName( elements[ i ].name ).removeClass( this.settings.validClass );
				}
			} else {
				elements
					.removeClass( this.settings.errorClass )
					.removeClass( this.settings.validClass );
			}
		},

		numberOfInvalids: function() {
			return this.objectLength( this.invalid );
		},

		objectLength: function( obj ) {
			/* jshint unused: false */
			var count = 0,
				i;
			for ( i in obj ) {

				// This check allows counting elements with empty error
				// message as invalid elements
				if ( obj[ i ] !== undefined && obj[ i ] !== null && obj[ i ] !== false ) {
					count++;
				}
			}
			return count;
		},

		hideErrors: function() {
			this.hideThese( this.toHide );
		},

		hideThese: function( errors ) {
			errors.not( this.containers ).text( "" );
			this.addWrapper( errors ).hide();
		},

		valid: function() {
			return this.size() === 0;
		},

		size: function() {
			return this.errorList.length;
		},

		focusInvalid: function() {
			if ( this.settings.focusInvalid ) {
				try {
					$( this.findLastActive() || this.errorList.length && this.errorList[ 0 ].element || [] )
					.filter( ":visible" )
					.focus()

					// Manually trigger focusin event; without it, focusin handler isn't called, findLastActive won't have anything to find
					.trigger( "focusin" );
				} catch ( e ) {

					// Ignore IE throwing errors when focusing hidden elements
				}
			}
		},

		findLastActive: function() {
			var lastActive = this.lastActive;
			return lastActive && $.grep( this.errorList, function( n ) {
				return n.element.name === lastActive.name;
			} ).length === 1 && lastActive;
		},

		elements: function() {
			var validator = this,
				rulesCache = {};

			// Select all valid inputs inside the form (no submit or reset buttons)
			return $( this.currentForm )
			.find( "input, select, textarea, [contenteditable]" )
			.not( ":submit, :reset, :image, :disabled" )
			.not( this.settings.ignore )
			.filter( function() {
				var name = this.name || $( this ).attr( "name" ); // For contenteditable
				var isContentEditable = typeof $( this ).attr( "contenteditable" ) !== "undefined" && $( this ).attr( "contenteditable" ) !== "false";

				if ( !name && validator.settings.debug && window.console ) {
					console.error( "%o has no name assigned", this );
				}

				// Set form expando on contenteditable
				if ( isContentEditable ) {
					this.form = $( this ).closest( "form" )[ 0 ];
					this.name = name;
				}

				// Ignore elements that belong to other/nested forms
				if ( this.form !== validator.currentForm ) {
					return false;
				}

				// Select only the first element for each name, and only those with rules specified
				if ( name in rulesCache || !validator.objectLength( $( this ).rules() ) ) {
					return false;
				}

				rulesCache[ name ] = true;
				return true;
			} );
		},

		clean: function( selector ) {
			return $( selector )[ 0 ];
		},

		errors: function() {
			var errorClass = this.settings.errorClass.split( " " ).join( "." );
			return $( this.settings.errorElement + "." + errorClass, this.errorContext );
		},

		resetInternals: function() {
			this.successList = [];
			this.errorList = [];
			this.errorMap = {};
			this.toShow = $( [] );
			this.toHide = $( [] );
		},

		reset: function() {
			this.resetInternals();
			this.currentElements = $( [] );
		},

		prepareForm: function() {
			this.reset();
			this.toHide = this.errors().add( this.containers );
		},

		prepareElement: function( element ) {
			this.reset();
			this.toHide = this.errorsFor( element );
		},

		elementValue: function( element ) {
			var $element = $( element ),
				type = element.type,
				isContentEditable = typeof $element.attr( "contenteditable" ) !== "undefined" && $element.attr( "contenteditable" ) !== "false",
				val, idx;

			if ( type === "radio" || type === "checkbox" ) {
				return this.findByName( element.name ).filter( ":checked" ).val();
			} else if ( type === "number" && typeof element.validity !== "undefined" ) {
				return element.validity.badInput ? "NaN" : $element.val();
			}

			if ( isContentEditable ) {
				val = $element.text();
			} else {
				val = $element.val();
			}

			if ( type === "file" ) {

				// Modern browser (chrome & safari)
				if ( val.substr( 0, 12 ) === "C:\\fakepath\\" ) {
					return val.substr( 12 );
				}

				// Legacy browsers
				// Unix-based path
				idx = val.lastIndexOf( "/" );
				if ( idx >= 0 ) {
					return val.substr( idx + 1 );
				}

				// Windows-based path
				idx = val.lastIndexOf( "\\" );
				if ( idx >= 0 ) {
					return val.substr( idx + 1 );
				}

				// Just the file name
				return val;
			}

			if ( typeof val === "string" ) {
				return val.replace( /\r/g, "" );
			}
			return val;
		},

		check: function( element ) {
			element = this.validationTargetFor( this.clean( element ) );

			var rules = $( element ).rules(),
				rulesCount = $.map( rules, function( n, i ) {
					return i;
				} ).length,
				dependencyMismatch = false,
				val = this.elementValue( element ),
				result, method, rule, normalizer;

			// Prioritize the local normalizer defined for this element over the global one
			// if the former exists, otherwise user the global one in case it exists.
			if ( typeof rules.normalizer === "function" ) {
				normalizer = rules.normalizer;
			} else if (	typeof this.settings.normalizer === "function" ) {
				normalizer = this.settings.normalizer;
			}

			// If normalizer is defined, then call it to retreive the changed value instead
			// of using the real one.
			// Note that `this` in the normalizer is `element`.
			if ( normalizer ) {
				val = normalizer.call( element, val );

				// Delete the normalizer from rules to avoid treating it as a pre-defined method.
				delete rules.normalizer;
			}

			for ( method in rules ) {
				rule = { method: method, parameters: rules[ method ] };
				try {
					result = $.validator.methods[ method ].call( this, val, element, rule.parameters );

					// If a method indicates that the field is optional and therefore valid,
					// don't mark it as valid when there are no other rules
					if ( result === "dependency-mismatch" && rulesCount === 1 ) {
						dependencyMismatch = true;
						continue;
					}
					dependencyMismatch = false;

					if ( result === "pending" ) {
						this.toHide = this.toHide.not( this.errorsFor( element ) );
						return;
					}

					if ( !result ) {
						this.formatAndAdd( element, rule );
						return false;
					}
				} catch ( e ) {
					if ( this.settings.debug && window.console ) {
						console.log( "Exception occurred when checking element " + element.id + ", check the '" + rule.method + "' method.", e );
					}
					if ( e instanceof TypeError ) {
						e.message += ".  Exception occurred when checking element " + element.id + ", check the '" + rule.method + "' method.";
					}

					throw e;
				}
			}
			if ( dependencyMismatch ) {
				return;
			}
			if ( this.objectLength( rules ) ) {
				this.successList.push( element );
			}
			return true;
		},

		// Return the custom message for the given element and validation method
		// specified in the element's HTML5 data attribute
		// return the generic message if present and no method specific message is present
		customDataMessage: function( element, method ) {
			return $( element ).data( "msg" + method.charAt( 0 ).toUpperCase() +
				method.substring( 1 ).toLowerCase() ) || $( element ).data( "msg" );
		},

		// Return the custom message for the given element name and validation method
		customMessage: function( name, method ) {
			var m = this.settings.messages[ name ];
			return m && ( m.constructor === String ? m : m[ method ] );
		},

		// Return the first defined argument, allowing empty strings
		findDefined: function() {
			for ( var i = 0; i < arguments.length; i++ ) {
				if ( arguments[ i ] !== undefined ) {
					return arguments[ i ];
				}
			}
			return undefined;
		},

		// The second parameter 'rule' used to be a string, and extended to an object literal
		// of the following form:
		// rule = {
		//     method: "method name",
		//     parameters: "the given method parameters"
		// }
		//
		// The old behavior still supported, kept to maintain backward compatibility with
		// old code, and will be removed in the next major release.
		defaultMessage: function( element, rule ) {
			if ( typeof rule === "string" ) {
				rule = { method: rule };
			}

			var message = this.findDefined(
					this.customMessage( element.name, rule.method ),
					this.customDataMessage( element, rule.method ),

					// 'title' is never undefined, so handle empty string as undefined
					!this.settings.ignoreTitle && element.title || undefined,
					$.validator.messages[ rule.method ],
					"<strong>Warning: No message defined for " + element.name + "</strong>"
				),
				theregex = /\$?\{(\d+)\}/g;
			if ( typeof message === "function" ) {
				message = message.call( this, rule.parameters, element );
			} else if ( theregex.test( message ) ) {
				message = $.validator.format( message.replace( theregex, "{$1}" ), rule.parameters );
			}

			return message;
		},

		formatAndAdd: function( element, rule ) {
			var message = this.defaultMessage( element, rule );

			this.errorList.push( {
				message: message,
				element: element,
				method: rule.method
			} );

			this.errorMap[ element.name ] = message;
			this.submitted[ element.name ] = message;
		},

		addWrapper: function( toToggle ) {
			if ( this.settings.wrapper ) {
				toToggle = toToggle.add( toToggle.parent( this.settings.wrapper ) );
			}
			return toToggle;
		},

		defaultShowErrors: function() {
			var i, elements, error;
			for ( i = 0; this.errorList[ i ]; i++ ) {
				error = this.errorList[ i ];
				if ( this.settings.highlight ) {
					this.settings.highlight.call( this, error.element, this.settings.errorClass, this.settings.validClass );
				}
				this.showLabel( error.element, error.message );
			}
			if ( this.errorList.length ) {
				this.toShow = this.toShow.add( this.containers );
			}
			if ( this.settings.success ) {
				for ( i = 0; this.successList[ i ]; i++ ) {
					this.showLabel( this.successList[ i ] );
				}
			}
			if ( this.settings.unhighlight ) {
				for ( i = 0, elements = this.validElements(); elements[ i ]; i++ ) {
					this.settings.unhighlight.call( this, elements[ i ], this.settings.errorClass, this.settings.validClass );
				}
			}
			this.toHide = this.toHide.not( this.toShow );
			this.hideErrors();
			this.addWrapper( this.toShow ).show();
		},

		validElements: function() {
			return this.currentElements.not( this.invalidElements() );
		},

		invalidElements: function() {
			return $( this.errorList ).map( function() {
				return this.element;
			} );
		},

		showLabel: function( element, message ) {
			var place, group, errorID, v,
				error = this.errorsFor( element ),
				elementID = this.idOrName( element ),
				describedBy = $( element ).attr( "aria-describedby" );

			if ( error.length ) {

				// Refresh error/success class
				error.removeClass( this.settings.validClass ).addClass( this.settings.errorClass );

				// Replace message on existing label
				error.html( message );
			} else {

				// Create error element
				error = $( "<" + this.settings.errorElement + ">" )
					.attr( "id", elementID + "-error" )
					.addClass( this.settings.errorClass )
					.html( message || "" );

				// Maintain reference to the element to be placed into the DOM
				place = error;
				if ( this.settings.wrapper ) {

					// Make sure the element is visible, even in IE
					// actually showing the wrapped element is handled elsewhere
					place = error.hide().show().wrap( "<" + this.settings.wrapper + "/>" ).parent();
				}
				if ( this.labelContainer.length ) {
					this.labelContainer.append( place );
				} else if ( this.settings.errorPlacement ) {
					this.settings.errorPlacement.call( this, place, $( element ) );
				} else {
					place.insertAfter( element );
				}

				// Link error back to the element
				if ( error.is( "label" ) ) {

					// If the error is a label, then associate using 'for'
					error.attr( "for", elementID );

					// If the element is not a child of an associated label, then it's necessary
					// to explicitly apply aria-describedby
				} else if ( error.parents( "label[for='" + this.escapeCssMeta( elementID ) + "']" ).length === 0 ) {
					errorID = error.attr( "id" );

					// Respect existing non-error aria-describedby
					if ( !describedBy ) {
						describedBy = errorID;
					} else if ( !describedBy.match( new RegExp( "\\b" + this.escapeCssMeta( errorID ) + "\\b" ) ) ) {

						// Add to end of list if not already present
						describedBy += " " + errorID;
					}
					$( element ).attr( "aria-describedby", describedBy );

					// If this element is grouped, then assign to all elements in the same group
					group = this.groups[ element.name ];
					if ( group ) {
						v = this;
						$.each( v.groups, function( name, testgroup ) {
							if ( testgroup === group ) {
								$( "[name='" + v.escapeCssMeta( name ) + "']", v.currentForm )
									.attr( "aria-describedby", error.attr( "id" ) );
							}
						} );
					}
				}
			}
			if ( !message && this.settings.success ) {
				error.text( "" );
				if ( typeof this.settings.success === "string" ) {
					error.addClass( this.settings.success );
				} else {
					this.settings.success( error, element );
				}
			}
			this.toShow = this.toShow.add( error );
		},

		errorsFor: function( element ) {
			var name = this.escapeCssMeta( this.idOrName( element ) ),
				describer = $( element ).attr( "aria-describedby" ),
				selector = "label[for='" + name + "'], label[for='" + name + "'] *";

			// 'aria-describedby' should directly reference the error element
			if ( describer ) {
				selector = selector + ", #" + this.escapeCssMeta( describer )
					.replace( /\s+/g, ", #" );
			}

			return this
				.errors()
				.filter( selector );
		},

		// See https://api.jquery.com/category/selectors/, for CSS
		// meta-characters that should be escaped in order to be used with JQuery
		// as a literal part of a name/id or any selector.
		escapeCssMeta: function( string ) {
			return string.replace( /([\\!"#$%&'()*+,./:;<=>?@\[\]^`{|}~])/g, "\\$1" );
		},

		idOrName: function( element ) {
			return this.groups[ element.name ] || ( this.checkable( element ) ? element.name : element.id || element.name );
		},

		validationTargetFor: function( element ) {

			// If radio/checkbox, validate first element in group instead
			if ( this.checkable( element ) ) {
				element = this.findByName( element.name );
			}

			// Always apply ignore filter
			return $( element ).not( this.settings.ignore )[ 0 ];
		},

		checkable: function( element ) {
			return ( /radio|checkbox/i ).test( element.type );
		},

		findByName: function( name ) {
			return $( this.currentForm ).find( "[name='" + this.escapeCssMeta( name ) + "']" );
		},

		getLength: function( value, element ) {
			switch ( element.nodeName.toLowerCase() ) {
			case "select":
				return $( "option:selected", element ).length;
			case "input":
				if ( this.checkable( element ) ) {
					return this.findByName( element.name ).filter( ":checked" ).length;
				}
			}
			return value.length;
		},

		depend: function( param, element ) {
			return this.dependTypes[ typeof param ] ? this.dependTypes[ typeof param ]( param, element ) : true;
		},

		dependTypes: {
			"boolean": function( param ) {
				return param;
			},
			"string": function( param, element ) {
				return !!$( param, element.form ).length;
			},
			"function": function( param, element ) {
				return param( element );
			}
		},

		optional: function( element ) {
			var val = this.elementValue( element );
			return !$.validator.methods.required.call( this, val, element ) && "dependency-mismatch";
		},

		startRequest: function( element ) {
			if ( !this.pending[ element.name ] ) {
				this.pendingRequest++;
				$( element ).addClass( this.settings.pendingClass );
				this.pending[ element.name ] = true;
			}
		},

		stopRequest: function( element, valid ) {
			this.pendingRequest--;

			// Sometimes synchronization fails, make sure pendingRequest is never < 0
			if ( this.pendingRequest < 0 ) {
				this.pendingRequest = 0;
			}
			delete this.pending[ element.name ];
			$( element ).removeClass( this.settings.pendingClass );
			if ( valid && this.pendingRequest === 0 && this.formSubmitted && this.form() ) {
				$( this.currentForm ).submit();

				// Remove the hidden input that was used as a replacement for the
				// missing submit button. The hidden input is added by `handle()`
				// to ensure that the value of the used submit button is passed on
				// for scripted submits triggered by this method
				if ( this.submitButton ) {
					$( "input:hidden[name='" + this.submitButton.name + "']", this.currentForm ).remove();
				}

				this.formSubmitted = false;
			} else if ( !valid && this.pendingRequest === 0 && this.formSubmitted ) {
				$( this.currentForm ).triggerHandler( "invalid-form", [ this ] );
				this.formSubmitted = false;
			}
		},

		previousValue: function( element, method ) {
			method = typeof method === "string" && method || "remote";

			return $.data( element, "previousValue" ) || $.data( element, "previousValue", {
				old: null,
				valid: true,
				message: this.defaultMessage( element, { method: method } )
			} );
		},

		// Cleans up all forms and elements, removes validator-specific events
		destroy: function() {
			this.resetForm();

			$( this.currentForm )
				.off( ".validate" )
				.removeData( "validator" )
				.find( ".validate-equalTo-blur" )
					.off( ".validate-equalTo" )
					.removeClass( "validate-equalTo-blur" )
				.find( ".validate-lessThan-blur" )
					.off( ".validate-lessThan" )
					.removeClass( "validate-lessThan-blur" )
				.find( ".validate-lessThanEqual-blur" )
					.off( ".validate-lessThanEqual" )
					.removeClass( "validate-lessThanEqual-blur" )
				.find( ".validate-greaterThanEqual-blur" )
					.off( ".validate-greaterThanEqual" )
					.removeClass( "validate-greaterThanEqual-blur" )
				.find( ".validate-greaterThan-blur" )
					.off( ".validate-greaterThan" )
					.removeClass( "validate-greaterThan-blur" );
		}

	},

	classRuleSettings: {
		required: { required: true },
		email: { email: true },
		url: { url: true },
		date: { date: true },
		dateISO: { dateISO: true },
		number: { number: true },
		digits: { digits: true },
		creditcard: { creditcard: true }
	},

	addClassRules: function( className, rules ) {
		if ( className.constructor === String ) {
			this.classRuleSettings[ className ] = rules;
		} else {
			$.extend( this.classRuleSettings, className );
		}
	},

	classRules: function( element ) {
		var rules = {},
			classes = $( element ).attr( "class" );

		if ( classes ) {
			$.each( classes.split( " " ), function() {
				if ( this in $.validator.classRuleSettings ) {
					$.extend( rules, $.validator.classRuleSettings[ this ] );
				}
			} );
		}
		return rules;
	},

	normalizeAttributeRule: function( rules, type, method, value ) {

		// Convert the value to a number for number inputs, and for text for backwards compability
		// allows type="date" and others to be compared as strings
		if ( /min|max|step/.test( method ) && ( type === null || /number|range|text/.test( type ) ) ) {
			value = Number( value );

			// Support Opera Mini, which returns NaN for undefined minlength
			if ( isNaN( value ) ) {
				value = undefined;
			}
		}

		if ( value || value === 0 ) {
			rules[ method ] = value;
		} else if ( type === method && type !== "range" ) {

			// Exception: the jquery validate 'range' method
			// does not test for the html5 'range' type
			rules[ method ] = true;
		}
	},

	attributeRules: function( element ) {
		var rules = {},
			$element = $( element ),
			type = element.getAttribute( "type" ),
			method, value;

		for ( method in $.validator.methods ) {

			// Support for <input required> in both html5 and older browsers
			if ( method === "required" ) {
				value = element.getAttribute( method );

				// Some browsers return an empty string for the required attribute
				// and non-HTML5 browsers might have required="" markup
				if ( value === "" ) {
					value = true;
				}

				// Force non-HTML5 browsers to return bool
				value = !!value;
			} else {
				value = $element.attr( method );
			}

			this.normalizeAttributeRule( rules, type, method, value );
		}

		// 'maxlength' may be returned as -1, 2147483647 ( IE ) and 524288 ( safari ) for text inputs
		if ( rules.maxlength && /-1|2147483647|524288/.test( rules.maxlength ) ) {
			delete rules.maxlength;
		}

		return rules;
	},

	dataRules: function( element ) {
		var rules = {},
			$element = $( element ),
			type = element.getAttribute( "type" ),
			method, value;

		for ( method in $.validator.methods ) {
			value = $element.data( "rule" + method.charAt( 0 ).toUpperCase() + method.substring( 1 ).toLowerCase() );

			// Cast empty attributes like `data-rule-required` to `true`
			if ( value === "" ) {
				value = true;
			}

			this.normalizeAttributeRule( rules, type, method, value );
		}
		return rules;
	},

	staticRules: function( element ) {
		var rules = {},
			validator = $.data( element.form, "validator" );

		if ( validator.settings.rules ) {
			rules = $.validator.normalizeRule( validator.settings.rules[ element.name ] ) || {};
		}
		return rules;
	},

	normalizeRules: function( rules, element ) {

		// Handle dependency check
		$.each( rules, function( prop, val ) {

			// Ignore rule when param is explicitly false, eg. required:false
			if ( val === false ) {
				delete rules[ prop ];
				return;
			}
			if ( val.param || val.depends ) {
				var keepRule = true;
				switch ( typeof val.depends ) {
				case "string":
					keepRule = !!$( val.depends, element.form ).length;
					break;
				case "function":
					keepRule = val.depends.call( element, element );
					break;
				}
				if ( keepRule ) {
					rules[ prop ] = val.param !== undefined ? val.param : true;
				} else {
					$.data( element.form, "validator" ).resetElements( $( element ) );
					delete rules[ prop ];
				}
			}
		} );

		// Evaluate parameters
		$.each( rules, function( rule, parameter ) {
			rules[ rule ] = $.isFunction( parameter ) && rule !== "normalizer" ? parameter( element ) : parameter;
		} );

		// Clean number parameters
		$.each( [ "minlength", "maxlength" ], function() {
			if ( rules[ this ] ) {
				rules[ this ] = Number( rules[ this ] );
			}
		} );
		$.each( [ "rangelength", "range" ], function() {
			var parts;
			if ( rules[ this ] ) {
				if ( $.isArray( rules[ this ] ) ) {
					rules[ this ] = [ Number( rules[ this ][ 0 ] ), Number( rules[ this ][ 1 ] ) ];
				} else if ( typeof rules[ this ] === "string" ) {
					parts = rules[ this ].replace( /[\[\]]/g, "" ).split( /[\s,]+/ );
					rules[ this ] = [ Number( parts[ 0 ] ), Number( parts[ 1 ] ) ];
				}
			}
		} );

		if ( $.validator.autoCreateRanges ) {

			// Auto-create ranges
			if ( rules.min != null && rules.max != null ) {
				rules.range = [ rules.min, rules.max ];
				delete rules.min;
				delete rules.max;
			}
			if ( rules.minlength != null && rules.maxlength != null ) {
				rules.rangelength = [ rules.minlength, rules.maxlength ];
				delete rules.minlength;
				delete rules.maxlength;
			}
		}

		return rules;
	},

	// Converts a simple string to a {string: true} rule, e.g., "required" to {required:true}
	normalizeRule: function( data ) {
		if ( typeof data === "string" ) {
			var transformed = {};
			$.each( data.split( /\s/ ), function() {
				transformed[ this ] = true;
			} );
			data = transformed;
		}
		return data;
	},

	// https://jqueryvalidation.org/jQuery.validator.addMethod/
	addMethod: function( name, method, message ) {
		$.validator.methods[ name ] = method;
		$.validator.messages[ name ] = message !== undefined ? message : $.validator.messages[ name ];
		if ( method.length < 3 ) {
			$.validator.addClassRules( name, $.validator.normalizeRule( name ) );
		}
	},

	// https://jqueryvalidation.org/jQuery.validator.methods/
	methods: {

		// https://jqueryvalidation.org/required-method/
		required: function( value, element, param ) {

			// Check if dependency is met
			if ( !this.depend( param, element ) ) {
				return "dependency-mismatch";
			}
			if ( element.nodeName.toLowerCase() === "select" ) {

				// Could be an array for select-multiple or a string, both are fine this way
				var val = $( element ).val();
				return val && val.length > 0;
			}
			if ( this.checkable( element ) ) {
				return this.getLength( value, element ) > 0;
			}
			return value !== undefined && value !== null && value.length > 0;
		},

		// https://jqueryvalidation.org/email-method/
		email: function( value, element ) {

			// From https://html.spec.whatwg.org/multipage/forms.html#valid-e-mail-address
			// Retrieved 2014-01-14
			// If you have a problem with this implementation, report a bug against the above spec
			// Or use custom methods to implement your own email validation
			return this.optional( element ) || /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test( value );
		},

		// https://jqueryvalidation.org/url-method/
		url: function( value, element ) {

			// Copyright (c) 2010-2013 Diego Perini, MIT licensed
			// https://gist.github.com/dperini/729294
			// see also https://mathiasbynens.be/demo/url-regex
			// modified to allow protocol-relative URLs
			return this.optional( element ) || /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test( value );
		},

		// https://jqueryvalidation.org/date-method/
		date: ( function() {
			var called = false;

			return function( value, element ) {
				if ( !called ) {
					called = true;
					if ( this.settings.debug && window.console ) {
						console.warn(
							"The `date` method is deprecated and will be removed in version '2.0.0'.\n" +
							"Please don't use it, since it relies on the Date constructor, which\n" +
							"behaves very differently across browsers and locales. Use `dateISO`\n" +
							"instead or one of the locale specific methods in `localizations/`\n" +
							"and `additional-methods.js`."
						);
					}
				}

				return this.optional( element ) || !/Invalid|NaN/.test( new Date( value ).toString() );
			};
		}() ),

		// https://jqueryvalidation.org/dateISO-method/
		dateISO: function( value, element ) {
			return this.optional( element ) || /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test( value );
		},

		// https://jqueryvalidation.org/number-method/
		number: function( value, element ) {
			return this.optional( element ) || /^(?:-?\d+|-?\d{1,3}(?:,\d{3})+)?(?:\.\d+)?$/.test( value );
		},

		// https://jqueryvalidation.org/digits-method/
		digits: function( value, element ) {
			return this.optional( element ) || /^\d+$/.test( value );
		},

		// https://jqueryvalidation.org/minlength-method/
		minlength: function( value, element, param ) {
			var length = $.isArray( value ) ? value.length : this.getLength( value, element );
			return this.optional( element ) || length >= param;
		},

		// https://jqueryvalidation.org/maxlength-method/
		maxlength: function( value, element, param ) {
			var length = $.isArray( value ) ? value.length : this.getLength( value, element );
			return this.optional( element ) || length <= param;
		},

		// https://jqueryvalidation.org/rangelength-method/
		rangelength: function( value, element, param ) {
			var length = $.isArray( value ) ? value.length : this.getLength( value, element );
			return this.optional( element ) || ( length >= param[ 0 ] && length <= param[ 1 ] );
		},

		// https://jqueryvalidation.org/min-method/
		min: function( value, element, param ) {
			return this.optional( element ) || value >= param;
		},

		// https://jqueryvalidation.org/max-method/
		max: function( value, element, param ) {
			return this.optional( element ) || value <= param;
		},

		// https://jqueryvalidation.org/range-method/
		range: function( value, element, param ) {
			return this.optional( element ) || ( value >= param[ 0 ] && value <= param[ 1 ] );
		},

		// https://jqueryvalidation.org/step-method/
		step: function( value, element, param ) {
			var type = $( element ).attr( "type" ),
				errorMessage = "Step attribute on input type " + type + " is not supported.",
				supportedTypes = [ "text", "number", "range" ],
				re = new RegExp( "\\b" + type + "\\b" ),
				notSupported = type && !re.test( supportedTypes.join() ),
				decimalPlaces = function( num ) {
					var match = ( "" + num ).match( /(?:\.(\d+))?$/ );
					if ( !match ) {
						return 0;
					}

					// Number of digits right of decimal point.
					return match[ 1 ] ? match[ 1 ].length : 0;
				},
				toInt = function( num ) {
					return Math.round( num * Math.pow( 10, decimals ) );
				},
				valid = true,
				decimals;

			// Works only for text, number and range input types
			// TODO find a way to support input types date, datetime, datetime-local, month, time and week
			if ( notSupported ) {
				throw new Error( errorMessage );
			}

			decimals = decimalPlaces( param );

			// Value can't have too many decimals
			if ( decimalPlaces( value ) > decimals || toInt( value ) % toInt( param ) !== 0 ) {
				valid = false;
			}

			return this.optional( element ) || valid;
		},

		// https://jqueryvalidation.org/equalTo-method/
		equalTo: function( value, element, param ) {

			// Bind to the blur event of the target in order to revalidate whenever the target field is updated
			var target = $( param );
			if ( this.settings.onfocusout && target.not( ".validate-equalTo-blur" ).length ) {
				target.addClass( "validate-equalTo-blur" ).on( "blur.validate-equalTo", function() {
					$( element ).valid();
				} );
			}
			return value === target.val();
		},

		// https://jqueryvalidation.org/remote-method/
		remote: function( value, element, param, method ) {
			if ( this.optional( element ) ) {
				return "dependency-mismatch";
			}

			method = typeof method === "string" && method || "remote";

			var previous = this.previousValue( element, method ),
				validator, data, optionDataString;

			if ( !this.settings.messages[ element.name ] ) {
				this.settings.messages[ element.name ] = {};
			}
			previous.originalMessage = previous.originalMessage || this.settings.messages[ element.name ][ method ];
			this.settings.messages[ element.name ][ method ] = previous.message;

			param = typeof param === "string" && { url: param } || param;
			optionDataString = $.param( $.extend( { data: value }, param.data ) );
			if ( previous.old === optionDataString ) {
				return previous.valid;
			}

			previous.old = optionDataString;
			validator = this;
			this.startRequest( element );
			data = {};
			data[ element.name ] = value;
			$.ajax( $.extend( true, {
				mode: "abort",
				port: "validate" + element.name,
				dataType: "json",
				data: data,
				context: validator.currentForm,
				success: function( response ) {
					var valid = response === true || response === "true",
						errors, message, submitted;

					validator.settings.messages[ element.name ][ method ] = previous.originalMessage;
					if ( valid ) {
						submitted = validator.formSubmitted;
						validator.resetInternals();
						validator.toHide = validator.errorsFor( element );
						validator.formSubmitted = submitted;
						validator.successList.push( element );
						validator.invalid[ element.name ] = false;
						validator.showErrors();
					} else {
						errors = {};
						message = response || validator.defaultMessage( element, { method: method, parameters: value } );
						errors[ element.name ] = previous.message = message;
						validator.invalid[ element.name ] = true;
						validator.showErrors( errors );
					}
					previous.valid = valid;
					validator.stopRequest( element, valid );
				}
			}, param ) );
			return "pending";
		}
	}

} );

// Ajax mode: abort
// usage: $.ajax({ mode: "abort"[, port: "uniqueport"]});
// if mode:"abort" is used, the previous request on that port (port can be undefined) is aborted via XMLHttpRequest.abort()

var pendingRequests = {},
	ajax;

// Use a prefilter if available (1.5+)
if ( $.ajaxPrefilter ) {
	$.ajaxPrefilter( function( settings, _, xhr ) {
		var port = settings.port;
		if ( settings.mode === "abort" ) {
			if ( pendingRequests[ port ] ) {
				pendingRequests[ port ].abort();
			}
			pendingRequests[ port ] = xhr;
		}
	} );
} else {

	// Proxy ajax
	ajax = $.ajax;
	$.ajax = function( settings ) {
		var mode = ( "mode" in settings ? settings : $.ajaxSettings ).mode,
			port = ( "port" in settings ? settings : $.ajaxSettings ).port;
		if ( mode === "abort" ) {
			if ( pendingRequests[ port ] ) {
				pendingRequests[ port ].abort();
			}
			pendingRequests[ port ] = ajax.apply( this, arguments );
			return pendingRequests[ port ];
		}
		return ajax.apply( this, arguments );
	};
}
return $;
}));
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
