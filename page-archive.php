<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 * Template Name: Archive
 
 * @file           page-archive.php
 * @package        Responsive
 * @author         William Paceley
 */

get_header(); ?>

<div id="content" class="grid col-620">

	<?php if (current_user_can( 'gravityforms_view_addons' )) { ?>
	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry">
					<?php if( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					<?php endif; ?>
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
                    <div id="recent-gigs">
    <table>
		<?php
			$args = array( 'numberposts' => '-1', 'post_status' => 'publish' );
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
					<?php wp_link_pages( array( 'before' => '<div class="pagination">' . __( 'Pages:', 'responsive' ), 'after' => '</div>' ) ); ?>
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
    <?php } else { 
		echo '<h2>Hello, and welcome!</h2>';
		echo '<p>Welcome to the ESM Gig Service! You must be logged in as a student to view this page. If you haven\'t set up your account yet, please register below by entering your NetID and password.<br /></p>
			  <p><a href="http://www.esm.rochester.edu/iml/blog/wp-login.php">Log In</a></p>
			  <p><a href="http://www.esm.rochester.edu/iml/blog/wp-login.php">Register</a></p>';
	}?>

</div><!-- end of #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>