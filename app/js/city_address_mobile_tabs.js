/*------------------------------
Script for tabs in the bottom of the page
with adresses of saloons in kiyv and kharkiv.
--------------------------------*/

var debounce = function(func, wait, immediate) {
    // Returns a function, that, as long as it continues to be invoked, will not
    // be triggered. The function will be called after it stops being called for
    // N milliseconds. If `immediate` is passed, trigger the function on the
    // leading edge, instead of the trailing.
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};

var SalonObj = {
    init: function() {
        var self = this;
        var w = $(window);
        var wWidth = w.width();
        var minWidth = 640;
        var isMobile = false;
        if (wWidth < 800) {
            self.enableMobileLinks();
            $('.adress-centre span').hide();
        } else {
            self.disableMobileLinks();
            $('.adress-centre span').show();
        }
    },


    enableMobileLinks: function() {
        var links = $('.salon-city-link');
        var blocks = $('.salon-information');
        var blockky = $('#kyiv');
        var blockkh = $('#kharkiv');
        var tabs = $('.location-tab');

        var dataId;
        var currentBlock;
        var cssActiveLink = 'salon-active';

        blockky.show();
        blockkh.hide();
        tabs.show();

        links.on('click.mobile', function(e) {
            e.preventDefault();
            blocks.hide();
            links.parent('.salon-cities-tabs').removeClass(cssActiveLink);

            dataId = $(this).data('id');
            currentBlock = $('#'+dataId);

            currentBlock.show();
            $(this).parent('.salon-cities-tabs').addClass(cssActiveLink);
        });
    },
    disableMobileLinks: function() {
        var links = $('.salon-cities-tabs');
        var blocks = $('.salon-information');
        var tabs = $('.location-tab');

        blocks.show();
        tabs.hide();
        links.off('click.mobile');
    }
};
$(function() {
    SalonObj.init();
    var updateLayout = debounce(function(e) {
        var wWidth = $(window).width();
        if (wWidth < 994){
            SalonObj.enableMobileLinks();
            $('.adress-centre span').hide();
        } else {
            SalonObj.disableMobileLinks();
            $('.adress-centre span').show();
        }
    }, 500); // Maximum run of once per 500 milliseconds
    window.addEventListener("resize", updateLayout, false);

});
