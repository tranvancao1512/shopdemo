'use strict';
jQuery(document).ready( function(){
	var $ = jQuery;
	var delay = 2;
	var interval;

	if( ! $('.goto-checkout') ) {
		var sticky = new Sticky( '.cart-collaterals' );
	}

	$('#content .product-quantity input').each(function(){
		if( $(this).hasClass('added') ) return;
		$(this).addClass('added');
		$(this).on('change',function(){
			clearInterval( interval );
			delay = 2;
			interval = setInterval(function(){ 
				delay -= 1;
				if( delay <= 0 ) {
					$('[name="update_cart"]').trigger('click'); 
					clearInterval( interval );
					delay = 2;
				}
			}, 1000);
		});
	});

	$(document).ajaxComplete(function(){
		$('#content .product-quantity input').each(function(){
			if( $(this).hasClass('added') ) return;
			$(this).addClass('added');
			$(this).on('change',function(){
				clearInterval( interval );
				delay = 2;
				interval = setInterval(function(){ 
					delay -= 1;
					if( delay <= 0 ) {
						$('[name="update_cart"]').trigger('click'); 
						clearInterval( interval );
						delay = 2;
					}
				}, 1000);
			});
		});
		$('#content .q-minus,#content .q-add').each(function(){
			if( $(this).hasClass('added') ) return;
			$(this).addClass('added');
			$(this).on('click',function(){
				var $input = $(this).parent().find('.qty'), quantity = parseInt( $input.val() );
				quantity = $(this).hasClass('q-minus') ? quantity - 1 : quantity + 1; 
				quantity = quantity ? quantity : 1;
				$input.val( quantity ).trigger('change');
			});
		});

		var lazyLoadInstance = new LazyLoad({
		  // Your custom settings go here
		});
	});
});