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
		};
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
	};
	productPageVideosObj.init();

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


	// Инициализация изменяемого селекта в блоке "требуется докупить"
	$('.purchase-form__qty').editableSelect({filter: false});
	// -----------------------------------------
	// ----------- Требуется докупть -----------

	$('.products-purchase__show-link').on('click', function(e) {
		e.preventDefault();
		console.log('hello');
		$(this).prev().slideToggle();
		$(this).toggleClass('products-purchase__show-link--open');
	});
	
});


// Images processing
$(document).ready(function() {
	var wWidth = $(window).width();
	var mainImage = $('.product-card__main-image img');
	var smallImages = $('.gallery-product__item');
	var galleryContent = $('.gallery-product__content');
	var gallery = $('.gallery-product');
	var galleryHeight = gallery.outerHeight();
	var galleryContentHeight = galleryContent.outerHeight();
	var galleryContentPosition = 0;
	var galleryControlArrowHeight = 12;
// Добавление кнопок навигации по картинкам галереи, если их больше 4х
	if (wWidth >= 1235){
		if (galleryHeight < galleryContentHeight) {
			$('.gallery-product__control--down').addClass('gallery-product__control--active');

			$('.gallery-product__control--down').on('click', function(e) {
				e.preventDefault();
				if (galleryContentPosition + galleryHeight > galleryContentHeight - galleryHeight) {
					galleryContentPosition = galleryContentHeight - galleryHeight;
					console.log('exceeds' + galleryContentPosition);
					galleryContent.css('transform', 'translateY(' + (  -galleryContentPosition - galleryControlArrowHeight + 'px)'));
					$('.gallery-product__control--up').addClass('gallery-product__control--active');
					$(this).removeClass('gallery-product__control--active');
				} else {
					galleryContentPosition += galleryHeight;
					galleryContent.css('transform', 'translateY(' + ( -(galleryContentPosition) - galleryControlArrowHeight + 'px)'));
					$('.gallery-product__control--up').addClass('gallery-product__control--active');
				}
				console.log(galleryContentPosition);
				// galleryContent.css('transform', 'translateY(' + (gallery.outerHeight() - galleryContent.outerHeight() - 12 + 'px)'));
				// $('.gallery-product__control--up').addClass('gallery-product__control--active');
				// $(this).removeClass('gallery-product__control--active');
			});

			$('.gallery-product__control--up').on('click', function(e) {
				e.preventDefault();
				if (galleryContentPosition - galleryHeight <= 0) {
					galleryContentPosition = 0;
					galleryContent.css('transform', 'translateY(' + (0 + 'px)'));
					$(this).removeClass('gallery-product__control--active');
					$('.gallery-product__control--down').addClass('gallery-product__control--active');
				} else {
					galleryContentPosition -= galleryHeight;
					galleryContent.css('transform', 'translateY(' + (  -galleryContentPosition + galleryControlArrowHeight + 'px)'));
					$('.gallery-product__control--down').addClass('gallery-product__control--active');
				}
				console.log(galleryContentPosition);
			});
		}
	}

// переключение изображений по клику для маленьких экранов и по ховеру
// для больших
	if (wWidth < 1235) {
		smallImages.on('click', showImage);
	} else {
		smallImages.off('click', showImage);
		smallImages.on('mouseover', showImage);
	}

	function showImage(e) {
		var imgHref;

		e.stopPropagation();
		e.preventDefault();

		if (!($(this).hasClass('gallery-product__item--active')) && $(this).hasClass('gallery-product__item')){
			imgHref = $(this).children().attr('href');
			mainImage.parent().attr('href', imgHref);
			mainImage.attr('src', imgHref);
			smallImages.removeClass('gallery-product__item--active');
			$(this).addClass('gallery-product__item--active');
			console.log("switching over the images");
		}
	}


	

// -----------------------------
// Попап галереи
	var galleryPopupObj = {
		iniatialized: false,
		galleryImages: null,
		mainImage: null,
		init: function () {
			var content, block, activeImage, popupMainImageBlock;
			var shift, maxshift, currentShift = 0;
			var startPos, currentPos, endPos = 0;

			var self = this;

			block = $('.popup-gallery__all-images');
			popupMainImageBlock = $('.popup-gallery__main-image');
			content = galleryContent.clone().appendTo('.popup-gallery__all-images');
			content.css("transform", "translateY(0px)");
			$('.product-card__main-image img').clone().appendTo(popupMainImageBlock);
			self.mainImage = $('.popup-gallery__main-image img');
			self.galleryImages = content.find('.gallery-product__item');
			self.handleNavLinks();
			
			// Переключение изображений по клику
			self.galleryImages.on('mouseover', imageSwitchHandler);
			self.galleryImages.on('click', imageSwitchHandler);

			function imageSwitchHandler (e) {
				e.stopPropagation();
				e.preventDefault();

				if (!($(this).hasClass('gallery-product__item--active')) && $(this).hasClass('gallery-product__item')){
					imgHref = $(this).children().attr('href');
					// self.mainImage.parent().attr('href', imgHref);
					
					self.mainImage.attr('src', imgHref);
					self.mainImage.addClass('scaleIn');
					self.mainImage.removeClass('scaleIn');
					self.galleryImages.removeClass('gallery-product__item--active');
					$(this).addClass('gallery-product__item--active');
					self.handleNavLinks();
				}
			}
			$('.popup-gallery__nav').on('click', navLinksClickHandler);
			// обработка кликов на иконки навигации по картинкам
			function navLinksClickHandler(e) {
				e.preventDefault();
				var activeImage, imgHref;
				if (!$(e.target).hasClass('disabled')) {
					activeImage = self.galleryImages.filter('.gallery-product__item--active');
					if ($(e.target).hasClass('nav-next') && !$(e.target).hasClass('disabled')) {
						self.galleryImages.removeClass('gallery-product__item--active');
						activeImage.next().addClass('gallery-product__item--active');
						activeImage = activeImage.next();
					}
					if ($(e.target).hasClass('nav-prev') && !$(e.target).hasClass('disabled')) {
						self.galleryImages.removeClass('gallery-product__item--active');
						activeImage.prev().addClass('gallery-product__item--active');
						activeImage = activeImage.prev();
					}
					imgHref = activeImage.children().attr('href');
					// self.mainImage.parent().attr('href', imgHref);
					self.mainImage.attr('src', imgHref);
					self.mainImage.addClass('scaleIn');
					// clearTimeout(animationTimeOut);

					var animationTimeOut = setTimeout(function() {
						self.mainImage.removeClass('scaleIn');
					}, 0);
					self.handleNavLinks();
				}
			}

			$('.popup-gallery__bigger-link').on('click', function(e) {
				e.preventDefault();

				// $(this).closest('#galleryPopup').hide();
				// $(this).closest('#galleryPopup').parent().hide();
				$('#fullImagePopup img').remove();
				self.mainImage.clone().appendTo('#fullImagePopup');
				$('#fullImagePopup').parent().fadeIn();
				$('#fullImagePopup').css('display', 'inline-block');
			});
			
			// Свайп изображений в галерее, если они не влязят в зону попапа
			maxshift = block.width() - content.width();
			if (wWidth < 1235 && maxshift < 0) {

				content.on('touchstart', function(e) {
					startPos = e.originalEvent.touches[0].pageX;
				});
				content.on('touchmove', function(e) {
					var thisPos = $(this).position().left;

					e.preventDefault();
					currentPos = e.originalEvent.touches[0].pageX;
					shift = currentPos - startPos;
					// границы по сдвигу
					if (shift + endPos  >= 0){
						shift = 0;
						endPos = 0;
						startPos = currentPos;
					} else if (shift + endPos < maxshift) {
						shift =  0;
						endPos = maxshift;
						startPos = currentPos;
					}
					$(this).css('transform', 'translateX(' + (shift + endPos) + 'px)');
					
				});
				content.on('touchend', function(e) {
					endPos = $(this).position().left;
				});
			}

			this.iniatialized = true;
		},
		handleNavLinks: function () {
			var self = this;
			var activeImage = self.galleryImages.filter('.gallery-product__item--active');
			var navPrev = $('.popup-gallery__nav .nav-prev');
			var navNext = $('.popup-gallery__nav .nav-next');

			if (activeImage.prev().length > 0) {
				navPrev.removeClass('disabled');
			} else {
				navPrev.addClass('disabled');
			}

			if (activeImage.next().length > 0) {
				navNext.removeClass('disabled');
			} else {
				navNext.addClass('disabled');
			}
		}


	};	
// Открытие попапа галереи
	(function() {
		'use strict';
		var popup = $('#galleryPopup');
		
		// открытие попапа при клике на основное изображение
		// происходит для всех размеров экрана
		mainImage.on('click', function(e) {
			e.preventDefault();

			popup.show();
			popup.parent().fadeIn();
			console.log($(this));
			var imageFilePath = $(this).parent().attr("href");
			setGalleryPopupMainImage(imageFilePath);
		});

		// Открытие попапа при клике на миниатюры изображений слева
		// для десктопа (смена изображений происходит при ховере)
		if (wWidth >= 1235) {
			smallImages.on('click', function(e) {
				e.preventDefault();
				
				popup.show();
				popup.parent().fadeIn();

				var imageFilePath = $(this).children().attr("href");
				setGalleryPopupMainImage(imageFilePath);
			});
		}

		function setGalleryPopupMainImage(imageFilePath) {
			if (!galleryPopupObj.iniatialized) {
				galleryPopupObj.init();
			} else {
				galleryPopupObj.galleryImages.removeClass('gallery-product__item--active');
				galleryPopupObj.galleryImages.find('[href="' + imageFilePath + '"]').parent().addClass('gallery-product__item--active');
				galleryPopupObj.mainImage.parent().attr("href", imageFilePath);
				galleryPopupObj.mainImage.attr("src", imageFilePath);
			}
		}

	}());

});





/**
 * Changes price value to be in readable format (with spaces between number triplets) 
 * 
 * @param {number} price Number to be formatted
 * @return {string} formatted price value.
 */
// function getPriceString (price) {
//     var intPrice;
//     price = price.toFixed(2);
//     price = price.split('.');
//     intPrice = price[0];

//     // if (price.length == 1) {
//     //     price.push('0'); // добавить ноль после запятой для целочисленных сум
//     // }
//     // ниже блок разбиения больших сумм в тройки с пробелом между ними
//     if (intPrice.length > 3) {
//         var n = parseInt(intPrice.length / 3);
//         var m = intPrice.length % 3;
//         var newPrice = '';

//         if (m === 0) {
//             newPrice = intPrice.slice(0, 3);
//             for (i = 1; i < n; i++) {
//                 newPrice += ' ' + intPrice.slice(i*3, i*3 + 3);
//             }
//         } else {
//             newPrice = intPrice.slice(0, m);
//             for (i = 0; i < n; i++) {
//                 newPrice += ' ' + intPrice.slice(m + i*3, m + i*3 + 3);
//             }
//         }
//         price[0] = newPrice;
//     }


//     return price.join('.');
// }



// ========================= Popups new ==================
$(function () {

	$('.product-feature--best-price').on('click',function () {
		var bestPricePopup = $('#bestPricePopup');
		bestPricePopup.show();
		bestPricePopup.parent().fadeIn();
	});

	var mypopup = {
		closeLink: $('.popup-b__close'),
		backLink: $('.popup-b__back'),
		wrapper: $('.popup-outer')
	};

	mypopup.closeLink.on('click', closePopupHandler);
	mypopup.backLink.on('click', closePopupHandler);
	mypopup.wrapper.on('click', function(e) {
		e.stopPropagation();
		if ($(e.target).hasClass('popup-outer')) {
			mypopup.wrapper.children().fadeOut();
			mypopup.wrapper.fadeOut();
		}
	});

	function closePopupHandler (e) {
		e.preventDefault();
		mypopup.wrapper.children().fadeOut();
		mypopup.wrapper.fadeOut();
	}
	// $('.popup-bcart__content').customScrollbar();
	// Нажатие кнопки "Купить" открывает попап
	$('#submitOrderBtn').on('click', function(e) {
		e.preventDefault();
		var popup = $('#cartPopup');

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
	});

	$('.popup-open-link').on('click', function(e) {
		e.preventDefault();
		var targetId = this.dataset.popupTarget;
		var popup = $('#' + targetId);

		popup.show();
		popup.parent().fadeIn();
	});


	

});



// review form submitting

$(document).ready(function () {
	$("#reviewform").submit(function(e){
		//alert('hello');
		var pros = $('textarea[name="pros"]').val().length;
		var cons = $('textarea[name="cons"]').val().length;
		var text = $('textarea[name="feedback"]').val().length;
		if(pros === 0 && cons === 0 && text === 0)
		{
			e.preventDefault();
			alert('Заполните пожалуйста хотя бы одно из полей: "Достоинства", "Недостатки" или "Комментарий"');
		}
		
		var rate = $('.star-rating-on').length;
		if(rate === 0)
		{
			e.preventDefault();
			$('.rate_text').css('color','red');
		}
		$('#rate').attr('value',rate);
		
		var name = $('input[name="name"]').val().length;
		if(name === 0)
		{
			e.preventDefault();
			$('.name-title').css('color','red');
		}
		
		var email = $('input[name="email"]').val();
		if(email.indexOf('@')< 1)
		{
			e.preventDefault();
			$('.email-title').css('color','red');
		}
	});
});

$(function() {
	var ratingBlock = $('.star-rating-control');
	ratingBlock.children().on('mouseover', function(){
		'use strict';
		var current = $(this);
		ratingBlock.children().removeClass('.review-star-rating__star--hover');
		$(this).addClass('review-star-rating__star--hover');
		while (current.prev().length > 0) {
			current.prev().addClass('review-star-rating__star--hover');
			current = current.prev();
		}
	});

	ratingBlock.on('mouseleave', function() {
		ratingBlock.children().removeClass('review-star-rating__star--hover');
	});

	ratingBlock.children().on('click', function () {
		'use strict';
		var current = $(this);
		ratingBlock.children().removeClass('review-star-rating__star--on');
		$(this).addClass('review-star-rating__star--on');
		while (current.prev().length > 0) {
			current.prev().addClass('review-star-rating__star--on');
			current = current.prev();
		}
	});

}); 