<?php
/*
Name: Blog Masonry
Slug: blog-masonry
*/
?>
<?php wp_enqueue_script( 'ayvo-isotope' ); ?>
<?php if ( have_posts() ): ?>
	<div class="blog-grid blog-masonry">
		<div class="ayvo-isotope response-loadmore" data-layout="packery">
			<?php while ( have_posts() ): the_post(); ?>
				<?php
				$class   = array( ' isotope-item' );
				$options = get_post_meta( get_the_ID(), '_metabox_post_options', true );
				if ( isset( $options['post_size'] ) )
					$class['post_size'] = $options['post_size'];
				?>
				<div <?php post_class( $class ); ?>>
					<div class="post-item">
						<div class="post-thumb">
							<?php
							ayvo_post_thumbnail();
							ayvo_post_date();
							?>
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
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
		<?php ayvo_blog_pagination(); ?>
	</div>
<?php else :
	get_template_part( 'content', 'none' );
endif; ?>
