<?php
/*
Name: Blog Style 03
Slug: content-blog-style-3
*/
?>
<?php
$image_thumb        = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), 960, 698, true, true );
?>
<div class="post-item style-3">
	<div class="post-thumb equal-elem">
		<?php echo '<a href="' . get_permalink() . '">' . wp_specialchars_decode( $image_thumb['img'] ) . '</a>'; ?>
	</div>
	<div class=" equal-elem">
		<div class="post-info">
			<?php ayvo_post_title(); ?>
			<div class="post-metas">
				<?php ayvo_post_author(); ?>
			</div>
			<div class="read-more">
				<a class="readmore-button" href="<?php the_permalink(); ?>">
					<span> <?php echo esc_html__( 'Read more', 'ayvo' ); ?> </span>
				</a>
			</div>
		</div>
	</div>
</div>