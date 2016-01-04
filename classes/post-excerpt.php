<?php

class PWCCRM_PostExcerpt {

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
		$content = get_the_content();
		$content = apply_filters( 'the_content', $content );
		$content = str_replace( ']]>', ']]&gt;', $content );

		return $this->prepare_excerpt_response( $this->raw() );
	}

	function raw() {
		return $this->_post->post_excerpt;
	}


	/**
	 * Check the post excerpt and prepare it for single post output.
	 *
	 * @param string       $excerpt
	 * @return string|null $excerpt
	 */
	protected function prepare_excerpt_response( $excerpt ) {
		if ( post_password_required( $this->_post ) ) {
			return __( 'There is no excerpt because this is a protected post.' );
		}
		/** This filter is documented in wp-includes/post-template.php */
		$excerpt = apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', $excerpt ) );
		if ( empty( $excerpt ) ) {
			return '';
		}
		return $excerpt;
	}


}
