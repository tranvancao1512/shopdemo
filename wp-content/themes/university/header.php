<?php
/**
 * The Header for our theme.
 *
 *
 * @package University
 */
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale = 1.0, maximum-scale=2.0, user-scalable=yes" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="container">
		<div id="outerwrapper">

			<div id="header">
  				<div id="logo">
                	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    					<?php if (get_theme_mod( 'logo_img' )) : ?>
    						<img src="<?php echo esc_url (get_theme_mod( 'logo_img')); ?>">
    					<?php else : ?>
    						<h1 class="site-title">
      							<?php bloginfo('name'); ?>
    						</h1>
    					<?php endif; ?>
    				</a>

    				<div id="site-description"><?php bloginfo( 'description' ); ?></div> 
    			</div>
			</div>


			<div id="wrapper">
				<div id="inwrapper">

					<?php if ( has_nav_menu( 'primary' ) ) {
    					wp_nav_menu( 
							array( 
								'theme_location' => 'primary', 
								'container_id'   => 'mainmenu',
								'menu_id'		 =>	'nav',
								'menu_class' 	 => 'sf-menu superfish',
								'fallback_cb'	 => false
							) 
						);
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container_class'   => 'mmenu',
								'menu_class' 	 => 'navmenu',
								'fallback_cb'	 => false
							)
						);
  					} ?>

					<?php if (is_front_page()) : ?>
						<?php
   							$args = array(
   								'posts_per_page' =>-1,
								'post_type' => 'any',
	  							'post__not_in' => get_option( 'sticky_posts' ),
      							'meta_query' => array(
         											array(
            											'key' => '_university-slider-checkbox',
            											'value' => 'yes'
         									)
      									)
   									);
  							$slider_posts = new WP_Query($args);
						?>

    					<?php if($slider_posts->have_posts()) : ?>
    						<div id="slidecontainer">
  								<div class="camera_wrap" id="camera_wrap_1">
    							<?php while($slider_posts->have_posts()) : $slider_posts->the_post() ?>
    								<div data-thumb="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'university-slidethumb' ); ?><?php echo $image[0]; ?>" data-src="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'university-slideimage' ); ?><?php echo $image[0]; ?>" data-link="
									<?php if(get_post_meta($post->ID, 'slidelink', true)): ?>
										<?php echo get_post_meta($post->ID, 'slidelink', true); ?> 
        							<?php else : ?>
										<?php the_permalink(); ?>
                                    <?php endif; ?>">

                        			<div class="fadeIn camera_effected">
        								<?php if(get_post_meta($post->ID, 'slidetitle', true)): ?>
        									<?php echo get_post_meta($post->ID, 'slidetitle', true); ?>
        								<?php else : ?>
        									<?php the_title(); ?>
        								<?php endif; ?>
      								</div>
    								</div>
    						<?php endwhile ?>
    						<?php wp_reset_postdata(); ?>
    						</div>
						</div>
    				<?php endif ?>

			<?php
   				$args = array(
   							'posts_per_page' =>-1,
							'post_type' => 'any',
	  						'post__not_in' => get_option( 'sticky_posts' ),
      						'meta_query' => array(
         					array(
            					'key' => '_university-services-checkbox',
            					'value' => 'yes'
         						)
      							)
   							);
  				$services_posts = new WP_Query($args);
			?>

  			<?php if($services_posts->have_posts()) : ?>
  				<div id="services">
  					<?php while($services_posts->have_posts()) : $services_posts->the_post() ?>
  						<div class="servicespost">
    						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark">
      							<?php the_title(); ?>
      						</a></h2>
    
    						<a href="<?php the_permalink(); ?>">
    							<?php the_post_thumbnail('university-servicethumb'); ?>
    						</a>

							<?php the_excerpt(); ?>
    						<div class="belowpost"><a class="more-link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'university' ); ?></a></div>
  						</div>
  					<?php endwhile ?>
  					<?php wp_reset_postdata(); ?>
  				</div>
  			<?php endif ?>
	<?php endif; ?>
