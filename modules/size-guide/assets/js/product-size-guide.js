jQuery( document ).ready( function( $ ) {
	$( '#dimax_size_guide-display' ).on( 'change', function() {
		var $select = $( this );

		if ( 'panel' === $select.val() ) {
			$select.closest( '.form-field' ).nextAll( '.dimax_size_guide-button_position_field, .dimax_size_guide-attribute_field' ).show();

			$( '#dimax_size_guide-button_position' ).trigger( 'change' );
		} else {
			$select.closest( '.form-field' ).nextAll( '.dimax_size_guide-button_position_field, .dimax_size_guide-attribute_field' ).hide();
		}
	} ).trigger( 'change' );

	$( '#dimax_size_guide-button_position' ).on( 'change', function() {
		var $select = $( this );

		if ( 'bellow_attribute' === $select.val() ) {
			$select.closest( '.form-field' ).next( '.dimax_size_guide-attribute_field' ).show();
		} else {
			$select.closest( '.form-field' ).next( '.dimax_size_guide-attribute_field' ).hide();
		}
	} ).trigger( 'change' );

	// Reload the size guide tab when attributes updated
	$( '#variable_product_options' ).on( 'reload', function() {
		var wrapper = $( '#dimax-size-guide' );

		block();

		$.ajax({
			url: ajaxurl,
			data: {
				action:     'dimax_addons_load_product_size_guide_attributes',
				security:   wrapper.data( 'nonce' ),
				product_id: woocommerce_admin_meta_boxes_variations.post_id,
			},
			type: 'POST',
			success: function( response ) {
				$( 'select#dimax_size_guide-attribute', wrapper ).closest( 'p.form-field' ).replaceWith( response );

				$( 'select#dimax_size_guide-display' ).trigger( 'change' );

				unblock();
			}
		});
	} );

	/**
	 * Block edit screen
	 */
	function block() {
		if ( ! $.fn.block ) {
			return;
		}

		$( '#woocommerce-product-data' ).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});
	}

	/**
	 * Unblock edit screen
	 */
	function unblock() {
		if ( ! $.fn.unblock ) {
			return;
		}

		$( '#woocommerce-product-data' ).unblock();
	}
} );