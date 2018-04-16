jQuery(document).ready(function( $ ) {

    $(".open-left").click(function() {
	    $(".slide-left").toggleClass("show");
        $(".open-left").toggleClass("closed");
	    $("body").toggleClass("menu-is-active push-left");
	});

	$(".open-right").click(function() {
	    $(".slide-right").toggleClass("show");
        $(".open-right").toggleClass("closed");
	    $("body").toggleClass("menu-is-active push-right");
	});

	$(".slide-overlay").click(function() {
	    $(".slide-right").removeClass("show");
	    $(".slide-left").removeClass("show");
        $(".open-left").removeClass("closed");
        $(".open-right").removeClass("closed");
	    $("body").removeClass("menu-is-active push-right push-left");
	});

    var lastScrollLeft = 0;
    $(window).scroll(function() {
        var documentScrollLeft = $(document).scrollLeft();
        if (lastScrollLeft !== documentScrollLeft) {
            $(".slide-right").removeClass("show");
    	    $(".slide-left").removeClass("show");
    	    $("body").removeClass("menu-is-active push-right push-left");
            lastScrollLeft = documentScrollLeft;
        }
    });

    //* Set up submenus
    $( '.mobile-nav-area .sub-menu' ).hide();

    //* Set up classes on submenus
    $( '.mobile-nav-area .menu > li > .sub-menu' ).addClass( 'sub-menu-level-1' );
    $( '.mobile-nav-area .menu > li > .sub-menu .sub-menu' ).addClass( 'sub-menu-level-2' );

    //* Set up classes on parents
    $( '.mobile-nav-area .menu > li.menu-item-has-children, .mobile-nav-area .menu > li.menu-item-object-custom' ).addClass( 'parent-level-1' );
    $( '.mobile-nav-area .menu > li.menu-item-has-children li.menu-item-has-children, .mobile-nav-area .menu > li.menu-item-object-custom li.menu-item-object-custom, .mobile-nav-area .menu > li.menu-item-object-custom li.menu-item-has-children, .mobile-nav-area .menu > li.menu-item-has-children li.menu-item-object-custom' ).addClass( 'parent-level-2' );

    //* Prevent the default behavior on all levels
    $( '.mobile-nav-area .menu > .menu-item-has-children > a, .mobile-nav-area .menu > .menu-item-object-custom > a' ).click(function() {
        
        event.preventDefault();

    });

    //* Level 1 submenu effect
    $( '.menu-item-has-children.parent-level-1, .menu-item-object-custom.parent-level-1' ).click(function() {
        
        event.stopPropagation(); // stop propagation to prevent the parent level effect being applied
        
        $( '.sub-menu-level-1', this ).toggle( 'visible' );
        $( this ).toggleClass( 'active' );
    });

    //* Level 2 submenu effect
    $( '.menu-item-has-children.parent-level-2, .menu-item-object-custom.parent-level-2' ).click(function() {
        
        event.stopPropagation(); // stop propagation to prevent the parent level effect being applied
        
        $( '.sub-menu-level-2', this ).toggle( 'visible' );
        $( this ).toggleClass( 'active' );
    });

});
