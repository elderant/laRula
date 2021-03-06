<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
		<div class="post-thumbnail <?php echo !is_single()? 'col-6':'';?>">
			<?php
				if ( is_single() ) :
					the_post_thumbnail();
				else :
					the_post_thumbnail('medium');
				endif;?>
			<?php  ?>
		</div>
		<div class="entry-information <?php echo !is_single()? 'col-6':'';?>">
			<header class="entry-header">
				<?php
				if ( is_single() ) :
					//the_title( '<h1 class="entry-title">', '</h1>' );
				else :
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				endif;

				if ( false /*'post' === get_post_type()*/ ) : ?>
				<div class="entry-meta">
					<?php wp_bootstrap_starter_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php
				endif; ?>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
						if ( is_single() ) :
							the_content();
						else :
							the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'wp-bootstrap-starter' ) );
						endif;

					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
						'after'  => '</div>',
					) );
				?>
			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php wp_bootstrap_starter_entry_footer(); ?>
				<?php if(is_single()) {
					larula_get_page_footer_html();
				 } 
				?>
			</footer><!-- .entry-footer -->
		</div>
	</div>
</article><!-- #post-## -->
