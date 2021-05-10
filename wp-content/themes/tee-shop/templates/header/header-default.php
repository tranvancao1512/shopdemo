<?php
/**
 * Default header template shiped with theme. This header will be used when header-buidler isn't activated.
 *
 * @package ln-moonlight
 * @since   1.0.0
 */

?>

<header id="masthead" class="site-header default-header" role="banner">
	<div class="container">
		<div class="logo">
			<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				                          rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else : ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				                         rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif; ?>
		</div>
		<!-- /.logo -->
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<button class="menu-toggle">
				<?php esc_html_e( 'Menu', 'origin' ); ?>
			</button>
			<!-- /.menu-toggle -->

			<nav id="primary-menu" class="main-menu" role="navigation"
			     aria-label="<?php esc_attr_e( 'Primary Menu', 'origin' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
				) );
				?>
			</nav>
			<!-- /#primary-menu.main-menu -->
		<?php endif; // has_nav_menu 'primary'. ?>
	</div>
	<!-- /.container -->
</header><!-- #masthead -->
