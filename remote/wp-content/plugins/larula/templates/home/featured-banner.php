<?php
  $product = $larula_args -> product;
?>
<div class="banner-content">
  <div class="row">
    <div class="taller-image">
      <?php $image = get_field( 'featured_banner_image', $larula_args -> parent_product -> get_id() );?> 
      <img  class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" 
            src="<?php echo $image;?>"
            alt="banner image">
    </div>
    <div class="taller-info offset-lg-6 offset-sm-0 col-lg-6 col-sm-12 justify-content-start">
      <div class="taller-info-container">
        <?php echo do_shortcode('[contact-form-7 id="375" title="Preinscripcion" html_class="wpcf7-form preins-form"]');?>
      </div>
    </div>
  </div>
</div>