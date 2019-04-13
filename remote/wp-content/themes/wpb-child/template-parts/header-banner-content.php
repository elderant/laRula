<div class="banner-image">
  <?php echo get_the_post_thumbnail( get_the_ID(), 'large'); ?>
</div>
<div class="banner-content">
  <div class="container">
    <div class="row">
      <?php $content = get_post_meta( get_the_ID(), 'banner-content', true );?>
      
      <?php if(!empty($content)) : ?>
        <div class="banner-custom-content col-lg-12 col-md-12 col-sm-12">
          <?php echo $content;?>
        </div>
      <?php else : ?>
      <?php $_product = larula_get_featured_product();?>
        <?php if(!empty($_product)) : ?>
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
              <!-- <div class="price"><?php /*echo '<span class="label">' . __('Precio :','larula') . '</span><span class="price value">' . wc_price( $_product->get_price() ) . '</span>'; */?></div> -->
              
              <?php $date = larula_get_product_start_date($_product);?>
              <?php if($date != null) : ?>
                <?php $date_object = DateTime::createFromFormat('Y-m-d', $date); ?>
                <div class="date">
                  <span class="label"><?php _e('Fecha :','larula')?></span>
                  <span class="date"><?php echo $date_object -> format('d/m/Y'); ?></span>
                  <span class="time"><?php echo larula_get_product_start_time($_product); ?></span>
                </div>
              <?php endif; ?>

              <!-- <div class="estimated-hours"><?php /*echo '<span class="label">' . __('Intensidad horaria :', 'larula') . '</span><span class="hours value">' . $_product -> estimated_hours . '</span>'; */?></div> -->
              <div class="maximun-seats"><?php echo '<span class="label">' . __('Cupos :', 'larula') . '</span><span class="seats value">' . $_product -> get_stock_quantity() . '/' . $_product -> maximun_seats . '</span>';?></div>
              <?php /*if (strcasecmp( $_product -> get_type(), 'variation' ) == 0) : */?>
                <!-- <div class="variation-description"><?php echo $_product -> get_description();?></div> -->
              <?php /*endif;*/ ?>
              <div class="parent-excerpt"><?php echo $_parent -> get_short_description();?></div>
              <!-- <div class="parent-description"><?php /*echo $_parent -> get_description();*/?></div> -->
              <div class="actions">
                <?php $options = get_option('larula_options'); ?>
                <?php if($options['hide_not_featured']) : ?>
                  <a class="button alt" href="http://localhost/larula/talleres/?id=post-<?php echo $_parent -> get_id()?>"><?php _e('Ver mas', 'larula');?></a>
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
          <div class="contact-form col-lg-4 col-md-12 col-sm-12">
            <?php echo do_shortcode('[contact-form-7 id="375" title="Preinscripcion" html_class="wpcf7-form preins-form"]');?>
          </div>
        <?php endif;?>
      <?php endif; ?>
    </div>
  </div>
</div>