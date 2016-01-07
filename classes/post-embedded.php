<?php

class PWCCRM_PostEmbedded {

	public $_post;
	private $_author;

	protected static $posts;

	/**
	 * @param int|WP_Post|null  $post_id  (Optional) Post ID or post object.
	 */
	function __construct( $post_id ) {
		$this->_post = get_post( $post_id );
	}

	function author() {
		if ( ! $this->_author ) {
			$author_id = get_the_author_meta( 'ID', $this->_post->post_author );
			$this->_author = new PWCCRM_User( $author_id );
		}
		return array( $this->_author );
	}

}
