$(function(){
	var isListFlag = false;
	var alreadyList = false;

	// object which methods are processing the changing in layout
	var categoryLayoutObj = {
		products: [],
		links: null,
		linkList: null,
		linkBlock: null,
		init: function() {
			var self = this;
			var productObj = {};
			var products = $('.category-product__inner');
			self.links = self.links || $('.view-changer-link');
			self.linkList = self.linkList || $('.view-changer-link[data-view="list"]');
			self.linkBlock = self.linkBlock || $('.view-changer-link[data-view="block"]');
			for (var i = 0; i < products.length; i++) {

				productObj.product = $(products[i]);
				productObj.code = $(productObj.product.find('.category-product__product-code'));
				productObj.rightBlock = $(productObj.product.find('.category-product__content-right'));
				productObj.comments = $(productObj.product.find('.category-product__product-comments'));
				productObj.links = $(productObj.product.find('.category-product__product-links'));
				productObj.rating = $(productObj.product.find('.category-product__rating'));
				self.products.push($.extend(true, {}, productObj));
			}
			return self;
		},
		displayList: function() {
			var self = this;
			var products = self.products;
			var product;

			self.links.removeClass('view-changer-link--active');
			self.linkList.addClass('view-changer-link--active');

			$('.category-content__products').addClass('category-content__products--list');
			for (var i = 0; i < products.length; i++) {
				product = products[i];
				product.rightBlock.prepend(product.code);
				product.product.find('.category-product__heading').append(product.comments);
				product.product.find('.category-product__content').append(product.links);
				product.product.find('.category-product__content').append(product.rating);
			}
			alreadyList = true;
			isListFlag = true;
			localStorage.listFlag = JSON.stringify(isListFlag);

		},
		displayBlock: function() {
			var self = this;
			var products = self.products;
			var product;

			self.links.removeClass('view-changer-link--active');
			self.linkBlock.addClass('view-changer-link--active');

			$('.category-content__products').removeClass('category-content__products--list');
			for (var i = 0; i < products.length; i++) {
				product = products[i];
				product.product.find('.category-product__product-info').append(product.comments).append(product.code);
				product.product.find('.category-product__buy').append(product.links);
				product.product.find('.category-product__hidden-content').append(product.rating);
			}
			alreadyList = false;
			isListFlag = false;
			localStorage.listFlag = JSON.stringify(isListFlag);
		}
	};
	// process clicks on the change layout links
	var links = $('.view-changer-link');
	links.on('click', function(e){
		e.preventDefault();

		var link = $(this);

		if (link.data('view') == 'list') {
			categoryLayoutObj.displayList();
		}
		if (link.data('view') == 'block' && alreadyList) {
			categoryLayoutObj.displayBlock();
		}
	});
	if (links.length > 0) {
		categoryLayoutObj.init();
	}
	
	// check if list settings is on in local storage of users pc
	if (typeof localStorage.listFlag !== "undefined" && localStorage.listFlag !== "undefined") {
		isListFlag = JSON.parse(localStorage.listFlag);
	}
	// display list view if settings set on list by user (checking in local storage)
	if (isListFlag && $(window).width() > 1235) {
		categoryLayoutObj.displayList();
	}
});

$(function(){
	
	var sidebar = $('.sidebar-filter');
	var filterLink = $('.filter-link');
	var filterHeader = $('.filter-header');

	// раскрытие дополнительных элементов в фильтре
	$('.additional-filters').on('click', function(e) {
		var toggler;
		if (e.target.parentNode.nodeName === 'SPAN') {
			toggler = $(e.target.parentNode);
		} else if (e.target.nodeName === 'SPAN') {
			toggler = $(e.target);
		}

		if (toggler !== undefined) {
			toggler.toggleClass('additional-filter__toggler--opened');
			toggler.next().slideToggle();
		}
		
	});

	// close sidebar filter by clicking on empty space
	$(document).mouseup(function (e)
	{ if ($(document).width() <= 994){
	        if (!sidebar.is(e.target) // if the target of the click isn't the container...
	            && sidebar.has(e.target).length === 0 // ... nor a descendant of the container
	            && !filterLink.is(e.target))
	        {
	            sidebar.hide();
	            filterLink.removeClass('filter-link-active');
	        }
	    }
	});
	// open sidebar filter by clicking on mobile filter link (подбор)
	filterLink.click(function() {
		var offset = filterLink.position();
		var sidebarOffset = sidebar.offset();
	    sidebar.css('width', $(this).outerWidth() + 'px');
	    sidebar.css('top', (offset.top) + filterLink.outerHeight()  + 'px' );
	    sidebar.css('left', (offset.left)  + 'px' );
	    sidebar.toggle();
	    $(this).toggleClass('filter-link-active');
	});

	// ======================== filter popup ==================
	var filterPopup = $('.filter-popup');
	var filterPopupCloseLink = $('.filter-popup-close-link');

	filterPopupCloseLink.on('click', function (e) {
		e.preventDefault();

		filterPopup.fadeOut();
	});

});