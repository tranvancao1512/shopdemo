
jQuery.noConflict();

jQuery(document).ready(function($){

	"use strict"; 

	// install, uninstall plugin
   	
	install();

	// tab 

	$('.nav-tab-wrapper a').on('click',function(){
		if ( ! $(this).hasClass('active') ) {
			$('#tabs-container .active').removeClass('active');
			$(this).addClass('active');
			$('.tab-content .active').removeClass('active');
			$( $(this).attr('href') ).addClass('active');
			return false;
		};
	});

	/*  [ Performs a smooth page scroll to an anchor ]
	- - - - - - - - - - - - - - - - - - - - */
	$( '.anchor' ).click( function() {
		$('a:not(.anchor)[href="' + $(this).attr('href') + '"]').each(function(){
			$(this).trigger('click');
		});

		if ( location.pathname.replace( /^\//, '' ) == this.pathname.replace( /^\//, '' ) && location.hostname == this.hostname ) {
			var target = $( this.hash );

			var adminBar = $( '#wpadminbar' ).outerHeight();
			target = target.length ? target : $( '[name=' + this.hash.slice( 1 ) + ']' );
			if ( target.length ) {
				$( 'html,body' ).animate( {
					scrollTop: target.offset().top - adminBar - 100 + "px"
				}, 800 );
				return false;
			}
		}
	} );

	// nav-tab

	$('.nav-tab').on('click',function(){
		if( $(this).attr('href') == '#demos' ) {
			$('.versions-filters li:first-child a').trigger('click');
		}
	});

	// func

	function install(){
		$('.plugin-install').on('click',function(){
			var installing;

			var action = $(this).hasClass('install') ? 'install' : 'uninstall';

			$( this ).hide();

			var $pr = $(this).closest('.plugin-item');

			$pr.find('.spinner').addClass('is-active');
			setTimeout(function() {
				var pl = Array();
				pl['source']			= $pr.data('source');
				pl['file']				= $pr.data('file');
				pl['slug']				= $pr.data('slug');
				pl['install_nonce']		= $pr.data('install_nonce');
				pl['uninstall_nonce']	= $pr.data('uninstall_nonce');
				pl['name']				= $pr.data('name');
				pl['activate_nonce']	= $pr.data('activate_nonce');
				if( pl['slug'] === 'unyson' ) {
					pl['extensions_nonce']	= $pr.data('extensions_nonce');
				}

				if ( action == 'install' ) ajax_tgmpa_install( pl, $pr );
				else ajax_uninstall_plugin( pl, $pr );
			}, 300);

		});
	}

	/* Install plugin */ 

	function ajax_tgmpa_install( pl, $pr ){
		console.log(pl);

		var plugin_source_temp = ( pl['source'] != '' ) ? "&plugin_source=" +  pl['source'] : "&plugin_source=repo" ;
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"] );
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"] );
		$.ajax({
			async: true,
			url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"],
			complete: function( data ) {
				$.ajax({
					async: true,
					url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"],
					complete: function( data ) {
						$.ajax({
							async: true,
							url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&tgmpa-nonce=' + pl["install_nonce"],
							complete: function (data) {
								if( pl["slug"] === 'unyson' ) {
									$.ajax({
										type: "POST",
										url: home_url + '/wp-admin/admin.php?page=fw-extensions&sub-page=install&supported',
										data: "_nonce_fw_extensions_install="+pl["extensions_nonce"],
										complete: function (data) {
											$pr.find('.spinner').removeClass('is-active');
											$pr.find('button:not(.install)').show();
										}
									});
								} else {
									$pr.find('.spinner').removeClass('is-active');
									$pr.find('button:not(.install)').show();
								}
							}
						});
					}
				});
			}
		});
	}

	/* Uninstall plugin */

	function ajax_uninstall_plugin( pl, $pr ){
		console.log(pl['uninstall_nonce']);
		console.log(pl['file']);
		console.log(pl['slug']);
		$.ajax({
			url: ajaxurl,
			data: {
				'action' : 	'moodshop_uninstall_plugin',
				'slug' 	 :  pl['slug'],
				'nonce'  :  pl['uninstall_nonce'],
				'file'	 :  pl['file'],
			},
			success:function(data) {
				// This outputs the result of the ajax request
				$pr.find('.spinner').removeClass('is-active');
				$pr.find('.install').show();
			},
			error: function(errorThrown){
			    console.log(errorThrown);
			}
		});	
	}

	var $closeButton = $('.basr_advance_backup_data_popup_control_close'),
	$dialog = $('#advance_backup_data_popup_for_advance_backup_section_2'),
	$importButton = $('.advance_backup_data_popup_control_start'),
	$step1 = $('.advance_backup_data_popup_step_1'),
	$step2 = $('.advance_backup_data_popup_step_2'),
	$spinner = $('.advance_backup_data_popup_step_2 .spinner'),
	$p_plugins = $('#process_active_plugins'),
	$p_import = $('#process_import'),
	$p_import_status = $('.import-status'),
	$p_list = $importButton.data('plugins'),
	$p_current = $('.current-plugin'),
	$p_done = $('#proces_done'),
	installPlugin = function(pl, callback) {
		$p_current.html(pl.name);	
		var plugin_source_temp = ( pl['source'] != '' ) ? "&plugin_source=" +  pl['source'] : "&plugin_source=repo" ;
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"] );
		console.log( home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"] );
		$.ajax({
			async: true,
			url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20")  + plugin_source_temp + '&tgmpa-install=install-plugin&tgmpa-nonce=' + pl["install_nonce"],
			complete: function( data ) {
				$.ajax({
					async: true,
					url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&plugin=' + pl["slug"] + '&plugin_name=' + pl["name"].replace(" ", "%20") + plugin_source_temp + '&tgmpa-activate=activate-plugin&tgmpa-nonce=' + pl["activate_nonce"],
					complete: function( data ) {
						$.ajax({
							async: true,
							url: home_url + '/wp-admin/themes.php?page=tgmpa-install-plugins&tgmpa-nonce=' + pl["install_nonce"],
							complete: function (data) {
								if( pl["slug"] === 'unyson' ) {
									$.ajax({
										type: "POST",
										url: home_url + '/wp-admin/admin.php?page=fw-extensions&sub-page=install&supported',
										data: "_nonce_fw_extensions_install="+pl["extensions_nonce"],
										complete: function() {
											callback();
										}
									});
								} else {
									callback();
								}
							}
						});
					}
				});
			}
		});
	},
	installStatusChecker = function(cb) {
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'fw:ext:backups-demo:status'
			},
			complete: function(xhr) {
				var data = xhr.responseJSON;
				if( typeof data.success !== 'undefined') {
					if(data.success) {
						if( typeof data.data.is_busy !== 'undefined' && data.data.is_busy ) {
							$p_import_status.html(data.data.html);
							setTimeout(installStatusChecker(cb), 3000);
						} else {
							$p_import.addClass('success');
							cb(null);
						}
					} else {
						$p_import.addClass('fail');
						cb(err);
					}
				} else {
					$p_import.addClass('success');
					cb(null);
				}
			},
		});
	}
	;
	$('.install-ver').click(function () {
		$dialog.fadeIn(400);
		$importButton.attr('data-ver', $(this).data('ver'));
	});
	$closeButton.click(function() {
		$dialog.fadeOut(400);
	});
	var beforeUnLoadFn = function (e) {
	  var message = "Demo is in progress. You should wait for it to finish!";

	  e.returnValue = message;     
	  return message;                                
	}
	$importButton.click( function() {
		$closeButton.fadeOut();
		$step1.fadeOut(400);
		$importButton.fadeOut(function() {
			$step2.fadeIn(400);
		});
		window.addEventListener("beforeunload", beforeUnLoadFn); // 'Custom text support removed' in Chrome 51.0 and Firefox 44.0	
		async.waterfall([ 
			function(cb) {
				async.eachSeries($importButton.data('plugins'), function (prime, callback) {
				  installPlugin(prime, callback);
				}, function (err) {
				  if (err) {
				  	throw err;
				  	$p_plugins.addClass('fail');
				  	cb(err);
				  }
				  $p_current.html('Done!');
				  $p_plugins.addClass('success');
				  cb(null);
				});
			},
			function(cb) {
				$p_import.fadeIn(400);
				$.ajax({
					url: ajaxurl,
					type: 'POST',
					data: {
						action: 'fw:ext:backups-demo:install',
						id: $importButton.data('ver').toString(),
					},
					success: function() {
						installStatusChecker(cb);
					},
					error: function(err) {
						cb(err);
					}
				});
			}
		], function(err, result) {
			if( !err ) {
				console.log('Complete');
				$p_import_status.html('');
				$p_done.addClass('success');
				$p_done.fadeIn(400);
				$closeButton.fadeIn(400);
				window.removeEventListener("beforeunload", beforeUnLoadFn); // 'Custom text support removed' in Chrome 51.0 and Firefox 44.0	
			} else {
				console.log(err);
			}	
		});
	});

}); 
