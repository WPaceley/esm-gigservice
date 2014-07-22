<?php
//Single post template. 
//Author: William Paceley

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<div id="content" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">
	
	<!--Get WP Header, This handles Breadcrumbs (OFF for Gig Service)-->
	<?php //get_template_part( 'loop-header' ); ?>
	
    <!--If any posts exist-->
	<?php if( have_posts() ) : ?>
		
        <!--WP loop starts here-->
		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>
				
                <!--This seems to handle the title, author, date-->
				<?php get_template_part( 'post-meta' ); ?>

				<div class="post-entry">
                	<!--This is the body content, not necessarily needed for Gig Service-->
					<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
                    
                    <!--This is conditional land, similar to Candy Land-->
                    <!--If performance gig-->
                    <?php if (in_category('331') ) { ?>
						<ul id="performance_fields">
                        	<li><strong>Type of Gig</strong>: <ul><?php $category = get_the_category();
								foreach ($category as $current_cat) {
									//This prevents Performance Gig from being listed
									if ($current_cat->cat_name != 'Performance Gig') {
										echo "<li>$current_cat->cat_name</li>";
									}
								}
								?>
                                </ul></li>
                        	<li><strong>Gig Frequency</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Recurring', true ) ?></li>
                        <!--If this is a recurring gig-->
                        <?php if (get_post_meta( get_the_ID(), 'Recurring', true ) == 'Recurring') { ?>
                        	<li><strong>Recurrence Explanation</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Recurrence Description', true ) ?></li>
                        <!--Else this is a one-time gig-->
                        <?php } else { ?>
                        	<li><strong>Date</strong>: <?php echo get_post_meta( get_the_ID(), 'Date', true ) ?></li>
                            <li><strong>Start time</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Start Time', true ) ?></li>
                            <li><strong>End time</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'End Time', true ) ?></li>
                        <?php } ?>
                        <li><strong>Desired Instruments/Ensembles</strong>: <ul> <?php global $post;
								$tag_names = wp_get_post_tags( $post->ID, array( 'fields' => 'names' ) );
								foreach ($tag_names as $current_name) {
									echo "<li>$current_name</li>";
								}
							?> 
                            </ul></li>
                            <?php $additional_comments = get_post_meta( get_the_ID(), 'Additional Comments', true );
							//Only displays if there are additional comments
							if ($additional_comments != '') {
								echo "<li><strong>Additional Comments</strong>: $additional_comments</li>";
							}
							?>
                        </ul>
                    <?php } elseif (in_category('329') ) {?>
                        <ul id="teaching_fields">
                        	<li><strong>Travel Flexibility</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Travel Flexibility', true ) ?>
                            </li>
                            <li><strong>Age Group</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Age Group', true ) ?>
                            </li>
                            <li><strong>Instrument</strong>: <ul> <?php global $post;
								$tag_names = wp_get_post_tags( $post->ID, array( 'fields' => 'names' ) );
								foreach ($tag_names as $current_name) {
									echo "<li>$current_name</li>";
								}
							?> 
                            </ul></li>
                            <?php $additional_comments = get_post_meta( get_the_ID(), 'Additional Comments', true );
							//Only displays if there are additional comments
							if ($additional_comments != '') {
								echo "<li><strong>Additional Comments</strong>: $additional_comments</li>";
							}
							?>
                        </ul>
					<?php } elseif (in_category('332') ) { ?>
						<ul id="composition_fields">
                        	<li><strong>Type of Composition</strong>: <?php $category = get_the_category();
								foreach ($category as $current_cat) {
									//This prevents Composition from being listed
									if ($current_cat->cat_name != 'Composition') {
										echo "$current_cat->cat_name";
									}
								}
								?>
                            </li>
                            <?php $original_piece = get_post_meta( get_the_ID(), 'Original Piece', true );
								if ($original_piece != '') {
									echo "<li><strong>Piece to Arrange</strong>: $original_piece</li>";
								}
							?>
                            <?php $due_date = get_post_meta( get_the_ID(), 'Date', true );
								if ($due_date != '') {
									echo "<li><strong>Due Date</strong>: $due_date</li>";
								}
							?>
                            <li><strong>Genre</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Genre', true ) ?>
                            </li>
                            <li><strong>Instrumentation</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Instrumentation', true ) ?>
                            </li>
                            <li><strong>Project Synopsis</strong>: <?php 
								echo get_post_meta( get_the_ID(), 'Project Synopsis', true ) ?>
                            </li>
                        </ul>                   	
                    <?php } else { ?>
                    	<h2>Error! Unidentified gig type, category missing.</h2>
                    <?php } ?>
                    
                    <!--Contact Form/Interested in Gig-->
					<?php gravity_form(6, false, false, false, '', false); ?>
				</div><!-- end of .post-entry -->
				
                <!--This shows categories and tags, OFF for Gig Service-->
				<?php //get_template_part( 'post-data' ); ?>
				<!--ESM Gig Service Contact Form-->
                
				<?php responsive_entry_bottom(); ?>
			</div><!-- end of #post-<?php the_ID(); ?> -->
			<?php responsive_entry_after(); ?>

			<?php responsive_comments_before(); ?>
			<?php comments_template( '', true ); ?>
			<?php responsive_comments_after(); ?>
            
		<!--WP Loop ENDS here-->
		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>

</div><!-- end of #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
