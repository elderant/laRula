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

function larula_is_product_time_available($date, $time) {
  $timeString = str_replace ( '-' , ':', $date) . ' ' . $time . ':00';
  $date = new DateTime($timeString, new DateTimeZone("America/Bogota"));
  $milliseconds = $date -> getTimestamp() - (new DateTime('now', new DateTimeZone("America/Bogota"))) -> getTimestamp();

  return $milliseconds > 0 ? true : false;
}

function larula_get_product_estimated_hours($product) {
	if($product instanceof WC_Product) {
		$id = $product -> get_id();
		$parent_id = $product -> get_parent_id();
		$type = $product -> get_type();
	}
	else {
		$id = $product -> ID;
		$parent_id = $product -> post_parent;
		$type = $product -> post_type;
	}
	
	$hours = get_post_meta($id, '_estimated_hours', true );
	if(!empty($hours)) {
		return $hours;
	}
	if(strcasecmp($type, 'variation') == 0 || strcasecmp($type, 'product_variation') == 0) {
		$hours = get_post_meta($parent_id, '_estimated_hours', true );
		if(!empty($hours)) {
			return $hours;
		}
	}
	
	return null;
}

function larula_get_product_maximun_seats($product) {
	if($product instanceof WC_Product) {
		$id = $product -> get_id();
		$parent_id = $product -> get_parent_id();
		$type = $product -> get_type();
	}
	else {
		$id = $product -> ID;
		$parent_id = $product -> post_parent;
		$type = $product -> post_type;
	}
	
	$seats = get_post_meta($id, '_maximun_seats', true );
	if(!empty($seats)) {
		return $seats;
	}
	if(strcasecmp($type, 'variation') == 0 || strcasecmp($type, 'product_variation') == 0) {
		$seats = get_post_meta($parent_id, '_maximun_seats', true );
		if(!empty($seats)) {
			return $seats;
		}
	}
	
	return null;
}

function larula_get_product_start_date($product) {
	if($product instanceof WC_Product) {
		$id = $product -> get_id();
		$parent_id = $product -> get_parent_id();
		$type = $product -> get_type();
	}
	else {
		$id = $product -> ID;
		$parent_id = $product -> post_parent;
		$type = $product -> post_type;
	}
	
	$date = get_post_meta($id, '_taller_start_date', true );
	if(!empty($date)) {
		return $date;
	}
	if(strcasecmp($type, 'variation') == 0 || strcasecmp($type, 'product_variation') == 0) {
		$date = get_post_meta($parent_id, '_taller_start_date', true );
		if(!empty($date)) {
			return $date;
		}
	}
	
	return null;
}

function larula_get_product_start_time($product) {
	if($product instanceof WC_Product) {
		$id = $product -> get_id();
		$parent_id = $product -> get_parent_id();
		$type = $product -> get_type();
	}
	else {
		$id = $product -> ID;
		$parent_id = $product -> post_parent;
		$type = $product -> post_type;
	}
	
	$time = get_post_meta($id, '_taller_start_hour', true );
	if(!empty($time)) {
		return $time;
	}
	if(strcasecmp($type, 'variation') == 0 || strcasecmp($type, 'product_variation') == 0) {
		$time = get_post_meta($parent_id, '_taller_start_hour', true );
		if(!empty($time)) {
			return $time;
		}
	}
	
	return null;
}

/************************************************************/
/*********************** Admin functions ********************/
/************************************************************/

/**
 * Display the custom text field
 * @since 1.0.0
 */
function larula_taller_settings_fields_general() {
	global $post;
	
	$product_id = $post -> ID;
	// Intensidad horaria
	woocommerce_wp_text_input( 
		array( 
			'id'          => '_estimated_hours[' . $product_id . ']', 
			'label'       => __( 'Intensidad horaria', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Número de horas que toma el taller', 'larula' ),
      'value'       => get_post_meta( $product_id, '_estimated_hours', true ),
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
			'id'          => '_maximun_seats[' . $product_id . ']', 
			'label'       => __( 'Máximo participantes', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Número máximo de participantes en el taller', 'larula' ),
      'value'       => get_post_meta( $product_id, '_maximun_seats', true ),
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
			'id'          => '_taller_start_date[' . $product_id . ']', 
			'label'       => __( 'Fecha del taller', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Fecha del inicio del taller', 'larula' ),
      'value'       => get_post_meta( $product_id, '_taller_start_date', true ),
      'type'        => 'date',
			'custom_attributes' => array(
        'value' 	=> date('Y-m-d'),
        'max' => '',
      )
		)
  );

  // Hora del evento
  woocommerce_wp_text_input(
    array( 
			'id'          => '_taller_start_hour[' . $product_id . ']', 
			'label'       => __( 'Hora del taller', 'larula' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Hora de inicio del taller', 'larula' ),
      'value'       => get_post_meta( $product_id, '_taller_start_hour', true ),
      'type'        => 'time',
			'custom_attributes' => array(
        'step' => '900',
      )
		)
  );
}
add_action( 'woocommerce_product_options_advanced', 'larula_taller_settings_fields_general' );


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

function larula_save_variation_settings_fields_general( $product_id ) {
	// Intensidad horaria
	$estimated_hours = $_POST['_estimated_hours'][ $product_id ];
	if (!empty($estimated_hours)) {
		update_post_meta($product_id, '_estimated_hours', esc_attr($estimated_hours));
	}
	else {
		delete_post_meta( $product_id, '_estimated_hours' );
	}

	// Maximo participantes
	$maximun_seats = $_POST['_maximun_seats'][ $product_id ];
	if (!empty($maximun_seats)) {
		update_post_meta($product_id, '_maximun_seats', esc_attr($maximun_seats));
	}
	else {
		delete_post_meta( $product_id, '_maximun_seats' );
	}

	// Fecha del evento
	$taller_start_date = $_POST['_taller_start_date'][ $product_id ];
	if (!empty($taller_start_date)) {
		update_post_meta($product_id, '_taller_start_date', esc_attr($taller_start_date));
	}
	else {
		delete_post_meta( $product_id, '_taller_start_date' );
	}

	// Hora del evento
	$taller_start_hour = $_POST['_taller_start_hour'][ $product_id ];
	if (!empty($taller_start_hour)) {
		update_post_meta($product_id, '_taller_start_hour', esc_attr($taller_start_hour));
	}
	else {
		delete_post_meta( $product_id, '_taller_start_hour' );
	}
}
add_action( 'woocommerce_process_product_meta', 'larula_save_variation_settings_fields_general' );

/**
 * Save new fields for variations
*/
function larula_save_variation_settings_fields( $variation_id ) {
	// Intensidad horaria
	$estimated_hours = $_POST['_estimated_hours'][ $variation_id ];
	if( ! empty( $estimated_hours ) ) {
		update_post_meta( $variation_id, '_estimated_hours', esc_attr( $estimated_hours ) );
  }
  else {
    delete_post_meta( $variation_id, '_estimated_hours' );
  }

  // Maximo participantes
	$maximun_seats = $_POST['_maximun_seats'][ $variation_id ];
	if( ! empty( $maximun_seats ) ) {
		update_post_meta( $variation_id, '_maximun_seats', esc_attr( $maximun_seats ) );
  }
  else {
    delete_post_meta( $variation_id, '_maximun_seats' );
  }
  
  // Fecha del evento
	$taller_start_date = $_POST['_taller_start_date'][ $variation_id ];
	if( ! empty( $taller_start_date ) ) {
		update_post_meta( $variation_id, '_taller_start_date', esc_attr( $taller_start_date ) );
  }
  else {
    delete_post_meta( $variation_id, '_taller_start_date' );
  }
  
  // Hora del evento
	$taller_start_hour = $_POST['_taller_start_hour'][ $variation_id ];
	if( ! empty( $taller_start_hour ) ) {
		update_post_meta( $variation_id, '_taller_start_hour', esc_attr( $taller_start_hour ) );
  }
  else {
    delete_post_meta( $variation_id, '_taller_start_hour' );
  }
}
// Save Variation Settings
add_action( 'woocommerce_save_product_variation', 'larula_save_variation_settings_fields', 10, 1 );

function larula_add_custom_field_variation_data( $variations ) {
  $_variation = wc_get_product($variations[ 'variation_id' ]);
  // Intensidad horaria
  $variations['_estimated_hours'] = '<span class="woocommerce_estimated_hours"><span class="label">' . __('Intensidad horaria :','larula') . '</span>' .
    '<span>' . larula_get_product_estimated_hours($_variation) . '</span></span>';
  
  // Maximo participantes
  $variations['_seats'] = '<span class="woocommerce_maximun_seats"><span class="label">' . __('Cupos :','larula') . '</span>' .
    '<span class="current_inventory">' . $variations[ 'max_qty' ] . '</span>' .   
    '<span class="separator">/</span>' .
    '<span class="max_inventory">' . larula_get_product_maximun_seats($_variation) . '</span>' . 
    '</span>';

  // Fecha inicio del evento
  $date = larula_get_product_start_date($_variation);
  if($date != null) {
    $date_object = DateTime::createFromFormat('Y-m-d', $date);
    $variations['_taller_start_date'] = '<span class="woocommerce_taller_start_date_time"><span class="label">' . __('Fecha :','larula') . '</span>' .
      '<span class="date">' . $date_object -> format('d/m/Y') . '</span>' .
      '<span class="time">' . larula_get_product_start_time($_variation) . '</span></span>';
  }
  else {
    $variations['_taller_start_date'] = '<span class="woocommerce_taller_start_date_time hidden"></span>';
  }
  
  // Modifications woocommerce defaults
  if(!empty($variations['price_html'])) {
    $variations['price_html'] = '<span class="woocommerce_price_html"><span class="price-label">' . __('Precio :','larula') . '</span>' . $variations['price_html'] . '</span>';
  }
  else {
    $variations['price_html'] = '<span class="woocommerce_price_html hidden"></span>';
  }

  return $variations;
}
add_filter( 'woocommerce_available_variation', 'larula_add_custom_field_variation_data' );

/* Cron jobs */
register_activation_hook(__FILE__, 'larula_activate_cron_jobs');
function larula_activate_cron_jobs() {
	if (! wp_next_scheduled ( 'larula_taller_cron_job' )) {
		wp_schedule_event(strtotime('today'), 'daily', 'larula_taller_cron_job');
	}
}

add_action('larula_taller_cron_job', 'larula_deactivate_past_taller');
function larula_deactivate_past_taller() {
	error_log('running cron job');
  
  $query_args  = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'fields' => 'ids',
  );
  $product_query = new WP_Query( $query_args );

  foreach($product_query -> posts as $id) {
    error_log('evaluating product : ' . print_r($id,1));
    $_product = wc_get_product($id);
    $type = $_product -> get_type();

    if(strcasecmp($type, 'grouped') == 0 || strcasecmp($type, 'external') == 0) {
      error_log('Grouped or external : ignoring');
      continue;
    }

    // TODO Simple product
    if(strcasecmp($type, 'simple') == 0) {
      error_log('simple : TODO');
      continue;
    }

    if(strcasecmp($type, 'variable') == 0) {
      //add_filter('woocommerce_hide_invisible_variations', function($show, $id, $variation){return false;}, 10, 3);
      $variations = $_product -> get_available_variations();
      foreach($variations as $_variation_object) {
        $_variation = wc_get_product($_variation_object['variation_id']);
        $_variation -> date = get_post_meta($_variation -> get_id(), '_taller_start_date', true );
        $_variation -> time = get_post_meta($_variation -> get_id(), '_taller_start_hour', true );
        error_log('evaluating variation : ' . print_r($_variation -> get_id(),1));

        if(larula_is_product_time_available($_variation -> date, $_variation -> time)) {
          continue;
        }
  
        error_log('Deactivating variation' . print_r($_variation_object['variation_id'],1));
        if($_variation -> variation_is_active()) {
          $_variation -> set_status('private');
          $_variation -> save();
        }
  
        if($_variation -> is_in_stock()) {
          wc_update_product_stock($_variation, 0, 'set');
        }
      }
    }
  }
}

register_deactivation_hook(__FILE__, 'larula_deactivate_cron_jobs');
function larula_deactivate_cron_jobs() {
	if ( wp_next_scheduled ( 'larula_taller_cron_job' )) {
		wp_clear_scheduled_hook('larula_taller_cron_job');
	}
}


function larula_taller_available_validation( $passed, $product_id, $quantity, $variation_id, $variations ) {
  $_product = wc_get_product($product_id);
  $type = $_product -> get_type();

  if(strcasecmp($type, 'grouped') == 0 || strcasecmp($type, 'external') == 0) {
    return true;
  }

  // TODO Simple product
  if(strcasecmp($type, 'simple') == 0) {
    return true;
  }

  if(strcasecmp($type, 'variable') == 0) {
    $date = get_post_meta($variation_id, '_taller_start_date', true );
    $time = get_post_meta($variation_id, '_taller_start_hour', true );

    try {
      if (!larula_is_product_time_available($date, $time)) {
        throw new Exception( sprintf( __( 'Este evento ya ocurrio, trate de agregar otra sessión de ser posible.', 'larula' ) ) );
      }
    }
    catch ( Exception $e ) {
			if ( $e->getMessage() ) {
				wc_add_notice( $e->getMessage(), 'error' );
			}
			return false;
		}
  }

  return true;
}
add_action( 'woocommerce_add_to_cart_validation', 'larula_taller_available_validation', 10, 5 );

/************************************************************/
/************************ Home functions ********************/
/************************************************************/

function larula_build_featured_course_banner () {
  global $wp_query;
	$tnow = new DateTime('now', new DateTimeZone("America/Bogota"));
	
  $query_args  = array(
    'post_type' => array('product_variation'),
    'posts_per_page' => 5,
    'orderby' => 'modified',
    'post_status' => 'publish',
  );
  $recent_variations = new WP_Query( $query_args );

  $index = 0;
  $lowest_date = (new DateTime()) -> setTimestamp(0);
	$best = -1;
  foreach($recent_variations->posts as $_variation) {
		$date = larula_get_product_start_date($_variation);
		$time = larula_get_product_start_time($_variation);

		if($date == null || $time == null) {
			$index++;
			continue;
		}

    $timeString = str_replace ( '-' , ':', $date) . ' ' . $time . ':00';
    $dateTime = new DateTime($timeString, new DateTimeZone("America/Bogota"));

    if(!larula_is_product_time_available($date,$time)) {
      $index++;
      continue;
    }

    if( $lowest_date -> getTimestamp() == 0 ) {
      $lowest_date = $dateTime;
			$best = $index;
    }
    else {
      if($dateTime < $lowest_date) {
        $lowest_date = $dateTime;
				$best = $index;
      }
    }
		$index++;
  }

	$query_args  = array(
    'type' => 'simple',
    'limit' => 5,
    'orderby' => 'modified',
    'status' => 'publish',
  );
	$recent_products = wc_get_products( $query_args );

	$index = 0;
	$best_product = -1;
	foreach($recent_products as $_product) {
    $date = larula_get_product_start_date($_product);
    $time = larula_get_product_start_time($_product);

		if($date == null || $time == null){
			$index++;
      continue;
		}

    $timeString = str_replace ( '-' , ':', $date) . ' ' . $time . ':00';
    $dateTime = new DateTime($timeString, new DateTimeZone("America/Bogota"));

    if(!larula_is_product_time_available($date,$time)) {
      $index++;
      continue;
    }

    if( $lowest_date -> getTimestamp() == 0 ) {
      $lowest_date = $dateTime;
      $best_product = $index;
    }
    else {
      if($dateTime < $lowest_date) {
        $lowest_date = $dateTime;
        $best_product = $index;
      }
    }
    $index++;
  }

	// If no suitable product was found exit.
	if($best == -1 && $best_product == -1) {return;}

	// Decide wether to use the best product or the best variation.
	$best = $best_product != -1? $best_product: $best;

  // Store featured product in cache to avoid it in the slider.
  if(FALSE === wp_cache_get( 'featured_event' )) {
		wp_cache_add( 'featured_event', array() );
	}
	else {
		wp_cache_set( 'featured_event', array() );
	}
	if($best_product != -1) {
		$parent_id = $recent_products[$best_product] -> get_id();
		$product = $recent_products[$best_product];
	}
	else {
		$product = wc_get_product( $recent_variations -> posts[$best] -> ID );
		$parent_id = $product -> get_parent_id();
		$parent = wc_get_product( $parent_id );
	}
  wp_cache_set( 'featured_event', array($parent_id) );

  $product -> date = $lowest_date;
  $product -> until_event = $tnow -> diff($lowest_date);
  $product -> milliseconds = $lowest_date -> getTimestamp() - $tnow -> getTimestamp();
  $product -> maximun_seats = larula_get_product_maximun_seats($product, '_maximun_seats', true );
  $product -> estimated_hours = larula_get_product_estimated_hours($product, '_estimated_hours', true );

  $wp_query -> query_vars['larula_args'] = (object)[];
	$wp_query -> query_vars['larula_args'] -> product = $product;
	if($best_product != -1) {
		$wp_query -> query_vars['larula_args'] -> parent_product = $product;
	}
	else {
		$wp_query -> query_vars['larula_args'] -> parent_product = $parent;
	}

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

  $wp_query -> query_vars['larula_args'] -> variations = array();
  foreach($product_query -> posts as $id) {
    $_product = wc_get_product($id);
    if($_product -> get_type() === 'simple') {
      if(!$_product -> is_in_stock()) {
        continue;
      }
      $_product -> date = larula_get_product_start_date($_product );
      $_product -> time = larula_get_product_start_time($_product );

			if($_product -> date == null || $_product -> time == null){
				continue;
			}

      if(!larula_is_product_time_available($_product -> date, $_product -> time)) {
        continue;
      }

      $timeString = str_replace ( '-' , ':', $_product -> date) . ' ' . $_product -> time . ':00';
      $date = new DateTime($timeString, new DateTimeZone("America/Bogota"));
      $_product -> date = $date;
      $_product -> milliseconds = $date -> getTimestamp();
      $_product -> maximun_seats = larula_get_product_maximun_seats($_product);
      $_product -> estimated_hours = larula_get_product_estimated_hours($_product);
      array_push($wp_query -> query_vars['larula_args'] -> variations, $_product);
      continue;
    }

    $variations = $_product -> get_available_variations();

		// Find closest variation (according to time and date fields)
    $next_variation = array();
    foreach($variations as $_variation_object) {
      $_variation = wc_get_product($_variation_object['variation_id']);

      if(!$_variation -> variation_is_active()) {
        continue;
      }
      if(!$_variation -> is_in_stock()) {
        continue;
      }
      $_variation -> date = larula_get_product_start_date($_variation );
      $_variation -> time = larula_get_product_start_time($_variation );

			if($_variation -> date == null || $_variation -> time == null){
				continue;
			}

      if(!larula_is_product_time_available($_variation -> date, $_variation -> time)) {
        continue;
      }

      $timeString = str_replace ( '-' , ':', $_variation -> date) . ' ' . $_variation -> time . ':00';
      $date = new DateTime($timeString, new DateTimeZone("America/Bogota"));

      $_variation -> date = $date;
      $_variation -> milliseconds = $date -> getTimestamp();

      if(!empty($next_variation)) {
        $interval = $next_variation -> milliseconds - $_variation -> milliseconds;
        
        if($interval < 0) {
          continue;
        }
      }

      $_variation -> maximun_seats = larula_get_product_maximun_seats($_variation);
      $_variation -> estimated_hours = larula_get_product_estimated_hours($_variation);

      $next_variation = $_variation;
    }

    array_push($wp_query -> query_vars['larula_args'] -> variations, $next_variation);
  }

  ob_start();
	$template_url = larula_load_template('product-slider.php', 'home');
	load_template($template_url, true);
  $body_html = ob_get_clean();
  
  return $body_html;
}
add_shortcode( 'larula_home_products_slider', 'larula_build_home_product_slider' );

