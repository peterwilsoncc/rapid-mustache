<?php
/*
Plugin Name: Rapid Mustache
Plugin URI:
Description: Mustache library for WordPress
Version:     0.1-alpha
Author:      Peter Wilson
Author URI:  http://peterwilson.cc/
Text Domain: rapid-mustache
*/

// Include Mustache if it does not exist.
if ( ! class_exists( 'Mustache_Engine' ) ) {
	// This copy of Mustache was taken from the WordPress VIP svn server
	// to include any hard coded modifications WPVIP may have made to
	// improve the security of the library.
	// Source: https://vip-svn.wordpress.com/plugins/lib/Mustache/
	include 'lib/Mustache/0-load.php';
}

include 'inc/escaping.php';

include 'classes/post.php';
include 'classes/post-content.php';
include 'classes/post-date.php';
include 'classes/post-embedded.php';
include 'classes/post-excerpt.php';
include 'classes/post-guid.php';
include 'classes/post-title.php';

include 'classes/user.php';
include 'classes/user-avatars.php';
