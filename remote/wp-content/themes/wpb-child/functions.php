<?php 

add_action( 'wp_enqueue_scripts', 'wpb_child_enqueue_styles' );
function wpb_child_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	// wp_enqueue_script('wpb-child-main', get_stylesheet_directory_uri() . '/inc/assets/js/main.js', array(), '', true );
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
add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_single_add_to_cart', 11 );
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