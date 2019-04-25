<?php global $product;
  $variations = $larula_args -> variations;
  $slides_count = count($variations);
?>
<div class="product-slider-section slider-container simple col-12" data-slides="<?php echo $slides_count;?>">
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
        if(strcasecmp($variation -> get_type(), 'variation') == 0 ) {
          $parent_id = $variation -> get_parent_id();
          $parent = wc_get_product( $parent_id );
        }
        else {
          $parent_id = $variation -> get_id();
          $parent = $variation;
        }
      ?>
      <li class="slide-container<?php echo $additionalClass;?>" data-page="<?php echo ++$i; ?>">
        <div class="row">
          <a href="/talleres/?id=post-<?php echo $parent_id?>">
            <div class="info-container col-12">
              <div class="name"><?php echo $variation -> get_name();?></div>
            </div>  
            <div class="thumnail-container col-12 ">
              <?php echo $variation -> get_image();?>
            </div>
          </a>
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