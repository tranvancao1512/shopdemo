<?php
/**
 * Template Name: Shopify Backup All
 * Template Post Type: post, page, event
 */
get_header(); ?>

	<?php 
	?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main teea-mu" role="main">

			<?php
				$user = wp_get_current_user();
				if ( ! ( get_current_user_id() == 1 || in_array( 'shop_manager', $user->roles ) ) ) return;
				$store = '';
				if ( isset( $_POST['store'] ) ) {
					$store = $_POST['store'];
				}
				if ( isset( $_GET['store'] ) ) {
					$store = $_GET['store'];
				}
				$end_at = 0;
				if ( isset( $_GET['end_at'] ) ) {
					$end_at = $_GET['end_at'];
				}

				$apis = origin_get_setting('s_backup_store');

				$d4f = new S_Collection( $apis[2]['api-link'] );

				$d4f->ba_products_by_collection_id();

				return;

				$html = '<form action="" method="POST">';

				$html .= '<label style="display: block;margin-bottom: 20px"> Select Store to backup : </label>';

				$html .= '<select name="store" class="" style="min-width: 120px;margin-right: 20px;">';

				foreach( $apis as $key => $value ) {
					preg_match_all( '/@[^\.]*/', $value['api-link'], $stores );
					$stores = str_replace( '@', '', $stores[0][0] );
					$html .= '<option value="' . $stores . '" ' . selected( $stores, $store, false )  .  ' >';
					$html .= $stores;
					$html .= '</option>';

					if ( isset( $store ) && $store == $stores ) {
						$api_link = $value['api-link'];
					}
				}

				$html .= '</select>';

				$html .= '<button type="submit">Backup</button>';

				$html .= '</form>';

				echo $html;

				$link = '';

				if ( isset( $api_link ) && $api_link ) {
					echo '<p> Please wait, Processing!</p>';
					fw_print( 'Backup Products!' );
					$P = new S_Product();
					$page = isset( $_GET['l_page'] ) ? $_GET['l_page'] : 1;
					$action = isset( $_GET['action'] ) ? $_GET['action'] : 'get_product';
					if ( $action == 'get_product' ) {
						fw_print( 'Backup Products' );
						$last = $P->backup_products( $api_link, $page );
						unset( $P ); 
						if ( $end_at && $last >= $end_at ) {
							fw_print('Force Stop');
							return;
						}
						if ( $last === true ) {
							$action = 'get_orders';
							$page = 1;
						}
						fw_print('last:' . $last );
					}
					
					if ( $action == 'get_orders' ) {
						fw_print( 'Backup Orders' );
						$O = new S_Order();
						$last = $O->backup_orders( $api_link, $page );
						unset( $O );
						if ( $last === true ) {
							$action = 'orders_done';
							$page = 1;
						}
						fw_print('last:' . $last );
						if ( $end_at && $last >= $end_at ) {
							fw_print('Force Stop');
							return;
						}
					}
					

					if ( $action == 'get_collections' ) {
						fw_print( 'Backup Collections!' );
						$C = new S_Collection( $api_link );
						$C->backup_collections();
						unset( $C );
						$action = 'done';
						if ( $end_at && $last >= $end_at ) {
							fw_print('Force Stop');
							return;
						}
					}

					
					$link         = get_permalink( get_the_ID() );

					if ( $action == 'orders_done' ) {
						$action = 'get_collections';
						$last = 1;
					}

					$link = add_query_arg( 'store', $store, $link );
					$link = add_query_arg( 'action', $action, $link );

					switch ($action) {
						case 'get_product':
							$link = add_query_arg( 'l_page', $last, $link );
							break;
						case 'get_orders':
							$link = add_query_arg( 'l_page', $last, $link );
							break;
						case 'get_collections':
							$link = add_query_arg( 'l_page', $last, $link );
							break;
						default:
							$link = true;
							break;
					}
				}


				if ( $link === true ) {
					echo 'Done!';
				} else {
					echo '<div class="loop-link" data-link="' . $link . '" ></div>';
				}
			?>
				<div id="ajax-status"></div>
				<div id="status"></div>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

<?php get_footer();
