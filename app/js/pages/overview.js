
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
	
	var popularProductsSlider = $("#owl-popular-products");
	popularProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		pagination: false,
		nav: true,
		dots: false,
		scrollbar: true,

		responsive:{
			0:{
				items:1,
			},
			544:{
				items:2
			},
			768:{
				items:3
			},
			994:{
				items:3
			},
			1235:{
				items:4
			}
		}
	});
});
