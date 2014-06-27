<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Entheme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php get_template_part('home-page'); ?>

			<?php
				$entheme_pages = new WP_Query(array(
					'post_type' => 'page',
					'post_status' => 'publish',
					'nopaging' => true,
					'orderby' => 'menu_order',
					'order' => 'ASC',
					'meta_key' => 'page_show_front',
					'meta_value' => '1',
				));
			?>

			<?php if ($entheme_pages->have_posts()) : ?>
			<div id="pages">
				<?php while ($entheme_pages->have_posts()) : $entheme_pages->the_post(); ?>
				<?php
					$template = get_post_meta(get_the_ID(), '_wp_page_template', true);
					if (strpos($template,'.php')) {
						get_template_part(str_replace('.php', '', $template));
					} else {
						get_template_part('basic-page');
					}
				?>
				<?php endwhile; ?>
			</div>
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>