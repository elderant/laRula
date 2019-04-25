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
  
  add_settings_section('messages_section', 'Messages Settings', 'larula_messages_text', 'larula');
	add_settings_field('messages_download_database', 'Download all messages', 'larula_download_messages', 'larula', 'messages_section');
}

function larula_products_text() {
	//echo "<h2></h2>";
}
function larula_messages_text() {}

function larula_hide_not_featured() {
  $options = get_option('larula_options');
  $html = '<input type="checkbox" id="product-hide-not-featured" name="larula_options[hide_not_featured]" value="1"' . checked( 1, $options['hide_not_featured'], false ) . '/>';
  echo $html;
}

function larula_download_messages() {
  $html = '<input type="submit" name="download_messages_csv" class="download-database messages button" value="Descargar BD de mensajes"/>';
  echo $html;
}

function larula_options_validate($input) {

	return $input;
}

function larula_download_message_database() {
  global $post;
  if (isset($_POST['download_messages_csv'])) {
		$args = array(
      'post_type' => 'flamingo_inbound',
      'fields' => 'ids',
			'posts_per_page ' => 500, 
			'paged' => 1,
		);
	}
	else {
		return;
	}

  // The Query
	$post_query = new WP_Query( $args );

  error_log('posts on messages database download : ' . print_r($post_query -> get_results(),1));

	// posts Loop
	ini_set("auto_detect_line_endings", true);
  if ( $post_query -> found_posts > 0 ) {
		ob_clean();
		header( 'Pragma: public' );
		header( 'Expires: 0' );
		header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
		header( 'Cache-Control: private', false );
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename="Messages database.csv"' );

		$file = fopen('php://output', 'w');
		$header_array = array('id', 'date', 'channel', 'name', 'email', 'phone', 'nombre taller', 'message');

		fputcsv( $file, $header_array );

    $i = 1;
    if($post_query -> have_posts()) {
      while( $i <= $post_query -> max_num_pages) {
        if( $i > 1 ) {
          $args = array(
            'post_type' => 'flamingo_inbound',
            'fields' => 'ids',
            'posts_per_page ' => 500, 
            'paged' => $i,
          );

          // Update the query
          $post_query = new WP_User_Query( $args );
          $_posts = $post_query -> get_results();
        }
        error_log('writting messages page ' . print_r($i,1) . ' messages in page : ' . print_r(count($post_query -> post_count),1));

        while ( $post_query -> have_posts() ) {
          $post_query -> the_post();
          $_post = new Flamingo_Inbound_Message( $post );

          error_log('flamingo post : ' . print_r($post,1));
          $message_array = array();
          array_push($message_array, $_post -> id);
          array_push($message_array, $_post -> channel);
          array_push($message_array, $_post -> date);

          foreach ($_post -> fields as $key => $value){
            array_push($message_array, $value);
          }

          fputcsv($file, $message_array);
        }
        $i++;
        // Restore original Post Data
	      wp_reset_postdata();
      }

      fclose($file);
      ob_flush();
      exit;
    }
	} else {
		echo 'No messages found.';
	}
}
add_action('admin_init', 'larula_download_message_database');