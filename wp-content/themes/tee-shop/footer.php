<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package ln-moonlight
 * @since 1.0
 * @version 1.0
 */

?>
	</div><!-- #content -->

	<?php
	/**
	 * Hook: origin_footer
	 *
	 * @hooked origin_action_default_footer - 10v
	 * @hooked origin_action_default_footer - 10
	 */
	do_action( 'origin_footer' );
	?>
</div><!-- #st-container -->

<?php wp_footer(); ?>
<script type="text/javascript">
	document.body.classList.add('domloaded');
	window.onbeforeunload = function(){
		document.body.classList.remove('domloaded');
		console.log('before leave');
	};
</script>
</body>
</html>
