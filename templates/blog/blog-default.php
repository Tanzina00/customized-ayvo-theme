<?php
/*
Name: Blog Default
Slug: blog-default
*/
?>
<?php if ( have_posts() ): ?>
	<div class="blog-default response-loadmore">
		<?php while ( have_posts() ): the_post(); ?>
			<div <?php post_class( 'post-item default' ); ?>>
				<div class="post-thumb">
					<?php ayvo_post_thumbnail(); ?>
				</div>
				<div class="post-info">
					<?php ayvo_post_title(); ?>
					<div class="post-metas">
						<?php
						ayvo_post_author();
						ayvo_post_count_comment();
						ayvo_post_date();
						?>
					</div>
					<div class="post-content">
						<?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 50 ); ?>
					</div>
					<?php
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
