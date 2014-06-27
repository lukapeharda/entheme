<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Entheme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'entheme' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content">
				<p><?php _e( 'It looks like nothing was found at this location.', 'entheme' ); ?></p>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->
	</div><!-- #primary -->

<?php get_footer(); ?>