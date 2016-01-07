<?php

// Function names are inspired by the WP-API view endpoint.
// This will make it easier to use the same Mustache templates
// for both PHP and JavaScript implementations.

class PWCCRM_User {

	private $_user_id;
	private $_avatars;
	private $_getters;

	/**
	 * @param int $user_id
	 */

	function __construct( $user_id ) {
		if ( empty( $user_id ) ) {
			throw new Exception( '$user_id empty' );
		}

		$this->_getters = array(
			'description',
			'link',
			'slug',
			'url',
		);

		if ( ! isset( $this->_user_id ) ) {
			$this->_user_id = $user_id;
		}
	}

	/**
	 * Return the user's ID.
	 */
	function id() {
		return (int) get_the_author_meta( 'ID', $this->_user_id );
	}

	/**
	 * Return the avatar_urls.
	 *
	 * The object uses the __get magic method to return the size dynamically.
	 * Eg user.avatar_urls.67 will return a URL of the 67x67 image.
	 */
	function avatar_urls() {
		if ( ! $this->_avatars ) {
			$this->_avatars = new PWCCRM_UserAvatars( $this->_user_id );
		}
		return $this->_avatars;
	}

	/**
	 * Fake isset for magic getters.
	 */
	function __isset( $name ) {
		return in_array( $name, $this->_getters );
	}

	/**
	 * magic getter for profile data
	 */
	function __get( $name ) {
		if ( in_array( $name, $this->_getters ) ) {
			return get_the_author_meta( $name, $this->_user_id );
		}
		return '';
	}

	/**
	 * The user's archive link.
	 */
	function link() {
		return get_author_posts_url( $this->_user_id );
	}

	/**
	 * The user's display name.
	 */
	function name() {
		return get_the_author_meta( 'display_name', $this->_user_id );
	}

	/**
	 * The user's slug.
	 */
	function slug() {
		return get_the_author_meta( 'user_nicename', $this->_user_id );
	}


}
