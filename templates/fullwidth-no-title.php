<?php
/**
 * Template Name: Full Width No Page title
 *
 * @package WordPress
 * @subpackage Ayvo
 * @since Ayvo 1.0
 */
get_header();
?>
	<div class="fullwidth-template">
		<div class="container">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; ?>
		</div>
	</div>
<?php
get_footer();