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

	// close sidebar by clicking on free space
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
	// var categorySlider = $(".owl-category-slider");	
	var popularProductsSlider = $("#owl-popular-products");
	popularProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		
		// responsiveclass:true,
		pagination: false,
		nav: true,
		dots: false,

		responsive:{
			0:{
				items:1,

			},
			544:{
				items:2,

			},
			768:{
				items:3,
				// onTranslated: myCallback
			},
			994:{
				items:2,


			},
			1200:{
				items:3,

			}
		}
	});

	var owlSlidersWithScrollbar = document.querySelectorAll('.owl-loaded.custom-scrollbar');
	var item;
	for (var i=0; i < owlSlidersWithScrollbar.length; i++) {
		item = owlSlidersWithScrollbar[i];
		addCustomScrollbar(item);
	}
	// scrollbar внизу блока с популярными товарами
	// if ($(window).width() > 767) {
	// 	var newDiv = document.createElement('div');
	// 	newDiv.classList.add("owl-custom-scrollbar-wrapper");
	// 	newDiv.innerHTML = "<div class='owl-custom-scrollbar' draggable></div>";
	// 	var customScrollbar = $(newDiv).find('.owl-custom-scrollbar');

	// 	popularProductsSlider.append(newDiv);
	// 	var scrollbarWidth = 100 / (popularProductsSlider.find('.owl-stage').width()/popularProductsSlider.width());
	// 	customScrollbar.css('width', scrollbarWidth + '%');
	// }
	
	// function myCallback(event) {
	//     var transformMatrix = popularProductsSlider.find('.owl-stage').css('transform');
	//     var matrix = transformMatrix.replace(/[^0-9\-.,]/g, '').split(',');
	// 	var x = matrix[12] || matrix[4];//translate x
	// 	var y = matrix[13] || matrix[5];//translate y

	// 	customScrollbar.css('margin-left', -100 / (popularProductsSlider.find('.owl-stage').width() / x) + '%');
	// }

	// function getTouches(event) {
 //        if (event.touches !== undefined) {
 //            return {
 //                x : event.touches[0].pageX,
 //                y : event.touches[0].pageY
 //            };
 //        }

 //        if (event.touches === undefined) {
 //            if (event.pageX !== undefined) {
 //                return {
 //                    x : event.pageX,
 //                    y : event.pageY
 //                };
 //            }
 //            if (event.pageX === undefined) {
 //                return {
 //                    x : event.clientX,
 //                    y : event.clientY
 //                };
 //            }
 //        }
 //    }
});
// page slider
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