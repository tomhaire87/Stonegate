!(function ($) {
    var responsiveFooter = {
        onResize: function () {
            $(window).resize(function () {
                responsiveFooter.checkWidth();
            });
        },
        checkWidth: function () {
            if (window.innerWidth > 1024) {
                responsiveFooter.desktop();
            } else {
                responsiveFooter.tablet();
            }
        },
        desktop: function () {
            $('.footer .col-l').prependTo('.footer.content');
        },
        tablet: function () {
            $('.footer .col-l').appendTo('.col-l-wrapper');
        },
        init: function () {
            this.onResize();
            this.checkWidth();
        }
    };
    responsiveFooter.init();
})(jQuery);