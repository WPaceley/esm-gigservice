<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
Template Name: Client Home
Author: William Paceley
Author URL: http://arpegg.io
*/

get_header(); ?>

<div id="content-full" class="grid col-940">

	<?php if( have_posts() ) : ?>
		<!--WP loop starts here-->
		<?php while( have_posts() ) : the_post(); ?>
			<!--Provides breadcrumbs back to landing page, so turning OFF-->
			<?php //get_template_part( 'loop-header' ); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>
				
                <!--Currently this handles the title of the page, OFF for Gig Service-->
				<?php //get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
                	<!--This will display any content typed into the page-->
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
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
						?>
                        <?php
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
						?>
                        <br /><a href="http://www.esm.rochester.edu/iml/blog/edit-client-profile/ ">Edit Profile</a>
                        <hr>
                    </div>
                    <div id="client-gigs">
                    <h2>Your Gigs</h2>
                    <table id="gig table">
                    <?php
					    global $current_user;
    					get_currentuserinfo();
    					$author_query = array('posts_per_page' => '-1','author' => $current_user->ID);
    					$author_posts = new WP_Query($author_query);
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

</div><!-- end of #content-full -->

<?php get_footer(); ?>
