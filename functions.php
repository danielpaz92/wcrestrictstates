function wc_checkout_validation() {
			$shipping_country     = ! empty( $_POST['shipping_country'] ) ? $_POST['shipping_country'] : $_POST['billing_country'];
			$shipping_state       = ! empty( $_POST['shipping_state'] ) ? $_POST['shipping_state'] : $_POST['billing_state'];			
			$countries_obj   = new WC_Countries();
			$countries   = $countries_obj->__get('countries');
			$default_country = $countries_obj->get_base_country();
			$included_states = $countries_obj->get_states( $default_country );
			// Verification if you are in Base Country
			if ($default_country != $shipping_country) {
					wc_add_notice( __( 'Desculpem-nos, infelizmente não vendemos para fora do Brasil.', 'odin' ), 'error' );
			}
			// States Verification
			if (!in_array( $shipping_state, $included_states ) ) {
					// Here you generate State Label for your Alert.
					$states = WC()->countries->get_states($default_country);
					$state  = $states[$shipping_state];
					wc_add_notice( sprintf( __( 'Desculpem-nos, infelizmente não realizamos entregas para <strong>%s</strong>.', 'odin' ), $state ), 'error' );
			}
	}
	
	add_action( 'woocommerce_checkout_process', 'wc_checkout_validation' );
