$(function(){
	var isListFlag = localStorage.listFlag || false;
	var alreadyList = false;
	var categoryLayoutObj = {
		products: [],
		init: function() {
			var self = this;
			var productObj = {};
			var products = $('.category-product');
			for (var i = 0; i < products.length; i++) {

				productObj.product = $(products[i]);
				productObj.code = $(productObj.product.find('.category-product__product-code'));
				productObj.rightBlock = $(productObj.product.find('.category-product__content-right'));
				productObj.comments = $(productObj.product.find('.category-product__product-comments'));
				productObj.links = $(productObj.product.find('.category-product__product-links'));
				productObj.rating = $(productObj.product.find('.category-product__rating'))
				console.log(productObj);
				self.products.push($.extend(true, {}, productObj));
			}
			console.log(self.products);
			return self;
		},
		displayList: function() {
			var self = this;
			var products = self.products;
			var product;
			$('.category-content__products').addClass('category-content__products--list');
			for (var i = 0; i < products.length; i++) {
				product = products[i];
				console.log(product);
				product.rightBlock.prepend(product.code);
				product.product.find('.category-product__heading').append(product.comments);
				product.product.find('.category-product__content').append(product.links);
				product.product.find('.category-product__content').append(product.rating);
			}
			alreadyList = true;
		}

	}
	// if (layoutFlag) {
	// 	categoryLayoutObj.init();
	// }
	var links = $('.view-changer-link');
	links.on('click', function(e){
		e.preventDefault();
		var link = $(e.currentTarget);
		console.log(link);

		links.removeClass('view-changer-link--active');
		link.addClass('view-changer-link--active');

		if (link.data('view') == 'list') {
			categoryLayoutObj.displayList();
		}
	});

	console.log('hello there kids');
	categoryLayoutObj.init();
	// if (!alreadyList) {
	// 	categoryLayoutObj.displayList();
	// }

	// var product = $('.category-product');
	// console.log(product.length);
	// for (var i=0; i < product.length; i++) {
	// 	console.log(product[i]);
	// 	console.log($(product[i]).find('.category-product__content-right'));
	// 	$(product[i]).find('.category-product__content-right').prepend($(product[i]).find('.category-product__product-code'));
	// }

	// var code = product.find('.category-product__product-code');
	// console.log(code);
	// product.find('.category-product__content-right').append(code);
});