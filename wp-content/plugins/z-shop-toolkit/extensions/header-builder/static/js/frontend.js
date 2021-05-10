'use strict';
( function ($) {
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

	function clickOutsideDivHandler(selector, callback) {
		var args = Array.prototype.slice.call(arguments); // Save/convert arguments to array since we won't be able to access these within .on()
		$(document).on("mouseup.clickOFF touchend.clickOFF", function (e) {
			var container = $(selector);

			if ( !container.is(e.target) // if the target of the click isn't the container...
				&& container.has(e.target).length === 0 ) // ... nor a descendant of the container
			{
				$(document).off("mouseup.clickOFF touchend.clickOFF");
				if ( callback ) callback.apply(this, args);
			}
		});
	}

	var s, self;
	var LunarHeaderBuilder = {
		settings: {
			document: $(document),
			body: $(document.body),
			window: $(window),
			page: $(document.getElementById('page')),
			header: $('.header-builder'),
			headerHeight: 0,
			browserWidth: 0,
			browserHeight: 0,
			toggler: $('.m-header-buider-menu-toggler'),
		},
		init: function () {
			self = this;
			s    = this.settings;

			this.updateBrowserDimension();
			s.headerHeight = s.header.height();

			if ( s.header.hasClass('headroom') || s.header.hasClass('header-fixed') ) {
				self.fixedHeader();
			}

			s.window.on('resize', debounce(function () {
				self.updateBrowserDimension();
				if ( s.header.hasClass('headroom') || s.header.hasClass('header-fixed') ) {
					self.fixedHeader();
				}
			}, 250));

			if( self.isTouch ) {
				this.centerMobileEl();
			} else {
				this.centerDesktopEl();
			}

			s.toggler.on('click', this.toggleMenu);
		},
		fixedHeader: function () {
			if ( s.browserWidth > 991 ) {
				s.page.css('padding-top', s.headerHeight + 'px');
			} else {
				s.page.css('padding-top', '');
			}
		},
		updateBrowserDimension: function () {
			s.browserWidth  = s.window.width();
			s.browserHeight = s.window.height();
		},
		centerDesktopEl: function () {
			var $builder = $('.header-builder');
			if ( $builder.length === 0 ) return;
			var $centerEls = $builder.find('.center-el');
			if ( $centerEls.length === 0 ) return;

			var $wrapper          = $builder.find('.row'),
			    $wrapperOffset    = $wrapper.offset(),
			    $centerEl         = $centerEls.first(),
			    $centerElsBefore  = $centerEl.prevAll(),
			    $centerElBefore   = false,
			    $centerElBeforeClass = false;

			$centerElsBefore.each(function () {
				var $this = $(this),
				    $classes   = $this.attr('class');
				if ( typeof $classes !== 'undefined' && $classes.indexOf('flex') !== -1 ) {
					$centerElBefore   = $this;
					$centerElBeforeClass = $classes;
					return false;
				}
			});

			if ( $centerElBeforeClass ) {
				$centerElBefore.css('flex-grow', '0');
			}

			var $centerElOffset = $centerEl.offset(),
			    $centerElWidth  = $centerEl.outerWidth(),
			    $wrapperWidth   = $wrapper.outerWidth(),
			    $padding        = $wrapperWidth / 2 - ( $centerElOffset.left - $wrapperOffset.left) - $centerElWidth / 2;
			if ( $padding <= 0 ) return;

			if ( $centerElBeforeClass ) {
				$centerElBefore.css('width', $padding + 'px');
			} else {
				$centerEl.css('margin-left', $padding + 'px');
			}
		},
		centerMobileEl: function () {
			var $builder = $('.m-header-builder');
			if ( $builder.length === 0 ) return;
			var $centerEls = $builder.find('.center-el');
			if ( $centerEls.length === 0 ) return;

			var $wrapper          = $builder.find('.row'),
			    $wrapperOffset    = $wrapper.offset(),
			    $centerEl         = $centerEls.first(),
			    $centerElsBefore  = $centerEl.prevAll(),
			    $centerElBefore   = false,
			    $centerElBeforeClass = false;

			$centerElsBefore.each(function () {
				var $this = $(this),
				    $classes   = $this.attr('class');
				if ( typeof $classes !== 'undefined' && $classes.indexOf('flex') !== -1 ) {
					$centerElBefore   = $this;
					$centerElBeforeClass = $classes;
					return false;
				}
			});

			if ( $centerElBeforeClass ) {
				$centerElBefore.css('flex-grow', '0');
			}

			var $centerElOffset = $centerEl.offset(),
			    $centerElWidth  = $centerEl.outerWidth(),
			    $wrapperWidth   = $wrapper.outerWidth(),
			    $padding        = $wrapperWidth / 2 - ( $centerElOffset.left - $wrapperOffset.left) - $centerElWidth / 2;
			console.log($wrapperWidth, $wrapperOffset.left, $centerElWidth, $centerElOffset.left);
			if ( $padding <= 0 ) return;

			if ( $centerElBeforeClass ) {
				$centerElBefore.css('width', $padding + 'px');
			} else {
				$centerEl.css('margin-left', $padding + 'px');
			}
		},
		isTouch: function() {
			  var check = false;
			  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os )?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip )|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/ )|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/ )|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w] )|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
			  return check;
		},
		toggleMenu: function() {
			s.body.addClass('m-menu-active');
			clickOutsideDivHandler('.mobile-menu', debounce(self.hideMenu, 100));
		},
		hideMenu: function() {
			s.body.removeClass('m-menu-active');
		}
	};
	LunarHeaderBuilder.init();
}(jQuery) );
