$(function() {
	var wWidth = $(window).width();
	var subcategories = $('.category-menu__subcategories');
	var menuLinks = $('.subcategory');

	var sidebar = $('.category-sidebar-menu');
	var filterLink = $('.filter-link');

	// open sidebar filter by clicking on mobile filter link (подбор)
	filterLink.click(function() {
		var offset = filterLink.position();
		var sidebarOffset = sidebar.offset();
		if(offset !== undefined) {
			var top = offset.top;
			var left = offset.left;
		}
		sidebar.css('width', $(this).outerWidth() + 'px');
		sidebar.css('top', (offset.top) + filterLink.outerHeight()    + 'px' );
		sidebar.css('left', (offset.left) + 'px');
		sidebar.toggle();
		$(this).toggleClass('filter-link-active');
	});
	// close sidebar with click on blank space
	$(document).mouseup(function (e)
	{ if ($(document).width() <= 994){
			if (!sidebar.is(e.target) // if the target of the click isn't the container...
				&& sidebar.has(e.target).length === 0 // ... nor a descendant of the container
				&& !filterLink.is(e.target) && sidebar.css('display') === 'block') 
			{
				sidebar.hide();
				filterLink.removeClass('filter-link-active');
			}
		}
	});
	//    раскрытие пунктов меню сайдбара
	menuLinks.on('click', function(e) {
		if (e.target.nodeName !== 'A'){
			e.preventDefault();
			if ($(this).hasClass('opened')) {
				$(this).next().slideUp();
				$(this).removeClass('opened');
			} else {
				menuLinks.removeClass('opened');
				$(this).addClass('opened');
				subcategories.slideUp();
				$(this).next().slideDown();
			}
		}
	});

	// раскрытие блока с брендами товара в мобильном виде
	if (wWidth < 768) {
		$('.brands-block__heading').on('click', function(e) {
			$(this).toggleClass('active');
			console.log($(this).next());
			$(this).next().slideToggle();
		});
	}

});


$(document).ready(function() {
	var categorySlider = $(".owl-category-slider");	
	var popularProductsSlider = $("#owl-popular-products");
 
	categorySlider.owlCarousel({
 
		nav : true, // Show next and prev buttons
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
	var pageSliderContainer = $(".page-slider-container");
	var pageSliderContorls = pageSliderContainer.find('.page-slider__controls');
	var pageSliderNextLink = pageSliderContainer.find('.owl-next');
	var pageSliderPrevLink = pageSliderContainer.find('.owl-prev');
	pageSliderNextLink.html(pageSliderContorls.find('.custom-dot.active').next().html());
	pageSliderContainer.find('.owl-nav').on('click', function(e) {
		if ($(e.target).hasClass('owl-prev') || $(e.target).hasClass('owl-next')) {
			var nextElem = pageSliderContorls.find('.custom-dot.active').next();
			var prevElem = pageSliderContorls.find('.custom-dot.active').prev();
			if (nextElem.length !== 0) {
				pageSliderNextLink.html(pageSliderContorls.find('.custom-dot.active').next().html());
			}
			if (prevElem.length !== 0) {
				pageSliderPrevLink.html(pageSliderContorls.find('.custom-dot.active').prev().html());
			}
		}
		
	});

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
				pagination: false
			},
			994:{
				items:3,
				nav:true,
				loop:false,
				paginatioin: false

			},
			1200:{
				items:3,
				nav:true,
				loop:false,
				paginatioin: false
			}
		}
	});
});