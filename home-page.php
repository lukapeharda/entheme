<div id="home-page">
	<?php $logo = get_option('logo_main'); ?>
	<?php if (!empty($logo)): ?>
	<?php $logo_info = getimagesize($logo); ?>
	<div class="home-wrap">
		<div class="logo-main">
			<img src="<?php echo $logo; ?>" alt="<?php bloginfo('name'); ?>" />	
		</div>
		<?php if ('1' === get_option('show_site_description')): ?>
		<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php endif; ?>
	</div>
	<?php endif; ?>
</div>