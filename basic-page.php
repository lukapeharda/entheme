<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Entheme
 */

if ('' === get_option('permalink_structure')) {
    $page_id = 'post-' . get_the_ID();
} else {
    $page_id = apply_filters('entheme_page_slug', get_permalink(), false);
}
?>
	<article id="<?php echo $page_id; ?>" <?php post_class(); ?>>
		<?php if (has_post_thumbnail()) : ?>
		<div class="page-background"></div>
		<?php endif; ?>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->