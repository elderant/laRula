<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
    $enable_vc = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);
    if(!$enable_vc ) {
    ?>
    <header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->
    <?php } ?>

	<div class="entry-content">
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	
	<footer class="entry-footer">
		<!-- <div class="social-links">
			<a class="facebook" href="https://www.facebook.com/enlarula/"><i class="fab fa-facebook-f"></i></a>
			<a class="instagram" href="https://www.instagram.com/la_rula_taller/"><i class="fab fa-instagram"></i></a>
		</div>
		<div class="rainbow-strip">
			<img src="http://localhost/larula/wp-content/uploads/page-footer-lines-1.png" alt="Color line strip">
		</div> -->
		<?php if ( get_edit_post_link() && !$enable_vc ) : ?>
			<?php
				edit_post_link(
					sprintf(
						/* translators: %s: Name of current post */
						esc_html__( 'Edit %s', 'wp-bootstrap-starter' ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					),
					'<span class="edit-link">',
					'</span>'
				);
			?>
		<?php endif; ?>
	</footer><!-- .entry-footer -->
	
</article><!-- #post-## -->
