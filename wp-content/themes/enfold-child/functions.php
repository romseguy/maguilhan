<?php

/*
* Add your own functions here. You can also copy some of the theme functions into this file. 
* Wordpress will use those functions instead of the original functions then.
*/

add_action('init', 'start_session');

function start_session() {
    if( !session_id() ) {
		session_start();
		$_SESSION['start'] = 'true';
    }
}

add_action( 'init', 'add_product_to_cart' );

function add_product_to_cart() {
	if (isset($_SESSION['start']) && $_SESSION['start'] == 'true') { 
		return;
	}

	if ( ! is_admin() ) {
		$product_id = 19; //replace with your own product id
		$found = false;
		//check if product already in cart
		if ( sizeof( WC()->cart->get_cart() ) > 0 ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				$_product = $values['data'];
				if ( $_product->get_id() == $product_id )
					$found = true;
			}
			// if product not found, add it
			if ( ! $found )
				WC()->cart->add_to_cart( $product_id );
		} else {
			// if no products in cart, add it
			WC()->cart->add_to_cart( $product_id );
		}
	}
}