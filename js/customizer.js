(function($) {
	wp.customize('blogdescription', function(value) {
		value.bind(function(to) {
			$('.site-description').text(to);
		});
	});
	wp.customize('show_site_description', function(value) {
		value.bind(function(to) {
			if (to === true) {
				$('.home-wrap').append('<h2 class="site-description">' + window._wpCustomizeSettings.values.blogdescription + '</h2>');
			} else {
				$('.home-wrap .site-description').remove();
			}
		});
	});
	wp.customize('home_background_color', function(value) {
		value.bind(function(to) {
			$('#primary').css('background-color', to);
		});
	});
	wp.customize('logo_main', function(value) {
		value.bind(function(to) {
			if (to !== '') {
				$('.logo-main').html('<img src="' + to + '" />');
			} else {
				$('.logo-main').html('');
			}
		});
	});
	wp.customize('logo_main', function(value) {
		value.bind(function(to) {
			if (to !== '') {
				$('.logo-main').html('<img src="' + to + '" />');
			} else {
				$('.logo-main').html('');
			}
		});
	});
})(jQuery);