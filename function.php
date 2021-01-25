<?php

/**
 * Plugin Name: Custom Field Registration Form
 * Description: Add custom field.
 * Version: 0.1
 * Author: Matteo Rigamonti
 * Author URI: https://matteorigamonti.info/
 */

defined( 'ABSPATH' ) || exit;

function wooc_extra_register_fields() { ?>

	<p class="form-row form-row-first">
		<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
	</p>

	<p class="form-row form-row-last">
		<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
	</p>

	<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php _e( 'Phone', 'woocommerce' ); ?></label>
		<input type="tel" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php esc_attr_e( $_POST['billing_phone'] ); ?>" />
	</p>

	<p class="form-row form-row-wide">
		<label for="reg_birthday"><?php _e( 'Date of birth', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="date" class="input-text birthday" min="1900-01-01" max="<?php echo date("Y-m-d") ?>" name="birthday" id="reg_birthday" value="<?php esc_attr_e( $_POST['birthday'] ); ?>" />
	</p>

	<p class="form-row form-row-wide">
		<label for="reg_role"><?php _e( 'Private or editor?', 'woocommerce' ); ?></label>
		<select class="input-text" name="role" id="reg_role">
			<option <?php if ( ! empty( $_POST['role'] ) && $_POST['role'] == 'customer') esc_attr_e( 'selected' ); ?> value="customer">private</option>
			<option <?php if ( ! empty( $_POST['role'] ) && $_POST['role'] == 'editor') esc_attr_e( 'selected' ); ?> value="editor">editor</option>
		</select>
	</p>

	<p style="display: none;" class="form-row form-row-wide editor-field">
		<label for="reg_p_iva"><?php _e( 'P. Iva', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text p_iva" name="p_iva" id="reg_p_iva" value="<?php if ( ! empty( $_POST['p_iva'] ) ) esc_attr_e( $_POST['p_iva'] ); ?>" />
	</p>

	<p style="display: none;" class="form-row form-row-wide editor-field">
		<label for="reg_ragione_sociale"><?php _e( 'Ragione sociale', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text ragione_sociale" name="ragione_sociale" id="reg_ragione_sociale" value="<?php if ( ! empty( $_POST['ragione_sociale'] ) ) esc_attr_e( $_POST['ragione_sociale'] ); ?>" />
	</p>

	<p style="display: none;" class="form-row form-row-wide editor-field">
		<label for="reg_pec"><?php _e( 'Pec', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="email" class="input-text pec" name="pec" id="reg_ragione_sociale" value="<?php if ( ! empty( $_POST['pec'] ) ) esc_attr_e( $_POST['pec'] ); ?>" />
	</p>

	<p style="display: none;" class="form-row form-row-wide editor-field">
		<label for="reg_codice_sdi"><?php _e( 'Codice SDI', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text codice_sdi" name="codice_sdi" id="reg_codice_sdi" value="<?php if ( ! empty( $_POST['codice_sdi'] ) ) esc_attr_e( $_POST['codice_sdi'] ); ?>" />
	</p>
	<div class="clear"></div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
		$('#reg_role').on('change',function(){
			if ( $(this).val()==="editor" ){
				$('.editor-field').show();
			}
			else {
				$('.editor-field').hide()
			}
		});
	</script>

<?php }
add_action( 'woocommerce_register_form', 'wooc_extra_register_fields' );





/**
 * Register fields Validating.
 */
function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$validation_errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: Nome richiesto!', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
		$validation_errors->add( 'billing_phone_error', __( '<strong>Error</strong>: Telefono richiesto!', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$validation_errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Cognome richiesto!.', 'woocommerce' ) );
	}

	if ( isset($_POST['birthday']) && empty($_POST['birthday']) ) {
		$validation_errors->add('birthday_error', __('<strong>Error</strong>: Birthday required.', 'woocommerce'));
	}

	if ( isset( $_POST['role'] ) && ! empty( $_POST['role'] == 'editor' ) ) {

		if ( isset($_POST['p_iva']) && empty($_POST['p_iva']) ) {
			$validation_errors->add('p_iva_error', __('<strong>Error</strong>: P. Iva required.', 'woocommerce'));
		}

		if ( isset($_POST['ragione_sociale']) && empty($_POST['ragione_sociale']) ) {
			$validation_errors->add('ragione_sociale_error', __('<strong>Error</strong>: Ragione sociale required.', 'woocommerce'));
		}

		if ( isset($_POST['pec']) && empty($_POST['pec']) ) {
			$validation_errors->add('pec_error', __('<strong>Error</strong>: PEC required.', 'woocommerce'));
		}

		if ( isset($_POST['codice_sdi']) && empty($_POST['codice_sdi']) ) {
			$validation_errors->add('codice_sdi_error', __('<strong>Error</strong>: Codice sdi required.', 'woocommerce'));
		}

	}
	return $validation_errors;
}
add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );


/**
* Below code save extra fields.
*/
function wooc_save_extra_register_fields( $customer_id ) {

	// First name field
	if ( isset( $_POST['billing_first_name'] ) ) {
		update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) ); // Wordpress field
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) ); // Woocommerce field
	}
	
	// Last name field
	if ( isset( $_POST['billing_last_name'] ) ) {
		update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) ); // Wordpress field
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) ); // Woocommerce field
	}

	// Phone field
	if ( isset( $_POST['billing_phone'] ) ) {
		update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
	}

	// Birthday field
	if ( isset( $_POST['birthday'] ) ) {
		update_user_meta( $customer_id, 'birthday', sanitize_text_field( $_POST['birthday'] ) );
	}
	
	// Role field selected
	if ( isset($_POST['role']) ) {
		if( $_POST['role'] == 'editor' ){
			$user = new WP_User($customer_id);
			$user->set_role('editor');
		}
	}

	// Save in database if you select editor
	if ( isset($_POST['role']) ) {
		if( $_POST['role'] == 'editor' ){

			// P. Iva field
			if ( isset( $_POST['p_iva'] ) ) {
				update_user_meta( $customer_id, 'p_iva', sanitize_text_field( $_POST['p_iva'] ) );
			}
		
			// Ragione sociale field
			if ( isset( $_POST['ragione_sociale'] ) ) {
				update_user_meta( $customer_id, 'ragione_sociale', sanitize_text_field( $_POST['ragione_sociale'] ) );
			}
		
			// PEC field
			if ( isset( $_POST['pec'] ) ) {
				update_user_meta( $customer_id, 'pec', sanitize_text_field( $_POST['pec'] ) );
			}
		
			// Codice sdi field
			if ( isset( $_POST['codice_sdi'] ) ) {
				update_user_meta( $customer_id, 'codice_sdi', sanitize_text_field( $_POST['codice_sdi'] ) );
			}

		}
	}

}
add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );
// add_action( 'woocommerce_save_account_details', 'wooc_save_extra_register_fields' );
// add_action( 'woocommerce_update_customer', 'wooc_save_extra_register_fields' );



















function wooc_extra_edit_fields() {
	$usermeta_billing_phone = get_user_meta( get_current_user_id(), 'billing_phone', true );
	$usermeta_birthday = get_user_meta( get_current_user_id(), 'birthday', true );
	?>

	<h4><?php esc_html_e( 'More information', 'woocommerce' ); ?></h4>
	<p class="form-row form-row-wide">
		<label for="reg_billing_phone"><?php esc_html_e( 'Phone', 'woocommerce' ); ?></label>
		<input type="tel" class="input-text" name="account_billing_phone" id="account_billing_phone" value="<?php echo $usermeta_billing_phone; ?>" />
	</p>

	<h3><?php var_dump($usermeta_billing_phone); ?></h3>

	<p id="otherType" class="form-row form-row-wide editor-field">
		<label for="reg_birthday"><?php esc_html_e( 'Birthday', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="date" class="input-text birthday" min="1900-01-01" max="<?php echo date("Y-m-d") ?>" name="birthday" id="reg_birthday" value="<?php echo $usermeta_birthday; ?>" />
	</p>

	<?php
	$user = wp_get_current_user();
	if ( in_array( 'editor', (array) $user->roles ) ) { ?>

	<h4>Info profilo editore</h4>
	<p id="otherType" class="form-row form-row-wide editor-field">
		<label for="reg_p_iva"><?php esc_html_e( 'P. Iva', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text p_iva" name="p_iva" id="reg_p_iva" value="<?php if ( ! empty( $_POST['p_iva'] ) ) esc_attr_e( $_POST['p_iva'] ); ?>" />
	</p>

	<p id="otherType" class="form-row form-row-wide editor-field">
		<label for="reg_ragione_sociale"><?php esc_html_e( 'Ragione sociale', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text ragione_sociale" name="ragione_sociale" id="reg_ragione_sociale" value="<?php if ( ! empty( $_POST['ragione_sociale'] ) ) esc_attr_e( $_POST['ragione_sociale'] ); ?>" />
	</p>

	<p id="otherType" class="form-row form-row-wide editor-field">
		<label for="reg_pec"><?php esc_html_e( 'Pec', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="email" class="input-text pec" name="pec" id="reg_ragione_sociale" value="<?php if ( ! empty( $_POST['pec'] ) ) esc_attr_e( $_POST['pec'] ); ?>" />
	</p>

	<p id="otherType" class="form-row form-row-wide editor-field">
		<label for="reg_codice_sdi"><?php esc_html_e( 'Codice SDI', 'woocommerce' ); ?><span class="required">*</span></label>
		<input type="text" class="input-text codice_sdi" name="codice_sdi" id="reg_codice_sdi" value="<?php if ( ! empty( $_POST['codice_sdi'] ) ) esc_attr_e( $_POST['codice_sdi'] ); ?>" />
	</p>

	<div class="clear"></div>

	<?php }

}
add_action( 'woocommerce_edit_account_form', 'wooc_extra_edit_fields', 10 );