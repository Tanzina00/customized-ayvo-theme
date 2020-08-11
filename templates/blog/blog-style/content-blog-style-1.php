<?php
/*
Name: Blog Style 01
Slug: content-blog-style-1
*/
?>
<?php
$image_thumb = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), 940, 686, true, true );
?>
<div class="post-item equal-elem style-1">
    <div class="post-thumb">
		<?php echo '<a href="' . get_permalink() . '">' . wp_specialchars_decode( $image_thumb['img'] ) . '</a>'; ?>
		<?php
		ayvo_post_date();
		?>
    </div>
    <div class="post-info">
		<?php ayvo_post_title(); ?>
        <div class="post-metas">
			<?php ayvo_post_author(); ?>
			<?php ayvo_post_count_comment(); ?>
        </div>
		<?php
		ayvo_post_excerpt();
		ayvo_post_readmore();
		?>
    </div>
</div>