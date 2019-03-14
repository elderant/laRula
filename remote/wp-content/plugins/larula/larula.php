<?php
/*
Plugin Name: La Rula
Description: Functions and modifications to match site requirements
Version:     1.0
Author:      Sebastian Guerrero
*/

// Script hooks.
add_action( 'wp_enqueue_scripts', 'larula_scripts' );
add_action( 'admin_enqueue_scripts', 'larula_admin_scripts' );

function larula_scripts () {
	wp_enqueue_script ( 'flor-js', plugins_url('/js/main.js', __FILE__), array('jquery'),  rand(111,9999), 'all' );
	wp_enqueue_style ( 'flor',  plugins_url('/css/main.css', __FILE__), array(),  rand(111,9999), 'all' );

	wp_localize_script( 'flor-js', 'ajax_params', array('ajax_url' => admin_url( 'admin-ajax.php' )));
}

function larula_admin_scripts () {
	wp_enqueue_script ( 'flor-js-admin', plugins_url('/js/admin.js', __FILE__), array('jquery'),  rand(111,9999), 'all' );
	wp_enqueue_style ( 'main-admin',  plugins_url('/css/admin.css', __FILE__), array(),  rand(111,9999), 'all' );

	wp_localize_script( 'flor-js-admin', 'ajax_params', array('ajax_url' => admin_url( 'admin-ajax.php' )));
}

/************************************************************/
/********************* Helper functions *********************/
/************************************************************/

function larula_load_template($template, $folder = '') {
	// first check if this is the page where you want to render your own template
	// if ( !is_page($the_page_you_want)) {
		// return $template;
	// }

	// get the actual file name, like single.php or page.php
	$filename = basename($template);
	if(!empty($folder) && strpos($folder, '/') !== 0) {
		$folder = '/' . $folder;
	}

	// build a path for the filename in a folder named for our plugin "fisherman" in the theme folder
	$custom_template = sprintf('%s/%s%s/%s', get_stylesheet_directory(), 'larula', $folder, $filename);

	// if the template is found, awesome! return it. that's what we'll use.
	if ( is_file($custom_template) ) {
		return $custom_template;
	}

	// otherwise, build a path for the filename in a folder named "templates" in our plugin folder
	$custom_template = larula_file_build_path(plugin_dir_path( __FILE__ ), 'templates', $folder, $filename);
	//$custom_template = sprintf('%stemplates%s/%s', plugin_dir_path( __FILE__ ), $folder, $filename);

	// found? return our plugin's default template
	if ( is_file($custom_template) ) {
		return $custom_template;
	}

	// otherwise, build a path for the filename in a folder named "templates" in our plugin folder
	$custom_template = sprintf('%stemplates/%s', plugin_dir_path( __FILE__ ), $filename);

	// found? return our plugin's default template
	if ( is_file($custom_template) ) {
		return $custom_template;
	}

	return $template;
}

function larula_file_build_path($plugin, $template_folder, $folder, $filename) {
  return $plugin . DIRECTORY_SEPARATOR .
          $template_folder . DIRECTORY_SEPARATOR .
          $folder . DIRECTORY_SEPARATOR .
          $filename;
}

function larula_is_variation_time_available($date, $time) {
  $timeString = str_replace ( '-' , ':', $date) . ' ' . $time . ':00';
  $date = new DateTime($timeString);
  $milliseconds = $date -> getTimestamp() - (new DateTime()) -> getTimestamp();

  return $milliseconds > 0 ? TRUE : FALSE;
}

/************************************************************/
/*********************** Admin functions ********************/
/************************************************************/

function larula_taller_settings_fields( $loop, $variation_data, $variation ) {
  // Intensidad horaria
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_estimated_hours[' . $variation->ID . ']', 
			'label'       => __( 'Intensidad horaria', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Número de horas que toma el taller', 'larula' ),
      'value'       => get_post_meta( $variation->ID, '_estimated_hours', true ),
      'type'        => 'number',
			'custom_attributes' => array(
        'step' 	=> 'any',
        'min'	=> '0'
      ) 
		)
  );

  // Maximo participantes
  woocommerce_wp_text_input( 
		array( 
			'id'          => '_maximun_seats[' . $variation->ID . ']', 
			'label'       => __( 'Máximo participantes', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Número máximo de participantes en el taller', 'larula' ),
      'value'       => get_post_meta( $variation->ID, '_maximun_seats', true ),
      'type'        => 'number',
			'custom_attributes' => array(
        'step' 	=> 'any',
        'min'	=> '0'
      )
		)
  );

  // Fecha del evento
  woocommerce_wp_text_input(
    array( 
			'id'          => '_taller_start_date[' . $variation->ID . ']', 
			'label'       => __( 'Fecha del taller', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Fecha del inicio del taller', 'larula' ),
      'value'       => get_post_meta( $variation->ID, '_taller_start_date', true ),
      'type'        => 'date',
			'custom_attributes' => array(
        'value' 	=> date('Y-m-d'),
        'min'	=> date('Y-m-d'),
        'max' => '',
      )
		)
  );

  // Hora del evento
  woocommerce_wp_text_input(
    array( 
			'id'          => '_taller_start_hour[' . $variation->ID . ']', 
			'label'       => __( 'Hora del taller', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Hora de inicio del taller', 'larula' ),
      'value'       => get_post_meta( $variation->ID, '_taller_start_hour', true ),
      'type'        => 'time',
			'custom_attributes' => array(
        'step' => '900',
      )
		)
  );
}
// Add Variation Settings
add_action( 'woocommerce_product_after_variable_attributes', 'larula_taller_settings_fields', 10, 3 );

/**
 * Save new fields for variations
*/
function larula_save_variation_settings_fields( $post_id ) {
	// Intensidad horaria
	$estimated_hours = $_POST['_estimated_hours'][ $post_id ];
	if( ! empty( $estimated_hours ) ) {
		update_post_meta( $post_id, '_estimated_hours', esc_attr( $estimated_hours ) );
  }
  
  // Maximo participantes
	$maximun_seats = $_POST['_maximun_seats'][ $post_id ];
	if( ! empty( $maximun_seats ) ) {
		update_post_meta( $post_id, '_maximun_seats', esc_attr( $maximun_seats ) );
  }
  
  // Fecha del evento
	$taller_start_date = $_POST['_taller_start_date'][ $post_id ];
	if( ! empty( $taller_start_date ) ) {
		update_post_meta( $post_id, '_taller_start_date', esc_attr( $taller_start_date ) );
  }
  
  // Hora del evento
	$taller_start_hour = $_POST['_taller_start_hour'][ $post_id ];
	if( ! empty( $taller_start_hour ) ) {
		update_post_meta( $post_id, '_taller_start_hour', esc_attr( $taller_start_hour ) );
	}
}
// Save Variation Settings
add_action( 'woocommerce_save_product_variation', 'larula_save_variation_settings_fields', 10, 1 );

/************************************************************/
/************************ Home functions ********************/
/************************************************************/

function larula_build_featured_course_banner () {
  global $wp_query;
  
  $query_args  = array(
    'post_type' => array('product_variation'),
    'posts_per_page' => 10,
    'orderby' => 'modified',
    'post_status' => 'publish',
  );
  $recent_products = new WP_Query( $query_args );

  $index = 0;
  $lowest_date;
  $best = 0;
  foreach($recent_products->posts as $_product) {
    $date = get_post_meta($_product->ID, '_taller_start_date', true );
    $time = get_post_meta($_product->ID, '_taller_start_hour', true );

    $timeString = str_replace ( '-' , ':', $date) . ' ' . $time . ':00';
    $dateTime = new DateTime($timeString);

    if(!larula_is_variation_time_available($date,$time)) {
      continue;
    }

    if( $index == 0 ) {
      $lowest_date = $dateTime;
    }
    else {
      if($dateTime < $lowest_date) {
        $lowest_date = $dateTime;
        $best = $index;
      }
    }
    $index++;
  }

  if(FALSE === wp_cache_get( 'featured_event' )) {
		wp_cache_add( 'featured_event', array() );
	}
	else {
		wp_cache_set( 'featured_event', array() );
  }
  $variation = wc_get_product( $recent_products -> posts[$best]->ID );
  $parent_id = $variation -> get_parent_id();
  wp_cache_set( 'featured_event', array($parent_id) );

  $recent_products -> posts[$best] -> date = $lowest_date;
  $recent_products -> posts[$best] -> until_event = (new DateTime()) -> diff($lowest_date);
  $recent_products -> posts[$best] -> milliseconds = $lowest_date -> getTimestamp() - (new DateTime()) -> getTimestamp();
  $recent_products -> posts[$best] -> maximun_seats = get_post_meta($recent_products -> posts[$best]-> ID, '_maximun_seats', true );
  $recent_products -> posts[$best] -> estimated_hours = get_post_meta($recent_products -> posts[$best]-> ID, '_estimated_hours', true );

  $wp_query -> query_vars['larula_args'] = (object)[];
  $wp_query -> query_vars['larula_args'] -> product = $recent_products -> posts[$best];

  ob_start ();
	$template_url = larula_load_template('featured-banner.php', 'home');
	load_template($template_url, true);
  $body_html = ob_get_clean();
  
  return $body_html;
}
add_shortcode( 'larula_home_banner', 'larula_build_featured_course_banner' );


function larula_build_home_product_slider () {
  global $wp_query;

  $featured_event = wp_cache_get( 'featured_event' );

  $query_args  = array(
    'post_type' => 'product',
    'posts_per_page' => 5,
    'post__not_in' => $featured_event,
    'fields' => 'ids',
  );
  $product_query = new WP_Query( $query_args );

  // error_log('query vars : ' . print_r($wp_query -> query_vars,1));
  $wp_query -> query_vars['larula_args'] -> variations = array();
  foreach($product_query -> posts as $id) {
    $_product = wc_get_product($id); 
    $variations = $_product -> get_available_variations();

    $next_variation = array();
    foreach($variations as $_variation_object) {
      $_variation = wc_get_product($_variation_object['variation_id']);

      if(!$_variation -> variation_is_active()) {
        continue;
      }
      if(!$_variation -> is_in_stock()) {
        continue;
      }
      $_variation -> date = get_post_meta($_variation->get_id(), '_taller_start_date', true );
      $_variation -> time = get_post_meta($_variation->get_id(), '_taller_start_hour', true );

      if(!larula_is_variation_time_available($_variation -> date, $_variation -> time)) {
        continue;
      }

      $timeString = str_replace ( '-' , ':', $_variation -> date) . ' ' . $_variation -> time . ':00';
      $date = new DateTime($timeString);

      $_variation -> date = $date;
      $_variation -> milliseconds = $date -> getTimestamp();

      if(!empty($next_variation)) {
        $interval = $next_variation -> milliseconds - $_variation -> milliseconds;
        
        if($interval < 0) {
          continue;
        }
      }

      $_variation -> maximun_seats = get_post_meta($_variation->get_id(), '_maximun_seats', true );
      $_variation -> estimated_hours = get_post_meta($_variation->get_id(), '_estimated_hours', true );

      $next_variation = $_variation;
    }

    array_push($wp_query -> query_vars['larula_args'] -> variations, $next_variation);
  }

  error_log(print_r($wp_query -> query_vars['larula_args'] -> variations,1));
  ob_start();
	$template_url = larula_load_template('product-slider.php', 'home');
	load_template($template_url, true);
  $body_html = ob_get_clean();
  
  return $body_html;
}
add_shortcode( 'larula_home_products_slider', 'larula_build_home_product_slider' );

