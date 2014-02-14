<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Entheme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	<header id="masthead" class="site-header" role="banner">
		<?php $nav_logo = get_option('logo_navigation'); ?>
		<?php if (!empty($nav_logo)): ?>
		<div class="site-branding">
			<a href="#page" class="logo-navigation hidden" rel="home" title="<?php bloginfo('name'); ?>"><img src="<?php echo esc_url($nav_logo); ?>" alt="<?php bloginfo('name'); ?>" /></a>
		</div>
		<?php endif; ?>

		<nav id="site-navigation" class="main-navigation" role="navigation">
			<h1 class="menu-toggle"><i class="fa fa-bars"></i></h1>
			<?php wp_nav_menu(array('theme_location' => 'primary', 'depth' => 1)); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
