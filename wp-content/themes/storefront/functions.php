<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version'    => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce            = require 'inc/woocommerce/class-storefront-woocommerce.php';
	$storefront->woocommerce_customizer = require 'inc/woocommerce/class-storefront-woocommerce-customizer.php';

	require 'inc/woocommerce/class-storefront-woocommerce-adjacent-products.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
	require 'inc/woocommerce/storefront-woocommerce-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';

	require 'inc/admin/class-storefront-plugin-install.php';
}

/**
 * NUX
 * Only load if wp version is 4.7.3 or above because of this issue;
 * https://core.trac.wordpress.org/ticket/39610?cversion=1&cnum_hist=2
 */
if ( version_compare( get_bloginfo( 'version' ), '4.7.3', '>=' ) && ( is_admin() || is_customize_preview() ) ) {
	require 'inc/nux/class-storefront-nux-admin.php';
	require 'inc/nux/class-storefront-nux-guided-tour.php';

	if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0.0', '>=' ) ) {
		require 'inc/nux/class-storefront-nux-starter-content.php';
	}
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */
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