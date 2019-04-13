<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'wp-bootstrap-starter' ); ?></a>
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="wrapper site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
		<div class="container">
			<nav class="navbar navbar-expand-xl p-0">
				<div class="row top-row">
					<div class="navbar-brand col-lg-6 col-xs-12">
						<?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
							<a href="<?php echo esc_url( home_url( '/' )); ?>" class="logo-link">
								<img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
							</a>
							<a href="<?php echo esc_url( home_url( '/' )); ?>" class="slogan-link">
								<div class="site-description"><?php echo get_bloginfo( 'description' );?></div>
							</a>
						<?php else : ?>
							<a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
						<?php endif; ?>
					</div>
					<div class="header-info col-lg-6 col-xs-12">
						<div class="row general-info">
							<div class="social-links">
								<div class="facebook">
									<a class="facebook" href="https://www.facebook.com/enlarula/"><i class="fab fa-facebook-f"></i></a>
								</div>
								<div class="instagram">
									<a class="instagram" href="https://www.instagram.com/la_rula_taller/"><i class="fab fa-instagram"></i></a>
								</div>
							</div>
						</div>
						<?php $_product = larula_get_featured_product();?>
						<div class="row countdown splitted mt-5" milliseconds="<? echo $_product -> milliseconds;?>">
							<div class="days">
								<div class="value"><?php echo $_product -> until_event -> format('%a'); ?></div>
								<div class="label">días</div>
							</div>
							<div class="hours">
								<div class="value"><?php echo $_product -> until_event -> format('%h'); ?></div>
								<div class="label">horas</div>
							</div>
							<div class="minutes">
								<div class="value"><?php echo $_product -> until_event -> format('%i'); ?></div>
								<div class="label">min</div>
							</div>
							<div class="seconds">
								<div class="value"><?php echo $_product -> until_event -> format('%s'); ?></div>
								<div class="label">seg</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row bottom-row mt-5">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
					</button>

					<?php
					wp_nav_menu(array(
					'theme_location'    => 'primary',
					'container'       => 'div',
					'container_id'    => 'main-nav',
					'container_class' => 'collapse navbar-collapse justify-content-start',
					'menu_id'         => false,
					'menu_class'      => 'navbar-nav',
					'depth'           => 3,
					'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
					'walker'          => new wp_bootstrap_navwalker()
					));
					?>
					<div class="header-actions">
						<a class="button alt" href="http://localhost/larula/talleres/?id=post-<?php echo $_product -> parent_object -> get_id()?>"><?php _e('Ver mas', 'larula');?></a>
						<?php if (strcasecmp( $_product -> get_type(), 'variation' ) == 0) : ?>
							<a class="button" href="http://localhost/larula/checkout/?<?php 
							$url = 'add-to-cart=' . $_product -> parent_object -> get_id() . '&variation_id=' . $_product -> get_id();
							$attribures = $_product -> get_attributes();
							foreach ($attribures as $key => $value) {
								$value = utf8_uri_encode( $value );
								$value = str_replace('/', '%2F', $value);
								$url .= '&attribute_pa_' . $key . '=' . $value;
							}
							echo $url;
							?>"><?php _e('Comprar', 'larula');?></a>
						<?php else: ?>
							<a class="button" href="http://localhost/larula/checkout/?<?php 
							$url = 'add-to-cart=' . $_product -> parent_object -> get_id() . '&variation_id=' . $_product -> get_id();
							echo $url;
							?>"><?php _e('Comprar', 'larula');?></a>
						<?php endif; ?>
					</div>
				</div>				
			</nav>
		</div>
	</header><!-- #masthead -->
    <?php if(is_front_page() && !get_theme_mod( 'header_banner_visibility' )): ?>
        <div id="page-sub-header" <?php if(has_header_image()) { ?>style="background-image: url('<?php header_image(); ?>');" <?php } ?>>
            <div class="container">
                <h1>
                    <?php
                    if(get_theme_mod( 'header_banner_title_setting' )){
                        echo get_theme_mod( 'header_banner_title_setting' );
                    }else{
                        echo 'Wordpress + Bootstrap';
                    }
                    ?>
                </h1>
                <p>
                    <?php
                    if(get_theme_mod( 'header_banner_tagline_setting' )){
                        echo get_theme_mod( 'header_banner_tagline_setting' );
                }else{
                        echo esc_html__('To customize the contents of this header banner and other elements of your site, go to Dashboard > Appearance > Customize','wp-bootstrap-starter');
                    }
                    ?>
                </p>
                <a href="#content" class="page-scroller"><i class="fa fa-fw fa-angle-down"></i></a>
            </div>
        </div>
    <?php endif; ?>
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
                <?php endif; ?>