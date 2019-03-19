<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

// echo wc_get_stock_html( $product ); // WPCS: XSS ok.
?>
<div class="custom-information">
<?php 
	$hours = larula_get_product_estimated_hours($product);
	if($hours != null) :
?>
	<div class="woocommerce-product-hours">
		<span class="woocommerce_estimated_hours">
			<span class="label"><?php _e('Intensidad horaria :','larula'); ?></span>
			<span><?php echo $hours; ?></span>
		</span>
	</div>
<?php endif;?>
<?php 
	$seats = larula_get_product_maximun_seats($product);
	if($seats != null) :
?>
	<div class="woocommerce-variation-seats">
		<span class="woocommerce_maximun_seats">
			<span class="label"><?php _e('Cupos :','larula'); ?></span>
			<span class="current_inventory"><?php echo $product -> get_stock_quantity(); ?></span>
			<span class="separator">/</span>
			<span class="max_inventory"><?php echo $seats; ?></span>
		</span>
	</div>
<?php endif;?>
<?php 
	$date = larula_get_product_start_date($product);
	$time = larula_get_product_start_time($product);
	if($date != null && $time != null) :
?>
	<div class="woocommerce-variation-time">
		<span class="woocommerce_taller_start_date_time">
			<?php $date_object = DateTime::createFromFormat('Y-m-d', $date);?>
			<span class="label"><?php _e('Fecha :','larula'); ?></span>
			<span class="date"><?php echo $date_object -> format('d/m/Y'); ?></span>
			<span class="time"><?php echo $time; ?></span>
		</span>
	</div>
<?php endif;
echo '</div>';

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		) );

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
