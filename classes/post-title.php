<?php

class PWCCRM_PostTitle {

	public $_post;

	protected static $posts;

	/**
	 * @param int|WP_Post|null  $post_id  (Optional) Post ID or post object.
	 */
	function __construct( $post_id ) {
		$this->_post = get_post( $post_id );
	}

	function __toString() {
		return $this->rendered();
	}

	function rendered() {
		$title = $this->raw();

		if ( strlen( $title ) == 0 ) {
			$title = '';
		}

		return $title;
	}

	function raw() {
		return get_the_title( $this->_post );
	}

}
