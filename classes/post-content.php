<?php

class PWCCRM_PostContent {

	public $_post;
	public $_content;

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
		$content = $this->raw();
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $content;
	}

	function raw() {
		if ( ! isset( $this->_content ) ) {
			setup_postdata( $this->_post );
			$this->_content = get_the_content();
			wp_reset_postdata();
		}
		return $this->_content;
	}

}
