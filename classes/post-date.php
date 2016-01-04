<?php

class PWCCRM_PostDate {

	private $_post;

	protected static $posts;

	/**
	 * @param int|WP_Post|null  $post_id  (Optional) Post ID or post object.
	 */
	function __construct( $post_id ) {
		if ( is_int( $post_id ) && $this->posts[ $post_id ] ) {
			$this->_post = $this->posts[ $post_id ];
		}
		else {
			$this->_post = get_post( $post_id );
		}
	}

	function __toString() {
		return $this->date();
	}

	/**
	 * The date the object was published.
	 */
	function date() {
		$_post = &$this->_post;
		return $this->prepare_date_response( $_post->post_date_gmt, $_post->post_date );
	}

	/**
	 * The date the object was published, as GMT.
	 */
	function date_gmt() {
		$_post = &$this->_post;
		return $this->prepare_date_response( $_post->post_date_gmt );
	}

	/**
	 * The date the object was last modified.
	 */
	function modified() {
		$_post = &$this->_post;
		return $this->prepare_date_response( $this->_post->post_modified_gmt, $this->_post->post_modified );
	}

	/**
	 * The date the object was last modified, as GMT
	 */
	function modified_gmt() {
		$_post = &$this->_post;
		return $this->prepare_date_response( $this->_post->post_modified_gmt );
	}

	/**
	 * Check the post_date_gmt or modified_gmt and prepare any post or
	 * modified date for single post output.
	 *
	 * @param string       $date_gmt
	 * @param string|null  $date
	 * @return string|null ISO8601/RFC3339 formatted datetime.
	 */
	protected function prepare_date_response( $date_gmt, $date = null ) {
		if ( '0000-00-00 00:00:00' === $date_gmt ) {
			return null;
		}
		if ( isset( $date ) ) {
			return mysql_to_rfc3339( $date );
		}
		return mysql_to_rfc3339( $date_gmt );
	}

}
