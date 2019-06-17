jQuery(document).ready(function ($) {

    //* Set up classes on parents
    $('.mobile-nav-area .menu li.menu-item-has-children').addClass('parent');
    $('.mobile-nav-area .menu li.menu-item-has-children').addClass('inactive');

    //* Prevent the default behavior on all levels
    $('.parent > a').click(function () {
        event.preventDefault();
    });

    //* Submenu effect
    $('.parent > a').click(function () {
        $(this).parent().toggleClass('active');
        $(this).parent().toggleClass('inactive');
    });

});