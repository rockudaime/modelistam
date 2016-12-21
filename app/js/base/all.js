// main menu
$(function(){
	var mainNav = (new function (window, document) {
		this.isMobile = false;
		this.isTablet = false;
		this.isDesctop = false;
		var wWidth = $(window).width();
		if (wWidth < 768) {
			this.isMobile = true;
		} else if (wWidth < 1235) {
			this.isTablet = true;
		} else {
			this.isDesctop = true;
		}
		this.navLink = $('.main-nav-link');
		this.submenuOpenBtn = $('.main-nav-link__btn');
		this.menuItem = $('.main-nav__item');
		this.headerBtn = $('.header-menu-link'); // кнопка "меню" в шапке сайта (мобильный и планшетный вид)
		this.menuContainer = $('.main-nav'); // контейнер меню
		var menu = this;





		this.init = function () {

			// ракскрытие меню при клике на кнопку "меню" в шапке сайта (мобильный и планшетный вид)
			
			var submenuWrapper = document.getElementsByClassName('main-nav-submenu__wrapper');
			var bgImg, el;
			// раскрытие подменю при клике на меню
			if (menu.isMobile || menu.isTablet) {
				menu.submenuOpenBtn.on('click', mobileMenuHandler);

				menu.headerBtn.on('click', function(e) {
					e.preventDefault();
					menu.headerBtn.toggleClass('active');
					menu.menuContainer.toggle();
				});
			} else {
				menu.navLink.on('mouseenter', desctopMenuHandler);
				menu.menuItem.on('mouseleave', function (e) {
					$(this).find('.main-nav-link').removeClass('active');
				});
				// подключение фонового изображения
				for (var i = 0; i < submenuWrapper.length; i++) {
					el = submenuWrapper[i];
					bgImg = el.dataset.bg;
					if (bgImg) {
						el.style.backgroundImage = "url('" + bgImg + "')";
					}
				}
			}
			

			function mobileMenuHandler(e) {
				e.preventDefault();
				var parentLink = $(this).parent();
				if (parentLink.hasClass('active') && !parentLink.hasClass('main-nav-submenu__link')) {
					menu.navLink.removeClass('active');
				} else if (parentLink.hasClass('active') && parentLink.hasClass('main-nav-submenu__link')){
					$('.main-nav-submenu__link').removeClass('active');
				} else if (parentLink.hasClass('main-nav-submenu__link')){
					$('.main-nav-submenu__link').removeClass('active');
					parentLink.addClass('active');
				} else {
					menu.navLink.removeClass('active');
					parentLink.addClass('active');
				}
			}

			function desctopMenuHandler(e) {
				e.preventDefault();
				var parentLink = $(this); //$($(this).children()[0]);
				if (parentLink.hasClass('active') && !parentLink.hasClass('main-nav-submenu__link')) {
					menu.navLink.removeClass('active');
				} else if (parentLink.hasClass('active') && parentLink.hasClass('main-nav-submenu__link')){
					$('.main-nav-submenu__link').removeClass('active');
				} else if (parentLink.hasClass('main-nav-submenu__link')){
					$('.main-nav-submenu__link').removeClass('active');
					parentLink.addClass('active');
				} else {
					menu.navLink.removeClass('active');
					parentLink.addClass('active');
				}
			} 
		}
	}(window, document));

	mainNav.init(); // инициализация всех обработчиков событий для меню
});


// header popups

$(function() {
	var headerPopupTimeout;
	var isFocus = false;
	$('.header-personal__item').on('mouseover', function() {
		clearTimeout(headerPopupTimeout);;
		$('.header-popup').removeClass('active');
		$('#' + $(this).data("id")).addClass('active');
		
	});
	$('.header-personal__item').on('click', function(e) {
		e.preventDefault();
		clearTimeout(headerPopupTimeout);
		$('.header-popup').removeClass('active');
		$('#' + $(this).data("id")).addClass('active');
		isFocus = true;
	});

	$('.header-personal__item').on('mouseout', function() {
		if (!isFocus) {
				headerPopupTimeout = setTimeout(function() {
				$('.header-popup').removeClass('active');
			}, 300);
		}
	})
	$('.header-personal__item').on('blur', function(e) {
		e.preventDefault();
		headerPopupTimeout = setTimeout(function() {
			$('.header-popup').removeClass('active');
		}, 300);
		isFocus = false;

	})
});

// ========================= Popups new ==================
$(function () {
	var mypopup = {
		closeLink: $('.popup-b__close'),
		backLink: $('.popup-b__back'),
		wrapper: $('.popup-outer')
	};

	mypopup.closeLink.on('click', closePopupHandler);
	mypopup.backLink.on('click', closePopupHandler);
	mypopup.wrapper.on('click', function(e) {
		e.stopPropagation();
		if ($(e.target).hasClass('popup-outer')) {
			mypopup.wrapper.children().fadeOut();
			mypopup.wrapper.fadeOut();
		}
	});

	function closePopupHandler (e) {
		e.preventDefault();
		mypopup.wrapper.children().fadeOut();
		mypopup.wrapper.fadeOut();
	}
	// $('.popup-bcart__content').customScrollbar();
	$('.popup-open-link').on('click', function(e) {
		e.preventDefault();
		var targetId = this.dataset.popupTarget;
		var popup = $('#' + targetId);

		popup.show();
		popup.parent().fadeIn();
	});

});