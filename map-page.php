<?php
/*
Template Name: Contact page (map)
*/

if ('' === get_option('permalink_structure')) {
    $page_id = 'post-' . get_the_ID();
} else {
    $page_id = apply_filters('entheme_page_slug', get_permalink(), false);
}
?>
	<article id="<?php echo $page_id; ?>" <?php post_class(); ?>>
        <header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-## -->
	<div id="map" style="width:100%; height: 300px"></div>