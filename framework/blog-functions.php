<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 *
 * TEMPLATE BLOG GRID
 */
if ( !function_exists( 'ayvo_custom_pagination' ) ) {
	function ayvo_custom_pagination( $pagination )
	{
		global $wp_query;
		$max   = $wp_query->max_num_pages;
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$style = $paged > $wp_query->max_num_pages ? 'display:none' : '';
		// Don't print empty markup if there's only one page.
		if ( $max >= 2 ) {
			if ( $pagination == 'default' ) {
				echo get_the_posts_pagination( array(
						'before_page_number' => '',
						'prev_text'          => '<span class="prev">Prev</span>',
						'next_text'          => '<span class="next">Next</span>',
					)
				);
			} else {
				?>
                <div class="loadmore">
                    <a href="<?php echo get_next_posts_page_link(); ?>" class="button view-more-button"
                       data-max="<?php echo esc_attr( $wp_query->max_num_pages ); ?>"
                       data-current="<?php echo esc_attr( $paged ); ?>"
                       style="<?php echo esc_attr( $style ) ?>">
						<?php echo esc_html__( 'Load More', 'ayvo' ); ?>
                    </a>
                </div>
				<?php
			}
		}
	}
}
if ( !function_exists( 'ayvo_blog_pagination' ) ) {
	function ayvo_blog_pagination()
	{
		$pagination = Ayvo_Functions::get_option( 'ovic_blog_pagination', 'default' );
		ayvo_custom_pagination( $pagination );
	}
}
if ( !function_exists( 'ayvo_portfolio_pagination' ) ) {
	function ayvo_portfolio_pagination()
	{
		$pagination = Ayvo_Functions::get_option( 'ovic_portfolio_pagination', 'default' );
		ayvo_custom_pagination( $pagination );
	}
}
/*blog single*/
if ( !function_exists( 'ayvo_callback_comment' ) ) {
	/**
	 * aaron comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int $depth the comment depth.
	 * @since 1.0.0
	 */
	function ayvo_callback_comment( $comment, $args, $depth )
	{
		if ( 'div' == $args['style'] ) {
			$tag       = 'div ';
			$add_below = 'comment';
		} else {
			$tag       = 'li ';
			$add_below = 'div-comment';
		}
		?>
        <<?php echo esc_attr( $tag ); ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php echo get_comment_ID(); ?>">
        <div class="comment-body">
            <div class="author-comment">
				<?php echo get_avatar( $comment, 70 ); ?>
            </div>
            <div class="comment-info">
                <div class="comment-meta">
                    <div class="comment-name vcard">
						<?php printf( wp_kses_post( '%s <span class="name">%s</span>' ), esc_html__( '', 'ayvo' ), get_comment_author_link() ); ?>
                    </div>
					<?php if ( '0' == $comment->comment_approved ) : ?>
                        <em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'ayvo' ); ?></em>
                        <br/>
					<?php endif; ?>
                    <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( get_comment_ID() ) ) ); ?>"
                       class="comment-date">
						<?php echo '<time datetime="' . get_comment_date( 'M d, Y' ) . '">' . esc_html__( 'at ', 'ayvo' ) . '<span>' . get_comment_date() . '</span></time>'; ?>
                    </a>
					<?php edit_comment_link( __( 'Edit', 'ayvo' ), '  ', '' ); ?>
					<?php do_action( 'ovic_comment_meta' ); ?>
                </div>
				<?php echo ( 'div' != $args['style'] ) ? '<div id="div-comment-' . get_comment_ID() . '" class="comment-content">' : '' ?>
                <div class="comment-text">
					<?php comment_text(); ?>
                </div>
                <div class="reply">
                    <div class="reply-content">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div>
                </div>
				<?php echo 'div' != $args['style'] ? '</div>' : ''; ?>
            </div>
        </div>
		<?php
	}
}
/*Function*/
if ( !function_exists( 'ayvo_share_post' ) ) {
	function ayvo_share_post( $ovic_share_button )
	{
		$share_image_url  = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'full' );
		$share_link_url   = get_permalink( get_the_ID() );
		$share_link_title = get_the_title();
		$share_summary    = get_the_excerpt();
		$twitter          = 'https://twitter.com/share?url=' . $share_link_url . '&text=' . $share_summary;
		$facebook         = 'https://www.facebook.com/sharer.php?u=' . $share_link_url;
		$google           = 'https://plus.google.com/share?url=' . $share_link_url . '&title=' . $share_link_title;
		$pinterest        = 'https://pinterest.com/pin/create/button/?url=' . $share_link_url . '&description=' . $share_summary . '&media=' . $share_image_url;
		?>
		<?php if ( $ovic_share_button == 1 ): ?>
        <div class="ovic-share-socials">
            <span class="title"><?php echo esc_html__( 'Share', 'ayvo' ); ?></span>
            <div class="list-social">
                <a class="twitter"
                   href="<?php echo esc_url( $twitter ); ?>"
                   title="<?php echo esc_attr__( 'Twitter', 'ayvo' ) ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                    <span class="fa fa-twitter"></span>
                </a>
                <a class="facebook"
                   href="<?php echo esc_url( $facebook ); ?>"
                   title="<?php echo esc_attr__( 'Facebook', 'ayvo' ) ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                    <span class="fa fa-facebook-f"></span>
                </a>
                <a class="googleplus"
                   href="<?php echo esc_url( $google ); ?>"
                   title="<?php echo esc_attr__( 'Google+', 'ayvo' ) ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                    <span class="fa fa-google-plus"></span>
                </a>
                <a class="pinterest"
                   href="<?php echo esc_url( $pinterest ); ?>"
                   title="<?php echo esc_attr__( 'Pinterest', 'ayvo' ) ?>"
                   onclick='window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;'>
                    <span class="fa fa-pinterest"></span>
                </a>
            </div>
        </div>
	<?php endif; ?>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_thumbnail' ) ) {
	function ayvo_post_thumbnail()
	{
		$thumb           = '';
		$crop            = true;
		$width           = 1800;
		$height          = 955;
		$blog_list_style = Ayvo_Functions::get_option( 'ovic_blog_list_style', 'standard' );
		if ( $blog_list_style == 'masonry' ) {
			$post_size = '';
			$options   = get_post_meta( get_the_ID(), '_metabox_post_options', true );
			if ( isset( $options['post_size'] ) )
				$post_size = $options['post_size'];
			if ( $post_size == 'width-1' ) {
				$width  = 405;
				$height = 295;
			} else {
				$width  = 870;
				$height = 633;
			}
		}
		$width       = apply_filters( 'ayvo_size_thumb_width', $width );
		$height      = apply_filters( 'ayvo_size_thumb_height', $height );
		$image_thumb = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), $width, $height, $crop, true );
		if ( $blog_list_style == 'masonry' ) {
			$thumb = $image_thumb['img'];
		} else {
			if ( has_post_thumbnail() )
				$thumb = wp_get_attachment_image( get_post_thumbnail_id(), 'full' );
		}
		if ( $thumb != "" ) {
			?>
            <div class="thumb">
				<?php echo '<a href="' . get_permalink() . '"> <figure>' . wp_specialchars_decode( $thumb ) . '</figure></a>'; ?>
            </div>
			<?php
		}
	}
}
if ( !function_exists( 'ayvo_portfolio_thumbnail' ) ) {
	function ayvo_portfolio_thumbnail()
	{
		$portfolio_style = Ayvo_Functions::get_option( 'ovic_portfolio_list_style', 'masonry' );
		if ( $portfolio_style == 'masonry' ) {
			$portfolio_size = '';
			$options        = get_post_meta( get_the_ID(), '_metabox_portfolio_options', true );
			if ( isset( $options['portfolio_size'] ) )
				$portfolio_size = $options['portfolio_size'];
			if ( $portfolio_size == 'custom' && isset( $options['portfolio_width'] ) && isset( $options['portfolio_height'] ) ) {
				$width  = $options['portfolio_width'];
				$height = $options['portfolio_height'];
			} else {
				if ( $portfolio_size == 'height-1' ) {
					$width  = 370;
					$height = 270;
				} elseif ( $portfolio_size == 'height-2' ) {
					$width  = 370;
					$height = 370;
				} elseif ( $portfolio_size == 'height-3' ) {
					$width  = 370;
					$height = 540;
				} else {
					$width  = 370;
					$height = 270;
				}
			}
		} else {
			$width  = 370;
			$height = 370;
		};
		$image_thumb = apply_filters( 'ovic_resize_image', get_post_thumbnail_id(), $width, $height, true, true );
		?>
        <div class="thumb">
            <a href="<?php the_permalink(); ?>">
				<figure><?php echo wp_specialchars_decode( $image_thumb['img'] ); ?></figure>
            </a>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_title' ) ) {
	function ayvo_post_title()
	{
		?>
        <h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_sticky' ) ) {
	function ayvo_post_sticky()
	{
		if ( is_sticky() ) : ?>
            <div class="sticky-post"><i class="fa fa-flag"></i>
				<?php echo esc_html__( ' Sticky', 'ayvo' ); ?>
            </div>
		<?php endif;
	}
}
if ( !function_exists( 'ayvo_post_author' ) ) {
	function ayvo_post_author()
	{
		?>
        <span class="post-author">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 30 ); ?>
			<?php echo esc_html__( 'Posted by', 'ayvo' ), '<span>' . get_the_author() . '</span>'; ?>
		</span>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_date' ) ) {
	function ayvo_post_date()
	{
		echo '<span class="post-date style-1">' . get_the_date() . '</span>';
	}
}
if ( !function_exists( 'ayvo_about_author' ) ) {
	function ayvo_about_author()
	{
		if ( get_the_author_meta( 'description' ) != "" ) :?>
            <div class="about-author">
                <div class="avata">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>
                </div>
                <div class="info">
                    <h4 class="name">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
							<?php the_author() ?>
                        </a>
                    </h4>
					<?php if ( get_the_author_meta( 'description' ) != "" ) : ?>
                        <p class="description"><?php echo get_the_author_meta( 'description' ); ?></p>
					<?php endif; ?>
                </div>
            </div>
		<?php
		endif;
	}
}
if ( !function_exists( 'ayvo_post_tags' ) ) {
	function ayvo_post_tags()
	{
		$get_term_tag = get_the_terms( get_the_ID(), 'post_tag' );
		if ( !is_wp_error( $get_term_tag ) && !empty( $get_term_tag ) ) : ?>
            <div class="tags">
				<span class="head">
					<span class="text"><?php echo esc_html__( 'Tags:', 'ayvo' ) ?></span>
				</span>
				<?php the_tags( '' ); ?>
            </div>
		<?php
		endif;
		ayvo_post_category( 'category' );
	}
}
if ( !function_exists( 'ayvo_post_category' ) ) {
	function ayvo_post_category( $taxonomy )
	{
		$get_term_cat = get_the_terms( get_the_ID(), $taxonomy );
		if ( !is_wp_error( $get_term_cat ) && !empty( $get_term_cat ) ) : ?>
            <div class="categories">
				<span class="head">
                        <span class="text"><?php echo esc_html__( 'Categories:', 'ayvo' ) ?></span>
				</span>
				<?php foreach ( $get_term_cat as $item ):
					$link = get_term_link( $item->term_id, $taxonomy );
					?>
                    <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $item->name ); ?></a>
				<?php endforeach; ?>
            </div>
		<?php endif;
	}
}
if ( !function_exists( 'ayvo_post_excerpt' ) ) {
	function ayvo_post_excerpt()
	{
		?>
        <div class="post-content">
			<?php echo wp_trim_words( apply_filters( 'the_excerpt', get_the_excerpt() ), 20 ); ?>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_content' ) ) {
	function ayvo_post_content()
	{
		?>
        <div class="post-content">
			<?php the_content(); ?>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_single_content' ) ) {
	function ayvo_post_single_content()
	{
		?>
        <div class="post-content">
			<?php
			/* translators: %s: Name of current post */
			the_content( sprintf(
					esc_html__( 'Continue Reading %s', 'ayvo' ),
					the_title( '<span class="screen-reader-text">', '</span>', false )
				)
			);
			wp_link_pages( array(
					'before'      => '<div class="page-links">',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '%',
					'separator'   => '',
				)
			);
			?>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_count_comment' ) ) {
	function ayvo_post_count_comment()
	{
		?>
        <span class="post-comment">
			<span class="icon"><i class="abc icon-message-circle"></i></span>
			<span class="count">
				<?php comments_number(
					esc_html__( '0', 'ayvo' ),
					esc_html__( '1', 'ayvo' ),
					esc_html__( '%', 'ayvo' )
				);
				?>
			</span>
		</span>
		<?php
	}
}
if ( !function_exists( 'ayvo_post_count_comment2' ) ) {
	function ayvo_post_count_comment2()
	{
		?>
        <div class="post-comment">
			<span class="count">
				<?php comments_number(
					esc_html__( '0 Comment', 'ayvo' ),
					esc_html__( '1 Comment', 'ayvo' ),
					esc_html__( '% Comments', 'ayvo' )
				);
				?>
			</span>
        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_simple_likes_button' ) ) {
	function ayvo_simple_likes_button()
	{
		do_action( 'ovic_simple_likes_button', get_the_ID() );
	}
}
if ( !function_exists( 'ayvo_post_readmore' ) ) {
	function ayvo_post_readmore()
	{
		?>
        <div class="read-more">
            <a class="readmore-button" href="<?php the_permalink(); ?>">
				<span>
					<?php echo esc_html__( 'Continue Reading', 'ayvo' ); ?>
                    <i class="abc icon-play-circle"></i>
				</span>
            </a>

        </div>
		<?php
	}
}
if ( !function_exists( 'ayvo_isotope_filter' ) ) {
	function ayvo_isotope_filter()
	{
		$portfolios = Ayvo_Functions::get_option( 'ayvo_portfolio_cat', array() );
		if ( !empty( $portfolios ) ):
			?>
            <div class="button-group filter-button-group">
                <div class="filter-list">
                    <a href="#" class="active" data-filter="*"><?php echo esc_html__( 'All', 'ayvo' ); ?></a>
					<?php
					foreach ( $portfolios as $portfolio ) {
						$terms = get_term( $portfolio, 'portfolio_category' );
						echo '<a href="#" data-filter=".' . 'portfolio_category' . '-' . $terms->slug . '">' . $terms->name . '</a>';
					}
					?>
                </div>
            </div>
		<?php
		endif;
	}
}
if ( !function_exists( 'ayvo_ajax_gallery' ) ) {
	function ayvo_ajax_gallery()
	{
		$response = array(
			'gallery' => '',
			'message' => '',
			'title'   => '',
			'href'    => '',
			'success' => 'no',
		);
		check_ajax_referer( 'ovic_ajax_frontend', 'security' );
		$data_gallery   = array();
		$id             = isset( $_POST['id'] ) ? $_POST['id'] : '';
		$meta           = get_post_meta( $id, '_metabox_portfolio_options', true );
		$data_gallery[] = wp_get_attachment_image_url( get_post_thumbnail_id( $id ), array( 770, 770 ) );
		if ( isset( $meta['portfolio_gallery'] ) && $meta['portfolio_gallery'] != '' ) {
			$galleries = explode( ',', $meta['portfolio_gallery'] );
			foreach ( $galleries as $gallery ) {
				$data_gallery[] = wp_get_attachment_image_url( $gallery, array( 770, 770 ) );
			}
			$response['success'] = 'ok';
		}
		$response['gallery'] = $data_gallery;
		$response['title']   = get_the_title( $id );
		$response['href']    = get_permalink( $id );
		wp_send_json( $response );
		die();
	}
}