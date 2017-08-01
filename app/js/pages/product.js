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
					videos.addClass('video-tab--hidden');
					videoTab.removeClass('video-tab--hidden');
					$('.tabs-nav').removeClass('tabs-nav--active');
					link.addClass('tabs-nav--active');
				}
				return false;
			});
		}
	};
	productPageVideosObj.init();

	// Init the carousel sliders on the page
	var owl = $(".owl-carousel");

	owl.owlCarousel({
		loop: false,
		margin:0,
		navigationText: true,
		scrollbar: true,
		pagination: false,
		responsive:{
			 0:{
				items:1,
				nav:true,
				dots: false
			 },
			544:{
				items:2,
				nav: true,
				dots: false
			},
			768:{
				items:3,
				nav:true,
				dots: false
			},
			994:{
				items:4,
				nav:true,
				loop:false,
				dots: false

			}
		}
	});


	// Инициализация изменяемого селекта в блоке "требуется докупить"
	$('.purchase-form__qty').editableSelect({filter: false});
	// -----------------------------------------
	// ----------- Требуется докупть -----------

	$('.products-purchase__show-link').on('click', function(e) {
		e.preventDefault();
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

	// раскрытие блока с брендами товара в мобильном виде
	if (wWidth < 768) {
		$('.brands-block__heading').on('click', function(e) {
			$(this).toggleClass('active');
			$(this).next().finish().slideToggle();
		});
	}

	galleryConfig = {
		galleryImagesParentBlock:  $('.gallery-product'),
		galleryImagesBlock: $('.gallery-product__content'),
		controlButtonUp: $('.gallery-product__control--up'),
		controlButtonDown: $('.gallery-product__control--down'),
		activeControlButtonClassName: 'gallery-product__control--active'
	}

// Добавление кнопок навигации по картинкам галереи, если их больше 4х

	if (wWidth >= 1235) {
		initializeGalleryImagesNavigation(galleryConfig);
	}

	function initializeGalleryImagesNavigation (galleryConfig) {
		var galleryImagesParentBlock = galleryConfig.galleryImagesParentBlock;
		var galleryImagesBlock = galleryConfig.galleryImagesBlock;
		var controlButtonUp = galleryConfig.controlButtonUp;
		var controlButtonDown = galleryConfig.controlButtonDown;
		var activeControlButtonClassName = galleryConfig.activeControlButtonClassName;

		var galleryImagesBlockHeight = galleryImagesBlock.outerHeight();
		var galleryImagesParentBlockHeight = galleryImagesParentBlock.outerHeight();
		var galleryContentPosition = 0;

		if (galleryImagesBlockHeight > galleryImagesParentBlockHeight) {
			controlButtonDown.addClass(activeControlButtonClassName);
			controlButtonDown.on('click', function (e) {
				e.preventDefault();

				if (galleryContentPosition + galleryImagesParentBlockHeight > galleryImagesBlockHeight - galleryImagesParentBlockHeight) {
					galleryContentPosition = galleryImagesBlockHeight - galleryImagesParentBlockHeight;
					galleryImagesBlock.css('transform', 'translateY(' + ( -galleryContentPosition + 'px)'));
					controlButtonUp.addClass(activeControlButtonClassName);
					$(this).removeClass(activeControlButtonClassName);
				} else {
					galleryContentPosition += galleryImagesParentBlockHeight;
					galleryImagesBlock.css('transform', 'translateY(' + ( -(galleryContentPosition) + 'px)'));
					controlButtonUp.addClass(activeControlButtonClassName);
				}
			});

			controlButtonUp.on('click', function (e) {
				e.preventDefault();

				if (galleryContentPosition - galleryImagesParentBlockHeight <= 0) {
					galleryContentPosition = 0;
					galleryImagesBlock.css('transform', 'translateY(' + (0 + 'px)'));
					$(this).removeClass(activeControlButtonClassName);
					$(controlButtonDown).addClass(activeControlButtonClassName);
				} else {
					galleryContentPosition -= galleryImagesParentBlockHeight;
					galleryImagesBlock.css('transform', 'translateY(' + (  -galleryContentPosition + 'px)'));
					$(controlButtonDown).addClass(activeControlButtonClassName);
				}
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
		}
	}

// -----------------------------
// Попап галереи
	var galleryPopupObj = {
		iniatialized: false,
		galleryImages: null,
		mainImage: null,
		init: function () {
			var previewImages, previewImagesParentBlock, activeImage, popupMainImageBlock;
			var self = this;

			previewImagesParentBlock = $('.popup-gallery__all-images');
			popupMainImageBlock = $('.popup-gallery__main-image');
			previewImages = galleryContent.clone().appendTo('.popup-gallery__all-images');
			previewImages.css("transform", "translateY(0px)");
			$('.product-card__main-image img').clone().appendTo(popupMainImageBlock);
			self.mainImage = $('.popup-gallery__main-image img');
			self.galleryImages = previewImages.find('.gallery-product__item');
			self.handleNavLinksStatus();
			self.addNavLinks(previewImagesParentBlock);
			
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
					self.handleNavLinksStatus();
				}
			}
			$('.popup-gallery__nav').on('click', navLinksClickHandler);
			// обработка кликов на иконки навигации по картинкам
			function navLinksClickHandler(e) {
				e.preventDefault();
				var activeImage, imgHref;
				if (!$(e.target).hasClass('disabled')) {
					activeImage = self.galleryImages.filter('.gallery-product__item--active');
					if ($(e.target).hasClass('nav-next')) {
						self.galleryImages.removeClass('gallery-product__item--active');
						activeImage.next().addClass('gallery-product__item--active');
						activeImage = activeImage.next();
					}
					if ($(e.target).hasClass('nav-prev')) {
						self.galleryImages.removeClass('gallery-product__item--active');
						activeImage.prev().addClass('gallery-product__item--active');
						activeImage = activeImage.prev();
					}

					imgHref = activeImage.children().attr('href');
					proccesActiveImagePosition(activeImage);
					self.mainImage.attr('src', imgHref);
					self.handleNavLinksStatus();
				}
			}

			function proccesActiveImagePosition(activeImage) {
				'use strict';
				var parent = activeImage.parent();
				var container = parent.parent();
				var controlButtonUp = container.find('.gallery-product__control--up');
				var containerSize, activeImageOffset, activeImageSize;
				var parentShiftLeft = 0;
				var parentShiftTop = 0;
				if (parent.outerHeight() > container.outerHeight()) {
					containerSize = container.outerHeight();
					activeImageOffset = activeImage.offset().top - parent.offset().top ;
					activeImageSize = activeImage.outerHeight();
					parentShiftTop = container.outerHeight() - activeImageOffset - activeImage.outerHeight();
				} else if (parent.outerWidth() > container.outerWidth()) {
					containerSize = container.outerWidth();
					activeImageOffset = activeImage.offset().left - parent.offset().left ;
					activeImageSize = activeImage.outerWidth();
					parentShiftLeft = containerSize - activeImageOffset - activeImageSize;
				}

				if (activeImageOffset > containerSize) {
					parent.css('transform', 'translate3d(' + parentShiftLeft + 'px, ' + parentShiftTop + 'px, 0px)' )
					parent.css('transition', 'transform 0.2s ease');
					controlButtonUp.addClass('gallery-product__control--active');
				} else {
					parent.css('transform', 'translate3d(' + 0 + 'px, ' + 0 + 'px, 0px)' )
					parent.css('transition', 'transform 0.2s ease');
					controlButtonUp.removeClass('gallery-product__control--active');
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
			
			if (wWidth < 1235 && previewImages.width() > previewImagesParentBlock.width()) {
				self.addTouchSlideForBlock(previewImages);
			}

			this.iniatialized = true;
		},
		handleNavLinksStatus: function () {
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
		},
		addTouchSlideForBlock: function (block) {
			var shift, maxshift, currentShift = 0;
			var startPos, currentPos, endPos = 0;

			maxshift = block.parent().width() - block.width();
			block.on('touchstart', function(e) {
				startPos = e.originalEvent.touches[0].pageX;
			});

			block.on('touchmove', function(e) {
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

			block.on('touchend', function(e) {
				endPos = $(this).position().left;
			});
		},
		addNavLinks: function (smallImagesContainer) {
			var galleryContentPosition = 0;
			var galleryImagesBlock = smallImagesContainer.find('.gallery-product__content');
			var galleryImagesBlockHeight = galleryImagesBlock.height();
			var galleryImagesParentBlockHeight = smallImagesContainer.height();
			var activeControlButtonClassName = 'gallery-product__control--active';

			if (!this.iniatialized) {
				var controlButtonUp = $('.gallery-product__control--up').clone().appendTo(smallImagesContainer);
				var controlButtonDown = $('.gallery-product__control--down').clone().appendTo(smallImagesContainer);
				
				if (galleryImagesBlockHeight > galleryImagesParentBlockHeight) {
					controlButtonDown.addClass(activeControlButtonClassName);
					controlButtonDown.on('click', function (e) {
						e.preventDefault();

						if (galleryContentPosition + galleryImagesParentBlockHeight > galleryImagesBlockHeight - galleryImagesParentBlockHeight) {
							galleryContentPosition = galleryImagesBlockHeight - galleryImagesParentBlockHeight;
							galleryImagesBlock.css('transform', 'translateY(' + (  -galleryContentPosition - 12 + 'px)'));
							controlButtonUp.addClass(activeControlButtonClassName);
							$(this).removeClass(activeControlButtonClassName);
						} else {
							galleryContentPosition += galleryImagesParentBlockHeight;
							galleryImagesBlock.css('transform', 'translateY(' + ( -(galleryContentPosition) - 12 + 'px)'));
							controlButtonUp.addClass(activeControlButtonClassName);
						}
					});

					controlButtonUp.on('click', function (e) {
						e.preventDefault();

						if (galleryContentPosition - galleryImagesParentBlockHeight <= 0) {
							galleryContentPosition = 0;
							galleryImagesBlock.css('transform', 'translateY(' + (0 + 'px)'));
							$(this).removeClass(activeControlButtonClassName);
							$(controlButtonDown).addClass(activeControlButtonClassName);
						} else {
							galleryContentPosition -= galleryImagesParentBlockHeight;
							galleryImagesBlock.css('transform', 'translateY(' + (  -galleryContentPosition + 12 + 'px)'));
							$(controlButtonDown).addClass(activeControlButtonClassName);
						}
					});
				}
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


	(function() {
		function TabsNavigation($tabsContainerElement) {
			var tabsObj = this;
			// tabsObj.offset = 0;
			tabsObj.currentOffset = 0;
			tabsObj.container = $tabsContainerElement;
			tabsObj.menu = tabsObj.container.find('.tabs-menu');
			tabsObj.menuItems = tabsObj.menu.find('.tabs-menu__item');
			tabsObj.tabs = $('.' + tabsObj.container.data('tab-class'));
			tabsObj.prevNav = tabsObj.container.find('.tabs-menu__control.tabs-menu__control--prev');
			tabsObj.nextNav = tabsObj.container.find('.tabs-menu__control.tabs-menu__control--next');
			tabsObj.navElementWidth = tabsObj.prevNav.width();
			tabsObj.maxOffset = tabsObj.container.outerWidth() - tabsObj.menu.outerWidth();
			tabsObj.offset = -tabsObj.maxOffset;

			if (tabsObj.menu.outerWidth() > tabsObj.container.outerWidth()) {
				tabsObj.nextNav.addClass('active');

				if (-tabsObj.maxOffset > tabsObj.container.outerWidth()) {
					tabsObj.offset = tabsObj.container.outerWidth() - tabsObj.nextNav.outerWidth()*2;
				}
			} else {
				tabsObj.nextNav.removeClass('active');
			}

			tabsObj.init = function () {
				tabsObj.menuItems.on('click', tabsMenuItemClickHandler);
				tabsObj.nextNav.on('click', -1,  navClickHandler);
				tabsObj.prevNav.on('click', 1,  navClickHandler);
			}


			function getOffset (dir) {
				var offset = tabsObj.offset * dir + tabsObj.currentOffset;
				if (offset >= 0) {
					offset = 0;
				}
				else if (offset <= tabsObj.maxOffset) {
					offset = tabsObj.maxOffset;
				}

				return offset;
			}

			function updateCurrentOffset (offset) {
				tabsObj.currentOffset = offset;
			}

			function updateTabsMenuPosition(offsetX, offsetY, offsetZ) {
				var offsetX = offsetX || 0;
				var offsetY = offsetY || 0;
				var offsetZ = offsetZ || 0;
				tabsObj.menu.css('transform', 'translate3d(' + offsetX + 'px, ' + offsetY + 'px, ' + offsetZ + 'px');
			}

			function navClickHandler (event) {
				var dir = event.data;
				var offset = getOffset(dir);
				updateCurrentOffset(offset);

				if (offset >= 0) {
					tabsObj.prevNav.removeClass('active');
					tabsObj.nextNav.addClass('active');
				} 
				else if (offset <= tabsObj.maxOffset) {
					tabsObj.nextNav.removeClass('active');
				} else if (offset < 0 && offset > tabsObj.maxOffset) {
					tabsObj.nextNav.addClass('active');
				}
 
				if (offset < 0) {
					tabsObj.prevNav.addClass('active');
				}

				updateTabsMenuPosition(offset);
			}

			function tabsMenuItemClickHandler (event) {
				event.preventDefault();

				var tabLink = $(this);
				var tab = $('#' + tabLink.data('tabid'));
				// var accessoriesTabs = $(tabsClass);
				tabsObj.tabs.hide();
				tab.show();

				tabsObj.menuItems.removeClass('tabs-menu__item--active');
				tabLink.addClass('tabs-menu__item--active');
			}


			return tabsObj;
		}

		var accessoriesAdditional = new TabsNavigation($('#accessoriesAdditional'));
		accessoriesAdditional.init();

		var accessoriesMain = new TabsNavigation($('#accessoriesMain'));
		accessoriesMain.init();
	}());

});

// ========================= Popups new ==================
$(function () {

	$('.product-feature--best-price').on('click',function () {
		var bestPricePopup = $('#bestPricePopup');
		bestPricePopup.show();
		bestPricePopup.parent().fadeIn();
	});

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

		}
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