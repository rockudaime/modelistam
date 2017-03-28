$(function () {
	var wWidth = $(window).width();
	$('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
		  $this.html(event.strftime('%-D %!D:день, дня, дней; %H:%M'));
		});
	});

	var similarProductsSlider = $('#owl-similar-products');
	initOwlSlider(similarProductsSlider);

	function initOwlSlider(slider) {
		slider.owlCarousel({
			loop: false,
			margin:0,
			navigationtext: false,
			pagination: false,
			nav: true,
			dots: false,
			scrollbar: true,

			responsive:{
				0:{
					items:1
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
				1200:{
					items:4
				}
			}
		});
	}
});