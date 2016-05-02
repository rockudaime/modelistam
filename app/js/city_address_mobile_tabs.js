/*------------------------------
Script for tabs in the bottom of the page
with adresses of saloons in kiyv and kharkiv.
--------------------------------*/
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

        var dataId;
        var currentBlock;
        var cssActiveLink = 'salon-active';

        blockky.show();
        blockkh.hide();

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
});
