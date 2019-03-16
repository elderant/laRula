<?php global $product;
  $variations = $larula_args -> variations;
  $slides_count = count($variations);
?>
<div class="row product-slider-section slider-container" data-slides="<?php echo $slides_count;?>">
  <?php $i = 0;?>
  <ul class="slides col-12">
    <?php foreach($variations as $variation) :?>
      <?php $additionalClass = '';?>
      <?php if($i == 0) :?>
        <?php $additionalClass = ' active';?>
      <?php elseif($i == 1) :?>
        <?php $additionalClass = ' right';?>
      <?php elseif($i == $slides_count - 1 && $slides_count > 2) :?>
        <?php $additionalClass = ' left';?>
      <?php endif;?>
      <?php 
        $parent_id = $variation -> get_parent_id();
        $parent = wc_get_product( $parent_id );
      ?>
      <li class="slide-container<?php echo $additionalClass;?>" data-page="<?php echo ++$i; ?>">
        <div class="row">
          <div class="thumnail-column col-6 col-md-6 col-sm-12">
            <?php echo $variation -> get_image();?>
          </div>
          <div class="info-column col-6 col-md-6 col-sm-12">
            <div class="name"><?php echo $variation -> get_name();?></div>
            <div class="price"><?php echo '<span class="label">' . __('Precio :', 'larula') . '</span><span class="price value">' . wc_price( $variation -> get_price()) . '</span>';?></div>
            <div class="estimated-hours"><?php echo '<span class="label">' . __('Intensidad horaria :', 'larula') . '</span><span class="hours value">'  . $variation -> estimated_hours . '</span>';?></div>
            <div class="maximun-seats"><?php echo '<span class="label">' . __('Cupos :', 'larula') . '</span><span class="seats value">'  . $variation -> get_stock_quantity() . '/' . $variation -> maximun_seats . '</span>';?></div>
            <div class="parent-excerpt"><?php echo $parent -> get_short_description();?></div>
            <div class="variation-description"><?php echo $variation -> get_description();?></div>
            <div class="actions">
              <a class="button alt" href="http://localhost/larula/talleres/#post-<?php echo $parent_id?>">Ver mas</a>
              <a class="button alt" href="http://localhost/larula/cart/?<?php 
                $url = 'add-to-cart=' . $parent_id . '&variation_id=' . $variation -> get_id();
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
      </li>
    <?php endforeach; ?>
  </ul>
  <div class="slider-ui">
    <div class="slider-paging">
      <?php for($i = 0; $i < $slides_count; $i++) :?>
        <?php $additionalClass = '';?>
        <?php if($i == 0) :?>
          <?php $additionalClass = ' active';?>
        <?php endif;?>
        <div class="page-container">
          <button class="page-button<?php echo $additionalClass?>" data-page="<?php echo $i + 1; ?>"></button>
        </div>
      <?php endfor; ?>
    </div>        
    <div class="slider-direction">
      <div class="direction-container left">
        <button class="direction-button left" data-direction="left">
          <i class="fa fa-angle-left"></i>
        </button>
      </div>
      <div class="direction-container right">
        <button class="direction-button right"  data-direction="right">
          <i class="fa fa-angle-right"></i>
        </button>
      </div>
    </div>
  </div>
</div>