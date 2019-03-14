<?php global $product;
  $variations = $larula_args -> variations;
  $slides_count = count($variations);
?>
<div class="product-slider-section slider-container" data-slides="<?php echo $slides_count;?>">
  <?php $i = 0;?>
  <ul class="slides">
    <?php foreach($variations as $variation) :?>
      <?php $additionalClass = '';?>
      <?php if($i == 0) :?>
        <?php $additionalClass = ' active';?>
      <?php elseif($i == 1) :?>
        <?php $additionalClass = ' right';?>
      <?php elseif($i == $slides_count - 1 && $slides_count > 2) :?>
        <?php $additionalClass = ' left';?>
      <?php endif;?>
      <li class="slide-container<?php echo $additionalClass;?>" data-page="<?php echo ++$i; ?>">
        <?php echo $variation -> get_image();?>
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