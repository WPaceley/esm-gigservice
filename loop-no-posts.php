<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * No-Posts Loop Content Template-Part File
 *
 * @file           loop-no-posts.php
 * @package        gigservice
 * @author         William Paceley
 * @copyright      2003 - 2014 CyberChimps
 */

/**
 * If there are no posts in the loop,
 * display default content
 */
$title = ( is_search() ? sprintf( __( 'Your search for %s did not match any entries.', 'responsive' ), get_search_query() ) : __( 'Uh oh! Your search did not match any current postings.', 'responsive' ) );
?>

	<h1 class="title-404"><?php echo $title; ?></h1>

	<p><?php _e( 'Don&#39;t panic, we&#39;ll get through this together. Let&#39;s explore our options here.', 'responsive' ); ?></p>

	<h6><?php
		printf( __( 'You can return %s or search again for the page you were looking for.', 'responsive' ),
				sprintf( '<a href="%1$s" title="%2$s">%3$s</a>',
						 esc_url( get_home_url() ),
						 esc_attr__( 'Home', 'responsive' ),
						 esc_attr__( '&larr; Home', 'responsive' )
				)
		);
		?></h6>

<?php //get_search_form(); ?>