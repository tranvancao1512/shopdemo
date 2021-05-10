
jQuery(document).ready( function(){
	var 
		$      = jQuery,
		values = {};

	if ( $().wpColorPicker ) {
		$('.wp-color-picker').wpColorPicker( {
			change: function(event, ui){
			    var theColor = ui.color.toString();
			} 
		});
	}

	var $select = $('select.trigger-type');

	$select.on('change', function(){
		$(this).trigger('type');
	});

	$select.on('type',function(){
		var type  = $(this).val(),
			$container = $(this).closest( '.wrap-item' );
			$type 	   = $container.find('.type-' + type );
		if( $type.length && ! $type.hasClass('active') ) {
			$container.find('.active').removeClass('active').slideUp();
			$type.addClass('active').slideDown();
		} else {
			$container.find('.active').removeClass('active').slideUp();
		}
	});

	$select.trigger('type');

	$('.basr-save').on('click',function() {
		values = {};

		var $loader = $(this).next();
		$loader.addClass('updating-message');

		$('.option').each( function(){
			if ( $(this).hasClass('get-image') ){
				values[$(this).attr('data-name')] = $(this).attr('data-id');	
			} else {
				values[$(this).attr('data-name')] = $(this).val();
			}
		});

		console.log( values );
		values = JSON.stringify( values );

		$.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action  : 'basr_wc_add_on_save',
				options : values,
			},
			success:function( response ) {
				$loader.removeClass('updating-message');
			},
			error: function(errorThrown){
			    console.log( errorThrown );
			}
		});
	});

	// media 

	var file_frame;
	var $crr;
 	// Set this
	jQuery('.type-image .option').on('click', function( event ){
		$crr = $(this);
		event.preventDefault();

		// Create the media frame.
		if ( typeof file_frame == 'undefined' ) {
			file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Select a image to upload',
				button: {
					text: 'Use this image',
				},
				multiple: false	// Set to true to allow multiple files to be selected
			});
		}

		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			$crr.css('background-image', 'url(' + attachment.url + ')' ).attr('data-id', attachment.id);
			// console.log( '--save--' );
			// console.log( $crr );
		});
		// When an image is selected, run a callback.
		// Finally, open the modal
		file_frame.open();
	});

	$('#basr_variation_style .image-preview').on('click', function( event ){
		var 
			$this = $(this);
		 	$wrap = $this.parent();

		// Create the media frame.
		if ( typeof file_frame == 'undefined' ) {
			file_frame = wp.media.frames.file_frame = wp.media({
				title: 'Select a image to upload',
				button: {
					text: 'Use this image',
				},
				multiple: false	// Set to true to allow multiple files to be selected
			});
		}

		file_frame.on( 'select', function() {
			// We set multiple to false so only get one image from the uploader
			attachment = file_frame.state().get('selection').first().toJSON();
			// Do something with attachment.id and/or attachment.url here
			$wrap.find('.image-preview').attr('src', attachment.url);
			$wrap.find('.image_attachment_id').val(attachment.id);
			// console.log( '--save--' );
			// console.log( $crr );
		});
		// When an image is selected, run a callback.
		// Finally, open the modal
		file_frame.open();
	});

});