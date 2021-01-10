<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package adri
 */

get_header();

?>



    <div id="primary" class="content-area grid-wide">
        <main id="masonry" class="site-main">

        <?php
        $arr = array(
            'post_type' => 'portfolio',
        );
        $portfolio = new WP_Query($arr);
        if ( $portfolio->have_posts() ) :

            /* Start the Loop */
            while ( $portfolio->have_posts() ) :
                $portfolio->the_post();  
                get_template_part( 'template-parts/content', 'preview' );
            endwhile;


        endif;
        ?>

        </main><!-- #main -->
        <?php the_posts_navigation(); ?>
    </div><!-- #primary -->

<?php
get_footer();
