<?php
/*
Name: Blog Style 02
Slug: content-blog-style-2
*/
?>
<?php
$image_thumb = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), 370, 344, true, true );
?>
<div class="post-item style-2">
	<div class="post-thumb">
		<?php echo '<a href="' . get_permalink() . '">' . wp_specialchars_decode( $image_thumb['img'] ) . '</a>'; ?>
	</div>
	<div class="post-info">
		<?php ayvo_post_title(); ?>
		<span class="post-date"><?php echo get_the_date(); ?></span>
		<?php ayvo_post_count_comment2(); ?>
	</div>
</div>