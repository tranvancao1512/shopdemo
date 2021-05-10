<?php
/**
 * Template Name: Shopify Backup Manager Order
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

				$S = new S_Order();

				$html = $S->manager_order_bar_html();

				echo '<h4> Search Bar</h4>';
				echo $html;
				echo '<div class="sb-search-result"></div>';
			?>
				<div id="ajax-status"></div>
				<div id="status"></div>

		</main><!-- #main -->
	</div><!-- #primary -->
	
	<?php get_sidebar(); ?>

<?php get_footer();
