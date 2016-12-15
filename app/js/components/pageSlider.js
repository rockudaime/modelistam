$(function() {
	var pageSlider = $(".page-slider");
	var pageSliderContainer, pageSliderControls;
	console.log(pageSlider);
 
	pageSlider.owlCarousel({
 
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
		onChanged: handleNavText,
		responsive:{
			0:{
				nav:false
			},
			768:{
				nav:true,
			},
		}
	});
	// текст следующего слайда в управляющей кнопке
	pageSliderContainer = $(".page-slider-container");
	pageSliderControls = pageSliderContainer.find('.page-slider__controls');
	var pageSliderNextLink = pageSliderContainer.find('.owl-next');
	var pageSliderPrevLink = pageSliderContainer.find('.owl-prev');
	var dotsContainer = pageSliderControls.find('.owl-dots');

	pageSliderNextLink.html(pageSliderControls.find('.custom-dot.active').next().html());
	function handleNavText(e) {
		/*
			* в навигационных кнопках содержится текст следующего слайда
			* текст берется из содержимого переключающих кнопок (owl-dots)
		*/

		pageSliderContainer = pageSliderContainer || $(".page-slider-container");
		pageSliderControls = pageSliderControls || pageSliderContainer.find('.page-slider__controls');
		var nextElem = pageSliderControls.find('.custom-dot.active').next();
		var prevElem = pageSliderControls.find('.custom-dot.active').prev();
		if (nextElem.length !== 0) {
			pageSliderNextLink.html(pageSliderControls.find('.custom-dot.active').next().html());
		}
		if (prevElem.length !== 0) {
			pageSliderPrevLink.html(pageSliderControls.find('.custom-dot.active').prev().html());
		}
	}
	if (dotsContainer.children().length > 3) {
		pageSliderControls.append('<div class="page-slider__more-btn"><i></i><i></i><i></i></div>');
		var pageSliderMoreBtn = pageSliderControls.find('.page-slider__more-btn');
		pageSliderMoreBtn.on('click', function(e) {
			var width = dotsContainer.find('.custom-dot').outerWidth();

			if ($(this).css('right') == "0px") {
				$(this).css('right', 'auto');
				dotsContainer.css('margin-left', (-width * 3 - 6 + $(this).width()) + 'px');
			} else {
				$(this).css('right', '0px');
				dotsContainer.css('margin-left', 0 + 'px');
			}
		});
		function pageSliderControlsInit () {
			var width = dotsContainer.find('.custom-dot').outerWidth();
			dotsContainer.children().css('flex-basis', width + 'px');
			dotsContainer.css('width', width * dotsContainer.children().length + 3 * dotsContainer.children().length);
		}
		if ($(window).width() > 767) {
			pageSliderControlsInit();
		}
	}
});