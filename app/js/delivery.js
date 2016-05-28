// Скрипт для табов на странице доставки
// Табы переходят в выпадающее меню в мобильном виде

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

$(function() {

});


var updateLayout = debounce(function(e) {
    var wWidth = $(window).width();
		var tabs = $('.delivery-cities-tabs');
		var links = $('.delivery-city-link');
		var blocks = $('.delivery-information');
		var cssActiveLink = 'delivery-active';
		var dataId;
		var currentBlock;

		blocks.hide();
		$('#deliveryKyiv').show();
		links.on('click.mobile', function(e) {
			if (wWidth < 545) {
				if ($(this).closest('li').hasClass('delivery-active')){
					tabs.toggle();
					$('.delivery-active').show();
				} else {
					tabs.hide();
					$(this).closest('li').show();
				}
			}
	      e.preventDefault();
	      blocks.hide();
	      links.parent('.delivery-cities-tabs').removeClass(cssActiveLink);

	      dataId = $(this).data('id');
	      currentBlock = $('#'+dataId);

	      currentBlock.show();
	      $(this).parent('.delivery-cities-tabs').addClass(cssActiveLink);
		});
		if (wWidth >= 545){
			console.log(wWidth);
			tabs.addClass('u-inline-block');
		} else {
			tabs.removeClass('u-inline-block');
		}
  }, 500); // Maximum run of once per 500 milliseconds
updateLayout();
window.addEventListener("resize", updateLayout, false);

// var SocialsObj = {
//         init: function() {
//         var self = this;
//         var w = $(window);
//         var wWidth = w.width();
//         var minWidth = 640; 
//         var isMobile = false;
//
//         self.enableMobileLinks();
//     },
//
//
//     enableMobileLinks: function() {
//         var links = $('.delivery-city-link');
//         var blocks = $('.delivery-information');
// 				var tabs = $('.delivery-cities-tabs');
//         var blockky = $('#kyiv');
//         var blockkh = $('#kharkiv');
//         var blockua = $('#ukraine');
//         var blockcr = $('#crimea');
//
//         var dataId;
//         var currentBlock;
//         var cssActiveLink = 'delivery-active';
//
//         blockky.show();
//         blockkh.hide();
//         blockua.hide();
//         blockcr.hide();
// 				console.log(wWidth);
// 				if (wWidth < 555) {
// 					$('.delivery-active > a').on('click.mobile', function(e) {
// 						tabs.toggle();
// 					});
// 				}
//
//         links.on('click.mobile', function(e) {
//             e.preventDefault();
//             blocks.hide();
//             links.parent('.delivery-cities-tabs').removeClass(cssActiveLink);
//
//             dataId = $(this).data('id');
//             currentBlock = $('#'+dataId);
//
//             currentBlock.show();
//             $(this).parent('.delivery-cities-tabs').addClass(cssActiveLink);
// 						if (wWidth < 555) {
// 							tabs.toggle();
// 							$('.delivery-active').show();
// 						}
//
//         })
//     },
//     disableMobileLinks: function() {
//         var links = $('.delivery-cities-tabs');
//                 var blocks = $('.delivery-information');
//
//                 blocks.show();
//                 links.off('click.mobile');
//     }
// }


// $(function() {
//     SocialsObj.init();
// })
