<?php
/**
 * Shopper functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shopper
 */

/**
 * Assign the shopper version to a var
 */
$shopper_theme              = wp_get_theme( 'shopper' );
$shopper_version = $shopper_theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	
	$content_width = 980; /* pixels */
}

$shopper = (object) array(
	'version' => $shopper_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require_once 'inc/class-shopper.php',
	'customizer' => require_once 'inc/customizer/class-shopper-customizer.php',
);


require_once 'inc/shopper-functions.php';
require_once 'inc/shopper-template-hooks.php';
require_once 'inc/shopper-template-functions.php';
require_once 'inc/customizer/include-kirki.php';
require_once  'inc/customizer/class-shopper-pro-kirki.php';

if ( is_admin() ) {
	
	$shopper->admin = require 'inc/admin/class-shopper-admin.php';
}

/**
 * All for WooCommerce functions
 */
if ( shopper_is_woocommerce_activated() ) {
	
	$shopper->woocommerce = require_once 'inc/woocommerce/class-shopper-woocommerce.php';

	require_once 'inc/woocommerce/shopper-wc-template-hooks.php';
	require_once 'inc/woocommerce/shopper-wc-template-functions.php';
}
function wooc_extra_register_fields() {?>
       <p class="form-row form-row-wide">
       <label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
       <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
       </p>
       <p class="form-row form-row-first">
       <label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
       </p>
       <p class="form-row form-row-last">
       <label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
       </p>
       <p class="form-row form-row-first">
       <label for="reg_billing_postcode"><?php _e( 'Postcode', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_postcode" id="reg_billing_postcode" value="<?php if ( ! empty( $_POST['billing_postcode'] ) ) esc_attr_e( $_POST['billing_postcode'] ); ?>" />
       </p>
       <p class="form-row form-row-last">
       <label for="reg_billing_city"><?php _e( 'City', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />
       </p>
       <p class="form-row form-row-wide">
       <label for="reg_dni"><?php _e( 'DNI', 'woocommerce' ); ?><span class="required">*</span></label>
       <input type="text" class="input-text" name="dni" id="reg_dni" value="<?php if ( ! empty( $_POST['dni'] ) ) esc_attr_e( $_POST['dni'] ); ?>" />
       </p>
       <div class="clear"></div>
       <?php
 }
 add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
      if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
             $validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: El nombre es obligatorio', 'woocommerce' ) );
      }
      if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
             $validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Al menos un apellido es obligatorio.', 'woocommerce' ) );
      }
      if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
             $validation_errors->add( 'billing_city_error', __( '<strong>Error</strong>: La ciudad es obligatoria', 'woocommerce' ) );
      }
      if ( isset( $_POST['billing_postcode'] ) && empty( $_POST['billing_postcode'] ) ) {
             $validation_errors->add( 'billing_postcode_error', __( '<strong>Error</strong>: El código postal es obligatorio', 'woocommerce' ) );
      }
      if ( isset( $_POST['billing_dni'] ) && empty( $_POST['billing_dni'] ) ) {
             $validation_errors->add( 'billing_dni_error', __( '<strong>Error</strong>: Es necesario introducir un DNI válido', 'woocommerce' ) );
      }
         return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

function wooc_save_extra_register_fields( $customer_id ) {
    if ( isset( $_POST['billing_phone'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
          }
      if ( isset( $_POST['billing_first_name'] ) ) {
             //First name field which is by default
             update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
             // First name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
      }
      if ( isset( $_POST['billing_last_name'] ) ) {
             // Last name field which is by default
             update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
             // Last name field which is used in WooCommerce
             update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
      }
      if ( isset( $_POST['billing_city'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
          }
      if ( isset( $_POST['billing_postcode'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_postcode'] ) );
          }
       if ( isset( $_POST['dni'] ) ) {
                 // Phone input filed which is used in WooCommerce
                 update_user_meta( $customer_id, 'dni', sanitize_text_field( $_POST['dni'] ) );
          }
}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

//FOTO
add_action( 'woocommerce_register_form', 'bbloomer_add_woo_account_registration_fields' );
  
function bbloomer_add_woo_account_registration_fields() {
    
   ?>
    
   <p class="form-row" id="image" data-priority=""><label for="image" class="">Foto (Opcional: JPG, PNG)</label><span class="woocommerce-input-wrapper"><input type='file' name='image' accept='image/*,.pdf'></span></p>
    
   <?php
       
}

// 3. Save new field
 
add_action( 'user_register', 'bbloomer_save_woo_account_registration_fields', 1 );
  
function bbloomer_save_woo_account_registration_fields( $customer_id ) {
   if ( isset( $_FILES['image'] ) ) {
      require_once( ABSPATH . 'wp-admin/includes/image.php' );
      require_once( ABSPATH . 'wp-admin/includes/file.php' );
      require_once( ABSPATH . 'wp-admin/includes/media.php' );
      $attachment_id = media_handle_upload( 'image', 0 );
      if ( is_wp_error( $attachment_id ) ) {
         update_user_meta( $customer_id, 'image', $_FILES['image'] . ": " . $attachment_id->get_error_message() );
      } else {
         update_user_meta( $customer_id, 'image', $attachment_id );
      }
   }
}
 
// --------------
// 4. Add enctype to form to allow image upload
 
add_action( 'woocommerce_register_form_tag', 'bbloomer_enctype_custom_registration_forms' );
 
function bbloomer_enctype_custom_registration_forms() {
   echo 'enctype="multipart/form-data"';
}