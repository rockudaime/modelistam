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

var SocialsObj = {
        init: function() {
        var self = this;
        var w = $(window);
        var wWidth = w.width();
        var minWidth = 640;
        var isMobile = false;

        self.enableMobileLinks();
    },


    enableMobileLinks: function() {
        var links = $('.delivery-city-link');
        var blocks = $('.delivery-information');
				var tabs = $('.delivery-cities-tabs');
        var blockky = $('#kyiv');
        var blockkh = $('#kharkiv');
        var blockua = $('#ukraine');
        var blockcr = $('#crimea');

        var dataId;
        var currentBlock;
        var cssActiveLink = 'delivery-active';

        blockky.show();
        blockkh.hide();
        blockua.hide();
        blockcr.hide();

				if (wWidth < 555) {
					$('.delivery-active a').on('click.mobile', function(e) {
						tabs.toggle();
					});
				}

        links.on('click.mobile', function(e) {
            e.preventDefault();
            blocks.hide();
            links.parent('.delivery-cities-tabs').removeClass(cssActiveLink);

            dataId = $(this).data('id');
            currentBlock = $('#'+dataId);

            currentBlock.show();
            $(this).parent('.delivery-cities-tabs').addClass(cssActiveLink);
						if (wWidth < 555) {
							tabs.toggle();
							$('.delivery-active').show();
						}

        })
    },
    disableMobileLinks: function() {
        var links = $('.delivery-cities-tabs');
                var blocks = $('.delivery-information');

                blocks.show();
                links.off('click.mobile');
            }
        }
var updateLayout = debounce(function(e) {
    wWidth = $(window).width();
		var links = $('.delivery-city-link');
		var tabs = $('.delivery-cities-tabs');
		var blocks = $('.delivery-information');
		var dataId;
		var currentBlock;

    if (wWidth < 544) {
      $('.delivery-active a').click(function(){
        $('.delivery-cities-tabs').show();
      });
			links.on('click.mobile', function(e) {
					e.preventDefault();
					blocks.hide();
					links.parent('.delivery-cities-tabs').removeClass(cssActiveLink);

					dataId = $(this).data('id');
					currentBlock = $('#'+dataId);

					currentBlock.show();

					$(this).parent('.delivery-cities-tabs').addClass(cssActiveLink);
					tabs.hide();
					$('.delivery-active').show();
			});
    }
    console.log(wWidth);
  }, 500); // Maximum run of once per 500 milliseconds
updateLayout();
window.addEventListener("resize", updateLayout, false);
$(function() {
    SocialsObj.init();
})
