<?php
/**
 * License from amember http api softsale module
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package Idmuvi Core
 */

if ( ! function_exists( 'idmuvi_core_license_menu' ) ) {
	/**
	 * License Menus
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_license_menu() {
		add_plugins_page( __( 'Muvipro License', 'idmuvi-core' ), __( 'Muvipro License', 'idmuvi-core' ), 'manage_options', IDMUVI_PLUGIN_LICENSE_PAGE, 'idmuvi_core_license_page' );
	}
} // endif idmuvi_core_license_menu
add_action( 'admin_menu', 'idmuvi_core_license_menu' );

if ( ! function_exists( 'idmuvi_core_license_page' ) ) {
	/**
	 * License Page with html
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_license_page() {
		$status = trim( get_option( 'newidmuvi_core_license_status' . md5( home_url() ) ) );
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Muvipro License Options', 'idmuvi-core' ); ?></h2>
			<form method="post" action="options.php">

				<?php settings_fields( 'idmuvi_core_license' ); ?>

				<table class="form-table">
					<tbody>
						<tr valign="top">
							<th scope="row" valign="top">
								<?php esc_html_e( 'License Key', 'idmuvi-core' ); ?>
							</th>
							<td>
								<input id="idmuvi_core_license_key" name="idmuvi_core_license_key" type="text" placeholder="XXXXX_xxxxxxxxxxxxxxx" class="regular-text" /><br />
								<label class="description" for="idmuvi_core_license_key"><?php esc_html_e( 'Enter your license key here', 'idmuvi-core' ); ?></label>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row" valign="top">
								<?php esc_html_e( 'Activate License', 'idmuvi-core' ); ?>
							</th>

							<td>
								<?php if ( ! empty( $status ) && 'ok' === $status ) { ?>
									<input type="submit" style="background: #dff0d8 !important;color: #3c763d !important;text-shadow: none !important;" class="button-secondary" name="" disabled value="<?php esc_html_e( 'License Active' ); ?>"/>
									<?php wp_nonce_field( 'idmuvi_core_license_nonce', 'idmuvi_core_license_nonce' ); ?>
									<input type="submit" class="button-secondary" name="idmuvi_core_license_deactivate" value="<?php esc_html_e( 'Deactivate License', 'idmuvi-core' ); ?>"/><br />
									<label class="description" for="idmuvi_core_license_key"><br />
										<?php esc_html_e( 'Congratulations, your license is active.', 'idmuvi-core' ); ?><br />
										<?php esc_html_e( 'You can disable license for this domain by entering the license key to the form and clicking Deactivate License', 'idmuvi-core' ); ?></label>
									<?php idmuvi_core_check_license(); ?>
									<?php
								} else {
									wp_nonce_field( 'idmuvi_core_license_nonce', 'idmuvi_core_license_nonce' );
									?>
									<input type="submit" class="button-secondary" name="idmuvi_core_license_activate" value="<?php esc_html_e( 'Activate License', 'idmuvi-core' ); ?>"/>
								<?php } ?>
							</td>
						</tr>

					</tbody>
				</table>

			</form>
		<?php
	}
}

if ( ! function_exists( 'idmuvi_core_register_option' ) ) {
	/**
	 * License Page with html
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_register_option() {
		// creates our settings in the options table.
		register_setting( 'idmuvi_core_license', 'newidmuvi_core_license_key' . md5( home_url() ), 'idmuvi_core_sanitize_license' );
	}
}
add_action( 'admin_init', 'idmuvi_core_register_option' );

if ( ! function_exists( 'idmuvi_core_de_license' ) ) {
	/**
	 * Simple method to encrypt or decrypt a plain text string
	 * initialization vector(IV) has to be the same when encrypting and decrypting
	 *
	 * @param string $action can be 'encrypt' or 'decrypt'.
	 * @param string $string string to encrypt or decrypt.
	 *
	 * @since 1.0.9
	 * @return string
	 */
	function idmuvi_core_de_license( $action, $string ) {
		$output         = false;
		$encrypt_method = 'AES-256-CBC';
		$secret_key     = 'This is my secret key';
		$secret_iv      = 'This is my secret iv';
		// hash.
		$key = hash( 'sha256', $secret_key );
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning.
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		if ( 'e' === $action ) {
			$output = openssl_encrypt( $string, $encrypt_method, $key, 0, $iv );
			$output = base64_encode( $output );
		} elseif ( 'd' === $action ) {
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
		return $output;
	}
}

if ( ! function_exists( 'idmuvi_core_sanitize_license' ) ) {
	/**
	 * Sanitize license
	 *
	 * @param string $new new password.
	 * @since 1.0.0
	 * @return string
	 */
	function idmuvi_core_sanitize_license( $new ) {
		$old = get_option( 'newidmuvi_core_license_key' . md5( home_url() ) );
		if ( $old && $new !== $old ) {
			delete_option( 'newidmuvi_core_license_status' . md5( home_url() ) ); // new license has been entered, so must reactivate.
		}
		return $new;
	}
}

if ( ! function_exists( 'idmuvi_core_activate_license' ) ) {
	/**
	 * This illustrates how to activate a license key
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_activate_license() {

		// listen for our activate button to be clicked.
		if ( isset( $_POST['idmuvi_core_license_activate'] ) ) {

			$license = ! empty( $_POST['idmuvi_core_license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['idmuvi_core_license_key'] ) ) : ''; // Input var okay.
			$url     = home_url();

			// run a quick security check.
			if ( ! check_admin_referer( 'idmuvi_core_license_nonce', 'idmuvi_core_license_nonce' ) ) {
				return; // get out if we didn't click the Activate button.
			}

			// data to send in our API request.
			$api_params = array(
				'key'          => $license,
				'request[url]' => esc_url( $url ),
			);

			// Send query to the license manager server.
			$query    = esc_url_raw( add_query_arg( $api_params, IDMUVI_API_URL ) );
			$response = wp_remote_get(
				$query,
				array(
					'timeout'   => 60,
					'sslverify' => false,
				)
			);

			// make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.', 'idmuvi-core' );
				}
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( 'ok' !== $license_data->code ) {
					switch ( $license_data->code ) {
						case 'license_empty':
							$message = __( 'Empty or invalid license key submitted.', 'idmuvi-core' );
							break;

						case 'license_not_found':
							$message = __( 'License key not found on our server.', 'idmuvi-core' );
							break;

						case 'license_disabled':
							$message = __( 'License key has been disabled.', 'idmuvi-core' );
							break;

						case 'license_expired':
							$message = __( 'Your license key expired on', 'idmuvi-core' ) . ' ' . date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) );
							break;

						case 'activation_server_error':
							$message = __( 'Activation server error.', 'idmuvi-core' );
							break;

						case 'invalid_input':
							$message = __( 'Activation failed: invalid input.', 'idmuvi-core' );
							break;

						case 'no_spare_activations':
							$message = sprintf( __( 'No more activations allowed. You must buy new license key.', 'idmuvi-core' ) );
							break;

						case 'no_activation_found':
							$message = __( 'No activation found for this installation.', 'idmuvi-core' );
							break;

						case 'no_reactivation_allowed':
							$message = __( 'Re-activation is not allowed', 'idmuvi-core' );
							break;

						case 'other_error':
							$message = __( 'Error returned from activation server', 'idmuvi-core' );
							break;

						default:
							$message = __( 'An error occurred, please try again.', 'idmuvi-core' );
							break;
					}
				}
			}

			// Check if anything passed on a message constituting a failure.
			if ( ( empty( $message ) ) && ( '1' === $license_data->scheme_id || '2' === $license_data->scheme_id || '3' === $license_data->scheme_id ) ) {
				// Save the license key in the options table.
				$e_license = idmuvi_core_de_license( 'e', $license );
				update_option( 'newidmuvi_core_license_key' . md5( home_url() ), $e_license );
				update_option( 'newidmuvi_core_license_status' . md5( home_url() ), 'ok' );

				wp_safe_redirect( admin_url( 'plugins.php?page=' . IDMUVI_PLUGIN_LICENSE_PAGE ) );
				exit();
			} else {
				$base_url = admin_url( 'plugins.php?page=' . IDMUVI_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					array(
						'idmuvi_core_activation' => 'false',
						'message'                => rawurlencode( $message ),
					),
					$base_url
				);

				wp_safe_redirect( $redirect );
				exit();
			}
		}
	}
}
add_action( 'admin_init', 'idmuvi_core_activate_license' );

if ( ! function_exists( 'idmuvi_core_deactivate_license' ) ) {
	/**
	 * This illustrates how to deactivate a license key
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_deactivate_license() {
		// listen for our activate button to be clicked.
		if ( isset( $_POST['idmuvi_core_license_deactivate'] ) ) {

			$license = ! empty( $_POST['idmuvi_core_license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['idmuvi_core_license_key'] ) ) : '';
			$url     = home_url();

			// run a quick security check.
			if ( ! check_admin_referer( 'idmuvi_core_license_nonce', 'idmuvi_core_license_nonce' ) ) {
				return; // get out if we didn't click the Activate button.
			}

			// data to send in our API request.
			$api_params = array(
				'key'          => $license,
				'request[url]' => esc_url( $url ),
			);

			// Send query to the license manager server.
			$query    = esc_url_raw( add_query_arg( $api_params, IDMUVI_API_URL_DEACTIVATED ) );
			$response = wp_remote_get(
				$query,
				array(
					'timeout'   => 60,
					'sslverify' => false,
				)
			);

			// make sure the response came back okay.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$message = $response->get_error_message();
				} else {
					$message = __( 'An error occurred, please try again.', 'idmuvi-core' );
				}
			} else {
				$license_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( 'ok' !== $license_data->code ) {
					switch ( $license_data->code ) {
						case 'license_empty':
							$message = __( 'Empty or invalid license key submitted.', 'idmuvi-core' );
							break;

						case 'license_not_found':
							$message = __( 'License key not found on our server.', 'idmuvi-core' );
							break;

						case 'activation_server_error':
							$message = __( 'Activation server error.', 'idmuvi-core' );
							break;

						case 'invalid_input':
							$message = __( 'Activation failed: invalid input.', 'idmuvi-core' );
							break;

						case 'other_error':
							$message = __( 'Error returned from activation server', 'idmuvi-core' );
							break;

						default:
							$message = __( 'An error occurred, please try again.', 'idmuvi-core' );
							break;
					}
				}
			}
			// Check if anything passed on a message constituting a failure.
			if ( ( empty( $message ) ) && ( '1' === $license_data->scheme_id || '2' === $license_data->scheme_id || '3' === $license_data->scheme_id ) ) {
				$base_url = admin_url( 'plugins.php?page=' . IDMUVI_PLUGIN_LICENSE_PAGE );
				$redirect = add_query_arg(
					array(
						'idmuvi_core_activation' => 'false',
						'message'                => rawurlencode( $message ),
					),
					$base_url
				);

				wp_safe_redirect( $redirect );
				exit();
			} else {
				// Save the license key in the options table.
				update_option( 'newidmuvi_core_license_key' . md5( home_url() ), '' );
				update_option( 'newidmuvi_core_license_status' . md5( home_url() ), '' );

				wp_safe_redirect( admin_url( 'plugins.php?page=' . IDMUVI_PLUGIN_LICENSE_PAGE ) );
				exit();
			}
		}
	}
}
add_action( 'admin_init', 'idmuvi_core_deactivate_license' );

if ( ! function_exists( 'idmuvi_core_check_license' ) ) {
	/**
	 * This illustrates how to check a license key every 7 * 24 * HOUR_IN_SECONDS
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_check_license() {

		if ( false === get_transient( 'idmuvi-core-license-transient' ) ) {

			$license = trim( get_option( 'newidmuvi_core_license_key' . md5( home_url() ) ) );

			$d_license = idmuvi_core_de_license( 'd', $license );

			// data to send in our API request.
			$api_params = array(
				'key' => $d_license,
			);

			// Send query to the license manager server.
			$query = esc_url_raw( add_query_arg( $api_params, IDMUVI_API_URL_CHECK ) );

			$response = wp_remote_get(
				$query,
				array(
					'timeout'   => 20,
					'sslverify' => false,
				)
			);

			// Check for error.
			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				return;
			}

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );

			// Check for error.
			if ( is_wp_error( $license_data ) ) {
				return;
			}

			// Store remote HTML file in transient, expire after 24 hours.
			set_transient( 'idmuvi-core-license-transient', $license_data, 2 * 24 * HOUR_IN_SECONDS );

			if ( 'ok' !== $license_data->code ) {
				delete_option( 'newidmuvi_core_license_key' . md5( home_url() ) );
				delete_option( 'newidmuvi_core_license_status' . md5( home_url() ) ); // new license has been entered, so must reactivate.
			}
		}
	}
}


if ( ! function_exists( 'idmuvi_core_admin_notices' ) ) {
	/**
	 * This is a means of catching errors from the activation method above and displaying it to the customer
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function idmuvi_core_admin_notices() {
		if ( isset( $_GET['idmuvi_core_activation'] ) && ! empty( $_GET['message'] ) ) {
			switch ( $_GET['idmuvi_core_activation'] ) {
				case 'false':
					$message = rawurldecode( sanitize_text_field( wp_unslash( $_GET['message'] ) ) );
					?>
					<div class="error">
						<p><?php echo esc_html( $message ); ?></p>
					</div>
					<?php
					break;

				case 'true':
				default:
					?>
					<div class="success">
						<p><?php echo esc_html_e( 'Success.', 'idmuvi-core' ); ?></p>
					</div>
					<?php
					break;

			}
		}
	}
}
add_action( 'admin_notices', 'idmuvi_core_admin_notices' );
