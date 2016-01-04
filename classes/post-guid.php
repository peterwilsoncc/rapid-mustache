<?php

class PWCCRM_PostGuid {

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
		$guid = $this->raw();
		$id   = (int) $this->_post->id;
		$rendered = apply_filters( 'the_guid', $guid, $id );

		return $rendered;
	}

	function raw() {
		return get_the_guid( $this->_post );
	}

}
