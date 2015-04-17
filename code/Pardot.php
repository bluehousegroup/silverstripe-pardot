<?php 
class Pardot extends DataObject
{



		/**
	 * Encrypts with a bit more complexity
	 *
	 * @since 1.1.2
	 */
	public static function pardot_encrypt($input_string, $key='pardot_key'){
		if ( function_exists('mcrypt_encrypt') ) {
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$h_key = hash('sha256', $key, TRUE);
			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $h_key, $input_string, MCRYPT_MODE_ECB, $iv));
		} else {
			return base64_encode($input_string);
		}
	}

	/**
	 * Decrypts with a bit more complexity
	 *
	 * @since 1.1.2
	 */
	public static function pardot_decrypt($encrypted_input_string, $key='pardot_key'){
		if ( function_exists('mcrypt_encrypt') ) {
		    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		    $h_key = hash('sha256', $key, TRUE);
		    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $h_key, base64_decode($encrypted_input_string), MCRYPT_MODE_ECB, $iv));
	    } else {
		    return base64_decode($encrypted_input_string);
	    }
	}




}