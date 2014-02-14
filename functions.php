<?php
/**
 * Entheme functions and definitions
 *
 * @package Entheme
 */

define('ENTHEME_DEFAULT_PAGE_BACKGROUND_COLOR', '#cccccc');
define('ENTHEME_DEFAULT_PAGE_TEXT_COLOR', '#333333');

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (! isset($content_width))
	$content_width = 640; /* pixels */

if (! function_exists('entheme_setup')) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function entheme_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Entheme, use a find and replace
	 * to change 'entheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain('entheme', get_template_directory() . '/languages');

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support('automatic-feed-links');

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support('post-thumbnails');

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'entheme'),
	));
}
endif; // entheme_setup
add_action('after_setup_theme', 'entheme_setup');

/**
 * Enqueue scripts and styles
 */
function entheme_scripts() {
	wp_enqueue_style('entheme-style', get_stylesheet_uri());
	wp_enqueue_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');

	wp_enqueue_script('entheme-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20120206', true);
	wp_enqueue_script('entheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_singular() && wp_attachment_is_image()) {
		wp_enqueue_script('entheme-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array('jquery'), '20120202');
	}

	if (wp_style_is('grid-columns')) {
		global $wp_styles;
		$wp_styles->registered['grid-columns']->args = 'screen and (min-width: 710px)';
	}
}
add_action('wp_enqueue_scripts', 'entheme_scripts');

function entheme_get_post_meta($post_id, $key, $default)
{
	$value = get_post_meta($post_id, $key, true);
	if (empty($value)) {
		$value  = $default;
	}

	return $value;
}

function entheme_nav_menu_link_attributes($atts, $item, $args)
{
	$atts['href'] = '#post-' . $item->object_id;

	return $atts;
}
add_filter('nav_menu_link_attributes', 'entheme_nav_menu_link_attributes', 10, 3);

function entheme_nav_menu_css_class($classes, $item, $args)
{
	$classes[] = 'object-id-' . $item->object_id;

	return $classes;
}
add_filter('nav_menu_css_class', 'entheme_nav_menu_css_class', 10, 3);

function entheme_generate_css()
{
	$calculated_css = get_option('entheme_calculated_css');
	if (empty($calculated_css)) {
		return;
	} else {
		$calculated_css = unserialize($calculated_css);
	}
	if (!is_array($calculated_css) || count($calculated_css) === 0) {
		return;
	}
	?>
<style type="text/css">
<?php foreach ($calculated_css as $line) : ?>
<?php echo $line; ?>

<?php endforeach; ?>
</style>
	<?
}
add_action('wp_head', 'entheme_generate_css');

function entheme_generate_head_code()
{
	$head_code = get_option('entheme_head_code');
	if (empty($head_code)) {
		return;
	}

	echo $head_code;
}
add_action('wp_head', 'entheme_generate_head_code');

function entheme_social_links()
{
	$links = get_option('entheme_calculated_social');
	if (! empty($links)) {		
		echo $links;
	}
}

function entheme_instantiate_map()
{
	wp_enqueue_script('google-maps', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), false, true);
	wp_enqueue_script('entheme-map-script', get_template_directory_uri() . '/js/map-initialization.js', array('google-maps'), false, true);

	$coordinates = explode(',', get_option('entheme_map_coordinates', '45.786679041363726, 15.97412109375'));
	$styles = get_option('entheme_map_style', null);
	if (null !== $styles) {
		$styles = json_decode($styles);
	}

    wp_localize_script('entheme-map-script', 'entheme_m', array(
    	'lat' => $coordinates[0],
    	'lng' => $coordinates[1],
    	'zoom' => get_option('entheme_map_zoom', 10),
    	'styles' => $styles,
    	'stroke_color' => entheme_get_post_meta(get_the_ID(), "page_background_color", ENTHEME_DEFAULT_PAGE_BACKGROUND_COLOR),
    ));
}
add_action('get_template_part_map-page', 'entheme_instantiate_map');

function entheme_instantiate_slider()
{
	wp_enqueue_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'));
}
add_action('entheme_instantiate_slider', 'entheme_instantiate_slider');

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Options page file.
 */
require get_template_directory() . '/inc/options-page.php';

/**
 * Meta box file.
 */
require get_template_directory() . '/inc/meta-box.php';