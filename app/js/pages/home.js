$(function() {
	// поиск в меню
	$('.mobile-search-link').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		self.toggleClass('active');
		$('.header-search').slideToggle();
	});
	// мобильный селект, с выпадающим меню
	$('.mobile-custom-select').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		$(this).toggleClass('active');
		$(this).next().toggle();
		
	})
	// переключение табов в блоке ТОП ПО БРЕНДАМ
	$('.top-brands-menu__item').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		var mobileSelect;
		var link = e.target;
		var tabId = link.dataset.id;
		if (link.nodeName === 'SPAN') {
			link = $(link).parent();
			tabId = link.data('id');
		}
		
		var links = $('.top-brands-menu__item'); // Элемент меню
		var tab = $('#' + tabId);
		var tabs = $('.top-brands-content__item');

		

		if (tabId && !tab.hasClass('active')){
			tabs.removeClass('active');
			links.removeClass('active');
			$(link).addClass('active');
			tab.addClass('active');
		}

		if ($(window).width() < 768) {
			mobileSelect = self.parent().prev();
			self.parent().hide();
			mobileSelect.removeClass('active');
			mobileSelect.html($(this).html());
		}
	});
	// переключение между адресами в футере сайта
	var storesInfo = $('.store');

	$('.store-address-tabs-menu__item').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		$('.store-address-tabs-menu__item').removeClass('active');
		storesInfo.removeClass('store--active');
		self.addClass('active');
		$(self.data("id")).addClass('store--active');

		if ($(window).width() < 768) {
			mobileSelect = self.parent().prev();
			self.parent().hide();
			mobileSelect.removeClass('active');
			mobileSelect.html($(this).html());
		}
	});

	$('.store-gallery__miniatures').on('click', function(e) {
		e.preventDefault();
		if (e.target.nodeName === "IMG") {
			console.log($(e.target).parent().attr("href"));
			$('.store-gallery__main-image img').attr("src", $(e.target).parent().attr("href"));
			$(this).find('.store-gallery__miniature--active').removeClass('store-gallery__miniature--active');
			$(e.target).parent().parent().addClass('store-gallery__miniature--active');
		}
	});






	// Start of main slider on home page

	var pageSlider = $(".page-slider");
	var pageSliderContainer, pageSliderControls;

	pageSlider.owlCarousel({
 
		nav : true, // Show next and prev buttons
		navText: false,
		pagination: true,
		slideSpeed : 300,
		paginationSpeed : 400,
		dotsContainer: '#customDots',
		
		// singleItem:true
 
		// "singleItem:true" is a shortcut for:
		items : 1, 
		itemsDesktop : false,
		itemsDesktopSmall : false,
		itemsTablet: false,
		itemsMobile : false,
		responsive:{
			0:{
				nav:false
			},
			768:{
				nav:true,
			},
		}
	});
	(function() {
		var homeDotsOffset = 0;
		var dots = $('.home-slider__custom-dot');
		var wrapper = $('.home-slider__dots');
		var viewportContainer = $('.home-slider__dots-wrapper');
		var viewportWidth = viewportContainer.width();
		var wrapperWidth = ($(dots[0]).width() + 8) * dots.length - 8;
		var moreBtn = document.createElement('div');
		moreBtn.classList.add('home-slider__more');
		console.log(moreBtn);
		if (wrapperWidth > viewportWidth) {
			wrapper.css('width', wrapperWidth + 'px');
			viewportContainer.append(moreBtn);
			$(moreBtn).on('click', function() {
				if ($(this).hasClass('left')) {
					console.log('hello');
					homeDotsOffset -= viewportWidth;
					if (homeDotsOffset < 0) {
						homeDotsOffset = 0;
						$(this).removeClass('left');
					}
				} else  {
					homeDotsOffset +=  viewportWidth;
					if (homeDotsOffset > wrapperWidth - viewportWidth) {
						homeDotsOffset = wrapperWidth - viewportWidth;
						$(this).addClass('left');
					}
					
				}

				wrapper.css('transform', 'translate3d(-' + homeDotsOffset + 'px, 0, 0)');
				wrapper.css('transition', 'transform .3s ease');

			});
		}
		
	}());
	

	var popularProductsSlider = $("#owl-popular-products");
	var viewedProductsSlider = $("#owl-viewed-products");
	var newProductsSlider = $("#owl-new-products");
	popularProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		
		// responsiveclass:true,
		pagination: false,
		nav: false,
		responsive:{
			0:{
				items:1,
				nav:false,
			},
			544:{
				items:2,
				nav: false,
			},
			768:{
				items:3,
				nav: true,
				dots: false,
				pagination: false,
				onTranslated: myCallback
			},
			994:{
				items:3,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback

			},
			1200:{
				items:4,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback
			}
		}
	});
	viewedProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		
		// responsiveclass:true,
		pagination: false,
		nav: false,
		responsive:{
			0:{
				items:1,
				nav:false,
			},
			544:{
				items:2,
				nav: false,
			},
			768:{
				items:3,
				nav: true,
				dots: false,
				pagination: false,
				onTranslated: myCallback
			},
			994:{
				items:3,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback

			},
			1200:{
				items:4,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback
			}
		}
	});
	newProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		
		// responsiveclass:true,
		pagination: false,
		nav: false,
		responsive:{
			0:{
				items:1,
				nav:false,
			},
			544:{
				items:2,
				nav: false,
			},
			768:{
				items:3,
				nav: true,
				dots: false,
				pagination: false,
				onTranslated: myCallback
			},
			994:{
				items:3,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback

			},
			1200:{
				items:4,
				nav:true,
				loop:false,
				paginatioin: false,
				onTranslated: myCallback
			}
		}
	});

	// scrollbar внизу блока с популярными товарами
	if ($(window).width() > 767) {
		var newDiv = document.createElement('div');
		newDiv.classList.add("owl-custom-scrollbar-wrapper");
		newDiv.innerHTML = "<div class='owl-custom-scrollbar' draggable></div>";
		var customScrollbar = $(newDiv).find('.owl-custom-scrollbar');

		popularProductsSlider.append(newDiv);
		var scrollbarWidth = 100 / (popularProductsSlider.find('.owl-stage').width()/popularProductsSlider.width());
		customScrollbar.css('width', scrollbarWidth + '%');
	}
	
	function myCallback(event) {
	    var transformMatrix = popularProductsSlider.find('.owl-stage').css('transform');
	    var matrix = transformMatrix.replace(/[^0-9\-.,]/g, '').split(',');
		var x = matrix[12] || matrix[4];//translate x
		var y = matrix[13] || matrix[5];//translate y

		customScrollbar.css('margin-left', -100 / (popularProductsSlider.find('.owl-stage').width() / x) + '%');
	}


});

