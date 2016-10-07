$(document).ready(function() {
	var wWidth = $(window).width();
	// < ==============================================
	// Выбор цвета
	var colorsBlock = $('.product-colors');
	var choosenColor = $('.color-product-info__choosed-color span');
	// Обработка выпадающего меню с опцией выбора цвета
	$('.color-product-info__choosed-color').on('click', function(e) {
		e.preventDefault();
		colorsBlock.toggle();
	});


	$('.product-colors__radio').change(function(){
		var color;
		if ($(this).prop('checked', true)){
			color = $(this).parent().find('.color-product-info__color-label').css('background-color');
			choosenColor.css('background-color', color);
			colorsBlock.fadeOut();
		}
	});

	// ============================================= />

	// Просто анимация звездочек рейтинга
	var rating = 0; // в эту переменную записывается выбранный рейтинг числа от 1 до 5

	$('.rateit__range').on('mousemove', function(e){
		var parentOffset = $(this).offset(); 
	   	var relX = e.pageX - parentOffset.left;
		$('.rateit__hover').css('width', relX + 'px');
	});
	$('.rateit__range').on('click', function(e){
		var parentOffset = $(this).offset(); 
	   	var relX = e.pageX - parentOffset.left;
	   	rating = Math.abs(Math.ceil(relX / parseInt($(this).width()) * 5));
	   	$('.rateit__selected').css('width', rating * 17 + 'px');

	});
	$('.rateit__range').on('mouseleave', function(e){
		$('.rateit__hover').css('width', '0');
	});
	


    // *********************** ТАБЫ И НАВИГАЦИЯ *******************
		// Меню для навигации по табам в десктопном\планшетном виде
		// .menu-details - меню - ul список ссылок для навигации по табам
		// .menu-details__link - отдельный элемент меню

	var $root = $('html, body');
	var tabs = $('.item-detail'); // блоки с сожержимым табов

	$('.menu-details').on('click', function(e){
		e.preventDefault();
		var link = e.target;
		if (link.nodeName === 'A'){
			var tabs = $('.details-product__detail-item');
			var tabId = link.dataset.target;
			var links = $('.menu-details__link'); // Элемент меню
			var tab = $('#' + tabId);

			if (tabId === 'accessories') {
				$('.accessories').hide();
			} else {
				$('.accessories').show();
			}

			if (tabId && !tab.hasClass('item-detail--active')){
				tabs.removeClass('item-detail--active');
				links.removeClass('menu-details__link--active');
				$(link).addClass('menu-details__link--active');
				tab.addClass('item-detail--active');
			}
		}
		
	});

	// Аккордеон для мобильного вида (все что меньше 768 пикселей в ширину)

	$('.item-detail__mobile-menu-item').on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		var links = $('.item-detail__mobile-menu-item');
		var tab = link.next();
		
		if (!tab.hasClass('item-detail--active')){ // если таб не активный, закрыть все остальные и открыть таб
			tabs.removeClass('item-detail--active');
			links.removeClass('mobile-menu-item--active');
			tab.addClass('item-detail--active');
			link.addClass('mobile-menu-item--active');
		} else { // если клик по уже активному табу, то просто закрыть его
			tab.removeClass('item-detail--active');
			link.removeClass('mobile-menu-item--active');
		}
		$root.animate({
		        scrollTop: tab.offset().top
		}, 500);
		
	});

	// accessories tabs
	var accessoriesTabs = $('.accessories__tabs').children('.item-detail');
	var accessoriesTabTabsHandler = tabsHandler('.accessories-tab__menu', '.accessories-tabs__item');
	var accessoriesBlockTabsHandler = tabsHandler('.accessories__tabs-menu', '.accessories__item');
	$('.accessories__tabs-menu .tabs-menu').on('click', accessoriesBlockTabsHandler);
	$('.accessories-tab__menu .tabs-menu').on('click', accessoriesTabTabsHandler);


	function tabsHandler(tabsMenuContainerClass, tabsClass) {
		return function (event) {
			var tabLinks = $(tabsMenuContainerClass + ' .tabs-menu__item');
			var tabLink = $(event.target);
			var tab = $('#' + tabLink.data('tabid'));
			var accessoriesTabs = $(tabsClass);
			accessoriesTabs.hide();
			tab.show();
			tabLinks.removeClass('tabs-menu__item--active');
			tabLink.addClass('tabs-menu__item--active');
		}
	}


	// link to characteristics tab in about product tab
	$('#characteristicsLink').on('click', function() {
		var tabId = this.dataset.id;
		var tabs = $('.item-detail');
		var links = $('.menu-details__link');
		var tab = $('#' + tabId);

		$('.accessories').hide();
		tabs.removeClass('item-detail--active');
		links.removeClass('menu-details__link--active');
		$('.menu-details__link[data-target="characteristics"]').addClass('menu-details__link--active');
		tab.addClass('item-detail--active');
		$root.animate({
		        scrollTop: tab.offset().top
		}, 500);
	});

	/**
	*
	* Processing the layout of video elements on the page (if there is more than one video). 
	* Creates navigation links to navigate across the tabs. 
	*
	**/
	// video elements on page
	var productPageVideosObj = {
		init: function() {
			var videos = $('.video-tab');
			if (videos.length > 1){
				var videosBlock = $('.about-product__video');
				videosBlock.append('<ul class="tabs-control">');
				var ul = $('.tabs-control');
				ul.append('<li class="tabs-control__item"><a class="tabs-nav tabs-nav--active" href="#" data-nav="1">1</a></li>');
				for (var i = 2; i <= videos.length; i++) {
					ul.append('<li class="tabs-control__item"><a class="tabs-nav" href="#" data-nav="' + parseInt(i) + '">' + parseInt(i) + '</a></li>');
				}

				videos.addClass('video-tab--hidden');
				$(videos[0]).removeClass('video-tab--hidden');
			}
			// add event listener to process click on tabs
			$('.tabs-control').on('click', function(e){
				e.preventDefault();
				var link = $(e.target);
				var videos = $('.video-tab');
				if (link.data("nav")){
					var videoTab = $('.video-tab').filter('[data-order=' +link.data("nav") + ']');
					console.log(link.data("nav"));
					videos.addClass('video-tab--hidden');
					videoTab.removeClass('video-tab--hidden');
					$('.tabs-nav').removeClass('tabs-nav--active');
					link.addClass('tabs-nav--active');
				}
			});
		}
	}
	productPageVideosObj.init();
	// function videoInit(){
	// 	var videos = $('.video-tab');
	// 	if (videos.length > 1){
	// 		var videosBlock = $('.about-product__video');
	// 		videosBlock.append('<ul class="tabs-control">');
	// 		var ul = $('.tabs-control');
	// 		ul.append('<li class="tabs-control__item"><a class="tabs-nav tabs-nav--active" href="#" data-nav="1">1</a></li>');
	// 		for (var i = 2; i <= videos.length; i++) {
	// 			ul.append('<li class="tabs-control__item"><a class="tabs-nav" href="#" data-nav="' + parseInt(i) + '">' + parseInt(i) + '</a></li>');
	// 		}

	// 		videos.addClass('video-tab--hidden');
	// 		$(videos[0]).removeClass('video-tab--hidden');
	// 	}
	// 	// add event listener to process click on tabs
	// 	$('.tabs-control').on('click', function(e){
	// 		e.preventDefault();
	// 		var link = $(e.target);
	// 		var videos = $('.video-tab');
	// 		if (link.data("nav")){
	// 			var videoTab = $('.video-tab').filter('[data-order=' +link.data("nav") + ']');
	// 			console.log(link.data("nav"));
	// 			videos.addClass('video-tab--hidden');
	// 			videoTab.removeClass('video-tab--hidden');
	// 			$('.tabs-nav').removeClass('tabs-nav--active');
	// 			link.addClass('tabs-nav--active');
	// 		}
			
	// 	});	
	// }

	


	// Init the carousel sliders on the page
	var owl = $(".owl-carousel");

	owl.owlCarousel({
	    loop: false,
	    margin:0,
	    navigationText: false,
	    // responsiveClass:true,
	    pagination: true,
	    responsive:{
	    	 0:{
	    	 	items:1,
	    	 	nav:false
	    	 },
	        544:{
	            items:2,
	            nav: false
	        },
	        768:{
	            items:3,
	            nav:false,
	            paginatioin: true
	        },
	        994:{
	            items:4,
	            nav:true,
	            loop:false,
	            paginatioin: false

	        },
	        1200:{
	            items:5,
	            nav:true,
	            loop:false,
	            paginatioin: false
	        }
	    }
	});


	// Init of editable selects in need to purchase block
	$('.purchase-form__qty').editableSelect({filter: false});


	
});


// Images processing
$(document).ready(function() {
	var wWidth = $(window).width();
	var mainImage = $('.product-card__main-image img');
	var smallImages = $('.gallery-product__item');

	smallImages.on('click', function(e) {
		console.log(e.target);
		e.stopPropagation();
		e.preventDefault();
		var imgHref = $(this).children().attr('href');
		mainImage.parent().attr('href', imgHref);
		mainImage.attr('src', imgHref);
		smallImages.removeClass('gallery-product__item--active');
		smallImages.children().addClass('fancybox-thumbs');
		$(this).children().removeClass('fancybox-thumbs');
		$(this).addClass('gallery-product__item--active');
	});


	console.log($('.fancybox-thumbs'));
	$('.fancybox-thumbs').fancybox({
		prevEffect : 'none',
		nextEffect : 'none',

		closeBtn  : true,
		arrows    : true,
		nextClick : true,

		helpers : {
			thumbs : {
				width  : 50,
				height : 50
			}
		}
	});

});

// Модуль для вызова попапа при нажатии на кнопку купить или быстрая покупка

var popupProductAddObj = {

	init: function() {
		var self = this;
		self.modal = $('.product-add-popup');
		self.closeLink = $('#productAddCloseLink');
		self.closeBtn = $('#productAddCloseBtn');
		self.body = $('body');
		self.activeBodyClass = 'modal-open';
		// click on link "быстрая покупка"
		$('.fastbuy-link').on('click', function(e) {
			e.preventDefault();
			popupProductAddObj.open();
		});
		// click on button "Купить"
		$('#productCardBuy').on('submit', function(e) {
			e.preventDefault();
			popupProductAddObj.open();
			return false;
		});

		return self;
	},

	open: function() {
		var self = this;
		self.modal.fadeIn();

		self.closeLink.on('click', closeHandler);
		self.closeBtn.on('click', closeHandler);
		setTimeout(function(){
			self.body.addClass(self.activeBodyClass);
		}, 50);
		

		function closeHandler () {
			self.close();
		}
		return self;
	},

	close: function () {
		var self = this;

		self.modal.fadeOut();
		setTimeout(function(){
			self.body.removeClass(self.activeBodyClass);
		}, 0);
		// self.body.removeClass(self.activeBodyClass);
		return self;
	},

	updateProductQuantity: function(targetObj, sign) { // sign - boolean value. "+" if true, "-" if false
		var productId = targetObj.dataset.product;
		var productInp = document.getElementById(productId);
		var productQty = isNaN(parseInt(productInp.value, 10)) ? 0 : parseInt(productInp.value, 10);
		var form = $(targetObj).closest('.pa-fast-order__form');
		var inputTextField = form.find('.cart-product__quantity-field');
		

		if (sign) {
			productQty++;
		} else if (productQty > 1){
			productQty--;
		}
		productInp.value = productQty;
		inputTextField.val(productQty);
		
		return productQty;

	},

	updateProductPrice: function(targetObj, productQty) { //@param integer - productQty - quantity of products
		var form = $(targetObj).closest('.pa-fast-order__form');
		var inputTextField = form.find('.cart-product__quantity-field');
		var productPrice = parseFloat(inputTextField.data('product-price'));
		var productPrBlock = form.find('.product-add__price'); // price block
		console.log(productPrice);
		productPrBlock.html(getPriceString(productQty * productPrice));
	}


};
// Иниацилизация попапа при нажатии кнопки купить

$(function(){
	popupProductAddObj.init();
});


// ----------------------------
// добавление товара

$(document).ready(function(){
	$('.cart-product__quantity--add').on('click', function(e){
		e.preventDefault();
		// var productId = this.dataset.product;
		// var productInp = document.getElementById(productId);
		// var productQty = parseInt(productInp.value) + 1;

		// productInp.value = productQty;
		// this.previousSibling.innerHTML = productQty + ' шт';
		// var productPrBlock = this.nextSibling;
		// var productPrice = parseInt(productPrBlock.innerHTML.replace(/[^0-9]/, '')) / (productQty - 1);
		// productPrBlock.innerHTML = getPriceString(productPrice * productQty) + ' грн';
		// calculateTotal();
		var productQty = popupProductAddObj.updateProductQuantity(this, true);
		popupProductAddObj.updateProductPrice(this, productQty);
	});

	$('.cart-product__quantity--del').on('click', function(e){
		e.preventDefault();
		// var productId = this.dataset.product;
		// var productInp = document.getElementById(productId);
		// var productQty = parseInt(productInp.value);
		// if (productQty > 1){
		// 	productInp.value = productQty - 1;
		// 	this.nextSibling.innerHTML = productInp.value + ' шт';

		// 	var productPrBlock = this.nextSibling.nextSibling.nextSibling;
		// 	var productPrice = parseInt(productPrBlock.innerHTML.replace(/[^0-9]/, '')) / (productQty);
		// 	productPrBlock.innerHTML = getPriceString(productPrice * (productQty - 1)) + ' грн';
		// 	calculateTotal();
		// }
		var productQty = popupProductAddObj.updateProductQuantity(this, false);
		popupProductAddObj.updateProductPrice(this, productQty);
	});

	$('.product-add__quantity-field').on('input', function(e) {
		e.preventDefault;

		var productId = this.dataset.product;
		var productInp = document.getElementById(productId);
		var productQty = isNaN(parseInt(this.value, 10)) ? 0 : parseInt(this.value, 10);
		var form = $(this).closest('.pa-fast-order__form');
		productInp.value = productQty;
		popupProductAddObj.updateProductPrice(this, productQty);

	});

	function calculateTotal(){
		var prices = document.querySelectorAll('.cart-product__price');
		var totalPrice = 0;
		for (var i = 0; i < prices.length; i++){				
				totalPrice += parseInt(prices[i].innerHTML.replace(/[^0-9]/, ''));
		}
		// document.querySelector('.order-total-sum span').innerHTML = splitSum(totalPrice) + ' грн';
		// document.querySelector('.cart-mobile-opener span').innerHTML = splitSum(totalPrice) + ' грн';
	}

	

});

/**
 * Changes price value to be in readable format (with spaces between number triplets) 
 * 
 * @param {number} price Number to be formatted
 * @return {string} formatted price value.
 */
function getPriceString (price) {
    var intPrice;
    price = price.toFixed(2);
    price = price.split('.');
    intPrice = price[0];

    // if (price.length == 1) {
    //     price.push('0'); // добавить ноль после запятой для целочисленных сум
    // }
    // ниже блок разбиения больших сумм в тройки с пробелом между ними
    if (intPrice.length > 3) {
        var n = parseInt(intPrice.length / 3);
        var m = intPrice.length % 3;
        var newPrice = '';

        if (m === 0) {
            newPrice = intPrice.slice(0, 3);
            for (i = 1; i < n; i++) {
                newPrice += ' ' + intPrice.slice(i*3, i*3 + 3);
            }
        } else {
            newPrice = intPrice.slice(0, m);
            for (i = 0; i < n; i++) {
                newPrice += ' ' + intPrice.slice(m + i*3, m + i*3 + 3);
            }
        }
        price[0] = newPrice;
    }

    // while (price[1].length < 2) {
    //     price[1] += '0';
    // }

    return price.join('.');
}



// ========================= Popups new ==================
$(function () {
	// function MyPopup (selector) {
	// 	this.popup = $(selector);
	// 	this.closeLink = this.popup.find('.popup-b__close');
	// 	this.wrapper = this.popup.parent();
	// }

	// MyPopup.prototype.init = function () {
	// 	var that = this;
	// 	this.closeLink.on('click', function(e) {
	// 		e.preventDefault();
	// 		that.wrapper.fadeOut();

	// 	})
	// }
	// MyPopup.prototype.show = function () {
	// 	this.popup.show();
	// 	this.wrapper.fadeIn();
	// }

	// var bestPricePopup = new MyPopup('#bestPricePopup');
	// var deliveryPopup = new MyPopup('#deliveryPopup');
	// console.log(bestPricePopup);
	// bestPricePopup.init();
	// deliveryPopup.init();

	$('.product-feature--best-price').on('click',function () {
		var bestPricePopup = $('#bestPricePopup');
	 	bestPricePopup.show();
	 	bestPricePopup.parent().fadeIn();
	});

	var mypopup = {
		closeLink: $('.popup-b__close'),
		wrapper: $('.popup-outer')
	}

	mypopup.closeLink.on('click', function (e) {
		e.preventDefault();
		$(this).parent().fadeOut();
		mypopup.wrapper.fadeOut();
	});

	mypopup.wrapper.on('click', function(e) {
		e.stopPropagation();
		if ($(e.target).hasClass('popup-outer')) {
			mypopup.wrapper.children().fadeOut();
			mypopup.wrapper.fadeOut();
		}
	});

	// $('.popup-bcart__content').customScrollbar();
	// Нажатие кнопки "Купить" открывает попап
	$('#submitOrderBtn').on('click', function(e) {
		e.preventDefault();
		var popup = $('.popup-bcart');

		popup.show();
		popup.parent().fadeIn();
	});
	// Нажатие ссылки купить в кредит
	$('#followbuyCreditProduct-link').on('click', function (e) {
		e.preventDefault();
		var popup = $('#askPopup');

		popup.show();
		popup.parent().fadeIn();
	});

	// обработка выбора срока рассрочки
	$('.popup-bcredit__cond').on('click', function(e) {
		e.preventDefault();
		var target = $(e.target);
		var tr = target.parents('tr');

		if (tr.prop("tagName")) {
			$(this).find('tr').removeClass('r-active');
			tr.addClass('r-active');
			tr.find('input[type=radio]').prop("checked", true);
		} else {
			console.log('no');
		}
	})

});

