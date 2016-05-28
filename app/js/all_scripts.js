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

// object to handle the events on product page
// 
var itemMenuObj = { // product_page
    init: function() {
        var self = this;
        var w = $(window);
        var wWidth = w.width();
        self.enableMobileLinks(wWidth);
    },


    enableMobileLinks: function(wWidth) {
        var links = $('.ui-icon-tab-menu-item'); // табы
        var cssActiveLink = 'item-detail-menu-item-active'; // ссылка на активный таб
        var blocks = $('.item-detail-menu-container'); // контент табов
        // Ниже перечисление различных блоков с контентом, содержимое табов
        var blockab = $('#about');
        var blockch = $('#charachteristic');
        var blockan = $('#answers');
        var blockac = $('#acksesories');
        var blockid = $('#items-detal');
        var blockqw = $('#questions');
        var blockcon = $('#consultation');
        var dataId;
        var currentBlock;

        blocks.hide();
        blockab.show();
        blockch.hide();
        blockan.hide();
        blockac.hide();
        blockid.hide();
        blockqw.hide();
        blockcon.hide();

        if (wWidth < 768){ // действия для мобильного вида
        	// перевод табов в аккордеон
        	// табы спрятаны в css, добавляем заголовки перед блоками с контентом
        	// они служат в качестве кнопок для раскрытия аккордеона.
              blocks.hide();
			  blockab.before('<h6>Описание</h6>');
			  blockch.before('<h6>Характеристики</h6>');
			  blockan.before('<h6>Отзывы</h6>');
			  blockac.before('<h6>Аксессуары</h6>');
			  blockid.before('<h6>Запчасти</h6>');
			  blockqw.before('<h6>Вопросы и ответы</h6>');
			  blockcon.before('<h6>Получить консультацию</h6>');
			  $('.item-detail-menu  h6').click(function (event) {
			        if(false == $(this).next().is(':visible')) {
			          $('.item-detail-menu-container').slideUp(300);
			      }
			      $(this).next().slideToggle(300);
			  });
		} else {
				$(".item-detail-menu h6").remove();

		}

        links.on('click.mobile', function(e) {
        	// обычные табы
            e.preventDefault();
            blocks.hide();
            links.parent('.item-detail-menu-item').removeClass(cssActiveLink);

            dataId = $(this).data('id');
            currentBlock = $('#'+dataId);

            currentBlock.show();
            $(this).parent('.item-detail-menu-item').addClass(cssActiveLink);
        })
    },
    disableMobileLinks: function() {
        var links = $('.item-detail-menu-item');
        var blocks = $('.item-detail-menu-container');

        blocks.show();
        links.off('click.mobile');
    }
}

// block with address at the bottom of the every page
var SalonObj = {
    init: function() {
        var self = this;
        var w = $(window);
        var wWidth = w.width();
        var minWidth = 640;
        var isMobile = false;
        if (wWidth < 995) {
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
	itemMenuObj.init();
    SalonObj.init();
    var updateLayout = debounce(function(e) {
        var wWidth = $(window).width();
        itemMenuObj.enableMobileLinks(wWidth);
        if (wWidth < 995){
            SalonObj.enableMobileLinks();
            $('.adress-centre span').hide();
        } else {
            SalonObj.disableMobileLinks();
            $('.adress-centre span').show();
        }
    }, 500); // Maximum run of once per 500 milliseconds

    window.addEventListener("resize", updateLayout, false);

});