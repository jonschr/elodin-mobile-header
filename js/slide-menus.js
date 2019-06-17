jQuery(document).ready(function ($) {

    $(".open-left").click(function () {
        $(".slide-left").toggleClass("show");
        $(".open-left").toggleClass("closed");
        $("body").toggleClass("menu-is-active push-left");
    });

    $(".open-right").click(function () {
        $(".slide-right").toggleClass("show");
        $(".open-right").toggleClass("closed");
        $("body").toggleClass("menu-is-active push-right");
    });

    $(".slide-overlay").click(function () {
        $(".slide-right").removeClass("show");
        $(".slide-left").removeClass("show");
        $(".open-left").removeClass("closed");
        $(".open-right").removeClass("closed");
        $("body").removeClass("menu-is-active push-right push-left");
    });

    var lastScrollLeft = 0;
    $(window).scroll(function () {
        var documentScrollLeft = $(document).scrollLeft();
        if (lastScrollLeft !== documentScrollLeft) {
            $(".slide-right").removeClass("show");
            $(".slide-left").removeClass("show");
            $("body").removeClass("menu-is-active push-right push-left");
            lastScrollLeft = documentScrollLeft;
        }
    });

});
