<?php
/**
 * @package _paperTheme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="title title--entry"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php _paperTheme_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_post_thumbnail('thumbnail'); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&rarr;</span>', '_paperTheme' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', '_paperTheme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', '_paperTheme' ) );
				if ( $categories_list && _paperTheme_categorized_blog() ) :
			?>
			<span class="cat-links">
				<?php printf( __( 'Posted in %1$s', '_paperTheme' ), $categories_list ); ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', '_paperTheme' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php printf( __( 'Tagged %1$s', '_paperTheme' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

	</footer><!-- .entry-footer -->
</article><!-- #post-## -->