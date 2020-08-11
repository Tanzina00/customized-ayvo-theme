<?php
/*
Name: Blog Standard
Slug: blog-standard
*/
?>
<?php if ( have_posts() ): ?>
    <div class="blog-standard response-loadmore">
		<?php while ( have_posts() ): the_post(); ?>
            <div <?php post_class( 'post-item list' ); ?>>
				<?php ayvo_post_date(); ?>
                <div class="post-thumb">
					<?php ayvo_post_thumbnail(); ?>
                </div>
                <div class="post-info">
					<?php ayvo_post_title(); ?>
                    <div class="post-metas">
						<?php
						ayvo_post_author();
						ayvo_post_count_comment();
						?>
                    </div>
					<?php
					ayvo_post_excerpt();
					ayvo_post_readmore();
					?>
                </div>
            </div>
		<?php endwhile;
		wp_reset_postdata(); ?>
		<?php ayvo_blog_pagination(); ?>
    </div>
<?php else :
	get_template_part( 'content', 'none' );
endif; ?>
