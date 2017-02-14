
$(function () {
	var wWidth = $(window).width();
	// var subcategories = $('.category-menu__subcategories');
	// var menuLinks = $('.subcategory');
	var filterLink = $('.filter-link');
	var sidebar = $('.category-sidebar-menu');
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
	// menuLinks.on('click', function(e) {
	// 	if (e.target.nodeName !== 'A'){
	// 		e.preventDefault();
	// 		menuLink = $(this);
	// 		if (menuLink.hasClass('opened')) {
	// 			menuLink.next().slideUp();
	// 			menuLink.removeClass('opened');
	// 		} else {
	// 			if (!menuLink.parent().hasClass('category-menu__item--no-subcategories')) {
	// 				menuLinks.removeClass('opened');
	// 				menuLink.addClass('opened');
	// 				subcategories.slideUp();
	// 				menuLink.next().slideDown();
	// 			}
				
	// 		}
	// 	}
	// });



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
			1235:{
				items:2,
			}
		}
	});

	var owlSlidersWithScrollbar = document.querySelectorAll('.owl-loaded.custom-scrollbar');
	var item;
	for (var i=0; i < owlSlidersWithScrollbar.length; i++) {
		item = owlSlidersWithScrollbar[i];
		addCustomScrollbar(item);
	}
});