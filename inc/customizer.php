<?php
/**
 * Entheme Theme Customizer
 *
 * @package Entheme
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function entheme_customize_register($wp_customize) {
	/*
	 * Removing unnecessary customizable controls and sections
	 */
	$wp_customize->remove_control('blogname');
	$wp_customize->remove_control('background_color');

	$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('background_image');

	/*
	 * Modifying existing settings
	 */
	$wp_customize->get_setting('blogdescription')->transport  = 'postMessage';

	/*
	 * Adding new sections
	 */
	$wp_customize->add_section('header_logo', array(
		'title' => __('Header & Logo Settings', 'entheme'),
	));
	
	/*
	 * Adding new settings and controls
	 */
	$wp_customize->add_setting('show_site_description', array(
		'type' => 'option',
		'default' => 0,
		'transport' => 'postMessage',
	));
	$wp_customize->add_control(new WP_Customize_Control($wp_customize, 'show_site_description', array(
		'label' => __('Show Page Site Description', 'entheme'),
		'section' => 'title_tagline',
		'settings' => 'show_site_description',
		'type' => 'checkbox',
	)));
	$wp_customize->add_setting('home_background_color', array(
		'type' => 'option',
		'default' => '#ffffff',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'home_background_color', array(
		'label' => __('Header Background Color', 'entheme'),
		'section' => 'colors',
		'settings' => 'home_background_color',
	)));
	$wp_customize->add_setting('logo_main', array(
		'type' => 'option',
		'default' => '',
		'transport' => 'postMessage',
	));
	$wp_customize->add_control(new Wp_Customize_Image_Control($wp_customize, 'logo_main', array(
		'label' => __('Main Logo', 'entheme'),
		'section' => 'header_logo',
		'settings' => 'logo_main',
	)));
}
add_action('customize_register', 'entheme_customize_register');

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function entheme_customize_preview_js() {
	wp_enqueue_script('entheme_customizer', get_template_directory_uri() . '/js/customizer.js', array('customize-preview'), '', true);
}
add_action('customize_preview_init', 'entheme_customize_preview_js');

add_action('customize_save_after', 'entheme_after_saving_settings');
