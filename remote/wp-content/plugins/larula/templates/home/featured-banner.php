<?php
  $variation = $larula_args -> variation;
  $parent = $larula_args -> parent_product;
?>
<div class="main-banner-section">
    <div class="banner">
      <?php echo $variation -> get_image(); ?>
      <span class="countdown" milliseconds="<? echo $variation -> milliseconds;?>"> 
        <?php echo $variation -> until_event -> format('%a dias %h horas %i minutos %s segundos'); ?>
      </span>
    </div>
    <div class="additional-info overlay hidden">
      <div class="additional-info-container">
        <div class="name"><?php echo $variation -> get_name();?></div>
        <div class="price"><?php echo '<span class="label">' . __('Precio :','larula') . '</span><span class="price value">' . wc_price( $variation->get_price() ) . '</span>';?></div>
        <div class="estimated-hours"><?php echo '<span class="label">' . __('Intensidad horaria :', 'larula') . '</span><span class="hours value">' . $variation -> estimated_hours . '</span>';?></div>
        <div class="maximun-seats"><?php echo '<span class="label">' . __('Cupos :', 'larula') . '</span><span class="seats value">' . $variation -> get_stock_quantity() . '/' . $variation -> maximun_seats . '</span>' . '<span style="color:red; padding-left:0.5rem; font-weight:bold;">SE DEBEN MOSTRAR LAS QUE NO TENGAN CUPOS?</span>';?></div>
        <div class="variation-description"><?php echo $variation -> get_description();?></div>
        <div class="parent-excerpt"><?php echo $parent -> get_short_description();?></div>
        <div class="parent-description"><?php echo $parent -> get_description();?></div>
        <div class="actions">
          <a class="button alt" href="http://localhost/larula/talleres/#post-<?php echo $parent -> get_id()?>"><?php _e('Ver mas', 'larula');?></a>
          <a class="button alt" href="http://localhost/larula/checkout/?<?php 
            $url = 'add-to-cart=' . $parent -> get_id() . '&variation_id=' . $variation -> get_id();
            $attribures = $variation -> get_attributes();
            foreach ($attribures as $key => $value) {
              $value = utf8_uri_encode( $value );
              $value = str_replace('/', '%2F', $value);
              $url .= '&attribute_pa_' . $key . '=' . $value;
            }
            echo $url;
          ?>"><?php _e('Comprar', 'larula');?></a>
        </div>
      </div>
    </div>
  </div>