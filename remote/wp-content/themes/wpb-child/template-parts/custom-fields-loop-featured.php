<?php 
  global $post;
  $_product = $post -> child_featured;
  $date = larula_get_product_start_date($_product);
  if($date != null) {
    $date_object = DateTime::createFromFormat('Y-m-d', $date);
    $_product -> taller_start_date_html = '<span class="woocommerce_taller_start_date_time"><span class="label">' . __('Fecha :','larula') . '</span>' .
      '<span class="date">' . $date_object -> format('d/m/Y') . '</span>' .
      '<span class="time">' . larula_get_product_start_time($_product) . '</span></span>';
  }
  else {
    $_product -> taller_start_date_html = '<span class="woocommerce_taller_start_date_time hidden"></span>';
  }
?>
<div class="woocommerce-variation single_variation">
  <div class="woocommerce-variation-price">
    <span class="woocommerce_price_html">
      <span class="price-label"><?php _e('Precio :','larula'); ?></span>
      <span class="price"><?php echo wc_price($_product -> get_price()); ?></span>
    </span>
  </div>  
  <div class="woocommerce-variation-hours">
    <span class="woocommerce_estimated_hours">
      <span class="label"><?php _e('Intensidad horaria :','larula'); ?></span>
		  <span><?php echo larula_get_product_estimated_hours($_product); ?></span>
    </span>
  </div>
  <div class="woocommerce-variation-seats">
    <span class="woocommerce_maximun_seats"><span class="label"><?php _e('Cupos :','larula'); ?></span>
      <span class="current_inventory"><?php echo $_product -> get_stock_quantity(); ?></span>
      <span class="separator">/</span>
      <span class="max_inventory"><?php echo larula_get_product_maximun_seats($_product); ?></span>
		</span>
  </div>
  <?php if($date != null) : ?>
    <?php $date_object = DateTime::createFromFormat('Y-m-d', $date);?>
    <div class="woocommerce-variation-time">
      <span class="woocommerce_taller_start_date_time">
        <span class="label"><?php _e('Fecha :','larula'); ?></span>
        <span class="date"><?php echo $date_object -> format('d/m/Y'); ?></span>
        <span class="time"><?php echo larula_get_product_start_time($_product); ?></span>
      </span>
    </div>
  <?php endif; ?>
</div>