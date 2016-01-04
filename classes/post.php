<?php

// Function names are inspired by the WP-API view endpoint.
// This will make it easier to use the same Mustache templates
// for both PHP and JavaScript implementations.

// This class liberally borrows from Joe Hoyle's work on
// humanmade/WordPress-Objects
class PWCCRM_Post {

	public $_post;
	public $_date;

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

	/**
	 * Unique identifier for the object.
	 */
	function id() {
		return (int) $this->_post->id;
	}

	/**
	 * The date the object was published.
	 */
	function date() {
		$_date = $this->_date_instance();
		return $_date;
	}

	/**
	 * The date the object was published, as GMT.
	 */
	function date_gmt() {
		$_date = $this->_date_instance();
		return $_date->date_gmt();
	}

	/**
	 * The globally unique identifier for the object.
	 */
	function guid() {
		return apply_filters( 'get_the_guid', $this->_post->guid );
	}

	/**
	 * URL to the object. (Permalink)
	 */
	function link() {
		return get_permalink( $this->_post->ID );
	}

	/**
	 * The date the object was last modified.
	 */
	function modified() {
		$_date = $this->_date_instance();
		return $_date->modified();
	}

	/**
	 * The date the object was last modified, as GMT
	 */
	function modified_gmt() {
		$_date = $this->_date_instance();
		return $_date->modified_gmt();
	}

	/**
	 * An alphanumeric identifier for the object unique to its type.
	 */
	function slug() {
		return $this->_post->post_name;
	}

	/**
	 * Type of Post for the object.
	 */
	function type() {
		return $this->_post->post_type;
	}

	/**
	 * The title for the object.
	 */
	function title() {
		return esc_html( get_the_title( $this->_post->ID ) );
	}

	/**
	 * The content for the object.
	 */
	function content() {
		return new PWCCRM_PostContent( $this->_post );
	}

	/**
	 * The ID for the author of the object.
	 */
	function author() {
		return (int) $this->_post->post_author;
	}

	/**
	 * The excerpt for the object.
	 */
	function excerpt() {
		return $this->prepare_excerpt_response( $this->_post->post_excerpt );
	}

	/**
	 * ID of the featured image for the object.
	 */
	function featured_image() {
		return (int) get_post_thumbnail_id( $this->_post->ID );
	}

	/**
	 * Whether or not comments are open on the object.
	 */
	function comment_status() {
		return $this->_post->comment_status;
	}

	/**
	 * Whether or not the object can be pinged.
	 */
	function ping_status() {
		return $this->_post->ping_status;
	}

	/**
	 * The format for the object.
	 */
	function format() {
		$format = get_post_format( $this->_post->ID );
		if ( empty( $format ) ) {
			$format = 'standard';
		}
		return $format;
	}

	/**
	 * Whether or not the object should be treated as sticky.
	 */
	function sticky() {
		return is_sticky( $this->_post->ID );
	}

	/**
	 * Return the post date instance, creating it first if needs be.
	 */
	private function _date_instance() {
		if ( ! $this->_date ) {
			$this->_date = new PWCCRM_PostDate( $this->_post );
		}
		return $this->_date;
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