<?php

//Admin Menu Hooks
add_action( 'admin_menu', 'larula_action_admin_menu' );


function larula_action_admin_menu() {
	add_options_page( 'La Rula Configurations', 'La Rula Configurations', 'manage_options', 'larula_admin_options_page', 'larula_admin_page' );
}

function larula_admin_page(){
  get_template_part('template-parts/larula', 'admin');
}

add_action('admin_init', 'larula_admin_init');
function larula_admin_init(){
	register_setting( 'larula_options', 'larula_options', 'larula_options_validate' );
  
  add_settings_section('products_section', 'Featured Products Settings', 'larula_products_text', 'larula');
	add_settings_field('products_hide_not_featured', 'Hide all products purchase except the featured ones', 'larula_hide_not_featured', 'larula', 'products_section');
}

function larula_products_text() {
	//echo "<h2></h2>";
}

function larula_hide_not_featured() {
  $options = get_option('larula_options');
  $html = '<input type="checkbox" id="product-hide-not-featured" name="larula_options[hide_not_featured]" value="1"' . checked( 1, $options['hide_not_featured'], false ) . '/>';
  echo $html;
}

function larula_options_validate($input) {

	return $input;
}