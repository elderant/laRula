<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<?php 
	if ( is_home() && ! did_action( 'woocommerce_init' ) ) {
		do_action('woocommerce_init');
	}
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
		<div class="woocommerce-notices-wrapper">
			<?php wc_print_notices();?>
		</div>
		<?php
			the_content();

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'wp-bootstrap-starter' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	
	<footer class="entry-footer">
		<div class="row column-footer justify-content-center align-content-center">
			<div class="first-column col-lg-4 col-md-4 col-sm-12">
				<img src="http://localhost/larula/wp-content/uploads/2019/03/page-logo.png" alt="La rula taller">
			</div>
			<div class="second-column col-lg-4 col-md-4 col-sm-12">
				Some content here
			</div>
			<div class="third-column col-lg-4 col-md-4 col-sm-12">
				Someother content here
			</div>
		</div>
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
