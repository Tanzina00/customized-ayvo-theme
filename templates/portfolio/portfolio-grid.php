<?php
/*
Name: Portfolio Grid
Slug: portfolio-grid
*/
$list_style      = Ayvo_Functions::get_option( 'ovic_portfolio_list_style', 'grid' );
$portfolio_items = Ayvo_Functions::get_option( 'portfolio_items', '3' );
wp_enqueue_script( 'ayvo-isotope' );
?>
<?php if ( have_posts() ): ?>
	<?php ayvo_isotope_filter(); ?>
    <div class="blog-portfolio">
        <div class="popup-gallery">
            <span class="close">x</span>
            <div class="list-gallery"></div>
            <a href="#" class="title-gallery"></a>
        </div>
        <div class="ayvo-isotope auto-clear response-loadmore portfolio-grid" data-layout="fitRows"
             data-cols="<?php echo esc_attr( $portfolio_items ); ?>">
			<?php while ( have_posts() ): the_post(); ?>
                <div <?php post_class( 'post-item isotope-item' ); ?>>
                    <div class="post-thumb">
						<?php ayvo_portfolio_thumbnail(); ?>
                        <div class="view-more">
                            <a class="view-button popup-portfolio" href="#" data-id="<?php the_ID(); ?>">
                                <span> <?php echo esc_html__( 'View Gallery', 'ayvo' ); ?> </span>
                            </a>
                        </div>
                    </div>
                    <div class="post-info">
						<?php
						ayvo_post_category( 'portfolio_category' );
						ayvo_post_title();
						?>
                    </div>
                </div>
			<?php endwhile; ?>
        </div>
		<?php ayvo_portfolio_pagination(); ?>
    </div>
<?php else :
	get_template_part( 'content', 'none' );
endif; ?>
