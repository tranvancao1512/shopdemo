<?php 


class toolkit_basr_shortcode_map extends toolkit_basr_shortcode {

	// shortcode name 

	public $shortcode = 'map';


	// Enqueue script, style 

	public function enqueue_script ( $extra = array() ) {

		global $post;

		$sc = get_query_var( $this->base );

		if( is_404() ) {
			return;
		}
		if ( is_object( $post ) && has_shortcode( $post->post_content, "{$this->base}" ) || $sc ) {

			parent::enqueue_script();
			wp_enqueue_script('basr-google-map');

			if( !empty($extra) ) {
				extract( shortcode_atts( $extra['sc_atts'], $extra['atts'] ) );
				$id = $extra['id'];
				$infowindow = str_replace('{br}', '<br>', $infowindow);
				$infowindow = str_replace('{b}', '<b>', $infowindow);
				$infowindow = str_replace('{/b}', '</b>', $infowindow);
				$infowindow = str_replace('{center}', '<center>', $infowindow);
				$infowindow = str_replace('{/center}', '</center>', $infowindow);

			$gmap = '
		(function($) {
		$(document).ready(function() {';
			if ( !empty( $str_arr_markers ) ) :
				$gmap .= 'var markers = ' . $str_arr_markers . ';';
			endif;
			$gmap .= 'var myOptions = {
			zoom: ' . $z . ',
			center: new google.maps.LatLng(-33.92, 151.25),
			mapTypeId: google.maps.MapTypeId.' . $maptype . ',';

			if ( $scrollwheel == 'true' ) {
				$gmap .= 'scrollwheel: true,';
			}else{
				$gmap .= 'scrollwheel: false,';
			}
			if ( $hidecontrols ) {
				$gmap .= 'disableDefaultUI: "' . $hidecontrols . '",';
				$gmap .= 'zoomControl: 		"' . $hidecontrols . '",';
			}
			if ( $draggable == 'true' ) {
				$gmap .= 'draggable: true,';
			}else{
				$gmap .= 'draggable: false,';
			}
			if ( !empty( $color ) ) {
				$gmap .= 'backgroundColor: "' . $color . '",';
			}
			switch ( $mapstype ) {
				case 'grayscale':
					$gmap .= 'styles: [{"featureType": "landscape","stylers": [{"saturation": -100},{"lightness": 65},{"visibility": "on"}]},
					{"featureType": "poi","stylers": [{"saturation": -100},{"lightness": 51},{"visibility": "simplified"}]},
					{"featureType": "road.highway","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "road.arterial","stylers": [{"saturation": -100},{"lightness": 30},{"visibility": "on"}]},
					{"featureType": "road.local","stylers": [{"saturation": -100},{"lightness": 40},{"visibility": "on"}]},
					{"featureType": "transit","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
					{"featureType": "administrative.province","stylers": [{"visibility": "off"}]},
					{"featureType": "water","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": -25},{"saturation": -100}]},
					{"featureType": "water","elementType": "geometry","stylers": [{"hue": "#ffff00"},{"lightness": -25},{"saturation": -97}]
				}]';
					break;
				case 'blue_water':
					$gmap .= 'styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{}]},
					{"featureType":"landscape","elementType":"all","stylers":[{}]},
					{"featureType":"poi","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"road","elementType":"all","stylers":[]},
					{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"on"}]},
					{"featureType":"transit","elementType":"all","stylers":[{"visibility":"on"}]},
					{"featureType":"water","elementType":"all","stylers":[{"color":"#afe0ff"},{"visibility":"on"}]
				}]';
					break;
				case 'pale_dawn':
					$gmap .= 'styles: [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},
					{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},
					{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},
					{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},
					{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},
					{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},
					{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]
				}]';
					break;
				case 'shades_of_grey':
					$gmap .= 'styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},
					{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},
					{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},
					{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},
					{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},
					{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},
					{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},
					{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},
					{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},
					{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},
					{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},
					{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]
				}]';
					break;

				case 'basr-core':
					$gmap .= 'styles: [
							    {
							        "featureType": "all",
							        "elementType": "labels.text.fill",
							        "stylers": [
							            {
							                "saturation": 36
							            },
							            {
							                "color": "#333333"
							            },
							            {
							                "lightness": 40
							            }
							        ]
							    },
							    {
							        "featureType": "all",
							        "elementType": "labels.text.stroke",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#ffffff"
							            },
							            {
							                "lightness": 16
							            }
							        ]
							    },
							    {
							        "featureType": "all",
							        "elementType": "labels.icon",
							        "stylers": [
							            {
							                "visibility": "off"
							            }
							        ]
							    },
							    {
							        "featureType": "administrative",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "off"
							            }
							        ]
							    },
							    {
							        "featureType": "administrative",
							        "elementType": "geometry.fill",
							        "stylers": [
							            {
							                "color": "#fefefe"
							            },
							            {
							                "lightness": 20
							            }
							        ]
							    },
							    {
							        "featureType": "administrative",
							        "elementType": "geometry.stroke",
							        "stylers": [
							            {
							                "color": "#fefefe"
							            },
							            {
							                "lightness": 17
							            },
							            {
							                "weight": 1.2
							            }
							        ]
							    },
							    {
							        "featureType": "landscape",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "lightness": 20
							            },
							            {
							                "color": "#ececec"
							            }
							        ]
							    },
							    {
							        "featureType": "landscape.man_made",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#f0f0ef"
							            }
							        ]
							    },
							    {
							        "featureType": "landscape.man_made",
							        "elementType": "geometry.fill",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#f0f0ef"
							            }
							        ]
							    },
							    {
							        "featureType": "landscape.man_made",
							        "elementType": "geometry.stroke",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#d4d4d4"
							            }
							        ]
							    },
							    {
							        "featureType": "landscape.natural",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#ececec"
							            }
							        ]
							    },
							    {
							        "featureType": "poi",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "lightness": 21
							            },
							            {
							                "visibility": "off"
							            }
							        ]
							    },
							    {
							        "featureType": "poi",
							        "elementType": "geometry.fill",
							        "stylers": [
							            {
							                "visibility": "on"
							            },
							            {
							                "color": "#d4d4d4"
							            }
							        ]
							    },
							    {
							        "featureType": "poi",
							        "elementType": "labels.text.fill",
							        "stylers": [
							            {
							                "color": "#303030"
							            }
							        ]
							    },
							    {
							        "featureType": "poi",
							        "elementType": "labels.icon",
							        "stylers": [
							            {
							                "saturation": "-100"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.attraction",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.business",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.government",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.medical",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.park",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.park",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "color": "#dedede"
							            },
							            {
							                "lightness": 21
							            }
							        ]
							    },
							    {
							        "featureType": "poi.place_of_worship",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.school",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.school",
							        "elementType": "geometry.stroke",
							        "stylers": [
							            {
							                "lightness": "-61"
							            },
							            {
							                "gamma": "0.00"
							            },
							            {
							                "visibility": "off"
							            }
							        ]
							    },
							    {
							        "featureType": "poi.sports_complex",
							        "elementType": "all",
							        "stylers": [
							            {
							                "visibility": "on"
							            }
							        ]
							    },
							    {
							        "featureType": "road.highway",
							        "elementType": "geometry.fill",
							        "stylers": [
							            {
							                "color": "#ffffff"
							            },
							            {
							                "lightness": 17
							            }
							        ]
							    },
							    {
							        "featureType": "road.highway",
							        "elementType": "geometry.stroke",
							        "stylers": [
							            {
							                "color": "#ffffff"
							            },
							            {
							                "lightness": 29
							            },
							            {
							                "weight": 0.2
							            }
							        ]
							    },
							    {
							        "featureType": "road.arterial",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "color": "#ffffff"
							            },
							            {
							                "lightness": 18
							            }
							        ]
							    },
							    {
							        "featureType": "road.local",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "color": "#ffffff"
							            },
							            {
							                "lightness": 16
							            }
							        ]
							    },
							    {
							        "featureType": "transit",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "color": "#f2f2f2"
							            },
							            {
							                "lightness": 19
							            }
							        ]
							    },
							    {
							        "featureType": "water",
							        "elementType": "geometry",
							        "stylers": [
							            {
							                "color": "#dadada"
							            },
							            {
							                "lightness": 17
							            }
							        ]
							    }
							]';

				default:

					break;
			}
			$gmap .= '};
		var ' . $id . ' = new google.maps.Map(document.getElementById("basr_' . $id . '"), myOptions);';
			//traffic
			if ( $traffic == 'true' ) {
				$gmap .= '
			var trafficLayer = new google.maps.TrafficLayer();
			trafficLayer.setMap(' . $id . ');
			';
			}
			//address
			if ( !empty( $address ) ) {
				$gmap .= 'var geocoder_' . $id . ' = new google.maps.Geocoder();
			var address = \'' . $address . '\';
			geocoder_' . $id . '.geocode( { \'address\': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					' . $id . '.setCenter(results[0].geometry.location);';

				if ( $marker == 'true' ) {
					//add custom image
					if ( !empty( $markerimage ) && is_numeric( $markerimage ) ){
						$gmap .= 'var image = "'. wp_get_attachment_url( $markerimage ) .'";';
					}elseif( !empty( $markerimage ) ){
						$gmap .= 'var image = "'. $markerimage .'";';
					}
					$gmap .= '
						var marker = new google.maps.Marker({
							map: ' . $id . ',
							';
					if ( !empty( $markerimage ) ) {
						$gmap .= 'icon: image,';
					}
					$gmap .= 'position: ' . $id . '.getCenter()});';
					//infowindow
					if ( !empty( $infowindow ) ) {
						//first convert and decode html chars

						$thiscontent = ( $infowindow );

						$gmap .= '
							var contentString = \'' . $thiscontent . '\';
							var infowindow = new google.maps.InfoWindow({
								content: contentString
							});
							google.maps.event.addListener(marker, \'click\', function() {
							  infowindow.open(' . $id . ',marker);});';
						//infowindow default
						if ( $infowindowdefault == 'true' ) {
							$gmap .= '
									infowindow.open(' . $id . ',marker);
								';
						}
					}
				}
				$gmap .= '} else {
				alert("Geocode was not successful for the following reason: " + status);
			}
			});
			';
			}

			if ( !empty( $str_arr_markers ) ) {
				if ( !empty( $markerimage ) ){
					$gmap .= 'var image = "'. wp_get_attachment_url( $markerimage ) .'";';
				}

				$gmap .= 'var bounds = new google.maps.LatLngBounds();';
				$gmap .= 'var infowindow = new google.maps.InfoWindow();';
				$gmap .=
					'var locations = [];
			for(var i = 0; i < markers.length; i++ ) {
		        position = new google.maps.LatLng( markers[i][1], markers[i][2]);
		        marker = new google.maps.Marker({
		            position: position,
		            map: ' . $id . ',';
				if ( !empty( $markerimage ) ) $gmap .= 'icon: image,';
				$gmap.= 'animation: google.maps.Animation.DROP,
		            title: markers[i][0],
		        });
		        locations.push(markers);
		        bounds.extend(marker.getPosition());
		        google.maps.event.addListener(marker, \'click\', (function(marker, i) {
			        return function() {
			          infowindow.setContent(markers[i][0]);
			          infowindow.open(' . $id . ', marker);
			        }
			    })(marker, i));4
		    }
		    var link_btn = "' . 'loc_' . $id . '";
		    	google.maps.event.addDomListener(document.getElementById( link_btn ), \'click\', function(e) {
		    		var loc = $(this).attr("data-link");
		    		var latlong = new google.maps.LatLng(markers[loc][1], markers[loc][2]);
			        ' . $id . '.setCenter( latlong );
			        var listener = google.maps.event.addListener('.$id.', "idle", function() { 
					  if ('.$id.'.getZoom() < '.$z.') '.$id.'.setZoom('.$z.'); 
					  google.maps.event.removeListener(listener); 
					});
					return false;
			    });
		    ';
				$gmap .= $id . '.fitBounds(bounds);
		    google.maps.event.addDomListener(document.getElementById( link_btn ), \'click\', function(e) {
	    		var loc = $(this).attr("data-link");
	    		if ( loc >= markers.length ) '.$id . '.fitBounds(bounds);
		    });
		    ';
			}
			//marker: show if address is not specified


			$gmap .= '});})(jQuery);';

			wp_add_inline_script('basr-google-map', $gmap);
			}
		}
		
	}

	// map shortcode to vc

	public function vc_map_shortcode() {
		vc_map( array(
						'base' 				=> $this->base,
						'name' 				=> esc_html__( 'Google Map', 'basr-core' ),
						'class' 			=> '',
						'category' 			=> $this->cat,
						'icon' 				=> $this->icon,
						'params' 			=> array(
							array(
								'param_name'       => $this->base . '_id',
								'map'          => esc_html__( 'ID', 'basr-core' ),
								'type'             => 'textfield',
								'value'            =>  0,
								'edit_field_class' => 'hidden',
							),
							array(
								'param_name'  => 'z',
								'heading'     => esc_html__( 'Zoom Level', 'basr-core' ),
								'description' => esc_html__( 'Between 0-20', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name' => 'input_type',
								'heading' 	 => esc_html__( 'Map Type', 'basr-core' ),
								'type' 		 => 'dropdown',
								'value'      => array(
									esc_html__( 'Latitude & Longitude', 'basr-core' )   => 'latlong',
									esc_html__( 'Address', 'basr-core' ) 				 => 'address',
								),
							),
							array(
								'param_name'  => 'lat',
								'heading'     => esc_html__( 'Latitude', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency' => array(
									'element' => 'input_type',
									'value'   => array( 'latlong' ),
								),
							),
							array(
								'param_name'  => 'lon',
								'heading'     => esc_html__( 'Longitude', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency' => array(
									'element' => 'input_type',
									'value'   => array( 'latlong' ),
								),
							),
							array(
								'param_name'  => 'address',
								'heading'     => esc_html__( 'Address', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency' => array(
									'element' => 'input_type',
									'value'   => array( 'address' ),
								),
							),
							array(
								'param_name' => 'map_size',
								'heading' 	 => esc_html__( 'Map Size', 'basr-core' ),
								'type' 		 => 'dropdown',
								'value'      => array(
									esc_html__( 'Fit parent', 'basr-core' )   => 'absolute',
									esc_html__( 'Custom', 'basr-core' ) 		 => 'custom',
								),
							),
							array(
								'param_name'  => 'w',
								'heading'     => esc_html__( 'Width', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency'  => array(
									'element'	=> 'map_size',
									'value'		=> 'custom'
									)
							),
							array(
								'param_name'  => 'h',
								'heading'     => esc_html__( 'Height', 'basr-core' ),
								'description' => esc_html__( 'Numeric value only, Unit is Pixel.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div',
								'dependency'  => array(
									'element'	=> 'map_size',
									'value'		=> 'custom'
									)
							),
							array(
								'param_name' => 'marker',
								'heading' 	 => esc_html__( 'Marker', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								),
							),
							array(
								'param_name'  => 'markerimage',
								'heading'     => esc_html__( 'Marker Image', 'basr-core' ),
								'description' => esc_html__( 'Change default Marker.', 'basr-core' ),
								'type'        => 'attach_image',
								'holder'      => 'div',
								'dependency' => array(
									'element' => 'marker',
									'value'   => array( 'true' ),
								),
							),
							array(
								'param_name' => 'traffic',
								'heading' 	 => esc_html__( 'Show Traffic', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								)
							),
							array(
								'param_name' => 'draggable',
								'heading' 	 => esc_html__( 'Draggable', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								)
							),
							array(
								'param_name' => 'infowindowdefault',
								'heading' 	 => esc_html__( 'Show Info Map', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								)
							),
							array(
								'param_name'  => 'infowindow',
								'heading'     => esc_html__( 'Content Info Map', 'basr-core' ),
								'description' => esc_html__( 'Strong, br are accepted.', 'basr-core' ),
								'type'        => 'textfield',
								'holder'      => 'div'
							),
							array(
								'param_name' => 'hidecontrols',
								'heading' 	 => esc_html__( 'Show Control', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								)
							),
							array(
								'param_name' => 'scrollwheel',
								'heading' 	 => esc_html__( 'Scroll wheel zooming', 'basr-core' ),
								'type' 		 => 'checkbox',
								'value'      => array(
									'' => 'true'
								)
							),
							array(
								'param_name' => 'maptype',
								'heading' 	 => esc_html__( 'Map Type', 'basr-core' ),
								'type' 		 => 'dropdown',
								'value'      => array(
									esc_html__( 'ROADMAP', 'basr-core' )   => 'ROADMAP',
									esc_html__( 'SATELLITE', 'basr-core' ) => 'SATELLITE',
									esc_html__( 'HYBRID', 'basr-core' )    => 'HYBRID',
									esc_html__( 'TERRAIN', 'basr-core' )   => 'TERRAIN'
								),
							),
							array(
								'param_name' => 'mapstype',
								'heading' 	 => esc_html__( 'Map style', 'basr-core' ),
								'type' 		 => 'dropdown',
								'value'      => array(
									esc_html__( 'None', 'basr-core' )   => '',
									esc_html__( 'Subtle Grayscale', 'basr-core' )   => 'grayscale',
									esc_html__( 'Blue water', 'basr-core' ) => 'blue_water',
									esc_html__( 'Pale Dawn', 'basr-core' ) => 'pale_dawn',
									esc_html__( 'Shades of Grey', 'basr-core' ) => 'shades_of_grey',
									esc_html__( 'basr-core', 'basr-core' ) => 'basr-core',
								),
							),
							array(
								'param_name'  => 'color',
								'heading'     => esc_html__( 'Background Color', 'basr-core' ),
								'type'        => 'colorpicker',
							),

							toolkit_basr_vcf_class(),

							toolkit_basr_vcf_animate(0),

							toolkit_basr_vcf_animate(1),

							toolkit_basr_vcf_animate(2),

							// More fields here 

						),
					) 
				);
	}

	// Render html

	public function generate_html( $atts, $content = null ) {

		$sc_atts =  array( 
						$this->base . '_id' 				=> ''				,
						'lat'               => '0',
						'geo_title'			=> '',
						'geo'               => '',
						'lon'               => '0',
						'id'                => '',
						'z'                 => '1',
						'map_size'			=> 'absolute',
						'w'                 => '600',
						'h'                 => '400',
						'maptype'           => 'ROADMAP',
						'mapstype'			=> '',
						'address'           => '',
						'marker'            => 'no',
						'markerimage'       => '',
						'traffic'           => 'no',
						'draggable'         => 'false',
						'infowindow'        => '',
						'infowindowdefault' => 'yes',
						'hidecontrols'      => 'false',
						'scrollwheel'       => 'false',
						'color'             => '',
						'popup'				=> '',
						'arr_title' 		=> array(),
						'classes'							=> ''				,
						'anm'								=> ''				,
						'anm_name'							=> ''				,
						'anm_delay'							=> '1000'			,
					);

		extract( shortcode_atts( $sc_atts, $atts ) );

		// enqueue

		$this->enqueue_script( array( 'sc_atts' => $sc_atts, 'atts' => $atts, 'id' => ${$this->base . '_id'} ) );

		// get id 
		
		$id = ${$this->base . '_id'};

		//var_dump(get_query_var('lucy_map'));
		// get class

		$classes .= $this->get_class( '' ); // pass id setting if need vc custome css class

		// set up shortcode here
		// get multi geo title to array

		if ( !empty( $geo_title ) ) :
			$arr_title = explode(';', $geo_title);
		endif;

		for  ( $i = 0; $i < count( $arr_title ); $i++ ) {
			$arr_title[ $i ] = '"' . $arr_title[ $i ] . '"';
		}

		if ( !empty( $geo ) ) :

			// extract String geo to array;

			$arr_geo = explode(	';', $geo );

			foreach ($arr_geo as $key => $value) {
				$arr_geo[$key] = explode( ',', $value );
			}

			// move geo title , geo to one array

			for( $i = 0; $i < count($arr_geo); $i++) {
				if ( isset( $arr_title[$i] ) ) :
					array_unshift( $arr_geo[ $i ], $arr_title[$i] );
				else:
					array_unshift( $arr_geo[ $i ], '\'' . 'Marker' . '\'' );
				endif;
			}

			// creat string array pass to js
			// creat list of location

			$list = '<ul class="map-locations">';
			$map_select = '<div class="wrap-map-select"><select class="map-select">';
			$str_arr_markers = '[';
			$i = 0;
			foreach ($arr_geo as $k => $geo_v) {
				$list 		 	 .= '<li><a href="' . '#' . '"' . ' id="loc_' . $id . '_' . $i . '" data-link="' . $i .'">';
				$map_select  	 .= '<option value="' . $i .'">';
				$str_arr_markers .= '[';
				$j = 0;
				foreach ($geo_v as $key => $value) {
					if ( $j == 0 ) $list 		.= trim(rtrim($value, '"'), '"');
					if ( $j == 0 ) $map_select  .= trim(rtrim($value, '"'), '"');

					$str_arr_markers .= $value . ',';
					$j++;
				}
				if ( $i == count( $arr_geo ) - 1 )
					$str_arr_markers .= ']';
				else
					$str_arr_markers .= '],';
				$list 		.= '</a></li>';
				$map_select .= '</option>';
				$i++;
			};
			$list .= '<li><a href="' . '#' . '"' . ' id="loc_' . $id . '_' . $i . '" data-link="' . $i .'">Zoom Out </a></li></ul>';
			$map_select .= '<option value="' . $i .'">Zoom Out</option></select><i class="zmdi zmdi-chevron-down"></i></div>';

			$str_arr_markers .= ']';

			$popup = '<div class="map-pop-up">' . do_shortcode( $content ) . $map_select .
			         '<a id="loc_' . $id . '" class="basr-btn map-btn" data-link="0">' . esc_html__( 'Go', 'basr-core') . '</a>' .
			         '<a class="open-btn"><i class="zmdi zmdi-search"></i></a>' .
			         '</div>';

			$popup = shortcode_unautop( $popup );

		endif;

		$w = is_numeric( $w ) ? 'width:'. $w .'px;' : 'width:'. $w .';';

		$h = is_numeric( $h ) ? 'height:'. $h .'px;' : 'height:'. $h .';';


		// Start out put

		$output = '<div class="basr-wrap-map ' . $map_size . '">' . $popup . '<div class="basr-map ' . $classes . '" id="basr_' . $id . '" style="' . $w . $h . '"' . $this->animation_data( $sc_atts ) . ' data-id="' . $id .'"></div></div>';

		// filter 

		$output = apply_filters( 'basr_{$this->base}_filter', $output );

		return $output;
	}

	// Render custom css

	public function generate_shortcode_css ( $atts ) {

		extract( shortcode_atts( array(
			$this->base . '_id' 				=> ''			,
			'font_size' 						=> ''			,
			'color'								=> ''			,
			'color_hover'						=> ''			,
			'classes'							=> ''			,
			// atts here

		), $atts ) );

		$id = '#' . ${ $this->base . '_id' };

		$css = '';

		if ( $font_size ) {
			$css .= $id . ' .h { font-size:' . intval( $font_size ) . 'px;}';
		}
		if ( $color ) {
			$css .= $id . ' .h { color:' . $color . ';}';
		}
		if ( $color_hover) {
			if ( $color ) {
				$css .= $id . ' .h a { color:' . $color . ';}';
			}
			$css .= $id . ' .h a:hover { color: ' . $color_hover . '}';
		}

		return $css;
	}

}
