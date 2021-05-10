'use strict';
jQuery(document).ready(function ($) {
	function debounce(func, wait, immediate) {
		var timeout;
		return function () {
			var context = this, args = arguments;
			var later   = function () {
				timeout = null;
				if ( !immediate ) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if ( callNow ) func.apply(context, args);
		};
	};

	var s, d;
	var HeaderBuilder = {
		settings: {
			document: $(document),
			body: $(document.body),
			window: $(window),
		},
		init: function () {
			s = this.settings;
			d = this;

			if ( typeof fwEvents !== 'undefined' ) {
				fwEvents.on('fw:header-builder:after-render-item', debounce(function () {
					d.centerDesktopEl();
				}, 300));
				fwEvents.on('fw:header-builder:after-remove-item', debounce(function () {
					d.centerDesktopEl();
				}, 100));
				$('.ui-sortable').on('sortstop', debounce(function () {
					d.centerDesktopEl();
				}, 100));
				fwEvents.on('fw:header-builder:before-render-menu', function (menu) {
					if ( menu === 'none' ) return;
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						dataType: 'html',
						data: {
							action: 'header_builder_get_menu_html',
							menu: menu
						},
						success: function (data) {
							var $container = $('#nav-' + menu);
							$container.html(data);
							$container.find('>ul>li>a').attr('style', $container.data('style'));
						}
					});
				});
				fwEvents.on('fw:m-header-builder:after-render-item', debounce(function () {
					d.centerMobileEl();
				}, 300));
				fwEvents.on('fw:m-header-builder:after-remove-item', debounce(function () {
					d.centerMobileEl();
				}, 100));
				$('.ui-sortable').on('sortstop', debounce(function () {
					d.centerMobileEl();
				}, 100));
			}
		},
		centerDesktopEl: function () {
			var $builder   = $('#fw-option-header-builder'),
			    $centerEls = $builder.find('.center-el');

			$builder.find('.fw-row > div').removeAttr('style');

			if ( $centerEls.length === 0 ) return;

			var $wrapper          = $builder.find('.builder-items'),
			    $wrapperOffset    = $wrapper.offset(),
			    $centerEl         = $centerEls.first().parent(),
			    $centerElsBefore  = $centerEl.prevAll(),
			    $centerElBefore   = false,
			    $centerElBeforeId = false;

			$centerElsBefore.each(function () {
				var $this = $(this),
				    $id   = $this.attr('id');
				if ( typeof $id !== 'undefined' && $id.indexOf('flex') !== -1 ) {
					$centerElBefore  = $this;
					$centerElBeforeId = $id;
					return false;
				}
			});

			if ( $centerElBeforeId ) {
				$centerElBefore.css('flex-grow', '0');
			}

			setTimeout(function () {
				var $centerElOffset = $centerEl.offset(),
				    $centerElWidth  = $centerEl.outerWidth(),
				    $wrapperWidth   = $wrapper.outerWidth(),
				    $padding        = $wrapperWidth / 2 - ( $centerElOffset.left - $wrapperOffset.left) - $centerElWidth / 2;
				if ( $padding <= 0 ) return;

				if ( $centerElBeforeId ) {
					$centerElBefore.css('width', $padding + 'px');
				} else {
					$centerEl.css('margin-left', $padding + 'px');
				}
			}, 500);
		},
		centerMobileEl: function () {
			var $builder   = $('#fw-option-m-header-builder'),
			    $centerEls = $builder.find('.center-el');

			$builder.find('.fw-row > div').removeAttr('style');

			if ( $centerEls.length === 0 ) return;

			var $wrapper          = $builder.find('.builder-items'),
			    $wrapperOffset    = $wrapper.offset(),
			    $centerEl         = $centerEls.first().parent(),
			    $centerElsBefore  = $centerEl.prevAll(),
			    $centerElBefore   = false,
			    $centerElBeforeId = false;

				$centerElsBefore.each(function () {
					var $this = $(this),
					    $id   = $this.attr('id');
					if ( typeof $id !== 'undefined' && $id.indexOf('flex') !== -1 ) {
						$centerElBefore  = $this;
						$centerElBeforeId = $id;
						return false;
					}
				});

			if ( $centerElBeforeId ) {
				$centerElBefore.css('flex-grow', '0');
			}

			setTimeout(function () {
				var $centerElOffset = $centerEl.offset(),
				    $centerElWidth  = $centerEl.outerWidth(),
				    $wrapperWidth   = $wrapper.outerWidth(),
				    $padding        = $wrapperWidth / 2 - ( $centerElOffset.left - $wrapperOffset.left) - $centerElWidth / 2;
				if ( $padding <= 0 ) return;

				if ( $centerElBeforeId ) {
					$centerElBefore.css('width', $padding + 'px');
				} else {
					$centerEl.css('margin-left', $padding + 'px');
				}
			}, 500);
		}
	};

	HeaderBuilder.init();
});
