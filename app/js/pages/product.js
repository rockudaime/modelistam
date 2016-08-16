$(document).ready(function() {
	// работа
	var wWidth = $(window).width();
	var mainImage = $('.product-card__main-image img');
	var smallImages = $('.gallery-product__item');

	smallImages.on('click', function(e) {
		mainImage.attr('src', $(this).children().attr('src'));
		smallImages.removeClass('gallery-product__item--active');
		$(this).addClass('gallery-product__item--active');	
	});



	// Выбор цвета
	var colorsBlock = $('.product-colors');
	var choosenColor = $('.color-product-info__choosed-color span');
	// Обработка выпадающего меню с опцией выбора цвета
	$('.color-product-info__choosed-color').on('click', function(e) {
		e.preventDefault();
		colorsBlock.toggle();
	});
	// Отрисовка выбранного цвета в блоке для выбранного цвета
	// colorsBlock.on('click', function(e){
	// 	e.preventDefault();
	// 	var span;
	// 	console.log(e.target);
	// 	if (e.target.nodeName == 'SPAN'){
	// 		span = $(e.target);
	// 	} else {
	// 		span = $($(e.target).children()[0]);
	// 	}

	// 	var color = span.css('background-color');
	// 	console.log(color);
	// 	if (color != 'rgba(0, 0, 0, 0)') {
	// 		choosenColor.css('background-color', color);
	// 		// colorsBlock.fadeOut();
	// 	}
		
		

	// });
	console.log($('input:radio[name=productColors]'));
	$('.product-colors__radio').change(function(){
		var color;
		if ($(this).prop('checked', true)){
			color = $(this).parent().find('.color-product-info__color-label').css('background-color');
			choosenColor.css('background-color', color);
			colorsBlock.fadeOut();
		}
	});
	// end of choose color 

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
	

	// Меню для навигации по табам (в мобильном виде - аккордеон)
	$('.menu-details').on('click', function(e){
		e.preventDefault();
		var link = e.target;
		if (link.nodeName === 'A'){
			var tabId = link.dataset.id;
			var tabs = $('.item-detail');
			var links = $('.menu-details__link');
			var tab = $('#' + tabId);

			if (tabId && !tab.hasClass('item-detail--active')){
				tabs.removeClass('item-detail--active');
				links.removeClass('menu-details__link--active');
				$(link).addClass('menu-details__link--active');
				tab.addClass('item-detail--active');
			}
		}
		
	});
	// Аккордеон для мобильного вида (все что меньше 768 пикселей в ширину)
	if(wWidth<= 768) {
		$('.item-detail__mobile-menu-item').on('click', function(e) {
			var tabs = $('.item-detail');
			var link = $(this);
			var links = $('.item-detail__mobile-menu-item');
			var tab = link.next();
			e.preventDefault();
			if (!tab.hasClass('item-detail--active')){ // если таб не активный, закрыть все остальные и открыть таб
				tabs.removeClass('item-detail--active');
				links.removeClass('mobile-menu-item--active');
				tab.addClass('item-detail--active');
				link.addClass('mobile-menu-item--active');
			} else { // если клик по уже активному табу, то просто закрыть его
				tab.removeClass('item-detail--active');
				link.removeClass('mobile-menu-item--active');
			}
			
		})
	}

	// video elements on page
	function videoInit(){
		var videos = $('.video-tab');
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

	videoInit();
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


	
});