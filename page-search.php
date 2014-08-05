<?php

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Content/Sidebar Template
 *
Template Name:  Search
 *
 * @file           page-search.php
 * @package        Responsive
 * @author         William Paceley
 * @version        Release: 1.0
 */

get_header(); ?>

<div id="content" class="grid col-620">

	<?php get_template_part( 'loop-header' ); ?>

	<?php if( have_posts() ) : ?>

		<?php while( have_posts() ) : the_post(); ?>

			<?php responsive_entry_before(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php responsive_entry_top(); ?>

				<?php get_template_part( 'post-meta-page' ); ?>

				<div class="post-entry search-container">
				<?php the_content( __( 'Read more &#8250;', 'responsive' ) ); ?>
				<a href="#" onclick="showAdvanced()" class="show-advanced">Advanced Search</a>
                <a href="#" onclick="showBasic()" class="show-basic">Basic Search</a>
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