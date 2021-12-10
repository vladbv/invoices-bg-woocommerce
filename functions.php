<?php

add_action( 'woocommerce_after_order_notes', 'wordimpress_custom_checkout_field' );

function wordimpress_custom_checkout_field( $checkout ) {

	//Check if Book in Cart (UPDATE WITH YOUR PRODUCT ID)


	//Book is in cart so show additional fields

		echo '<div id="my_custom_checkout_field"><h3>' . __( 'Ще желаете ли фактура?' ) . '</h3><p style="margin: 0 0 8px;">Желая да ми бъде издадена фактура</p>';

		//woocommerce_form_field( 'inscription_checkbox', array(
		//	'type'  => 'checkbox',
		//	'class' => array( 'inscription-checkbox ' ),
		//	'label' => __( 'Да' ),
		//), $checkout->get_value( 'inscription_checkbox' ) );
		
	        echo '<input type="button" id="inscription_addbox" name="inscription_addbox" class="button inscription_addbox" value="Да" />';

		
		echo '<input type="button" id="inscription_closebox" class="button inscription_closebox" value="Не желая фактура" />';
		
		woocommerce_form_field( 'inscription_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'Фирма' ),
		), $checkout->get_value( 'inscription_textbox' ) );
		
			woocommerce_form_field( 'inscriptioneik_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'ЕИК' ),
		), $checkout->get_value( 'inscriptioneik_textbox' ) );
		
		
			woocommerce_form_field( 'inscriptionin_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'ИН по ЗДДС' ),
		), $checkout->get_value( 'inscriptionin_textbox' ) );
		
		woocommerce_form_field( 'inscriptioncity_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'Град' ),
		), $checkout->get_value( 'inscriptioncity_textbox' ) );
		
		
				woocommerce_form_field( 'inscriptionaddress_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'Адрес' ),
		), $checkout->get_value( 'inscriptionaddress_textbox' ) );
		
		
				woocommerce_form_field( 'inscriptioncomment_textbox', array(
			'type'  => 'text',
			'class' => array( 'inscription-text ' ),
			'label' => __( 'Коментар' ),
		), $checkout->get_value( 'inscriptioncomment_textbox' ) );

		

		echo '</div>';


}

/**
 * Check if Conditional Product is In cart
 *
 * @param $product_id
 *
 * @return bool
 */
function wordimpress_is_conditional_product_in_cart( $product_id ) {
	//Check to see if user has product in cart
	global $woocommerce;

	//flag no book in cart
	$book_in_cart = false;

	foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
		$_product = $values['data'];

		if ( $_product->id === $product_id ) {
			//book is in cart!
			$book_in_cart = true;

		}
	}

	return $book_in_cart;

}


// Redirect WooCommerce Shop URL
function wpc_shop_url_redirect() {
    if( is_shop() ){
        wp_redirect( home_url( '/продукти/' ) ); // Assign custom internal page here
        exit();
    }
}
add_action( 'template_redirect', 'wpc_shop_url_redirect' );


/**
 * Update the order meta with field value
 **/
add_action( 'woocommerce_checkout_update_order_meta', 'wordimpress_custom_checkout_field_update_order_meta' );

function wordimpress_custom_checkout_field_update_order_meta( $order_id ) {

	//check if $_POST has our custom fields
	if ( $_POST['inscription_textbox'] || $_POST['inscriptioneik_textbox'] || $_POST['inscriptionin_textbox'] || $_POST['inscriptioncity_textbox'] || $_POST['inscriptionaddress_textbox'] ) {
		//It does: update post meta for this order
		update_post_meta( $order_id, 'Клиентът иска фактура', esc_attr( 'Да' ) );
	}
	if ( $_POST['inscription_textbox'] ) {
		update_post_meta( $order_id, 'Фирма', esc_attr( $_POST['inscription_textbox'] ) );
	}
	if ( $_POST['inscriptioneik_textbox'] ) {
		update_post_meta( $order_id, 'ЕИК', esc_attr( $_POST['inscriptioneik_textbox'] ) );
	}
	
		if ( $_POST['inscriptionin_textbox'] ) {
		update_post_meta( $order_id, 'ИН по ЗДДС', esc_attr( $_POST['inscriptionin_textbox'] ) );
	}
	
		if ( $_POST['inscriptioncity_textbox'] ) {
		update_post_meta( $order_id, 'Град', esc_attr( $_POST['inscriptioncity_textbox'] ) );
	}
	
		if ( $_POST['inscriptionaddress_textbox'] ) {
		update_post_meta( $order_id, 'Адрес', esc_attr( $_POST['inscriptionaddress_textbox'] ) );
	}
	
		if ( $_POST['inscriptioncomment_textbox'] ) {
		update_post_meta( $order_id, 'Коментар', esc_attr( $_POST['inscriptioncomment_textbox'] ) );
	}
}


/**
 * Add the field to order emails
 **/
add_filter( 'woocommerce_email_order_meta_keys', 'wordimpress_checkout_field_order_meta_keys' );

function wordimpress_checkout_field_order_meta_keys( $keys ) {

	//Check if Book in Cart


	//Only if book in cart


		$keys[] = 'Клиентът иска фактура';
		$keys[] = 'Фирма';
	$keys[] = 'ЕИК';	
	$keys[] = 'ИН по ЗДДС';
	$keys[] = 'Град';
	$keys[] = 'Адрес';
	$keys[] = 'Коментар';

	return $keys;
}



?>
