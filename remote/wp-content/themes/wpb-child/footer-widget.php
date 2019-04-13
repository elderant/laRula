<?php

if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) { ?>
	<div id="footer-widget" class="row m-0 <?php if(!is_theme_preset_active()){ echo 'bg-light'; } ?>">
		<div class="container">
			<div class="row">
				<div class="color-strip"></div>
			</div>
			<div class="row widget-content">
				<?php if ( is_active_sidebar( 'footer-1' )) : ?>
						<div class="col-12 col-lg-12 col-md-12 justify-content-center align-content-center"><?php dynamic_sidebar( 'footer-1' ); ?></div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-2' )) : ?>
						<div class="col-12 col-lg-12 col-md-12 justify-content-center align-content-center"><?php dynamic_sidebar( 'footer-2' ); ?></div>
				<?php endif; ?>
				<?php if ( is_active_sidebar( 'footer-3' )) : ?>
						<div class="col-12 col-lg-12 col-md-12 justify-content-center align-content-center"><?php dynamic_sidebar( 'footer-3' ); ?></div>
				<?php endif; ?>
			</div>
		</div>
		<div class="go-to-top"><i class="fas fa-chevron-up top"></i><i class="fas fa-chevron-up bottom"></i></div>
	</div>

<?php }