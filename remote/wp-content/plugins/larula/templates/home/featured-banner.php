<?php global $product;
  $_object = $larula_args -> product;
  $variation = wc_get_product( $_object->ID );
  $parent_id = $variation -> get_parent_id();
  $parent = wc_get_product( $parent_id );
  
  $product = $parent;
?>
<div class="main-banner-section">
    <div class="banner">
      <?php echo $variation -> get_image(); ?>
      <span class="countdown" milliseconds="<? echo $_object -> milliseconds;?>"> 
        <?php echo $_object -> until_event -> format('%a dias %h horas %i minutos %s segundos'); ?>
      </span>
    </div>
    <div class="additional-info overlay hidden">
      <div class="additional-info-container">
        <div class="name"><?php echo $variation -> get_name();?></div>
        <div class="price"><?php echo 'precio : ' . wc_price( $variation->get_price() );?></div>
        <div class="estimated-hours"><?php echo 'Intensidad horaria : ' . $_object -> estimated_hours;?></div>
        <div class="maximun-seats"><?php echo 'cupos : ' . $variation -> get_stock_quantity() . '/' . $_object -> maximun_seats . '<span style="color:red; padding-left:0.5rem; font-weight:bold;">SE DEBEN MOSTRAR LAS QUE NO TENGAN CUPOS?</span>';?></div>
        <div class="variation-description"><?php echo $variation -> get_description();?></div>
        <div class="parent-excerpt"><?php echo $parent -> get_short_description();?></div>
        <div class="parent-description"><?php echo $parent -> get_description();?></div>
        <div class="actions">
          <a class="button alt" href="http://localhost/larula/talleres/#post-<?php echo $parent_id?>">Ver mas</a>
          <?php woocommerce_template_loop_add_to_cart(); ?>
        </div>
      </div>
    </div>
  </div>