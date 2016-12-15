$(function() {
	// поиск в меню
	$('.mobile-search-link').on('click', function(e) {
		e.preventDefault();

		$(this).toggleClass('active');
		$('.header-search').slideToggle();
	})
	// переключение табов в блоке ТОП ПО БРЕНДАМ
	$('.top-brands-menu__item').on('click', function(e) {
		e.preventDefault();
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
	})
	// переключение между адресами в футере сайта
	var storesInfo = $('.store');

	$('.store-address-tabs-menu__item').on('click', function(e) {
		$('.store-address-tabs-menu__item').removeClass('store-address-tabs-menu__item--active');
		storesInfo.removeClass('store--active');
		$(this).addClass('store-address-tabs-menu__item--active');
		$($(this).data("id")).addClass('store--active');
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
});