(function ($) {
	var $footer = $('#masthead');
	var $page = $('#page');
	if( $footer.hasClass('footer-fixed') || $footer.hasClass('headroom') ) {
		var $footer_h = $footer.height();
		$page.css('padding-top', $footer_h + 'px');
	}
})(jQuery);