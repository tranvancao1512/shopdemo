<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @package ln-moonlight
 * @since   1.0
 * @version 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			printf(
			/* translators: 1: number of comments, 2: post title */
				_nx(
					'Comment &lpar;%s&rpar;',
					'Comments &lpar;%s&rpar;',
					$comments_number,
					'comments title',
					'origin'
				),
				number_format_i18n( $comments_number )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'avatar_size' => 70,
				'style'       => 'ol',
				'short_ping'  => true,
				'reply_text'  => esc_html__( 'Reply', 'origin' ),
				'max_depth'	  => 10,
			) );
			?>
		</ol>

		<?php the_comments_pagination();

	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'origin' ); ?></p>
		<?php
	endif;

	$comments_args = array(
        'label_submit'			=> esc_html__( 'Reply', 'origin'),
        'title_reply'			=> esc_html__( 'Reply comment', 'origin'),
        'title_reply_before'	=> '<h2 class="comments-title">',
		'title_reply_after' 	=> '</h2>',
        'comment_field' 		=> '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" class="required" placeholder="' . esc_html__( 'Comment', 'origin' ) . '" rows="1" cols="37" wrap="hard"></textarea></p>',
		'fields' 				=> apply_filters( 'comment_form_default_fields', array(

								    'author' =>
								      '<p class="comment-form-author">' .
								      '<input id="author" placeholder="' . esc_html__( 'Name *', 'origin' ) . '" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
								      '" size="30" /></p>',

								    'email' =>
								      '<p class="comment-form-email"><input id="email" class="required" placeholder="' . esc_html__( 'E-mail *', 'origin' ) . '" name="email" aria-required="true" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
								      '" size="30" /></p>',
	    )
	  ),
	);

	comment_form( $comments_args );
	?>

</div><!-- #comments -->
