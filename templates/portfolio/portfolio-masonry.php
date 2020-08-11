<?php
/*
Name: Blog Portfolio
Slug: blog-portfolio
*/
?>
<?php wp_enqueue_script( 'ayvo-isotope' );?>
<?php if ( have_posts() ): ?>
	<div class="blog-portfolio portfolio-masonry">
		<div class="popup-gallery">
			<span class="close">x</span>
			<div class="list-gallery"></div>
			<a href="#" class="title-gallery"></a>
		</div>
		<div class="ayvo-isotope response-loadmore" data-layout="packery">
			<?php while ( have_posts() ): the_post(); ?>
				<div <?php post_class( 'post-item portfolio isotope-item' ); ?>>
					<div class="post-thumb">
						<?php
						ayvo_portfolio_thumbnail();
						ayvo_post_category( 'portfolio_category' );
						?>
						<div class="view-more">
							<a class="view-button popup-portfolio" href="#" data-id="<?php the_ID(); ?>">
								<span> <?php echo esc_html__( 'View Gallery', 'ayvo' ); ?> </span>
							</a>
						</div>
						<?php ayvo_post_title(); ?>
					</div>
				</div>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
		<?php ayvo_portfolio_pagination(); ?>
	</div>

<?php else :
	get_template_part( 'content', 'none' );
endif; ?>
