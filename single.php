<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Entheme
 */

get_header(); ?>

    <div id="primary" class="content-area">

        <?php /* The loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php endif; ?>

                    <h1 class="entry-title"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <p class="post-date"><i class="fa fa-clock-o"></i> <?php the_date(); ?></p>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

            </article><!-- #post -->
        <?php endwhile; ?>

    </div><!-- #primary -->

<?php get_footer();