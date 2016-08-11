$(document).ready(function() {
	// работа 
	var mainImage = $('.product-card__main-image img');
	var smallImages = $('.gallery-product__item img');

	smallImages.on('click', function(e) {
		mainImage.attr('src', this.getAttribute('src'));			
	});

	
});