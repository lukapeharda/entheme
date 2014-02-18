<?php

$social_links = array(
    'facebook' => __('Facebook link', 'entheme'),
    'github' => __('Github link', 'entheme'),
    'twitter' => __('Twitter link', 'entheme'),
    'google-plus-square' => __('Google+ link', 'entheme'),
    'linkedin-square' => __('LinkedIn link', 'entheme'),
    'skype' => __('Skype link', 'entheme'),
    'stack-overflow' => __('Stack Overflow', 'entheme'),
);

function entheme_create_menu()
{
    $hook = add_menu_page(__('Entheme Theme options', 'entheme'), __('Entheme', 'entheme'), 'manage_options', 'entheme-options-page', 'entheme_settings_page', get_template_directory_uri() . '/images/icon-menu.png', '58.88');

    add_action('admin_init', 'entheme_register_settings');

    add_action('load-' . $hook, 'entheme_after_saving_settings');
}
add_action('admin_menu', 'entheme_create_menu');

function entheme_after_saving_settings($this = null)
{
    global $social_links;

    if ($this instanceof WP_Theme || (isset($_GET['settings-updated']) && !empty($_GET['settings-updated']))) {
        $home_background_color = get_option('home_background_color');
        // $navigation_hover_background_color = get_option('navigation_hover_background_color');

        $calculated_css = get_option('entheme_calculated_css');
        if (empty($calculated_css)) {
            $calculated_css = array();
        } else {
            $calculated_css = unserialize($calculated_css);
        }

        $calculated_css['settings'] = entheme_custom_options_css(array(
            'home_background_color' => $home_background_color,
            // 'navigation_hover_background_color' => $navigation_hover_background_color,
        ));

        update_option('entheme_calculated_css', serialize($calculated_css));

        $links = '';
        foreach ($social_links as $key => $label) {
            $link = get_option('entheme_social_' . $key);
            if (! empty($link)) {
                $links .= entheme_generate_social_link($key, $link);
            }
        }

        if ($email = get_option('entheme_social_email', false)) {
            $links .= '<a href="mailto:' . antispambot($email) . '" target="_blank" class="social-link social-link-email"><i class="fa fa-envelope"></i></a>';
        }

        update_option('entheme_calculated_social', $links);
    }
}

function entheme_generate_social_link($key, $link)
{
    return '<a href="' . $link . '" target="_blank" class="social-link social-link-' . $key . '"><i class="fa fa-' . $key . '"></i></a>';
}

function entheme_custom_options_css($data)
{
    return '#primary{background-color:' . $data['home_background_color'] . ';}';
// #site-navigation li:hover {background-color: ' . $data['navigation_hover_background_color'] . '}';
}

function entheme_register_settings()
{
    global $social_links;

    $social_links = apply_filters('entheme_social_links', $social_links);

    register_setting('entheme-settings-group-visual', 'favicon');
    register_setting('entheme-settings-group-visual', 'logo_main');
    register_setting('entheme-settings-group-visual', 'logo_navigation');
    register_setting('entheme-settings-group-visual', 'home_background_color');
    // register_setting('entheme-settings-group-visual', 'navigation_hover_background_color');
    register_setting('entheme-settings-group-visual', 'show_site_description');
    // register_setting('entheme-settings-group-visual', 'use_page_background_color');

    register_setting('entheme-settings-group-analytics', 'entheme_head_code');

    foreach ($social_links as $key => $title) {
        register_setting('entheme-settings-group-social', 'entheme_social_' . $key);
    }
    register_setting('entheme-settings-group-social', 'entheme_social_email');

    register_setting('entheme-settings-group-map', 'entheme_map_style');
    register_setting('entheme-settings-group-map', 'entheme_map_coordinates');
    register_setting('entheme-settings-group-map', 'entheme_map_zoom');

    register_setting('entheme-settings-group-styling', 'custom_css');
}

function entheme_settings_page()
{
    global $social_links;

    $tabs = array(
        'visual' => __('Visual', 'entheme'),
        'analytics' => __('Analytics', 'entheme'),
        'social' => __('Social', 'entheme'),
        'map' => __('Map', 'entheme'),
        'styling' => __('Styling', 'entheme'),
    );

    $active_tab = 'visual';
    if (isset($_GET['tab']) && ! empty($_GET['tab']) && array_key_exists($_GET['tab'], $tabs)) {
        $active_tab = $_GET['tab'];
    }

    if ( ! empty( $_GET['settings-updated'] ) ) : ?>
    <div id="message" class="updated"><p><?php _e('Options successfully updated.', 'entheme'); ?></p></div>
    <?php endif;
    ?>
    <div class="wrap">
        <div id="icon-entheme-page" class="icon32"><img src="<?php echo get_template_directory_uri() . '/images/icon-page.png'; ?>" /></div>
        <h2 class="nav-tab-wrapper">
            <?php foreach ($tabs as $key => $title) : ?>
            <a class="nav-tab<?php if ($key === $active_tab) { echo ' nav-tab-active'; } ?>" href="<?php echo admin_url('admin.php?page=entheme-options-page&tab=' . $key); ?>"><?php echo $title; ?></a>
            <?php endforeach; ?>
        </h2>
        <?php if ($active_tab === 'visual') : ?>
        <form method="post" action="options.php">
            <?php settings_fields('entheme-settings-group-visual'); ?>
            <?php do_action('entheme-settings-group-visual'); ?>
            <h3 class="title"><?php _e('Navigation Settings', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Navigation logo', 'entheme'); ?></th>
                    <td>
                        <input type="hidden" id="logo_navigation" name="logo_navigation" value="<?php echo esc_url(get_option('logo_navigation')); ?>" />
                        <input id="upload_logo_navigation" type="button" class="button" value="<?php _e('Upload Logo', 'entheme'); ?>" />
                        <input id="delete_logo_navigation" name="delete_logo_navigation" type="submit" <?php if ('' == get_option('logo_navigation')): ?>style="display:none" <?php endif; ?>class="button" value="<?php _e('Delete Logo', 'entheme'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Navigation logo preview', 'entheme'); ?></th>
                    <td id="preview_logo_navigation">
                        <?php if ('' != get_option('logo_navigation')): ?>
                        <img src="<?php echo get_option('logo_navigation'); ?>" />
                        <?php else: ?>
                        <span class="description"><?php _e('Upload the navigation logo image.', 'entheme'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <h3 class="title"><?php _e('Header & Logo Settings', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Main Logo', 'entheme'); ?></th>
                    <td>
                        <input type="hidden" id="logo_main" name="logo_main" value="<?php echo esc_url(get_option('logo_main')); ?>" />
                        <input id="upload_logo_main" type="button" class="button" value="<?php _e('Upload Logo', 'entheme'); ?>" />
                        <input id="delete_logo_main" name="delete_logo_main" type="submit" <?php if ('' == get_option('logo_main')): ?>style="display:none" <?php endif; ?>class="button" value="<?php _e('Delete Logo', 'entheme'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Main Logo Preview', 'entheme'); ?></th>
                    <td id="preview_logo_main">
                        <?php if ('' != get_option('logo_main')): ?>
                        <img src="<?php echo get_option('logo_main'); ?>" />
                        <?php else: ?>
                        <span class="description"><?php _e('Upload the main logo image.', 'entheme'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Header Background Color', 'entheme'); ?></th>
                    <td><input type="text" name="home_background_color" value="<?php echo get_option('home_background_color'); ?>" class="entheme-color-picker" data-default-color="#ffffff" /></td>
                </tr>
            </table>
            <h3 class="title"><?php _e('Other Settings', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Show Page Site Description', 'entheme'); ?></th>
                    <td>
                        <label for="show_site_description"><input type="checkbox" name="show_site_description" id="show_site_description" value="1" <?php checked('1', get_option('show_site_description')); ?>> <?php _e('Show description', 'entheme'); ?></label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Favicon icon', 'entheme'); ?></th>
                    <td>
                        <input type="hidden" id="favicon" name="favicon" value="<?php echo esc_url(get_option('favicon')); ?>" />
                        <input id="upload_favicon" type="button" class="button" value="<?php _e('Upload Favicon', 'entheme'); ?>" />
                        <input id="delete_favicon" name="delete_favicon" type="submit" <?php if ('' == get_option('favicon')): ?>style="display:none" <?php endif; ?>class="button" value="<?php _e('Delete Favicon', 'entheme'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Favicon preview', 'entheme'); ?></th>
                    <td id="preview_favicon">
                        <?php if ('' != get_option('favicon')): ?>
                        <img src="<?php echo get_option('favicon'); ?>" />
                        <?php else: ?>
                        <span class="description"><?php _e('Upload the favicon.', 'entheme'); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <?php elseif ($active_tab === 'analytics'): ?>
        <form method="post" action="options.php">
            <?php settings_fields('entheme-settings-group-analytics'); ?>
            <?php do_action('entheme-settings-group-analytics'); ?>
            <h3 class="title"><?php _e('Analytics code', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="entheme_head_code"><?php _e('Analytics code in &lt;head /&gt;', 'entheme'); ?></label></th>
                    <td>
                        <textarea name="entheme_head_code" rows="10" cols="50" id="entheme_head_code" class="large-text code"><?php echo get_option('entheme_head_code'); ?></textarea>
                        <p class="description"><?php _e('Enter anayltics invocation code with &lt;script /&gt; tags included.', 'entheme'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <?php elseif ($active_tab === 'social'): ?>
        <form method="post" action="options.php">
            <?php settings_fields('entheme-settings-group-social'); ?>
            <?php do_action('entheme-settings-group-social'); ?>
            <h3 class="title"><?php _e('Social connections', 'entheme'); ?></h3>
            <table class="form-table">
                <?php foreach ($social_links as $key => $label) : ?>
                <tr valign="top">
                    <th scope="row"><label for="entheme_social_<?php echo $key; ?>"><?php echo $label; ?></label></th>
                    <td>
                        <input type="text" class="regular-text code" name="entheme_social_<?php echo $key; ?>" value="<?php echo get_option('entheme_social_' . $key); ?>" />
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr valign="top">
                    <th scope="row"><label for="entheme_social_email"><?php _e('Email address', 'entheme'); ?></label></th>
                    <td>
                        <input type="text" class="regular-text code" name="entheme_social_email" value="<?php echo get_option('entheme_social_email'); ?>" />
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    <?php elseif ($active_tab === 'map'): ?>
        <form method="post" action="options.php">
            <?php settings_fields('entheme-settings-group-map'); ?>
            <?php do_action('entheme-settings-group-map'); ?>
            <h3 class="title"><?php _e('Map options', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="entheme_map_coordinates"><?php _e('Coordinates', 'entheme'); ?></label></th>
                    <td>
                        <input type="text" class="regular-text code" name="entheme_map_coordinates" value="<?php echo get_option('entheme_map_coordinates'); ?>" />
                        <p class="description"><?php _e('Enter coordinates for the marker and map center. Coordinates should be in a "LAT,LNG" format (45.786,15.974).', 'entheme'); ?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="entheme_map_zoom"><?php _e('Zoom level', 'entheme'); ?></label></th>
                    <td>
                        <input type="text" class="regular-text code" name="entheme_map_zoom" value="<?php echo get_option('entheme_map_zoom'); ?>" />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="entheme_map_style"><?php _e('JSON styling code', 'entheme'); ?></label></th>
                    <td>
                        <textarea name="entheme_map_style" rows="10" cols="50" id="entheme_map_style" class="large-text code"><?php echo get_option('entheme_map_style'); ?></textarea>
                        <p class="description"><?php _e('JSON with map styling generated through <a href="https://gmaps-samples-v3.googlecode.com/svn/trunk/styledmaps/wizard/index.html" target="_blank">google maps styling wizard</a> or found on <a href="http://snazzymaps.com/" target="_blank">Snazzy Maps</a>.', 'entheme'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    <?php elseif ($active_tab === 'styling'): ?>
        <form method="post" action="options.php">
            <?php settings_fields('entheme-settings-group-styling'); ?>
            <?php do_action('entheme-settings-group-styling'); ?>
            <h3 class="title"><?php _e('Custom CSS', 'entheme'); ?></h3>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="custom_css"><?php _e('Custom CSS in &lt;head /&gt;', 'entheme'); ?></label></th>
                    <td>
                        <textarea name="custom_css" rows="10" cols="50" id="custom_css" class="large-text code"><?php echo get_option('custom_css'); ?></textarea>
                        <p class="description"><?php _e('Enter custom CSS code without &lt;style /&gt; tags.', 'entheme'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    <?php endif; ?>
    </div>
    <?php
}

function entheme_enqueue_admin_scripts($hook_suffix)
{
    if ($hook_suffix !== 'toplevel_page_entheme-options-page' && $hook_suffix !== 'post-new.php' && $hook_suffix !== 'post.php') {
        return;
    }

    wp_enqueue_style('wp-color-picker');

    wp_enqueue_script('jquery');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('wptuts-upload');

    wp_enqueue_script('entheme-options-script', get_template_directory_uri() . '/js/options.js', array('jquery','media-upload','thickbox', 'wp-color-picker'), false, true);

    wp_localize_script('entheme-options-script', 'entheme_t', array(
        'upload_main_logo' => __('Upload a main logo', 'entheme'),
        'upload_navigation_logo' => __('Upload a navigation logo', 'entheme'),
        'upload_main_logo_image' => __('Upload the main logo image', 'entheme'),
        'upload_navigation_logo_image' => __('Upload the navigation logo image', 'entheme'),
        'upload_favicon' => __('Upload favicon icon', 'entheme'),
    ));
}
add_action('admin_enqueue_scripts', 'entheme_enqueue_admin_scripts');