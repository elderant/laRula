<?php 

include( '/inc/admin/admin.php' );

add_action( 'wp_enqueue_scripts', 'wpb_child_enqueue_styles' );
function wpb_child_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('wpb-child-main', get_stylesheet_directory_uri() . '/inc/assets/js/main.js', array(), '', true );
} 

/******************** Reorder shop product display ********************/
add_action( 'woocommerce_before_shop_loop_item', 'larula_wc_template_loop_product_row_open', 4 );
add_action( 'woocommerce_before_shop_loop_item', 'larula_wc_template_loop_product_column_open', 5 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_action( 'woocommerce_before_shop_loop_item_title', 'larula_wc_template_loop_product_column_close', 16 );

add_action( 'woocommerce_shop_loop_item_title', 'larula_wc_template_loop_product_column_open', 4 );
//add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );

add_action( 'woocommerce_after_shop_loop_item_title', 'larula_wc_template_loop_product_excerpt', 15 );

remove_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_column_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

$options = get_option('larula_options');
if($options['hide_not_featured']) {
	add_action( 'woocommerce_after_shop_loop_item', 'larula_template_loop_preins_form', 11 );
	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_single_add_to_cart', 11);
}
else {
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_add_to_cart', 11 );
	remove_action('woocommerce_after_shop_loop_item', 'larula_template_loop_preins_form', 11);
}


add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_column_close', 15 );
add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_row_close', 16 );


function larula_wc_template_loop_product_row_open() {
	echo '<div class="row">';
}

function larula_wc_template_loop_product_row_close() {
	echo '</div>';
}

function larula_wc_template_loop_product_column_open() {
	echo '<div class="col-md-6 col-sm-12">';
}

function larula_wc_template_loop_product_column_close() {
	echo '</div>';
}

function larula_wc_template_loop_product_excerpt() {
	$short_description = apply_filters( 'woocommerce_short_description', get_the_excerpt() );

	if ( !empty($short_description) ) {
		echo '<div class="description">' . $short_description . '</div>';
	}
	else {
		global $product;

		$description = $product -> get_description();
		echo '<div class="description">' . $description . '</div>';
	}
}

function larula_wc_change_cart_form_action($permalink) {
	global $wp;

	if(strcasecmp($wp->request, 'talleres') == 0 ) {
		return get_permalink( wc_get_page_id( 'shop' ) );
	}
	return $permalink;
}
add_filter( 'woocommerce_add_to_cart_form_action', 'larula_wc_change_cart_form_action', 10, 1 );

function larula_template_loop_preins_form() {
	echo do_shortcode('[contact-form-7 id="375" title="Preinscripcion" html_class="wpcf7-form preins-form"]');
}

/******************** Reorder single page product display ********************/
add_action( 'woocommerce_before_single_product', 'larula_wc_show_product_category', 5 );

add_action( 'woocommerce_before_single_product_summary', 'larula_wc_template_loop_product_row_open', 4 );
add_action( 'woocommerce_before_single_product_summary', 'larula_wc_template_loop_product_column_open', 5 );
add_action( 'woocommerce_before_single_product_summary', 'larula_wc_template_loop_product_column_close', 25 );
add_action( 'woocommerce_before_single_product_summary', 'larula_wc_template_loop_product_column_open', 30 );

add_action( 'woocommerce_after_single_product_summary', 'larula_wc_template_loop_product_column_close', 0 );
add_action( 'woocommerce_after_single_product_summary', 'larula_wc_template_loop_product_row_close', 1 );


function larula_wc_show_product_category() {
	global $product;
	echo wc_get_product_category_list( $product->get_id(), ' ', '<div class="posted_in product-title col-12">', '</div>' );
}

/******************** Page footer ********************/

function larula_get_page_footer_html() {
	get_template_part('template-parts/footer', 'page');
}

/******************** Cart/Checkout ********************/

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

function larula_cart_on_checkout_page_only() { 
	if ( is_wc_endpoint_url( 'order-received' ) ) return;
	echo do_shortcode('[woocommerce_cart]');
}

add_action( 'woocommerce_before_checkout_form', 'larula_cart_on_checkout_page_only', 5 );


function larula_redirect_empty_cart_checkout_to_home() {
	if ( is_cart() && is_checkout() && 0 == WC() -> cart -> get_cart_contents_count() && ! is_wc_endpoint_url( 'order-pay' ) && ! is_wc_endpoint_url( 'order-received' ) ) {
		wp_safe_redirect( home_url() );
		exit;
	}
}
add_action( 'template_redirect', 'larula_redirect_empty_cart_checkout_to_home' );

function larula_checkout_billing_fields_customization( $address_fields ) {
	unset($address_fields['billing_company']);
	$address_fields['billing_country']['required'] = false;
	unset($address_fields['billing_country']);
	$address_fields['billing_address_1']['required'] = false;
	unset($address_fields['billing_address_1']);
	unset($address_fields['billing_address_2']);
	$address_fields['billing_city']['required'] = false;
	unset($address_fields['billing_city']);
	$address_fields['billing_state']['required'] = false;
	unset($address_fields['billing_state']);
	unset($address_fields['billing_postcode']);

	return $address_fields;
}
add_filter( 'woocommerce_billing_fields', 'larula_checkout_billing_fields_customization', 10, 1 );


function larula_wpcf7_contact_form( $instance ) { 
	if($instance -> id() == 375 && !is_admin()) {
		if(is_shop()) {
			global $product;
			$porperties = $instance -> get_properties();
		
			$porperties['form'] = str_replace('DefaultValue', $product->get_name(), $porperties['form']);
			$instance -> set_properties($porperties);
		}
		else {
			$_product = larula_get_featured_product();
			$porperties = $instance -> get_properties();
		
			$porperties['form'] = str_replace('DefaultValue', $_product->get_name(), $porperties['form']);
			$instance -> set_properties($porperties);
		}
	}
}; 
			 
// add the action 
add_action( 'wpcf7_contact_form', 'larula_wpcf7_contact_form', 10, 1 ); 