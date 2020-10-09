!(function ($) {
    var responsiveHeader = {
        onResize: function () {
            $(window).resize(function () {
                responsiveHeader.checkWidth();
            });
        },
        checkWidth: function () {
            if (window.innerWidth > 1024) {
                responsiveHeader.desktop();
            } else if (window.innerWidth < 1024 && window.innerWidth > 767) {
                responsiveHeader.tablet();
            } else {
                responsiveHeader.mobile();
            }
        },
        desktop: function () {
            $('.header-push').css('height', $('.page-header').outerHeight());
            $('.navigation .mega-menu').css('max-height', (window.innerHeight - $('.page-header').outerHeight() - 46));
			$('.section-item-content[id*="links"] .menu').appendTo('.headerbar .account-links');
			$('nav.navigation').removeClass('mobile');
        },
        tablet: function () {
            $('.trade-account-bar').appendTo('.page-header');
            $('.header-push').css('height', $('.page-header').outerHeight());
            $('.navigation .mega-menu').css('max-height', (window.innerHeight - $('.page-header').outerHeight() - 46));
			$('.account-links .menu').appendTo('.section-item-content[id*="links"]');
			$('nav.navigation').addClass('mobile');
        },
        mobile: function () {
            $('.header-push').css('height', $('.page-header').outerHeight());
        },
        init: function () {
            this.onResize();
            this.checkWidth();
        }
    };
    responsiveHeader.init();

    var fixedHeader = {
        onScroll: function () {
            $(window).scroll(function () {
                fixedHeader.checkScroll();
            });
        },
        checkScroll: function () {
            if ($(window).scrollTop() > $('.header-push').outerHeight()) {
                fixedHeader.fixed();
            } else {
                fixedHeader.absolute();
            }
        },
        fixed: function () {
            $('body').addClass('fixed-header');
        },
        absolute: function () {
            $('body').removeClass('fixed-header');
        },
        init: function () {
            this.onScroll();
            this.checkScroll();
        }
    };

    $('.zopim').css('right', (window.innerWidth - $('#maincontent').innerWidth()) / 2)

    var fixedChat = {
        onScroll: function () {
            $(window).scroll(function() {
                fixedChat.checkScroll();
            });
        },
        checkScroll: function () {
            var footerHeight = $('.page-footer').outerHeight() + $('.copyright').outerHeight();
            if($(window).scrollTop() >= ($('.page-wrapper').outerHeight() - ($(window).outerHeight() + footerHeight))) {
                $('.zopim').css({
                    'position': 'absolute',
                    'bottom': footerHeight,
                });
            } else {
                $('.zopim').css({
                    'position': 'fixed',
                    'bottom': '0',
                });
            }
        },
        init: function () {
            this.onScroll();
            this.checkScroll();
        }
    }

    fixedChat.init();

    fixedHeader.init();

    if(window.innerWidth < 767) {
        $(window).resize(function () {
            if (!$('#search').is(':focus')) {
                $('#search').focus();
            }
        });
        $('#search').change(function() {
            if($(this).val().length > 0) {
                $('#search_autocomplete').addClass('visible');
            } else {
                $('#search_autocomplete').addClass('visible');
            }
        });
    }

    $('.mobile-search-icon').click(function () {
        $('.block-search').stop().slideToggle(300);
        if (!$('#search').is(':focus')) {
            $('#search').focus();
        } else {
            $('body').click();
        }
    });
})(jQuery);