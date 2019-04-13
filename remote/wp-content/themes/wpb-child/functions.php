<?php 

include( '/inc/admin/admin.php' );

add_action( 'wp_enqueue_scripts', 'wpb_child_enqueue_styles' );
function wpb_child_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script('wpb-child-main', get_stylesheet_directory_uri() . '/inc/assets/js/main.js', array(), '', true );
} 

/******************** General ********************/
function larula_post_background_title() {
	$id = get_queried_object_id();
	$background_title = get_field( 'background_title', $id );
	return $background_title;
}


/******************** shop display ********************/
//page title
add_filter('woocommerce_show_page_title', function() {
	echo '<div class="row">' .
		'<h1 class="col-12 larula-background-title" data-highlight="Talleres">' .
			'<span>' .
				'Mira' .
				'<span class="acent-color"> Nuestros </span>' .
				'Talleres' .
			'</span>' .
		'</h1>' .
	'</div>';
	return false;
});
//add_action('woocommerce_archive_description')

// product display
add_action( 'woocommerce_before_shop_loop_item', 'larula_wc_template_loop_product_row_open', 4 );
add_action( 'woocommerce_before_shop_loop_item', 'larula_wc_template_loop_product_image_column_open', 5 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

//add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );
add_action( 'woocommerce_before_shop_loop_item_title', 'larula_wc_template_loop_product_column_close', 16 );

add_action( 'woocommerce_shop_loop_item_title', 'larula_wc_template_loop_product_content_column_open', 4 );
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
add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_column_open', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_date', 25 );
add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_column_close', 40 );
add_action( 'woocommerce_after_shop_loop_item', 'larula_wc_template_loop_product_row_close', 41 );

add_action('woocommerce_before_shop_loop', 'larula_wc_template_loop_product_row_filters_open', 10); 
add_action('woocommerce_before_shop_loop', 'larula_wc_template_loop_product_row_filters_close', 50);

function larula_wc_template_loop_product_row_open() {
	echo '<div class="row">';
}

function larula_wc_template_loop_product_row_close() {
	echo '</div>';
}

function larula_wc_template_loop_product_row_filters_open() {
	echo '<div class="row filters-row">';
}

function larula_wc_template_loop_product_row_filters_close() {
	echo '</div>';
}

function larula_wc_template_loop_product_column_open() {
	echo '<div class="col-md-1 col-sm-12 product-date-container">';
}

function larula_wc_template_loop_product_content_column_open() {
	echo '<div class="col-md-7 col-sm-12 product-info">';
}

function larula_wc_template_loop_product_image_column_open() {
	echo '<div class="col-md-4 col-sm-12 product-image">';
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

function larula_add_featured_product_html() {
	$options = get_option('larula_options');
	if($options['hide_not_featured']) {
		$_product = larula_get_featured_product();
		global $post, $product;
		$post = get_post($_product -> parent_object -> get_id());
		
		setup_postdata($post);
		$product = $_product;
		$post -> child_featured = $_product;
		do_action( 'woocommerce_shop_loop' );
		
		//Title
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		add_action( 'woocommerce_shop_loop_item_title', 'larula_loop_featured_product_title', 10 );
		//Price
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		//Add to cart
		remove_action( 'woocommerce_after_shop_loop_item', 'larula_template_loop_preins_form', 11 );
		add_action( 'woocommerce_after_shop_loop_item', 'larula_template_loop_featured_add_to_cart', 11 );
		//Extended description
		add_action( 'woocommerce_after_shop_loop_item_title', 'larula_template_loop_featured_extended_description', 15 );
		//Custom fields
		add_action( 'woocommerce_after_shop_loop_item_title', 'larula_template_loop_featured_cutom_fields', 20 );

		//Print template
		wc_get_template_part( 'content', 'product' );

		//Title
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'larula_loop_featured_product_title', 10 );
		//Price
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		//Add to cart
		add_action( 'woocommerce_after_shop_loop_item', 'larula_template_loop_preins_form', 11 );
		remove_action( 'woocommerce_after_shop_loop_item', 'larula_template_loop_featured_add_to_cart', 11 );
		//Extended description
		remove_action( 'woocommerce_after_shop_loop_item_title', 'larula_template_loop_featured_extended_description', 15 );
		//Custom fields
		remove_action( 'woocommerce_after_shop_loop_item_title', 'larula_template_loop_featured_cutom_fields', 20 );
	}
}
add_action('woocommerce_before_shop_loop', 'larula_add_featured_product_html', 5);

function larula_loop_featured_product_title() {
	global $post;
	echo '<h2 class="woocommerce-loop-product__title">' . $post -> child_featured -> get_name() . '</h2>';
}

function larula_template_loop_featured_extended_description() {
	global $post;
	$_product = $post -> child_featured;

	echo '<div class="woocommerce-product-details__long-description">';
	the_content();
	echo '</div>';
	echo '<div class="variation-description">' . $_product -> get_description() . '</div>';
}

function larula_template_loop_featured_cutom_fields() {
	get_template_part('template-parts/custom-fields', 'loop-featured');
}

/* replace default value for the name of the taller */
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
}
add_action( 'wpcf7_contact_form', 'larula_wpcf7_contact_form', 10, 1 ); 

function larula_template_loop_featured_add_to_cart() {
	global $product, $post;
	$_product = $post -> child_featured;

	if (strcasecmp( $product -> get_type(), 'variation' ) == 0) {
		$_product -> button_html = '<a class="button alt" href="http://localhost/larula/checkout/?';
		
		$url = 'add-to-cart=' . $_product -> parent_object -> get_id() . '&variation_id=' . $_product -> get_id();
		$attribures = $_product -> get_attributes();
		foreach ($attribures as $key => $value) {
			$value = utf8_uri_encode( $value );
			$value = str_replace('/', '%2F', $value);
			$url .= '&attribute_pa_' . $key . '=' . $value;
		}

		$_product -> button_html .= $url . '">' . __('Comprar', 'larula') . '</a>';
	}
	else {
		$_product -> button_html = '<a class="button alt" href="http://localhost/larula/checkout/?';
		$url = 'add-to-cart=' . $_product -> parent_object -> get_id() . '&variation_id=' . $_product -> get_id();
		$_product -> button_html .= $url . '">' . __('Comprar', 'larula') . '</a>';
	}

	echo '<div class="woocommerce-actions">' . $_product -> button_html . '</div>';
} 

function larula_wc_template_loop_product_date () {
	global $product;
	
	$date_info = larula_get_next_event_date($product);

	$date = $date_info -> date;
	$time = $date_info -> time;
	$label = $date_info -> label;
	$label_html = empty($label) ? '' : '<div class="product-detail product-date-label uppercase">' . $date_info -> label . '</div>';
  if($date != null) {
    $date_object = DateTime::createFromFormat('Y-m-d', $date);
		$html = '<div class="woocommerce-product-details__date">' .
			$label_html .
			'<div class="detail-group-container date">' . 
				'<div class="product-detail product-date bold">' . $date_object -> format('d/m') . '</div>' .
				'<div class="product-detail product-date-year">' . $date_object -> format('Y') . '</div>' .
			'</div>' .
			'<div class="detail-group-container time">' . 
				'<div class="product-detail product-time-label bold">Hora</div>' .
				'<div class="product-detail product-time">' . $time . '</div>' .
			'</div>' .
		'</div>';
  }
  else {
    $html = '<div class="woocommerce-product-details__date hidden"></div>';
	}

	echo $html;
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
	echo wc_get_product_category_list( $product -> get_id(), ' ', '<div class="posted_in product-title col-12">', '</div>' );
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


function larula_redirect_empty_cart_checkout_to_home () {
	if ( is_cart() && 
			is_checkout() && 
			0 == WC() -> cart -> get_cart_contents_count() && 
			! is_wc_endpoint_url( 'order-pay' ) && 
			! is_wc_endpoint_url( 'order-received' ) ) {
		//error_log(print_r(wc_get_notices(),1));

		wc_add_notice('El carrito esta vacio', 'success');
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


/******************** Blog ********************/
// define the the_content_more_link callback 
function filter_the_content_more_link( $link, $link_text ) { 
	// 
	
	$read_more_link = new DOMDocument('1.0', 'utf-8');
	$read_more_link -> loadHTML(utf8_decode($link));
	$link_list = $read_more_link -> getElementsByTagName('a');

	$new_link = $link_list->item(0);

	while ($new_link->hasChildNodes()) {
    $new_link->removeChild($new_link -> firstChild);
  }

	$image = $read_more_link -> createElement('i');
	$image -> setAttribute('class', 'fas fa-chevron-right');
	$new_link->appendChild($image);

	$text = $read_more_link -> createElement('span', __( 'Continue reading' ) );
	$new_link->appendChild($text);
	
	return $new_link->C14N(); 
}; 
			 
// add the filter 
add_filter( 'the_content_more_link', 'filter_the_content_more_link', 10, 2 ); 

/******************** Emails ********************/

function larula_get_events_html($order) {
	global $wp_query;
	$wp_query -> query_vars['larula_args'] = array();

	$items = $order->get_items();
	foreach ( $items as $item_id => $item )  {
		$product_id = $item -> get_product_id();
		$product_variation_id = $item -> get_variation_id();

		$_product = wc_get_product($product_id);
		$_variation = wc_get_product($product_variation_id);
		
		array_push($wp_query -> query_vars['larula_args'], array('product' => $_product, 'variation' => $_variation));
		get_template_part('template-parts/email-order', 'item-invitation');
	}
}
