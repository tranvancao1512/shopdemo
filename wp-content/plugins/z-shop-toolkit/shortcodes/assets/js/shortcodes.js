/**
 * Script trigger shortcodes.
 *
 * @since  1.0
 * @author earththeme
 * @link   http://www.lunartheme.com
 */

(function($) {
	"use strict";

	var BASR = BASR || {};

	/*  [ Init Function ]
	- - - - - - - - - - - - - - - - - - - */
	$(document).ready(function() {

		var $tee_ct = $("#tee-ct");

		$tee_ct
		  	.countdown( $tee_ct.attr('data-date'), function(event) {
			    $tee_ct.find('.days').text(
			      event.strftime('%d')
			    );
			     $tee_ct.find('.hours').text(
			      event.strftime('%H')
			    );
			      $tee_ct.find('.minutes').text(
			      event.strftime('%M')
			    );
			       $tee_ct.find('.seconds').text(
			      event.strftime('%S')
			    );
			});

	}); // ready

})(jQuery);
