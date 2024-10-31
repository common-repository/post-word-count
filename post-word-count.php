<?php
/*
Plugin Name: Post Word Count
Plugin URI: http://wordpress.org/extend/plugins/post-word-count/
Description: Outputs the total number of words in all posts or the number of words in a single post.
Version: 1.2
Author: Nick Momrik
Author URI: http://nickmomrik.com/
*/

function mdv_post_word_count( $single = false ) {
    global $wpdb, $id;
	$now = gmdate( 'Y-m-d H:i:s', time() );

    if ( $single ) {
	    $query = $wpdb->prepare( "SELECT post_content FROM $wpdb->posts WHERE ID = %d", $id );
    } else {
	    $query = $wpdb->prepare( "SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish' AND post_date < %s", $now );
    }
	
	$words = $wpdb->get_results( $query );
	if ( $words ) {
		$oldcount = 0;
		foreach ( $words as $word ) {
			$post = strip_tags( $word->post_content );
			$post = explode( ' ', $post );
			$count = count( $post );
			$totalcount = $count + $oldcount;
			$oldcount = $totalcount;
		}
	} else {
		$totalcount = 0;
	}

	echo number_format( $totalcount );
}
