<?php

/**                                   
 * Copy and paste the code below and add it to the functions.php of your child theme or use a Snippet Plugin.
 *
 * If You have troubles please contact me: qubi7@mailbox.org
 * 
 * SNIPPET FOR WOOCOMMERCE
 * @TITLE: customize woocommerce package rates per parcel 
 * @DESCRIPTION: set custom package rates per parcel and define a certain ammount of products which fit in one parcel
 * @AUTHOR: qubi7
 * @VERSION: 1.0
 * @LAST TESTED WOOCOMMERCE VERSION: 4.5.2
 * @TESTED WORDPRESS VERSION:
 */	
 
// Filter to hook into shipping price calculation
add_filter( 'woocommerce_package_rates', 'override_direktversand_rates' );


// Amount of products that fit in one parcel
$products_per_parcel = 4;
$shippig-method_id = 7;
$product-shipping-class_id = 8;

function override_direktversand_rates( $rates ) {

  foreach( $rates as $rate_key => $rate ){
    // Check if the shipping method ID is Direktversand DHL [INSERT-SHIPPINGMETHOD_ID]
    if( (($rate->method_id == 'flat_rate') && ($rate->instance_id =='$shippig-method_id') ) ) {

    
    // Calculation of the amount of parcel needed
    global $WC;
			
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      if ( ( $cart_item['data']->get_shipping_class_id() == '$product-shipping-class_id') ) {
        $product_qty = $cart_item['quantity'];	
        $parcel_sum_qty = $parcel_sum_qty + ( ceil( $product_qty / $products_per_parcel) ) ;
      }
    }
		
  $karton_cost = 9;
  //calc parcel needed times parcel cost
	$rates[$rate_key]->cost = $parcel_sum_qty * $parcel_cost;
  } 
      
 }
    
return $rates;            
}
