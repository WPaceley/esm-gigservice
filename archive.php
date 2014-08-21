<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Archive Template
 *
 *
 * @file           archive.php
 * @package        Responsive
 * @author         Emil Uzelac
 * @copyright      2003 - 2014 CyberChimps
 * @license        license.txt
 * @version        Release: 1.1
 * @filesource     wp-content/themes/responsive/archive.php
 * @link           http://codex.wordpress.org/Theme_Development#Archive_.28archive.php.29
 * @since          available since Release 1.0
 */

get_header(); ?>

<div id="content-archive" class="<?php echo implode( ' ', responsive_get_content_classes() ); ?>">

	<?php if (current_user_can( 'gravityforms_view_addons' )) { ?>
	<?php if( have_posts() ) : ?>

		<?php //get_template_part( 'loop-header' ); ?>
        <table>
		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
				<?php responsive_entry_top(); ?>

				<?php //get_template_part( 'post-meta' ); ?>

                    	<?php echo '<tr>' ?>
                        	<td><a href="<?php echo get_permalink( ); ?>"><?php echo get_the_title() ?></a></td>
                            <?php $category = get_the_category( );
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
							?>
                            <?php echo '<td>' . get_the_time('F j, Y', get_the_ID() ) . '</td>';?>
                        <?php echo '</tr>' ?>

				<?php //get_template_part( 'post-data' ); ?>

				<?php responsive_entry_bottom(); ?>
                
			<?php responsive_entry_after(); ?>
		<?php
		endwhile;

		get_template_part( 'loop-nav' );

	else :

		get_template_part( 'loop-no-posts' );

	endif;
	?>
    </table>
    <?php } else { 
		echo '<h2>Hello, and welcome!</h2>';
		echo '<p>Welcome to the ESM Gig Service! You must be logged in as a student to view this page. If you haven\'t set up your account yet, please register below by entering your NetID and password.<br /></p>
			  <p><a href="http://www.esm.rochester.edu/iml/blog/wp-login.php">Log In</a></p>
			  <p><a href="http://www.esm.rochester.edu/iml/blog/wp-login.php">Register</a></p>';
	}?>

</div><!-- end of #content-archive -->

<?php get_sidebar( ); ?>
<?php get_footer(); ?>
