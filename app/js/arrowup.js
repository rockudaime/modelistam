BIS.arrowUp = {
    init: function() {
        var arrowUp =  $('#site-arrow-up'),
            minWindowWidth = 1140,
            windowWidth = $(window).width(),
            scrollTop = 400;

        if (minWindowWidth < windowWidth) {
            $(window).on('scroll', function() {
                if ($(document).scrollTop() > scrollTop) {
                    arrowUp.fadeIn('slow');
                } else {
                    arrowUp.fadeOut('slow');
                }
            });
            arrowUp.click(function (e) {
                $('html, body').animate({scrollTop: '0px'}, 800);
            });
        }
    }
};
$(function() {
    BIS.arrowUp.init();
});
