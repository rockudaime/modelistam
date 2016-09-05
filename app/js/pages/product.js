$(document).ready(function() {
	var wWidth = $(window).width();
	

	// < ==============================================
	// Выбор цвета
	var colorsBlock = $('.product-colors');
	var choosenColor = $('.color-product-info__choosed-color span');
	// Обработка выпадающего меню с опцией выбора цвета
	$('.color-product-info__choosed-color').on('click', function(e) {
		e.preventDefault();
		colorsBlock.toggle();
	});


	$('.product-colors__radio').change(function(){
		var color;
		if ($(this).prop('checked', true)){
			color = $(this).parent().find('.color-product-info__color-label').css('background-color');
			choosenColor.css('background-color', color);
			colorsBlock.fadeOut();
		}
	});

	// ============================================= />

	// Просто анимация звездочек рейтинга
	var rating = 0; // в эту переменную записывается выбранный рейтинг числа от 1 до 5

	$('.rateit__range').on('mousemove', function(e){
		var parentOffset = $(this).offset(); 
	   	var relX = e.pageX - parentOffset.left;
		$('.rateit__hover').css('width', relX + 'px');
	});
	$('.rateit__range').on('click', function(e){
		var parentOffset = $(this).offset(); 
	   	var relX = e.pageX - parentOffset.left;
	   	rating = Math.abs(Math.ceil(relX / parseInt($(this).width()) * 5));
	   	$('.rateit__selected').css('width', rating * 17 + 'px');

	});
	$('.rateit__range').on('mouseleave', function(e){
		$('.rateit__hover').css('width', '0');
	});
	


    // *********************** ТАБЫ И НАВИГАЦИЯ *******************
		// Меню для навигации по табам в десктопном\планшетном виде
		// .menu-details - меню - ul список ссылок для навигации по табам
		// .menu-details__link - отдельный элемент меню

	var $root = $('html, body');
	var tabs = $('.item-detail'); // блоки с сожержимым табов

	$('.menu-details').on('click', function(e){
		e.preventDefault();
		var link = e.target;
		if (link.nodeName === 'A'){
			var tabs = $('.details-product__detail-item');
			var tabId = link.dataset.target;
			var links = $('.menu-details__link'); // Элемент меню
			var tab = $('#' + tabId);

			if (tabId === 'accessories') {
				$('.accessories').hide();
			} else {
				$('.accessories').show();
			}

			if (tabId && !tab.hasClass('item-detail--active')){
				tabs.removeClass('item-detail--active');
				links.removeClass('menu-details__link--active');
				$(link).addClass('menu-details__link--active');
				tab.addClass('item-detail--active');
			}
		}
		
	});

	// Аккордеон для мобильного вида (все что меньше 768 пикселей в ширину)

	$('.item-detail__mobile-menu-item').on('click', function(e) {
		e.preventDefault();
		var link = $(this);
		var links = $('.item-detail__mobile-menu-item');
		var tab = link.next();
		
		if (!tab.hasClass('item-detail--active')){ // если таб не активный, закрыть все остальные и открыть таб
			tabs.removeClass('item-detail--active');
			links.removeClass('mobile-menu-item--active');
			tab.addClass('item-detail--active');
			link.addClass('mobile-menu-item--active');
		} else { // если клик по уже активному табу, то просто закрыть его
			tab.removeClass('item-detail--active');
			link.removeClass('mobile-menu-item--active');
		}
		$root.animate({
		        scrollTop: tab.offset().top
		}, 500);
		
	});

	// accessories tabs
	var accessoriesTabs = $('.accessories__tabs').children('.item-detail');
	// accessoriesTabs.removeClass('item-detail--active');
	// $(accessoriesTabs[0]).addClass('item-detail--active');
	// console.log(accessoriesTabs[0]);
	var accessoriesTabTabsHandler = tabsHandler('.accessories-tab__menu', '.accessories-tabs__item');
	var accessoriesBlockTabsHandler = tabsHandler('.accessories__tabs-menu', '.accessories__item');
	$('.accessories__tabs-menu .tabs-menu').on('click', accessoriesBlockTabsHandler);
	$('.accessories-tab__menu .tabs-menu').on('click', accessoriesTabTabsHandler);


	function tabsHandler(tabsMenuContainerClass, tabsClass) {
		return function () {
			var tabLinks = $(tabsMenuContainerClass + ' .tabs-menu__item');
			var tabLink = $(event.target);
			var tab = $('#' + tabLink.data('tabid'));
			var accessoriesTabs = $(tabsClass);
			accessoriesTabs.hide();
			tab.show();
			tabLinks.removeClass('tabs-menu__item--active');
			tabLink.addClass('tabs-menu__item--active');
		}
	}


	// link to characteristics tab in about product tab
	$('#characteristicsLink').on('click', function() {
		var tabId = this.dataset.id;
		var tabs = $('.item-detail');
		var links = $('.menu-details__link');
		var tab = $('#' + tabId);

		$('.accessories').hide();
		tabs.removeClass('item-detail--active');
		links.removeClass('menu-details__link--active');
		$('.menu-details__link[data-target="characteristics"]').addClass('menu-details__link--active');
		tab.addClass('item-detail--active');
		$root.animate({
		        scrollTop: tab.offset().top
		}, 500);
	});
	/**
	*
	* Processing the layout of video elements on the page (if there is more than one video). 
	* Creates navigation links to navigate across the tabs. 
	*
	**/
	// video elements on page
	videoInit();
	function videoInit(){
		var videos = $('.video-tab');
		if (videos.length > 1){
			var videosBlock = $('.about-product__video');
			videosBlock.append('<ul class="tabs-control">');
			var ul = $('.tabs-control');
			ul.append('<li class="tabs-control__item"><a class="tabs-nav tabs-nav--active" href="#" data-nav="1">1</a></li>');
			for (var i = 2; i <= videos.length; i++) {
				ul.append('<li class="tabs-control__item"><a class="tabs-nav" href="#" data-nav="' + parseInt(i) + '">' + parseInt(i) + '</a></li>');
			}

			videos.addClass('video-tab--hidden');
			$(videos[0]).removeClass('video-tab--hidden');
		}
		// add event listener to process click on tabs
		$('.tabs-control').on('click', function(e){
			e.preventDefault();
			var link = $(e.target);
			var videos = $('.video-tab');
			if (link.data("nav")){
				var videoTab = $('.video-tab').filter('[data-order=' +link.data("nav") + ']');
				console.log(link.data("nav"));
				videos.addClass('video-tab--hidden');
				videoTab.removeClass('video-tab--hidden');
				$('.tabs-nav').removeClass('tabs-nav--active');
				link.addClass('tabs-nav--active');
			}
			
		});	
	}

	


	// Init the carousel sliders on the page
	var owl = $(".owl-carousel");

	owl.owlCarousel({
	    loop: false,
	    margin:0,
	    navigationText: false,
	    // responsiveClass:true,
	    pagination: true,
	    responsive:{
	    	 0:{
	    	 	items:1,
	    	 	nav:false
	    	 },
	        544:{
	            items:2,
	            nav: false
	        },
	        768:{
	            items:3,
	            nav:false,
	            paginatioin: true
	        },
	        994:{
	            items:4,
	            nav:true,
	            loop:false,
	            paginatioin: false

	        },
	        1200:{
	            items:5,
	            nav:true,
	            loop:false,
	            paginatioin: false
	        }
	    }
	});


	
});


// Images processing
$(document).ready(function() {
	var wWidth = $(window).width();
	var mainImage = $('.product-card__main-image img');
	var smallImages = $('.gallery-product__item');

	smallImages.on('click', function(e) {
		console.log(e.target);
		e.stopPropagation();
		e.preventDefault();
		var imgHref = $(this).children().attr('href');
		mainImage.parent().attr('href', imgHref);
		mainImage.attr('src', imgHref);
		smallImages.removeClass('gallery-product__item--active');
		smallImages.children().addClass('fancybox-thumbs');
		$(this).children().removeClass('fancybox-thumbs');
		$(this).addClass('gallery-product__item--active');
	});


	console.log($('.fancybox-thumbs'));
	$('.fancybox-thumbs').fancybox({
		prevEffect : 'none',
		nextEffect : 'none',

		closeBtn  : true,
		arrows    : true,
		nextClick : true,

		helpers : {
			thumbs : {
				width  : 50,
				height : 50
			}
		}
	});

});
