<?php
global $post;
$enable_related   = Ayvo_Functions::get_option( 'ovic_enable_related_post' );
$number_related   = Ayvo_Functions::get_option( 'ovic_related_post_per_page', 6 );
$categories       = get_the_category( $post->ID );
if ( $categories && $enable_related == 1 ) :
	$woo_ls_items = Ayvo_Functions::get_option( 'ovic_related_post_ls_items', 3 );
	$woo_lg_items = Ayvo_Functions::get_option( 'ovic_related_post_lg_items', 3 );
	$woo_md_items = Ayvo_Functions::get_option( 'ovic_related_post_md_items', 3 );
	$woo_sm_items = Ayvo_Functions::get_option( 'ovic_related_post_sm_items', 2 );
	$woo_xs_items = Ayvo_Functions::get_option( 'ovic_related_post_xs_items', 1 );
	$woo_ts_items = Ayvo_Functions::get_option( 'ovic_related_post_ts_items', 1 );
	$atts         = array(
		'owl_loop'     => 'false',
		'owl_ts_items' => $woo_ts_items,
		'owl_xs_items' => $woo_xs_items,
		'owl_sm_items' => $woo_sm_items,
		'owl_md_items' => $woo_md_items,
		'owl_lg_items' => $woo_lg_items,
		'owl_ls_items' => $woo_ls_items,
	);
	$owl_settings = apply_filters( 'ovic_carousel_data_attributes', 'owl_', $atts );
	$category_ids = array();
	foreach ( $categories as $value ) {
		$category_ids[] = $value->term_id;
	}
	$args      = array(
		'category__in'        => $category_ids,
		'post__not_in'        => array( $post->ID ),
		'posts_per_page'      => $number_related,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand',
	);
	$new_query = new wp_query( $args );
	if ( $new_query->have_posts() ) : ?>
        <div class="related-post">
            <h3 class="title ayvo-title">
                <span class="text"><?php echo esc_html__( 'YOU MIGHT ALSO LIKE', 'ayvo' ); ?></span>
            </h3>
            <div class="owl-slick" <?php echo esc_attr( $owl_settings ); ?>>
				<?php while ( $new_query->have_posts() ): $new_query->the_post(); ?>
                    <article <?php post_class( 'post-item grid-v1' ); ?>>
                        <div class="post-thumb">
							<?php
							$image_thumb = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), false, false, true, true );
							echo '<a href="' . get_permalink() . '">';
							echo wp_specialchars_decode( $image_thumb['img'] );
							echo '</a>';
							?>
                        </div>
                        <div class="post-info">
							<?php
							ayvo_post_title();
							ayvo_post_author();
							?>
                        </div>
                    </article>
				<?php endwhile; ?>
            </div>
        </div>
	<?php endif;
endif;
wp_reset_postdata();