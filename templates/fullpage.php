<?php
/**
 * Template Name: Full Page Scroll
 *
 * @package WordPress
 * @subpackage Ayvo
 * @since Ayvo 1.0
 */
get_header();
wp_enqueue_style( 'fullpage' );
wp_enqueue_script( 'ayvo-fullpage' );
?>
    <div id="fullpage" class="fullpage-template">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
    </div>
<?php
get_footer();