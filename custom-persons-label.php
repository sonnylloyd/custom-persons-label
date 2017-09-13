<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/**
 * Plugin Name: customs persons label
 * Description: allowes the user to change the persons label per product when using woocommerce bookable with persons enabled
 * Version: 1.0.0
 * Author: Sonny Lloyd
 * Author URI: https://uk.linkedin.com/in/sonnylloyduk
 */

 if ( in_array( 'woocommerce-bookings/woocommmerce-bookings.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	 	$prefix = "custom_field_type_";
			function custom_persons_label_woocommerce_general_product_data_custom_field() {
			   global $woocommerce, $post;
					woocommerce_wp_text_input(
						array(
							'id'          => $prefix.'presons_label',
							'label'       => __( 'Persons Label', 'woocommerce' ),
							'placeholder' => 'Persons',
							'desc_tip'    => 'true',
							'description' => __( 'Enter the label you would like to replace persons with.', 'woocommerce' )
						)
					);
			}
			function custom_persons_label_woo_add_custom_general_fields_save( $post_id ){
			 $woocommerce_text_field = $_POST[$prefix.'presons_label'];
			 if( !empty( $woocommerce_text_field ) )
				 update_post_meta( $post_id, $prefix.'presons_label', esc_attr( $woocommerce_text_field ) );
		 }
      function custom_persons_label_booking_form_fields( $fields ) {
        $label = get_post_meta( get_the_ID(), $prefix.'presons_label', true );
        if($label){
          $fields['wc_bookings_field_persons']['label'] = $label;
        }
      	return $fields;
      }
     add_action( 'woocommerce_product_options_general_product_data', 'custom_persons_label_woocommerce_general_product_data_custom_field' );
     add_action( 'woocommerce_process_product_meta', 'custom_persons_label_woo_add_custom_general_fields_save' );
     add_filter( 'booking_form_fields', 'custom_persons_label_booking_form_fields' );
 }
?>
