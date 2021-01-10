<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package adri
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php

		while ( have_posts() ) :
			the_post(); ?>

			
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="grid">
				<header class="entry-header">
					<?php
					the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				</header><!-- .entry-header -->


				<div class="entry-content">
					<?php
					the_content( sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'adri' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					) ); ?>

				</div> <!-- end entry-content -->
				</div>
				<div class="grid-mid">
				<?php //Portfolio Image Gallery
				$img_size = 'full';
				$field_name ='gallery';
				$files = get_post_meta( get_the_ID(), 'gallery', 1 );

			    echo '<ul class="portfolio-gallery">';
			    // Loop through them and output an image
			    foreach ( (array) $files as $attachment_id => $attachment_url ) {
			        echo '<li>';
			        echo wp_get_attachment_image( $attachment_id, $img_size );
			        echo '</li>';
			    }
			    echo '</ul>';
					?>
			</div>
				
				</div><!-- .grid-mid -->

				<footer class="entry-footer grid">
				</footer><!-- .entry-footer -->
			</article><!-- #post-<?php the_ID(); ?> -->


			<?php //the_post_navigation();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
