<?php
// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/*
Template Name: Student Home
Author: William Paceley
Author URL: http://arpegg.io
*/

get_header(); ?>

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
					<h2>Your Profile</h2>
                    <div id="student-profile">
                    	<?php
    						$current_user = wp_get_current_user();
    						/**
     						* @example Safe usage: $current_user = wp_get_current_user();
     						* if ( !($current_user instanceof WP_User) )
     						*     return;
     						*/
							
							echo '<strong>First name</strong>: ' . $current_user->user_firstname . '<br />';
							echo '<strong>Last name</strong>: ' . $current_user->user_lastname . '<br />';
    						echo '<strong>Email</strong>: ' . $current_user->user_email . '<br />';
    						
						?>
                        <?php
							$current_id = get_current_user_id(); 
  							$user_phone = get_user_meta( $current_id, '_phone', true ); 
  							$user_website = get_user_meta( $current_id, '_website', true );
							$user_degree = get_user_meta( $current_id, '_degree', true );
							$user_grad_year = get_user_meta( $current_id, '_grad_year', true );
							
							
							if ($user_phone != '') {
								echo '<strong>Phone</strong>: ' . $user_phone . '<br />';
							}
							if ($user_website != '') {
								echo '<strong>Website</strong>: ' . $user_website . '<br />';
							}
							if ($user_degree != '') {
								echo '<strong>Degree</strong>: ' . $user_degree . '<br />';
							}
							if ($user_grad_year != '') {
								echo '<strong>Graduation Year</strong>: ' . $user_grad_year . '<br />';
							}
						?>
                        <br /><a href="http://www.esm.rochester.edu/iml/blog/edit-student-profile/">Edit Profile</a>
                        <hr>
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
<?php get_footer(); ?>
