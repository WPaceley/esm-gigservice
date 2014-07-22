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
							
							//Conditionals show these fields only if they are not empty
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
<hr>
<h2>Latest Gigs</h2>
<div id="recent-gigs">
    <table>
		<?php
			//Arguments show first 5 posts, and only published posts
			$args = array( 'numberposts' => '5', 'post_status' => 'publish' );
			$recent_posts = wp_get_recent_posts( $args );
			foreach( $recent_posts as $recent ){
				$category = get_the_category($recent["ID"]);
				echo '<tr>';
				echo '<td><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </td> ';
				//Add highest level category to post
				foreach($category as $cat)
				{
					//Conditionals catch all higher level categories
					if ($cat->name == 'Performance Gig')
    					echo '<td>' . $cat->name . '</td>';
					if ($cat->name == 'Composition')
    					echo '<td>' . $cat->name . '</td>';
					if ($cat->name == 'Private Instruction')
    					echo '<td>' . $cat->name . '</td>'; 
				}
				//Add each post's date
				echo '<td>' . get_the_time('F j, Y', $recent["ID"]) . '</td>';
				echo '</tr>';
			}
		?>
	</table>
</div>
<?php get_footer(); ?>
