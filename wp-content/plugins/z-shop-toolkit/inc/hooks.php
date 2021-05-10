<?php

add_action( 'admin_menu', 'basr_core_theme_option_register_custom_menu_link', 20 );

function basr_core_theme_option_register_custom_menu_link(){
	global $submenu;

    add_submenu_page(
        'basr-core-menu',
        esc_html__( 'ThemeOptions', 'basr-core' ),
        esc_html__( 'ThemeOptions', 'basr-core' ),
        'manage_options',
        'basr-core-theme-setting',
        'basr_core_theme_custom_menu_link'
    );

    add_submenu_page(
        'basr-core-menu',
        esc_html__( 'SwitchDB', 'basr-core' ),
        esc_html__( 'SwitchDB', 'basr-core' ),
        'manage_options',
        'basr-core-switchdb',
        'basr_core_switchdb'
    );
    
    $submenu['basr-core-menu'][2][2] = 'themes.php?page=fw-settings';
}

add_action( 'wp_ajax_shop_switch_product_db', 'shop_switch_product_db' );

function shop_switch_product_db() {

    if( get_current_user_id() != 1 ) wp_send_json_error();

    global $wpdb;

    $full_prefix = 'full_';

    $tables = [
        'postmeta',
        'posts',
        'termmeta',
        'terms',
        'term_relationships',
        'term_taxonomy',
        'wc_category_lookup',
        'wc_product_meta_lookup',
    ];

    $prefix = $wpdb->prefix;

    $temp = 'temp_';

    foreach( $tables as $k => $table ) {
        $rs = $wpdb->query( "RENAME TABLE $prefix$table TO $temp$table" );
        error_log( print_r( $rs, true ) );
        $rs = $wpdb->query( "RENAME TABLE $full_prefix$table TO $prefix$table" );
        error_log( print_r( $rs, true ) );
        $rs = $wpdb->query( "RENAME TABLE $temp$table TO $full_prefix$table" );
        error_log( print_r( $rs, true ) );
    }

    $type = get_post_meta( 456915, 'db_type', true );

    wp_send_json_success( [ 'type' => $type ] );
}

function basr_core_switchdb() {
    echo '<h1>Switch DB</h1>';
    echo '<button id="shop-db-switch">Switch</button>';    
    echo '<div>Current DB: <span  class="wrap-sw"> ' . ( get_post_meta( 456915, 'db_type', true ) == 'default' ? 'default DataBase' : 'GMC DataBase' )  .  ' </span></div>';   
    ?>
    <script>
        jQuery(function(){
            $ = jQuery;
            $("#shop-db-switch").on("click",function(){
                if( ! confirm( 'Are you sure?' ) ) return;
                $('body').css('opacity', 0.5);
                $.ajax({
                    type: 'POST',
                    url : ajaxurl,
                    data: {
                        action: 'shop_switch_product_db',
                    },
                    success: function( res ){
                        if( res.success ) {
                            $('.wrap-sw').empty().append('<h2>' +  ( res.data.type == 'default' ? 'default DataBase' : 'GMC DataBase') + '</h2>' );
                        } else {
                            alert('error');
                        }
                        $('body').css('opacity', 1);
                    },
                    error: function( e ) {
                        alert('false');
                        $('body').css('opacity', 1);
                        console.log( e );
                    }
                });
            });
        });
    </script>'
    <?php 
}

// HOOK REMOVE QUERY STRING

function _remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 100, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 100, 1 );


add_action( 'woocommerce_after_add_to_cart_button', 'tee_product_ct', 30 );

function tee_product_ct(){
    if( origin_get_setting( 'woo_single_timer' ) != 'yes') return;
	$date = date("Y-m-d");
	$rand = random_int( 2,5 );
	$date = strtotime( $date . "+ " . $rand . " days") ;
	echo do_shortcode('[origin_tee_ct date="' . date( "Y/m/d",$date ) . '"]');
}
