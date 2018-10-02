/* OLD VERSION
function promotions_free_shipping($rates, $package){
	if ( isset( $rates['free_shipping'] ) ) {
		global $woocommerce;
		$items = $woocommerce->cart->get_cart();
		$useFreeShipping = false;

		foreach( $items as $item ){
			if( ($item['product_id'] == 8433 && $item['quantity'] >= 2) || $item['product_id'] == 8507 ){
				$useFreeShipping = true;
			}
		}

		if( $useFreeShipping ){
			$freeShipping = $rates['free_shipping'];
			$rates = array();
		        $rates['free_shipping'] = $freeShipping;
		}else{
			unset($rates['free_shipping']);
		}
	}
	return $rates;
}
add_filter( 'woocommerce_package_rates', 'promotions_free_shipping', 10, 2 );
*/
function promotions_free_shipping( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			global $woocommerce;
			$items = $woocommerce->cart->get_cart();
			$useFreeShipping = false;

			foreach( $items as $item ){
				if( ($item['product_id'] == 8433 && $item['quantity'] >= 2) || $item['product_id'] == 8507 ){
					$useFreeShipping = true;
				}
			}

			if( $useFreeShipping ){
				$freeShipping = $rates['free_shipping'];
				$rates = array();
					$rates['free_shipping'] = $freeShipping;
			}else{
				unset($rates['free_shipping']);
			}
			
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'promotions_free_shipping', 100 );
