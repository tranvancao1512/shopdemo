<?php 

add_action( 'wp_ajax_basr_core_fn_load_template'       , 'basr_core_fn_load_template' );
add_action( 'wp_ajax_nopriv_basr_core_fn_load_template', 'basr_core_fn_load_template' );

function basr_core_fn_load_template() {

	$user = new Tee_user();

	$template_ids = $_POST['template_ids'];

	$post_type    = $_POST['dataType'];

	$template_ids = json_decode( str_replace('\\', '', $template_ids ) );

	$template_source 	  = call_user_func( 'basr_core_template_' . str_replace( '-', '_', $post_type ) );
	$template_source_name = call_user_func( 'basr_core_template_name_' . str_replace( '-', '_', $post_type ) );

	$html = '<div class="list-template-loaded"></br><p style="color: red;">Templates Created, Click Link below to Edit:</p></br>';

	foreach ( $template_ids as $key => $id ) :

		$insert_id = wp_insert_post( array(
			'post_type'    => $post_type,
			'post_content' => isset( $template_source[$id]['content'] ) ? $template_source[$id]['content']  : '',
			'post_title'   => isset( $template_source[$id]['title'] ) ? $template_source[$id]['title'] . ' ' . strtoupper( $user->obj->data->user_login ) : '',
			'post_status'  => 'publish',
		) );

		// Insert necessary post meta after insert page success 

		if ( $insert_id ) :

			foreach ( $template_source[$id] as $key => $options ) :

				if ( $key == '_wpb_post_custom_css' ) {
					add_post_meta( $insert_id, '_wpb_post_custom_css', $options, true );
				}
				if ( $key == '_wpb_shortcodes_custom_css' ) {
					add_post_meta( $insert_id, '_wpb_shortcodes_custom_css', $options, true );
				}
				if ( $key == 'basr_custom_css' ) {
					foreach( $options as $shortcode => $css ) {
						update_post_meta( $insert_id, $shortcode, $css, true );
					}
				}
				if ( $key == 'fw_options' && $post_type != 'header_builder' ) {
					$fw_options = (array) json_decode( $options );
					$fw_options = basr_core_conver_object_to_array( $fw_options );
					add_post_meta( $insert_id, 'fw_options', $fw_options, true );
				} else if ( $key == 'fw_options' ) {
					$data = array();
					$data['header-builder'] = array();
					$data['header-builder']['json'] = $options['json'];
					foreach ($options as $k => $value) {
						if ( $k != 'json' ) {
							$data[$k] = $value;
						}
					}
					fw_set_db_post_option( $insert_id, '', $data );
				}

				// for page_template

				if ( $key == 'page_template' ) {
					update_post_meta( $insert_id,'_wp_page_template', $options );
				}

			endforeach;

			$html .= '<a = href="' . get_edit_post_link( $insert_id, '&' ) . '">' . $template_source_name[ $id ] . '</a></br>';
		endif;

	endforeach;

	$html .= '</div>';

	echo $html;

	die();

};

function basr_core_conver_object_to_array( $array ) {

	foreach ($array as $key => $value) {

		if ( is_object( $array[ $key ] ) ) {
			$array[ $key ] = (array) $value ;
		}
		if ( is_array( $array[ $key ] ) ) {
			$array[ $key ] = basr_core_conver_object_to_array( $array[ $key ] );
		} 
	}

	return $array;
}

function basr_core_connect_fs($url, $method, $context, $fields = null) {
  global $wp_filesystem;
  if(false === ($credentials = request_filesystem_credentials($url, $method, false, $context, $fields))) 
  {
    return false;
  }

  //check if credentials are correct or not.
  if(!WP_Filesystem($credentials)) 
  {
    request_filesystem_credentials($url, $method, true, $context);
    return false;
  }

  return true;
}

function basr_core_write_file( $text ) {
	global $wp_filesystem;

	$url = wp_nonce_url("admin.php?page=fw-settings", "filesystem-nonce");

	$creds = request_filesystem_credentials( 
		$url,
		'',
		false,
		false,
		false,
		null,
		false
	);

	$form_fields = array("file-data");

	if( basr_core_connect_fs( $url, "", BASR_CORE_PLUGIN_PATH . "unyson-options/load-vc-template", $form_fields) ) {
		$dir  = $wp_filesystem->find_folder( BASR_CORE_PLUGIN_PATH . "unyson-options/load-vc-template");
		$file = trailingslashit($dir) . "data-template.php";
	    $wp_filesystem->put_contents( $file, $text, FS_CHMOD_FILE) ;
	}
} 

add_action( 'wp_ajax_basr_core_export_data_template'       , 'basr_core_export_data_template' );
add_action( 'wp_ajax_nopriv_basr_core_export_data_template', 'basr_core_export_data_template' );

function basr_core_export_data_template() {

	global $shortcode_tags;
	$template   = str_replace( '-', '_', get_option( 'template' ) );
	$basr_shortcode_tags  = array();

	foreach ( $shortcode_tags as $key => $shortcode ) {
		if ( preg_match( '/' . $template . '/', $key ) ) {
			$basr_shortcode_tags[] = $key;
		}
	}

	$post_type_arr = array( 'page', 'header_builder', 'footer_builder', 'product_template' );

	$output  = "<?php \n";

	$users = get_users();

	$users_reg = '';

	foreach ($users as $key => $u ) {
		$users_reg = $users_reg ? $users_reg . '|' . $u->data->user_login : $u->data->user_login;
	}

	$users_reg = '(' . $users_reg . ')';

	foreach ( $post_type_arr as $post_type ) : 

		$args = array(
			'post_type'      => $post_type,
			'posts_per_page' => '-1',
			'post_status'	 => 'publish',
		);

		if ( $post_type == 'product_template' ) {
			$args['author_name'] = 'admin';
		}

		$query = new WP_Query( $args );

		
		$output .= "function basr_core_template_" . str_replace( '-', '_', $post_type ) . "(){\n";
		$output .= "\treturn\n";

		$data_template      = "array(\n";
		$data_template_name = "return array(\n";

		while ( $query->have_posts() ) : $query->the_post();

			if ( $post_type == 'product_template' ) {
				if ( preg_match( '/^\s*' . $users_reg . '/i' , get_the_title() ) ) {
					continue;
				}
			}

			$content = get_the_content();

			$content = preg_replace_callback( '/(<|>)/', function( $matches ){
				return htmlspecialchars( $matches[1] );
			}, $content );

			$title = preg_replace( '/[\']{1,1}/', '\\', get_the_title() );
			$title = preg_replace_callback( '/(<|>)/', function( $matches ){
				return htmlspecialchars( $matches[1] );
			}, $title );

			if ( $title ) {
				$data_template_name .= "\t\t'" . get_the_id() . "' => '" . $title . "',\n";
			}
			
			if ( true ) {
				if ( ! $content && false ) continue;
				$data_template .= "'" . get_the_id() . "' => array(\n";

						$data_template .= "\t\t'" . 'title' . "' => '" . $title . "',\n";

					if (  get_post_meta( get_the_id(), '_wpb_post_custom_css', true ) ) {
						$data_template .= "'" . '_wpb_post_custom_css' . "' => " . "'" .  get_post_meta( get_the_id(), '_wpb_post_custom_css', true ) . "',\n";
					}

					if ( get_post_meta( get_the_id(), '_wpb_shortcodes_custom_css', true ) ) {
						$data_template .= "\t\t'" . '_wpb_shortcodes_custom_css' . "' => " . "'" .  get_post_meta( get_the_id(), '_wpb_shortcodes_custom_css', true ) . "',\n";
					}

					if ( $content ) {
						$content = preg_replace('/[\']{1,1}/', "\\'", $content);
						$data_template .= "\t\t'" . 'content' . "' => " . "'" . htmlspecialchars_decode( $content ) . "',\n";
					}

					$data_template .= "\t\t'basr_custom_css' => array(\n";
					foreach ( $basr_shortcode_tags as $key => $shortcode ) {
						if ( get_post_meta( get_the_id(), '_' . $shortcode . '_custom_css', true ) ) {
							$data_template .= "'" . '_' . $shortcode . '_custom_css' . "' => " . "'" .  get_post_meta( get_the_id(), '_' . $shortcode . '_custom_css' , true ) . "',\n";
						}
					}
					$data_template .= "),\n";

					if ( get_post_meta( get_the_id(), 'fw_options', true ) && $post_type != 'header_builder' ) {
						$data_template .= "\t\t'" . 'fw_options' . "' => '" .  json_encode( get_post_meta( get_the_id(), 'fw_options', true ) ) . "',\n";
					} else if ( $post_type == 'header_builder' ) {
						$data = get_post_meta( get_the_id(), 'fw_options' );
						$data_template .= "'" . 'fw_options' . "' => array ( " . "\n" .
										  "'" . 'json' . "' => '" . $data[0]['header-builder']['json'] . "',\n";
						foreach ($data[0] as $key => $value) {
							if ( $key == 'header-builder' ) continue;
							$data_template .= "'" . $key . "' => '" . $value . "',\n";
						}

						$data_template .= "),\n";
					}

					// for page_template

					if ( $post_type == 'page' && get_post_meta( get_the_id(), '_wp_page_template', true ) ) {
						$data_template .= "\t\t'" . 'page_template' . "' => '" . get_post_meta( get_the_id(), '_wp_page_template', true ) . "',\n";
					}

				$data_template .= "),\n";
			}
		endwhile;

		$data_template .= ");\n";
		$data_template_name .= ");\n";

		$output .= $data_template;
		$output .= "\n}\n\n";

		$output .= "function basr_core_template_name_" . str_replace('-', '_', $post_type) . "() {\n"; 
		$output .= $data_template_name;
		$output .= "\n}\n\n";

	endforeach;

	wp_reset_postdata();

	basr_core_write_file( $output );

	die();
}

