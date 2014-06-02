<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Entheme
 */
?>

	</div><!-- #content -->
	<footer class="clear">
		<div id="social">
			<?php entheme_social_links(); ?>
		</div>
		<div id="copyright">
			<p><?php echo get_option('copyright_text'); ?></p>
		</div>
	</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>