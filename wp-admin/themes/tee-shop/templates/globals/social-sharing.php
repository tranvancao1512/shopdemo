<?php
/**
 * The template for displaying social sharing
 *
 * This template can be overridden by childtheme
 *
 * @author Lunartheme
 * @package basrpo/template
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$share = array(
	'_facebook' 	=> 'yes',
	'_twitter' 		=> 'yes',
	'_google_plus' 	=> 'yes',
	'_linkedin' 	=> 'yes',
	'_tumblr' 		=> 'yes',
	'_email' 		=> 'yes',
);

if( defined('FW') ) {
	$share = origin_get_setting('social_share');
}

// classes 

$classes = 'social-sharing social';

$classes .= is_single() ? ' social-colorful' : '';

$classes = apply_filters( 'origin_social_sharing_class', $classes );

// social share

$twitter_username = origin_get_setting('social_twitter_username');

if($twitter_username) {
	$twitter_username = '&via=' . $twitter_username;
}

$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), false, '' );

$inline_js = ' onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600\');return false;"';
?>

<!-- social listing -->

<ul class="<?php echo esc_attr($classes); ?>">
	<?php
	if( $share['_facebook'] === 'yes' ) {
		printf(
			'<li class="facebook"><a href="http://www.facebook.com/sharer.php?u=%1$s" title="%3$s" %2$s><i class="ion-social-facebook"></i><span>%3$s</span></a></li>',
			urlencode(get_permalink()),
			$inline_js,
			esc_html__( 'Facebook', 'origin' )
		);
	}
	if( $share['_twitter'] === 'yes' ) {
		printf(
			'<li class="twitter"><a href="https://twitter.com/intent/tweet?url=%1$s%4$s" title="$3$s" %2$s><i class="ion-social-twitter"></i><span>%3$s</span></a></li>',
			urlencode(get_permalink()),
			$inline_js,
			esc_html__( 'Twitter', 'origin' ),
			$twitter_username
		);
	}
	if( $share['_google_plus'] === 'yes' ) {
		printf(
			'<li class="google-plus"><a href="https://plus.google.com/share?url=%1$s" title="$3$s" %2$s><i class="ion-social-googleplus"></i><span>%3$s</span></a></li>',
			urlencode(get_permalink()),
			$inline_js,
			esc_html__( 'Google Plus', 'origin' )
		);
	}
	if( $share['_linkedin'] === 'yes' ) {
		printf(
			'<li class="linkedin"><a href="http://www.linkedin.com/shareArticle?mini=true&url=%1$s&title=%4$s" title="$3$s" %2$s><i class="ion-social-linkedin"></i><span>%3$s</span></a></li>',
			urlencode(get_permalink()),
			$inline_js,
			esc_html__( 'LinkedIn', 'origin' ),
			urlencode(get_the_title())
		);
	}
	if( $share['_tumblr'] === 'yes' ) {
		printf(
			'<li class="tumblr"><a href="https://www.tumblr.com/share/link?url=%1$s&name=%4$s" title="$3$s" %2$s><i class="ion-social-tumblr"></i><span>%3$s</span></a></li>',
			urlencode(get_permalink()),
			$inline_js,
			esc_html__( 'Tumblr', 'origin' ),
			urlencode(get_the_title())
		);
	}
	if( $share['_email'] === 'yes' ) {
		printf(
			'<li class="email"><a href="mailto:?subject=%1$s&body=%5$s" title="$3$s"><i class="ion-email"></i><span>%3$s</span></a></li>',
			urlencode(get_the_title()),
			$inline_js,
			esc_html__( 'Send via Email', 'origin' ),
			urlencode(get_the_title()),
			esc_url(get_permalink())
		);
	}
	?>
</ul>
