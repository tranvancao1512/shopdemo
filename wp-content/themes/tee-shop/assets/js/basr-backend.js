
var log = console.log;

(function ( $, window, document, undefined ) {

    // Create the defaults once
    var pluginName = "basrBackend",
        defaults = {
            unysonLogistic: true
        };

    // The actual plugin constructor
    function basrBackend( element, options ) {
        this.element = element;

        // jQuery has an extend method that merges the
        // contents of two or more objects, storing the
        // result in the first object. The first object
        // is generally empty because we don't want to alter
        // the default options for future instances of the plugin
        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;

        this.init();
    }

    basrBackend.prototype = {

        init: function() {

        	var basrBackend 			= this;

        	$.each( this.options, function( func, value) {
            	if ( value ) {
            		basrBackend[func]();
            	}
            });
        },	

        // Unyson logistic

        unysonLogistic: function(el, options) { 

        	var get_option_control_val = this.get_option_control_val,
        		options_hidden 		   = this.options_hidden,
        		options_display 	   = this.options_display;

            /**
             * Listen to special event that is triggered for uninitialized elements
             */

            fwEvents.on('fw:options:init', function (data) {

                $('.basr-css-logic').each( function(){
                    var $container = $(this).closest('.fw-options-tab');
                    $(this).attr( 'data-current', $(this).val() );
                    if ( ! $container.hasClass('basr-css-logic-container') ) { $container.addClass('basr-css-logic-container') };
                    $container.addClass( $(this).attr('id') + '-lg' );
                    if ( $(this).val() != 'get-setting' ) {
                        $container.addClass( $(this).attr('id') + '-current-' + $(this).val() );
                    } else {
                        $container.addClass( $(this).attr('id') + '-current-' + $(this).attr('data-stt' ) );
                    }
                });
                
                $('.basr-css-logic').on('change', function(){
                    var $container = $(this).closest('.fw-options-tab');
                    log( $(this).attr('data-current') );
                    $container.removeClass( $(this).attr('id') + '-current-' + $(this).attr('data-current') );
                    $(this).attr( 'data-current', $(this).val() );
                    if ( $(this).val() == 'get-setting' ) {
                        $container.addClass( $(this).attr('id') + '-current-' + $(this).attr('data-stt' ) );
                        $(this).attr( 'data-current', $(this).attr('data-stt') );
                    } else {
                        $container.addClass( $(this).attr('id') + '-current-' + $(this).attr('data-current') );
                    }
                });
             
            });

        	setTimeout( function(){

                // console.log( $('.basr-logic') );

        		$('.basr-logic').each(function() {

	            	var elems 	 		= $(this) .attr('data-logic-item').split(' '),
	            		conditionals 	= $(this).attr('data-logic-value'),
	            		el_class	 	= $(this).attr('class'),
	            		$control 		= $(this),
	            		type 			= el_class.match( /fw-option-type-(\w+)/i );

	            	conditionals = conditionals.split(' ');

	            	if ( typeof( type[1] ) != 'undefined' ) {
	            		type = type[1];
	            	}

	            	var value 			= get_option_control_val( $control, type  );

	            	if ( value !== 'basr-break' ) {

	            		var event = 'change';

	            		$control.on('remote', function(){
		            		value 			= get_option_control_val( $control, type  );

		            		if ( ! $.inArray( value, conditionals ) ) {
		            			options_hidden( elems );
		            		} else {
		            			options_display( elems );
		            		}
		            	})

		            	if ( type == 'switch' ) event = 'click';

		            	$control.on( event , function() {
		            		setTimeout( function(){
		            			$control.trigger('remote');
		            		}, 300 );
		            	});
		            }

		            $control.trigger('remote');

	            });

                // reverse logic

	            $('.basr-rever-logic').each(function(){
	            	var elems 	 		= $(this).attr('data-logic-item').split(' '),
                        $this_fw_option = $(this).closest('.fw-backend-option'),
	            		conditionals 	= $(this).attr('data-logic-value'),
	            		el_class	 	= $(this).attr('id').match( /fw-option-([^\s]+)/i ),
                        type            = '',
                        $control        = $('#' + elems );

                    $control = ( $control.length > 0 ) ? $control : $control = $( '#fw-option-' + elems );

                    if ( typeof( $control.attr('class') ) != 'undefined' ) {
                        type            = $control.attr('class').match( /fw-option-type-(\w+)/i );
                        if ( typeof( type[1] ) != 'undefined' ) {
                            type = type[1];
                        }
                    }

                    if ( typeof( el_class[1] ) != 'undefined' ) {
                        el_class = el_class[1];
                    }
                    if ( !type ) {
                        $control.find('input').on('change',function() {
                            if ( conditionals == $(this).attr('id') ) {
                                options_display( el_class )
                            } else {
                                options_hidden( el_class );
                            }
                        });
                        $control.find('input:checked').trigger('change');
                    } else {

                        if ( $control.length > 0 ) {

                            var event = 'change';

                            $this_fw_option.on('remote', function(){

                                value = get_option_control_val( $control, type  );

                                elems = $this_fw_option.attr('id').replace( 'fw-backend-option-fw-option-', '' );

                                if ( $.inArray( value, $.makeArray( conditionals ) ) < 0 ) {
                                    options_hidden( elems );
                                } else {
                                    options_display( elems );
                                }
                            })

                            if ( type == 'switch' ) event = 'click';

                            $control.on( event , function() {
                                setTimeout( function(){
                                    $this_fw_option.trigger('remote');
                                }, 300 );
                            });
                        }
                    }
	            });

        	}, 1000);

        },

        get_option_control_val: function( $control, type ) {

        	switch ( type ) {
        		case 'select': value = $control.val(); break;
        		case 'switch': 
        			if ( $control.find('.adaptive-switch').hasClass('switch-right') ) {
        				value = 'switch-right';
        			} else {
        				value = 'switch-left';
        			}
        			break;
        		case 'text'  : value = $control.val(); break;  
        		default 	 : value = 'basr-break';
        	}

        	return value;
        },

        options_display: function( elems ) {
        	$.each( $.makeArray( elems ) , function( index, elems ){
        		$('body #fw-backend-option-fw-option-' + elems ).slideDown();
        	});
        },

    	options_hidden: function( elems ){
    		$.each( $.makeArray( elems ) , function( index, elems ){
        		$('body #fw-backend-option-fw-option-' + elems ).slideUp();
        	});
    	}

    	// 

    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $[pluginName] = function ( options ) {
        return	new basrBackend( this, options );
    };

})( jQuery, window, document );

(function ( $, window, document, undefined ) {
	$(document).ready(function(){
        // console.log( 'basr-backend' );
		$.basrBackend();
	});
})( jQuery, window, document );
