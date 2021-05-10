'use strict'
jQuery(document).ready( function(){
	var 
		$               = jQuery,
		$wc_container   = $('.summary table.variations'),
		$wrap_variants  = $('.wrap-variant-style'),
		$variants       = $('.basr-core-variant'),
		$reset 			= $wc_container.find('.reset_variations');

	var 
		$flex_nav = $('.wrap-flex-nav'),
		$wrap_gallery;

	if( $flex_nav.length ) {
		var $wrap_gallery = $('.woocommerce-product-gallery');
		$flex_nav.find('li').on('click',function(){
			$wrap_gallery.flexslider( $(this).index() );
		});
	}

	var count = 0,
		$selects = $('#variations_form cart .variations select'),
		$form = $('.entry-summary .variations_form'),
		_check_available = false;

	var $form = $('.variations_form');
	// console.log( $form );
	$form.on('woocommerce_update_variation_values',function(){
		$wrap_variants.find('.active-attr').removeClass('active-attr');
		$form.find('.variations select').each(function(){
			var key = $(this).closest('tr').index();
			var $fake_v = $wrap_variants.children().eq(key);

			if( ! $(this).val() ) {
				$fake_v.find('.selected').removeClass('selected');
			} else {
				$fake_v.addClass('selected');
			}
			$(this).children().each(function(){
				if( ! $(this).attr('value') ) return true;
				var option_class = 'o' + key + '-' + bin2hex( $(this).attr('value') );
				$fake_v.find('[data-class="' + option_class + '"]').addClass('active-attr');
			});
		});
		if( $('.variations_form').hasClass('cb-reset') ) {
			$('.variations_form').removeClass('cb-reset');
			$wrap_variants.find('.basr-core-variant label p').text('');
			$wrap_variants.find('.cb-reset').removeClass('cb-reset').trigger('click');
		}
	});

	$variants.each(function(i){

		var $container 	= $(this);
		$(this).attr('data-index', count++ );

		$container.find('span').on('click', function(){
			var $wc_variant = $( '#' + $container.attr('data-key').toLowerCase() ),
				variant_key = $(this).attr('data-value').replace(/"/g, '\\"' );
			var $wc_option = $wc_container.find( '[value="' + variant_key + '"]' );
			console.log( $wc_variant );
			$container.find('.selected').removeClass('selected');
			$(this).addClass('selected');
			$(this).parent().prev().find('p').text($(this).text().replace(/\b[a-z]/g, function(letter) {return letter.toUpperCase();}));

			$wc_variant.val( $(this).text() ).trigger('change');

			if( ! $wc_variant.val() ) {
				$form.addClass('cb-reset');
				$(this).addClass('cb-reset');
				$reset.trigger('click');
			} else {
				// console.log('ready for change');
				$wc_variant.trigger('change');
			}

		});

		$container.find('span.selected').each(function(){
			$(this).trigger('click');
		});
	});

	var $btn_size = $('#main .btn-size');

	$('.open-swipe').on('click',function(){
		$wrap_gallery.find('.flex-active-slide img').trigger('click');
	});

	if( $btn_size.length ) {
		var $popup = $('.popup-size')
		$btn_size.on('click',function(){
			$popup.addClass('active');
		});
		$popup.find('.close').on('click',function(){
			$popup.removeClass('active');
		});
		$popup.find('.nav span').on('click',function(){
			if( $(this).hasClass('active') ) return;
			$popup.find('.nav .active').removeClass('active');
			$popup.find('.content .active').removeClass('active');
			$(this).addClass('active');
			$popup.find('.c-' + $(this).attr('data-id') ).addClass('active');
		});
	}

	$('.combine-product a').on('click', function(e){
		console.log('click');
		e.preventDefault();

		var $selects = $('.combine-options').find('[data-data-id="' + $(this).attr('data-id') + '"]');

		$form.find( '[name="add-to-cart"]' ).val( $(this).attr('data-id') );
		$form.find( '[name="product_id"]' ).val( $(this).attr('data-id') );
		$form.find( '[name="variation_id"]' ).val( '' );

		$selects.each(function(){
			var index = $(this).index();
			console.log( $form.find('.variations tr:nth-child(' + ( index ) + ') select') );
			// $form.find('.variations tr:nth-child(' + ( index + 1 ) + ') select').replaceWith( $(this) );
		});;

		if( $form.find('.variations tr').length > $selects.length ) {
			for (var i = $selects.length + 1; i <= $form.find('.variations tr').length ; i++) {
				console.log( $form.find('.variations tr:nth-child(' + ( i + 1 ) + ')') );
				// $form.find('.variations tr:nth-child(' + ( i + 1 ) + ')').remove();
			}
		}

		return false;
	});

});

function bin2hex(s){  
    var v,i, f = 0, a = [];  
    s += '';  
    f = s.length;  
      
    for (i = 0; i<f; i++) {  
        a[i] = s.charCodeAt(i).toString(16).replace(/^([\da-f])$/,"0$1");  
    }  
    return a.join('');  
}