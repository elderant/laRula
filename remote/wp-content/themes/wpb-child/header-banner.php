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
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
		<div class="container">
			<nav class="navbar navbar-expand-xl p-0">
				<div class="navbar-brand">
					<?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
						<a href="<?php echo esc_url( home_url( '/' )); ?>" class="logo-link">
							<img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
					<?php else : ?>
						<a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
					<?php endif; ?>
				</div>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav" aria-controls="" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
				</button>

				<?php
				wp_nav_menu(array(
				'theme_location'    => 'primary',
				'container'       => 'div',
				'container_id'    => 'main-nav',
				'container_class' => 'collapse navbar-collapse justify-content-end',
				'menu_id'         => false,
				'menu_class'      => 'navbar-nav',
				'depth'           => 3,
				'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
				'walker'          => new wp_bootstrap_navwalker()
				));
				?>
			</nav>
		</div>
		<div class="page-banner">
			<div class="banner-image">
				<?php echo get_the_post_thumbnail( get_the_ID(), 'large'); ?>
			</div>
			<div class="banner-content">
				<div class="container">
					<div class="row">
						<?php $content = get_post_meta( get_the_ID(), 'banner-content', true );?>
						<?php if(empty($content)) : ?>
							<?php $_product = larula_get_featured_product();?>
							<?php if(!empty($_product)) : ?>
								<div class="contact-form col-lg-4 col-md-12 col-sm-12">
									<?php echo do_shortcode('[contact-form-7 id="375" title="Preinscripcion" html_class="wpcf7-form preins-form"]');?>
								</div>
								<div class="taller-image col-lg-4 col-md-6 col-sm-12">
									<span class="countdown" milliseconds="<? echo $_product -> milliseconds;?>"> 
										<?php echo $_product -> until_event -> format('%a dias %h horas %i minutos %s segundos'); ?>
									</span>	
									<?php echo $_product -> get_image(); ?>
								</div>
								<div class="taller-info col-lg-4 col-md-6 col-sm-12">
								<?php $_product = larula_get_featured_product();
											$_parent = $_product -> parent_object;?>
								
									<div class="taller-info-container">
										<div class="name"><?php echo $_product -> get_name();?></div>
										<div class="price"><?php echo '<span class="label">' . __('Precio :','larula') . '</span><span class="price value">' . wc_price( $_product->get_price() ) . '</span>';?></div>
										
										<?php $date = larula_get_product_start_date($_product);?>
										<?php if($date != null) : ?>
											<?php $date_object = DateTime::createFromFormat('Y-m-d', $date); ?>
											<div class="date">
												<span class="label"><?php _e('Fecha :','larula')?></span>
												<span class="date"><?php echo $date_object -> format('d/m/Y'); ?></span>
												<span class="time"><?php echo larula_get_product_start_time($_product); ?></span>
											</div>
										<?php endif; ?>
		
										<div class="estimated-hours"><?php echo '<span class="label">' . __('Intensidad horaria :', 'larula') . '</span><span class="hours value">' . $_product -> estimated_hours . '</span>';?></div>
										<div class="maximun-seats"><?php echo '<span class="label">' . __('Cupos :', 'larula') . '</span><span class="seats value">' . $_product -> get_stock_quantity() . '/' . $_product -> maximun_seats . '</span>';?></div>
										<?php if (strcasecmp( $_product -> get_type(), 'variation' ) == 0) : ?>
											<div class="variation-description"><?php echo $_product -> get_description();?></div>
										<?php endif; ?>
										<div class="parent-excerpt"><?php echo $_parent -> get_short_description();?></div>
										<div class="parent-description"><?php echo $_parent -> get_description();?></div>
										<div class="actions">
											<?php $options = get_option('larula_options'); ?>
											<?php if($options['hide_not_featured']) : ?>
												<a class="button alt" href="http://localhost/larula/talleres/?id=post-<?php echo $_product -> get_id()?>"><?php _e('Ver mas', 'larula');?></a>
											<?php else :?>
												<a class="button alt" href="http://localhost/larula/talleres/?id=post-<?php echo $_parent -> get_id()?>"><?php _e('Ver mas', 'larula');?></a>
											<?php endif;?>
											<?php if (strcasecmp( $_product -> get_type(), 'variation' ) == 0) : ?>
												<a class="button alt" href="http://localhost/larula/checkout/?<?php 
													$url = 'add-to-cart=' . $_parent -> get_id() . '&variation_id=' . $_product -> get_id();
													$attribures = $_product -> get_attributes();
													foreach ($attribures as $key => $value) {
														$value = utf8_uri_encode( $value );
														$value = str_replace('/', '%2F', $value);
														$url .= '&attribute_pa_' . $key . '=' . $value;
													}
													echo $url;
												?>"><?php _e('Comprar', 'larula');?></a>
											<?php else: ?>
												<a class="button alt" href="http://localhost/larula/checkout/?<?php 
													$url = 'add-to-cart=' . $_parent -> get_id() . '&variation_id=' . $_product -> get_id();
													echo $url;
												?>"><?php _e('Comprar', 'larula');?></a>
											<?php endif; ?>
										</div>
									</div>
									
								</div>
							<?php endif;?>
						<?php else : ?>
							<div class="banner-custom-content col-lg-12 col-md-12 col-sm-12">
								<?php echo $content;?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
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