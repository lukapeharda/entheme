(function($) {
	$('.entheme-color-picker').wpColorPicker();

	$('#upload_logo_main').click(function() {
        tb_show(entheme_t.upload_main_logo, 'media-upload.php?referer=entheme-settings&type=image&TB_iframe=true&post_id=0', false);
        window.send_to_editor = function(html, a, b) {
	    	$('#logo_main').val($('img', html).attr('src'));
		    $('#preview_logo_main').html(html);
		    $('#delete_logo_main').show();
		    tb_remove();
		}
        return false;
    });

    $('#delete_logo_main').click(function() {
    	$('#logo_main').val('');
	    $('#preview_logo_main').html('<span class="description">' + entheme_t.upload_main_logo_image + '</span>');
	    $('#delete_logo_main').hide();
        return false;
    });

    $('#upload_logo_navigation').click(function() {
        tb_show(entheme_t.upload_navigation_logo, 'media-upload.php?referer=entheme-settings&type=image&TB_iframe=true&post_id=0', false);
        window.send_to_editor = function(html, a, b) {
	    	$('#logo_navigation').val($('img', html).attr('src'));
		    $('#preview_logo_navigation').html(html);
		    $('#delete_logo_navigation').show();
		    tb_remove();
		}
        return false;
    });

    $('#delete_logo_navigation').click(function() {
    	$('#logo_navigation').val('');
	    $('#preview_logo_navigation').html('<span class="description">' + entheme_t.upload_navigation_logo_image + '</span>');
	    $('#delete_logo_navigation').hide();
        return false;
    });

    $('#upload_favicon').click(function() {
        tb_show(entheme_t.upload_navigation_logo, 'media-upload.php?referer=entheme-settings&type=image&TB_iframe=true&post_id=0', false);
        window.send_to_editor = function(html, a, b) {
            $('#favicon').val($('img', html).attr('src'));
            $('#preview_favicon').html(html);
            $('#delete_favicon').show();
            tb_remove();
        }
        return false;
    });

    $('#delete_favicon').click(function() {
        $('#favicon').val('');
        $('#preview_favicon').html('<span class="description">' + entheme_t.upload_favicon + '</span>');
        $('#delete_favicon').hide();
        return false;
    });
})(jQuery);