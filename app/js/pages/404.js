$(function () {
	var viewedProductsSlider = $("#owl-viewed-products");
	viewedProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		scrollbar: true,
		
		// responsiveclass:true,
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
			},
			994:{
				items:3,

			},
			1200:{
				items:4,
			}
		}
	});
});