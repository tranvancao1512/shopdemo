
jQuery(document).ready(function ($) {
    var optionTypeClass = '.fw-option-type-load-vc-template';

    /**
     * Listen to special event that is triggered for uninitialized elements
     */
    fwEvents.on('fw:options:init', function (data) {
        /**
         * data.$elements are jQuery selected elements
         * that contains options html that needs to be initialized
         *
         * Find uninitialized options by main class
         */
        var $options = data.$elements.find(optionTypeClass +':not(.initialized)');

        /**
         * Listen for button click and clear input value
         */
        $options.on('click', 'button', function(){
            $(this).closest(optionTypeClass).find('input').val('');
        });

        /**
         * After everything has done, mark options as initialized
         */
        $options.addClass('initialized');

        var $container   = $('.fw-backend-option-type-load-vc-template'),
            dataType     = $container.find('#fw-option-page_template').attr('data-type');
            template_ids = [];

        console.log( 'init' );

        $container.find('.basr-load-template').on('click',function() {  

            var $button = $(this);

            if ( $(this).hasClass('loading') ) return;

            $(this).addClass('loading');

            template_ids = [];
            $container.find('.items > div').each( function(){
                template_ids.push( $(this).attr('data-value') );
            });

            console.log( $container.find('.items > div') );

            if ( template_ids.length < 1) {
                alert( 'Please select at least 1 template.');
                return;
            }

            $container.find('.loader').addClass('updating-message');

            template_ids = JSON.stringify( template_ids );

            $.ajax( {
                type: "POST",
                url : ajaxurl,
                data: {
                    action      : 'basr_core_fn_load_template',
                    template_ids: template_ids,
                    dataType    : dataType,
                },
                success: function( response ) {
                    $container.find('.template-load-popup').html( response );
                    $container.find('.loader').removeClass('updating-message');
                    $button.removeClass('loading');
                },
                error: function ( e ) {
                    console.log( e );
                }
            });
        });

        $container.find('.basr-export-template').on('click',function() {
            $container.find('.loader').addClass('updating-message');
            $.ajax( {
                type: "POST",
                url : ajaxurl,
                data: {
                    action      : 'basr_core_export_data_template',
                },
                success: function( response ) {
                    $container.find('.loader').removeClass('updating-message');
                    alert('Export Done !');
                },
                error: function ( e ) {
                    console.log( e );
                }
            });
        });
    });
});