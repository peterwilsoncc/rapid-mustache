<?php

class PWCCRM_UserAvatars {

	private $_user_id;

	/**
	 * Get the WordPress WP_User object
	 * @param int $user_id
	 */

	function __construct( $user_id ) {
		if ( empty( $user_id ) ) {
			throw new Exception( '$user_id empty' );
		}

		if ( ! isset( $this->_user_id ) ) {
			$this->_user_id = $user_id;
		}
	}

	function __isset( $name ) {
		if ( is_numeric( $name ) && $name == (int) $name && $name == absint( $name ) ) {
			return true;
		}
		return false;
	}

	function __get( $name ) {
		if ( is_numeric( $name ) && $name == (int) $name && $name == absint( $name ) ) {
			return get_avatar_url( $this->_user_id, array( 'size' => $name ) );
		}
		return '';
	}
}
