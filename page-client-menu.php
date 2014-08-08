<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
Template Name: Client Home with Menu
Author: William Paceley
Author URL: http://arpegg.io
*/
?>
<!--Don't use auth redirect for now...not working as intended.-->
<?php //auth_redirect(); ?>
<?php get_header(); ?>


<div id="content" class="grid col-620">

	<?php if( have_posts() ) : ?>
		
        <!--WP Loop Starts Here-->
		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>
				<?php responsive_entry_top(); ?>>

				<div class="post-entry">
                	<!--This would display all body content typed in--turned off for this page-->
					<?php //the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
       				<?php if (current_user_can( 'edit_published_posts' ) ) { ?>
						<h2>Your Profile</h2>
                    	<div id="client-profile">
                        
                    	<?php
    						$current_user = wp_get_current_user();
    						/**
     						* @example Safe usage: $current_user = wp_get_current_user();
     						* if ( !($current_user instanceof WP_User) )
     						*     return;
     						*/
							
    						echo '<strong>Username</strong>: ' . $current_user->user_login . '<br />';
    						echo '<strong>Email</strong>: ' . $current_user->user_email . '<br />';
    						echo '<strong>First name</strong>: ' . $current_user->user_firstname . '<br />';
    						echo '<strong>Last name</strong>: ' . $current_user->user_lastname . '<br />';

							$current_id = get_current_user_id(); 
  							$user_phone = get_user_meta( $current_id, '_phone', true ); 
  							$user_website = get_user_meta( $current_id, '_website', true );
							$user_company = get_user_meta( $current_id, '_company', true );
							$user_affiliation = get_user_meta( $current_id, '_affiliation', true );
							
							echo '<strong>Account Type</strong>: ' . $user_affiliation . '<br />';
							if ($user_company != '') {
								echo '<strong>Company</strong>: ' . $user_company . '<br />';
							}
							echo '<strong>Phone</strong>: ' . $user_phone . '<br />';
							if ($user_website != '') {
								echo '<strong>Website</strong>: ' . $user_website . '<br />';
							}
							echo '<br /><a href="http://www.esm.rochester.edu/iml/blog/edit-client-profile/ ">Edit Profile</a>';
						 } else {
							echo '<h2>Hello, and welcome!</h2>';
							echo '<p>Welcome to the ESM Gig Service! You must be logged in as a client to view this page. If you don\'t have an account with us yet, please register below.<br /></p>
							<p><a href="http://www.esm.rochester.edu/iml/blog/wp-login.php">Log In</a></p>
							<p><a href="http://www.esm.rochester.edu/iml/blog/register-client/">Register</a></p>';
						}?>
                    </div>
				</div>
				<!-- end of .post-entry -->
				<?php get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>

		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar( 'right' ); ?>
<?php if ( current_user_can( 'edit_published_posts' ) ) { ?>
<div id="client-gigs">
	<hr />
	<h2>Your Gigs</h2>
    <table id="gig-table">
    	<?php
			global $current_user;
    		get_currentuserinfo();
    		$author_query = array('posts_per_page' => '-1','author' => $current_user->ID);
    		$author_posts = new WP_Query($author_query);
			if (!($author_posts->have_posts())) {
				echo '<p>You currently have no active gigs. Use the navigation menu to post one!</p>';
			}
    		while($author_posts->have_posts()) : $author_posts->the_post();
    	?>
        <!--WP Loop starts here-->
		<tr>
  			<td><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>
  			<td>Posted <?php the_time( 'F j, Y' );?></td>
            <?php 
				if (post_status != 'draft') {
					echo '<td>Active Listing</td>';
				}
			?>		
  			<td><?php show_delete_button() ?></td>
		</tr>
        <?php endwhile; ?>
        </table>
</div>
<?php } ?>
<?php get_footer(); ?>
