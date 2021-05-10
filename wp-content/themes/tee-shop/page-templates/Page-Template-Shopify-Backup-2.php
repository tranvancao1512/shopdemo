<?php
/**
 * Template Name: Teeallover Backup 2
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

				$apis = origin_get_setting('s_backup_store');
				$api = '';

				$store = isset( $_POST['store'] ) ? $_POST['store'] : '';

				$current_store = isset( $_POST['current_store'] ) ? $_POST['current_store'] : '';

				if( $current_store && $store && $current_store != $store ) {
					$_POST['collection_id'] = '';
					$_POST['backup_order'] = '';
				}

				$html = '<form action="" method="POST">';

				$html .= '<label style="display: block;margin-bottom: 20px"> Select Store to backup : </label>';

				$html .= '<input type="hidden" name="current_store" value="' . $store . '">';

				$html .= '<select name="store" class="" style="min-width: 120px;margin-right: 20px;">';

				$html .= '<option value="">Please select</option>';

				foreach( $apis as $key => $value ) {
					preg_match_all( '/@[^\.]*/', $value['api-link'], $stores );
					$stores = str_replace( '@', '', $stores[0][0] );
					if(  selected( $stores, $store, false ) ) {
						$api  = $value['api-link'];
					}
					$html .= '<option value="' . $stores . '" ' . selected( $stores, $store, false )  .  ' >';
					$html .= $stores;
					$html .= '</option>';
				}

				$html .= '</select>';

				if( $store ) {
					$C = new S_Collection( $api );
					$list = $C->get_list_collect();
					$collection_id = isset( $_POST['collection_id'] ) ? $_POST['collection_id'] : '';
					if( $collection_id ) {
						fw_print( 'Backup Collection' );
						$C->backup_collections( $collection_id );
					}
					if( isset( $_POST['backup_order'] ) && $_POST['backup_order']  ) {
						fw_print( 'Backup Order' );
						$O = new S_Order( $api );
						$O->backup_orders( $api );
					}
					$html .= '<p> Select Collection to backup </p>';
					$html .= '<select name="collection_id">';
						$html .= '<option value="' . '' . '" ' . '' .  ' >';
						$html .= 'Please Select Collection';
						$html .= '</option>';
						foreach( $list as $id => $title ) {
							$html .= '<option value="' . $id . '" ' . '' .  ' >';
							$html .= $title;
							$html .= '</option>';
						}
					$html .= '</select>';

					$html .= '<p> Backup orders ? </p>';
					$html .= '<select name="backup_order">';
						$html .= '<option value="' . '' . '" ' . '' .  ' >';
						$html .= 'No';
						$html .= '</option>';
						$html .= '<option value="' . 'yes' . '" ' . '' .  ' >';
						$html .= 'Yes';
						$html .= '</option>';
					$html .= '</select>';
				}

				$html .= '<button type="submit" style="margin-left: 30px;">select</button>';

				$html .= '</form>';

				echo $html;

				$link = '';
			?>
				<div id="ajax-status"></div>
				<div id="status"></div>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

<?php get_footer();
