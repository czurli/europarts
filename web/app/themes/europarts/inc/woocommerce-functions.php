<?php

function mytheme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );

add_filter( 'woocommerce_get_image_size_single', function ( $size ) {
	return array(
		'width'  => 500,
		'height' => 500,
		'crop'   => 1,
	);
} );

add_filter( 'woocommerce_get_image_size_thumbnail', function ( $size ) {
	return array(
		'width'  => 400,
		'height' => 400,
		'crop'   => 1,
	);
} );

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function ( $size ) {
	return array(
		'width'  => 400,
		'height' => 400,
		'crop'   => 1,
	);
} );

// aggiunge quantità nella lista prodotti
function custom_shop_page_add_quantity_field() {
	$product = wc_get_product( get_the_ID() );
	if ( ! $product->is_sold_individually() && 'variable' != $product->get_type() && $product->is_purchasable() ) {
		woocommerce_quantity_input( array(
			'min_value' => 1,
			'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity()
		) );
	}
}

add_action( 'woocommerce_before_shop_loop_item_title', 'custom_shop_page_add_quantity_field', 12 );


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 13 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 11 );

//aggiornamento ajax quantità sull'icona carrello//
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_cart_but_count' );
function woo_cart_but_count( $fragments ) {
	ob_start();
	$cart_count = WC()->cart->cart_contents_count;
	$cart_url   = wc_get_cart_url();

	?>
    <a class="cart-contents" href="<?php echo $cart_url; ?>"
       title="<?php __( 'Visualizza il carrello', 'europarts' ); ?>">
		<?php
		if ( $cart_count > 0 ) {
			?>
            <span class="cart-contents-count"><?php echo $cart_count; ?></span>
			<?php
		}
		?></a>
	<?php
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}

// Remove default WooCommerce wrapper
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'wptest_woocommerce_wrapper_before' ) ) {
	function wptest_woocommerce_wrapper_before() {
		?>
        <section class="pt-4 pb-5" id="mainContent">
        <div class="container">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'wptest_woocommerce_wrapper_before' );

if ( ! function_exists( 'wptest_woocommerce_wrapper_after' ) ) {
	function wptest_woocommerce_wrapper_after() {
		?>
        </div>
        </section>
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'wptest_woocommerce_wrapper_after' );

add_action( 'woocommerce_before_shop_loop', 'loop_start_override', 5 );
function loop_start_override() {
	echo '<div class="products row"><div class="col">';
}

add_action( 'woocommerce_after_shop_loop', 'loop_end_override', 15 );
function loop_end_override() {
	echo '</div></div>';
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 5 );

// Aggiungo pagina negozio al breadcrumb
add_filter( 'woocommerce_get_breadcrumb', function ( $crumbs, $Breadcrumb ) {
	$shop_page_id = wc_get_page_id( 'shop' ); //Get the shop page ID
	if ( $shop_page_id > 0 && ! is_shop() ) { //Check we got an ID (shop page is set). Added check for is_shop to prevent Home / Shop / Shop as suggested in comments
		$new_breadcrumb = [
			_x( 'Shop', 'breadcrumb', 'woocommerce' ), //Title
			get_permalink( wc_get_page_id( 'shop' ) ) // URL
		];
		array_splice( $crumbs, 1, 0, [ $new_breadcrumb ] ); //Insert a new breadcrumb after the 'Home' crumb
	}

	return $crumbs;
}, 10, 2 );

// aggiungo bottoni + e - per la quantità

add_action( 'woocommerce_before_quantity_input_field', 'quantity_minus_sign' );
function quantity_minus_sign() {
	echo '<button type="button" class="minus" >-</button>';
}

add_action( 'woocommerce_after_quantity_input_field', 'quantity_plus_sign' );
function quantity_plus_sign() {
	echo '<button type="button" class="plus" >+</button>';
}

/*
add_action( 'woocommerce_cart_item_removed', 'action_woocommerce_remove_cart_item', 10, 2 );
function action_woocommerce_remove_cart_item( $cart_item_key, $instance ) {
	wc_add_notice( 'ITEM REMOVED', 'error' );
}
*/

add_filter( 'woocommerce_output_related_products_args', 'jk_related_products_args', 20 );
function jk_related_products_args( $args ) {
	$args['posts_per_page'] = 12;
	$args['columns']        = 6;

	return $args;
}



