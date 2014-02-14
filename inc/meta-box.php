<?php

function entheme_create_page_meta()
{
	add_meta_box('entheme-page-meta', __('Page Options', 'entheme'), 'entheme_page_meta_box', 'page', 'side', 'default');
}
add_action('add_meta_boxes', 'entheme_create_page_meta');

function entheme_page_meta_box($post)
{
	wp_nonce_field('entheme_page_options', 'entheme_page_options_nonce');
	$page_background_color = entheme_get_post_meta($post->ID, 'page_background_color', ENTHEME_DEFAULT_PAGE_BACKGROUND_COLOR);
	$page_text_color = entheme_get_post_meta($post->ID, 'page_text_color', ENTHEME_DEFAULT_PAGE_TEXT_COLOR);
	$page_link_color = entheme_get_post_meta($post->ID, 'page_link_color', ENTHEME_DEFAULT_PAGE_TEXT_COLOR);
	$page_menu_color = entheme_get_post_meta($post->ID, 'page_menu_color', '0');
	?>
	<p><strong><?php _e('Page Background Color'); ?></strong></p>
	<p><input type="text" name="page_background_color" value="<?php echo esc_attr($page_background_color); ?>" class="entheme-color-picker" data-default-color="<?php echo ENTHEME_DEFAULT_PAGE_BACKGROUND_COLOR; ?>" /></p>
	<p><strong><?php _e('Page Text Color'); ?></strong></p>
	<p><input type="text" name="page_text_color" value="<?php echo esc_attr($page_text_color); ?>" class="entheme-color-picker" data-default-color="<?php echo ENTHEME_DEFAULT_PAGE_TEXT_COLOR; ?>" /></p>
	<p><strong><?php _e('Page Link Color'); ?></strong></p>
	<p><input type="text" name="page_link_color" value="<?php echo esc_attr($page_link_color); ?>" class="entheme-color-picker" data-default-color="<?php echo ENTHEME_DEFAULT_PAGE_TEXT_COLOR; ?>" /></p>
	<p><strong><?php _e('Page Menu Link Color', 'entheme'); ?></strong></p>
	<p><label for="page_menu_color"><input type="checkbox" name="page_menu_color" value="1"<?php checked('1', $page_menu_color); ?> /> <?php _e('Use page background color', 'entheme'); ?></label></p>
	<?
}

function entheme_save_page_meta_box($post_id)
{
	if (!isset($_POST['entheme_page_options_nonce'])) {
		return $post_id;	
	}
    
    $nonce = $_POST['entheme_page_options_nonce'];
  	if (!wp_verify_nonce($nonce, 'entheme_page_options')) {
    	return $post_id;
    }
    
    if ('page' !== $_POST['post_type']) {
    	return $post_id;
    }

    if (!current_user_can( 'edit_page', $post_id)) {
    	return $post_id;
    }

    $page_background_color = sanitize_text_field($_POST['page_background_color']);
    $page_text_color = sanitize_text_field($_POST['page_text_color']);
    $page_link_color = sanitize_text_field($_POST['page_link_color']);
    if (isset($_POST['page_menu_color'])) {
    	$page_menu_color = sanitize_text_field($_POST['page_menu_color']);	
    } else {
    	$page_menu_color = 0;
    }
    

	update_post_meta($post_id, 'page_background_color', $page_background_color);
	update_post_meta($post_id, 'page_text_color', $page_text_color);
	update_post_meta($post_id, 'page_link_color', $page_link_color);
	update_post_meta($post_id, 'page_menu_color', $page_menu_color);

	$calculated_css = get_option('entheme_calculated_css');
	if (empty($calculated_css)) {
		$calculated_css = array();
	} else {
		$calculated_css = unserialize($calculated_css);
	}

	$calculated_css['post-' . $post_id] = entheme_custom_page_css(array(
		'page_background_color' => $page_background_color,
		'page_text_color' => $page_text_color,
		'page_link_color' => $page_link_color,
		'page_menu_color' => $page_menu_color,
	), $post_id);

	update_option('entheme_calculated_css', serialize($calculated_css));
}
add_action('save_post', 'entheme_save_page_meta_box');

function entheme_custom_page_css($data, $post_id)
{
	$style = '.post-' . $post_id  . '{background-color:' . $data['page_background_color'] . ';color:' . $data['page_text_color'] . ';}
.post-' . $post_id . ' a{color:' . $data['page_link_color'] . ';}';

	if ('1' === $data['page_menu_color']) {
		$style .= '
.main-navigation .object-id-' . $post_id . ':hover{background-color:' . $data['page_background_color'] . ';color:#ffffff;}';
	}

	return $style;
}