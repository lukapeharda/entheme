/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 */
( function($) {
    var container, button, menu;

    container = document.getElementById( 'site-navigation' );
    if ( ! container )
        return;

    button = container.getElementsByTagName( 'h1' )[0];
    if ( 'undefined' === typeof button )
        return;

    menu = container.getElementsByTagName( 'ul' )[0];

    // Hide menu toggle button if menu is empty and return early.
    if ( 'undefined' === typeof menu ) {
        button.style.display = 'none';
        return;
    }

    if ( -1 === menu.className.indexOf( 'nav-menu' ) )
        menu.className += ' nav-menu';

    button.onclick = function() {
        if ( -1 !== container.className.indexOf( 'toggled' ) ) {
            container.className = container.className.replace( ' toggled', '' );
        } else {
            container.className += ' toggled';
        }
    };
    $('#site-navigation').find('.menu-item').click(function() {
        $('#site-navigation').removeClass('toggled');
    })
} )(jQuery);

jQuery( document ).ready( function( $ ) {
    var $logoMain = $('.logo-main'),
        $logoNav = $('.logo-navigation');
    $(window).scroll(function() {
        if ($(this).scrollTop() > parseInt($logoMain.offset().top + $logoMain.outerHeight())) {
            $logoNav.show();
        } else {
            $logoNav.hide();
        }
    });
} );
