<?php
/*
Plugin Name: Sidepop
Version: 1.0
Plugin URI: http://sidepop.me/
Author: Sidepop
Description: Integrate Wordpress with Sidepop easily in one simple step
*/

// WORDPRESS ADMIN


add_action( 'admin_menu', 'sidepop_base_info_menu' );

function sidepop_base_info_menu(){

  $page_title = 'Sidepop';
  $menu_title = 'Sidepop';
  $capability = 'manage_options';
  $menu_slug  = 'sidepop-base-info';
  $function   = 'sidepop_base_info_page';
  $icon_url   = 'dashicons-media-code';
  $position   = 30.1;

  add_menu_page( $page_title,
                 $menu_title, 
                 $capability, 
                 $menu_slug, 
                 $function, 
                 $icon_url, 
                 $position );
}

function sidepop_error_server() {
    ?>
    <div class="error notice">
        <p>There was an error contacting Sidepop server. Do you have a correct key?</p>
    </div>
    <?php
}

function sidepop_base_info_page(){

  if (!get_option('sidepop_wordpress') && isset($_POST['sidepop_api_key'])) {

    $api_key = sanitize_key($_POST['sidepop_api_key']);

    if(wp_verify_nonce($_REQUEST['sidepop-api-nonce'], 'sidepop-api-save')){

      try{

        $public_key =  wp_remote_retrieve_body( wp_remote_get( "https://app.sidepop.me/api/get_embed_id?api_key=" . $api_key ));

      } catch (Exception $e) {
        $public_key = "error";
      }

    } else {
      $public_key = "error";
    }

    if (strlen($public_key) == 36) {
      update_option('sidepop_display', "no"); // "no-except", "all-except"
      update_option('sidepop_api_key', $api_key);
      update_option('sidepop_public_key', sanitize_key($public_key));


      if(!get_option('sidepop_wordpress')) update_option('sidepop_wordpress', 'no');
      if(!get_option('sidepop_wordpress_line1')) update_option('sidepop_wordpress_line1', 'A person from {location}');
      if(!get_option('sidepop_wordpress_line2')) update_option('sidepop_wordpress_line2', 'Registered in '.get_bloginfo('name'));

      if(!get_option('sidepop_woocommerce')) update_option('sidepop_woocommerce', 'no');
      if(!get_option('sidepop_woocommerce_line1')) update_option('sidepop_woocommerce_line1', 'A person from {location}');
      if(!get_option('sidepop_woocommerce_line2')) update_option('sidepop_woocommerce_line2', 'Bought {product} for {price}');
    } else {
      add_action( 'admin_notices', 'sidepop_error_server' );
    }

  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_display'])) {
    update_option('sidepop_display', sanitize_key($_POST['sidepop_display']));
  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_wordpress'])) {
    update_option('sidepop_wordpress', sanitize_key($_POST['sidepop_wordpress']));
  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_wordpress_line1'])) {
    update_option('sidepop_wordpress_line1', sanitize_text_field($_POST['sidepop_wordpress_line1']));
  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_wordpress_line2'])) {
    update_option('sidepop_wordpress_line2', sanitize_text_field($_POST['sidepop_wordpress_line2']));
  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_woocommerce'])) {
    update_option('sidepop_woocommerce', sanitize_key($_POST['sidepop_woocommerce']));
  }

  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_woocommerce_line1'])) {
    update_option('sidepop_woocommerce_line1', sanitize_text_field($_POST['sidepop_woocommerce_line1']));
  }


  if (wp_verify_nonce($_REQUEST['sidepop-settings-nonce'], 'sidepop-settings-save') && isset($_POST['sidepop_woocommerce_line2'])) {
    update_option('sidepop_woocommerce_line2', sanitize_text_field($_POST['sidepop_woocommerce_line2']));
  }


  $sidepop_api_key = get_option('sidepop_api_key');

  if ($sidepop_api_key == false) {



    include('views/welcome.php');

  } else {

    
    $sidepop_public_key = get_option('sidepop_public_key');
    $sidepop_display = get_option('sidepop_display');

    $sidepop_wordpress = get_option('sidepop_wordpress');
    $sidepop_wordpress_line1 = get_option('sidepop_wordpress_line1');
    $sidepop_wordpress_line2 = get_option('sidepop_wordpress_line2');

    $sidepop_woocommerce = get_option('sidepop_woocommerce');
    $sidepop_woocommerce_line1 = get_option('sidepop_woocommerce_line1');
    $sidepop_woocommerce_line2 = get_option('sidepop_woocommerce_line2');

    include('views/settings.php');

  }

}



function add_sidepop_meta_box() {
  add_meta_box(
    'sidepop_meta_box', // $id
    'Sidepop', // $title
    'show_sidepop_meta_box', // $callback
    null, // $screen
    'side', // $context
    'high' // $priority
  );
}
add_action( 'add_meta_boxes', 'add_sidepop_meta_box' );

function show_sidepop_meta_box( $post, $metabox ) {

  $sidepop_api_key = get_option('sidepop_api_key');
  $sidepop_display = get_option('sidepop_display');
  $post_type_element = get_post_type($post->ID);

  $post_type = get_post_type_object($post_type_element);
  $post_type = $post_type->labels->singular_name;

  if ($sidepop_api_key == false) {
    ?>
      Before using Sidepop in this <?php echo $post_type;?> <a href="admin.php?page=sidepop-base-info">configure this plugin</a>
    <?php
  } else {

    $sidepop = get_post_meta( $post->ID, 'sidepop', true ); 
    wp_nonce_field( basename(__FILE__), 'sidepop_meta_box_nonce' );

    if ($sidepop_display == false || $sidepop_display == "no") {
    ?>
      The Sidepop widget embed is disabled for this site. <a href="admin.php?page=sidepop-base-info">Enable it to proceed</a>
    <?php
    } else if ($sidepop_display == "no-except") {
      ?>
      <p>
        <input type="checkbox" name="sidepop" value="enabled" <?php checked( $sidepop, 'enabled' ); ?>/>  Display Sidepop in this <?php echo $post_type;?>
      </p>
      <?php
    } else if ($sidepop_display == "all-except") {
      ?>
      <?php global $pagenow;?>
      <p>
        <input type="checkbox" name="sidepop" value="enabled" <?php if ($sidepop == "enabled" || $sidepop == false || $screen->base->action == "add" || $pagenow == "post-new.php") echo "checked"; ?>/>  Show Sidepop in this <?php echo $post_type;?>
      </p>
      <?php
    }

    
    
  }

  
}

function save_sidepop_meta($post_ID) {
    $post_ID = (int) $post_ID;
    $post_type_element = get_post_type($post_ID);
    $post_status = get_post_status( $post_ID );

    if ($post_type_element) {
      if ($_POST["sidepop"] == "enabled") {
        update_post_meta($post_ID, "sidepop", "enabled");
      } else {
        update_post_meta($post_ID, "sidepop", "disabled");
      }
    }
   return $post_ID;
}
add_action( 'save_post', 'save_sidepop_meta' );

function sidepop_base_embed_settings_link($links) { 
  $support = '<a target="_new" href="mailto:support@sidepop.me">Support</a>'; 
  array_unshift($links, $support); 
  $howto_link = '<a href="admin.php?page=sidepop-base-info">Use plugin</a>';
  array_unshift($links, $howto_link); 
  return $links; 
}

$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'sidepop_base_embed_settings_link');

// WORDPRESS FRONTEND

function sidepop_embed_js() {

  if (!is_admin()) {
    $display_sidepop = false;
    $display_sidepop_global = get_option('sidepop_display');
    $sidepop_public_key = get_option('sidepop_public_key');



    if ($display_sidepop_global == "no") $display_sidepop = false;
    if ($display_sidepop_global == "no-except") {
      if (is_singular() && get_post_meta(get_the_ID(),"sidepop",true) == 'enabled'){
        $display_sidepop = true;
      } else {
        $display_sidepop = false;
      }
    }
    if ($display_sidepop_global == "all-except") {
      if (is_singular() && get_post_meta(get_the_ID(),"sidepop",true) == "disabled"){
        $display_sidepop = false;
      } else {
        $display_sidepop = true;
      }
    }


    if ($display_sidepop && $sidepop_public_key !== false) {
      
      wp_enqueue_script('sidepop-embed', 'https://spembed.xyz/embed/js/' . get_option('sidepop_public_key') );
    }
  }


}

add_action( 'wp_enqueue_scripts', 'sidepop_embed_js' );


// send events

add_action( 'user_register', 'sidepop_user_created', 10, 1 );
function sidepop_user_created($user_id) {
  if (get_option('sidepop_wordpress') == "yes") {

    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }


    $user_info = get_userdata($user_id);
    $first_name = $user_info->first_name;
    $last_name = $user_info->last_name;

    $line_1 = get_option('sidepop_wordpress_line1');
    $line_2 = get_option('sidepop_wordpress_line2');

    $line_1  = str_replace("{first_name}", $first_name, $line_1);
    $line_2  = str_replace("{first_name}", $first_name, $line_2);

    $line_1  = str_replace("{last_name}", $last_name, $line_1);
    $line_2  = str_replace("{last_name}", $last_name, $line_2);

    $params = array(
      'ip_address' => $ip,
      'title' => $line_1,
      'subtitle' => $line_2,
      'tag' => 'sp_wordpress_signups' // sp_woocommerce_sales
    );
	 
	$args = array(
	    'body' => $params,
	    'timeout' => '5',
	    'redirection' => '5',
	    'httpversion' => '1.0',
	    'blocking' => false,
	    'headers' => array(
	    	"authkey" => get_option('sidepop_api_key')
	    ),
	    'cookies' => array()
	);
	 
	$response = wp_remote_post( 'https://app.sidepop.me/api/events', $args );

  }
}

add_action( 'woocommerce_checkout_order_processed', 'sidepop_payment_complete' );
function sidepop_payment_complete( $order_id ){

  if (get_option('sidepop_woocommerce') == "yes") {

    $order = wc_get_order( $order_id );
    $first_name =  get_post_meta($order->ID,'_billing_first_name', true);
    $last_name =  get_post_meta($order->ID,'_billing_last_name', true);

    foreach ($order->get_items() as $item_id => $item_data) {
      
      // Get an instance of corresponding the WC_Product object
      $product = $item_data->get_product();
      $product_name = $product->get_name(); // Get the product name
      $item_quantity = $item_data->get_quantity(); // Get the item quantity
      $item_total = strip_tags(wc_price($item_data->get_total(),array('currency' => $order->get_currency()))); // Get the item line total
      // Displaying this data (to check)
      //echo 'Product name: '.$product_name.' | Quantity: '.$item_quantity.' | Item total: '. $item_total;
  
      if ($item_quantity > 0) {

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }


        $line_1 = get_option('sidepop_woocommerce_line1');
        $line_2 = get_option('sidepop_woocommerce_line2');

        $line_1  = str_replace("{first_name}", $first_name, $line_1);
        $line_2  = str_replace("{first_name}", $first_name, $line_2);

        $line_1  = str_replace("{last_name}", $last_name, $line_1);
        $line_2  = str_replace("{last_name}", $last_name, $line_2);

        if ($item_quantity == 1) {
          $line_1  = str_replace("{product}", $product_name, $line_1);
          $line_2  = str_replace("{product}", $product_name, $line_2);
        } else {
          $line_1  = str_replace("{product}", $item_quantity ." ". $product_name, $line_1);
          $line_2  = str_replace("{product}", $item_quantity ." ". $product_name, $line_2);
        }

        $line_1  = str_replace("{price}", $item_total, $line_1);
        $line_2  = str_replace("{price}", $item_total, $line_2);


        $params = array(
          'ip_address' => $ip,
          'title' => $line_1,
          'subtitle' => $line_2,
          'tag' => 'sp_woocommerce_sales' 
        );

        $args = array(
		    'body' => $params,
		    'timeout' => '5',
		    'redirection' => '5',
		    'httpversion' => '1.0',
		    'blocking' => false,
		    'headers' => array(
		    	"authkey" => get_option('sidepop_api_key')
		    ),
		    'cookies' => array()
		);
		 
		$response = wp_remote_post( 'https://app.sidepop.me/api/events', $args );

      }

    }

  }

}


