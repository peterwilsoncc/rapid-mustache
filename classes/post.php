<?php

// Function names are inspired by the WP-API view endpoint.
// This will make it easier to use the same Mustache templates
// for both PHP and JavaScript implementations.

// This class liberally borrows from Joe Hoyle's work on
// humanmade/WordPress-Objects
class PWCCRM_Post {

	public $_post;
	public $_date;
	public $_excerpt;
	public $_guid;
	public $_title;
	public $_embedded;

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
		return (int) $this->_post->ID;
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
		if ( ! $this->_guid ) {
			$this->_guid = new PWCCRM_PostGuid( $this->_post );
		}
		return $this->_guid;
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
		if ( ! $this->_title ) {
			$this->_title = new PWCCRM_PostTitle( $this->_post );
		}
		return $this->_title;
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
		return get_the_author_meta( 'ID', $this->_post->post_author );
	}

	/**
	 * The excerpt for the object.
	 */
	function excerpt() {
		if ( ! $this->_excerpt ) {
			$this->_excerpt = new PWCCRM_PostExcerpt( $this->_post );
		}
		return $this->_excerpt;
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
		return comments_open( $this->_post ) ? 'open' : 'closed';
	}

	/**
	 * Whether or not the object can be pinged.
	 */
	function ping_status() {
		return pings_open( $this->_post ) ? 'open' : 'closed';
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
	 * Embedded objects.
	 */
	function _embedded() {
		if ( ! $this->_embedded ) {
			$this->_embedded = new PWCCRM_PostEmbedded( $this->_post );
		}
		return $this->_embedded;
	}

	/**
	 * Return the post date instance, creating it first if needs be.
	 */
	private function _guid_instance() {
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

}