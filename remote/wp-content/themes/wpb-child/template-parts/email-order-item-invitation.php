<?php global $wp_query;
  $_product = $larula_args[sizeof($larula_args) - 1]['product'];
  $_variation = $larula_args[sizeof($larula_args) - 1]['variation'];
  ?>
<div style='margin-bottom: 40px;'>
  <div style='color: #ffffff; 
        background-color: #2ac5f4;
        margin: 0;
        text-align: center; 
        text-shadow: 0 1px 0 black;' class="header-container">
    <h2 style='color: #ffffff; 
        font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; 
        text-align: center;
        font-size: 25px; 
        font-weight: 700; 
        line-height: 4;'><?php echo $_product -> get_name();?></h2>
  </div>
  <div style='color: black; 
        font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; 
        font-size: 1.1em;
        font-weight: 400; 
        line-height: 1.2; 
        margin: 30px 10%; 
        text-align: center;
        border-bottom: 3px solid #2ac5f4;' class="header-container">
    <p><?php echo larula_get_product_description($_product);?></p>
  </div>
  <div style='color: black; 
        font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; 
        font-size: 18px; 
        font-weight: 400; 
        line-height: 1.2;
        text-align: center;' class="header-container">
    <table>
      <tr>
        <td>
          <?php $url = larula_get_product_image_url($_product);?>
          <img style="max-width: 250px; margin-right: 0" src="<?php echo $url?>">
        </td>
        <td>
          <div>
            <div style="text-align: left;" class="date-container">
              <div style="color: #2ac5f4; font-weight: 700;" class="label">
                <?php _e('Fecha :', 'larula');?>
              </div>
              <div style="font-size: 0.8em; padding-top: 0.5em; padding-left: 0.5em;" class="value">
                <?php
                  $date = larula_get_product_start_date($_product);
                  if($date != null) : 
                    $date_object = DateTime::createFromFormat('Y-m-d', $date);?>
                  <span class="date"><?php echo $date_object -> format('d/m/Y'); ?></span>
                  <span class="time"><?php echo larula_get_product_start_time($_product) ?></span>
                <?php else:?>  
                  <span class="woocommerce_taller_start_date_time hidden"></span>
                <?php endif;?>
              </div>
            </div>
            <div style="padding-top: 2em; text-align: left;" class="location-container">
              <div style="color: #2ac5f4; font-weight: 700;" class="label">
                <?php _e('Lugar :', 'larula');?>
              </div>
              <div style="font-size: 0.8em;" class="value">
                <div style="padding-top: 0.5em; padding-left: 0.5em;">
                  <?php _e('Event location part 1', 'larula');?>
                </div>
                <div style="padding-top: 0.5em; padding-left: 0.5em;">
                  <?php _e('Event location part 2', 'larula');?>
                </div>
              </div>
            </div>
          </div>
        </td>
      </tr>
    </table>
  </div>
  <div style='color: #ffffff; 
        background-color: #2ac5f4;
        font-family: "Helvetica Neue", Helvetica, Roboto, Arial, sans-serif; 
        margin: 0; 
        text-align: center; 
        text-shadow: 0 1px 0 black;' class="header-container">
    <h3 style="color: #ffffff; 
        text-align: center; 
        line-height: 3;
        font-size: 20px; 
        font-weight: 700;"><?php echo _e('Te esperamos','larula');?></h2>
  </div>
<div>