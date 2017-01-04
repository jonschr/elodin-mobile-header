jQuery(document).ready(function( $ ) {

    //* Set up the slideout
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    //* Toggle button
    document.querySelector( '.toggle-button' ).addEventListener( 'click', function() {
        $( 'slideout-menu' ).css( "margin-left", "-256px" );
        slideout.toggle();

    });

    //* Set up submenus
    $( '.mobile-nav-area .sub-menu' ).hide();

    //* Set up classes on submenus
    $( '.mobile-nav-area .menu > li > .sub-menu' ).addClass( 'sub-menu-level-1' );
    $( '.mobile-nav-area .menu > li > .sub-menu .sub-menu' ).addClass( 'sub-menu-level-2' );

    //* Set up classes on parents
    $( '.mobile-nav-area .menu > li.menu-item-has-children' ).addClass( 'parent-level-1' );
    $( '.mobile-nav-area .menu > li.menu-item-has-children li.menu-item-has-children' ).addClass( 'parent-level-2' );

    //* Prevent the default behavior on all levels
    $( '.mobile-nav-area .menu > .menu-item-has-children > a' ).click(function() {
        event.preventDefault();
    });

    //* Level 1 submenu effect
    $( '.menu-item-has-children.parent-level-1' ).click(function() {
        event.stopPropagation(); // stop propagation to prevent the parent level effect being applied
        $( '.sub-menu-level-1', this ).toggle( 'visible' );
        $( this ).toggleClass( 'active' );
    });

    //* Level 2 submenu effect
    $( '.menu-item-has-children.parent-level-2' ).click(function() {
        event.stopPropagation(); // stop propagation to prevent the parent level effect being applied
        $( '.sub-menu-level-2', this ).toggle( 'visible' );
        $( this ).toggleClass( 'active' );
    });
});
