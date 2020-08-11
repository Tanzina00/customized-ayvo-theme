<?php
$enable_share = Ayvo_Functions::get_option( 'ovic_single_share_button' );
$single_style = Ayvo_Functions::get_option( 'ovic_single_blog_style', 'classic' );
?>
    <div class="blog-single">
        <div <?php post_class( 'post-item single-post' ); ?>>
			<?php if ( $single_style == 'classic' ) { ?>
                <div class="head">
                    <h4 class="post-title"><?php the_title(); ?></h4>
                    <div class="post-metas">
						<?php
						ayvo_post_author();
						ayvo_post_date();
						?>
                    </div>
                </div>
			<?php } ?>
            <div class="post-thumb">
				<?php the_post_thumbnail( 'full' ); ?>
            </div>
            <div class="post-info">
				<?php if ( $single_style == 'modern' ) { ?>
                    <h4 class="post-title"><?php the_title(); ?></h4>
                    <div class="post-metas">
						<?php
						ayvo_post_author();
						echo esc_html( 'on', 'ayvo' );
						ayvo_post_date();
						?>
                    </div>
				<?php } ?>
				<?php
				ayvo_post_single_content();
				?>
                <div class="group-bottom">
					<?php
					ayvo_post_tags();
					ayvo_share_post( $enable_share );
					ayvo_about_author();
					?>
                </div>
            </div>
        </div>
    </div>
<?php
get_template_part( 'templates/blog/blog', 'related' );