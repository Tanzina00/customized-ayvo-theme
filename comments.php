<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Ayvo
 * @since ayvo 1.0
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
$fields        = array(
	'author' => '<div class="row"><p class="col-sm-12 col-md-6"><span class="label input-important">'. esc_html__( 'Name', 'ayvo' ) .'</span><input type="text" name="author" id="name" class="input-form" placeholder="' . esc_attr__( 'ayvo - Name', 'ayvo' ) . '" /></p>',
	'email'  => '<p class="col-sm-12 col-md-6"><span class="label input-important">'. esc_html__( 'Email', 'ayvo' ) .'</span><input type="text" name="email" id="email" class="input-form" placeholder="' . esc_attr__( 'ayvo@email.com', 'ayvo' ) . '" /></p></div><!-- /.row -->',
);
$comment_field = '<p class="comment-form-comment"><span class="label">'. esc_html__( 'Comment ', 'ayvo' ) .'</span><textarea class="input-form" id="comment" name="comment" cols="45" rows="16" aria-required="true" placeholder="' . esc_attr__( 'Text here...', 'ayvo' ) . '">' .
	'</textarea></p>';
$comment_form_args = array(
	'class_submit'  => 'button',
	'fields'        => $fields,
	'comment_field' => $comment_field,
	'label_submit'  => esc_html__( 'Post Comment', 'ayvo' ),
	'title_reply'   => esc_html__( 'Leave a Reply', 'ayvo' ),
);
?>
<div id="comments" class="comments-area">
	<?php if ( have_comments() ) : ?>
		<h4 class="comments-title">
			<span class="count">
				<?php comments_number(
					esc_html__( '0 Comment', 'ayvo' ),
					esc_html__( '1 Comment', 'ayvo' ),
					esc_html__( '% Comments', 'ayvo' )
				);
				?>
			</span>
		</h4>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'callback'   => 'ayvo_callback_comment',
				)
			);
			?>
		</ol>
		<?php
	endif;
	the_comments_pagination( array(
			'screen_reader_text' => '',
			'prev_text'          => '<span class="screen-reader-text">' . esc_html__( 'Prev', 'ayvo' ) . '</span>',
			'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next', 'ayvo' ) . '</span>',
		)
	);
	if ( !comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php echo esc_html__( 'Comments are closed.', 'ayvo' ); ?></p>
		<?php
	endif;
	comment_form( $comment_form_args );
	?>
</div><!-- #comments -->