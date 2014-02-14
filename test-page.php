<?php
/*
Template Name: Slider test page
*/
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				$posts = new Wp_Query(array('post_type' => 'post'));

				if ($posts->have_posts()) :
			?>
			<div class="flexslider">
				<ul class="slides">
					<?php while ($posts->have_posts()) : $posts->the_post(); ?>
					<li>
						<h2><?php the_title(); ?></h2>
						<span><i class="fa fa-clock-o"></i> <?php the_date(); ?></span>
						<?php the_content(); ?>
					</li>
					<?php endwhile; ?>
				</ul>
	        </div>
	    	<?php endif; ?>
		</div><!-- .entry-content -->		
	</article><!-- #post-## -->
	<script>
	jQuery(document).ready(function() {
      	jQuery('.flexslider').flexslider({
        	animation: "slide",
        	controlNav: false,
        	slideshow: false,
        	prevText: '<i class="fa fa-angle-left"></i>',
        	nextText: '<i class="fa fa-angle-right"></i>',
        	animationLoop: false
      	});
    });
	</script>
	<?php do_action('entheme_instantiate_slider'); ?>