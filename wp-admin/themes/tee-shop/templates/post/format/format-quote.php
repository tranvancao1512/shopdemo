<?php 

$qoute = origin_get_post_meta( 'post_format_quote', get_the_ID() );

get_template_part( 'templates/post/format/format', 'image' );

if ( ! defined( 'FW' ) ) {
	// the_content();
} else {
?>

<div class="post-format-quote ">
	
	<blockquote>
		<p> <?php echo esc_html( $qoute['_content'] );?> </p>
		<?php 
			if( $qoute['_author_URL'] ) {
				echo '<a href="' . esc_url( $qoute['_author_URL'] ) . '"><cite>' . esc_html( $qoute['_author'] ) . '</cite></a>';
			} else {
				echo '<cite>' .  esc_html( $qoute['_author'] ) . '</cite>';
			}
		?>
	</blockquote>
	
</div> <!-- End slick -->

<?php }