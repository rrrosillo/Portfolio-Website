<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * You can also override it with more specific templates like page-{slug}.php
 *
 * @package YourTheme
 */

get_header(); ?>

<main id="primary" class="site-main">

    <?php
    while ( have_posts() ) :
        the_post();
    ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>

            <div class="entry-content">
                <?php
                the_content();

                wp_link_pages([
                    'before' => '<div class="page-links">Pages:',
                    'after'  => '</div>',
                ]);
                ?>
            </div>

            <?php if ( comments_open() || get_comments_number() ) : ?>
                <div class="comments-area">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>

</main>

<?php get_footer(); ?>