<?php
$ayvo_page_used_sidebar = Ayvo_Functions::get_post_meta( get_the_ID(), 'ovic_page_used_sidebar', 'widget-area' );
?>
<?php if ( is_active_sidebar( $ayvo_page_used_sidebar ) ) : ?>
    <div id="widget-area" class="widget-area page-sidebar">
		<?php dynamic_sidebar( $ayvo_page_used_sidebar ); ?>
    </div><!-- .widget-area -->
<?php endif; ?>
