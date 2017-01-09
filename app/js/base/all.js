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
		this.menuBlock = $('.main-nav');
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
			var myMouseEnterTimer;
			var myMouseEnterTimer2;
			var myMouseLeaveTimer;
			// раскрытие подменю при клике на меню
			if (menu.isMobile || menu.isTablet) {
				menu.submenuOpenBtn.on('click', mobileMenuHandler);

				menu.headerBtn.on('click', function(e) {
					e.preventDefault();
					menu.headerBtn.toggleClass('active');
					menu.menuContainer.toggle();
				});
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

			// Desctop menu 
			if (menu.isDesctop) {
				$('.breadcrumbs-menu-btn').on('click', function (e) {
					e.preventDefault();
					$(this).toggleClass('active');
					menu.menuContainer.toggle();
				})
				menu.navLink.on('mouseenter', desctopMenuHandler);
				menu.menuItem.on('mouseleave', function (e) {
					clearTimeout(myMouseEnterTimer);
					clearTimeout(myMouseEnterTimer2);
					var self = $(this);
					myMouseLeaveTimer = setTimeout(function() {
						self.find('.main-nav-link').removeClass('active');
						console.log(self);
						console.log('leave timeout fired!');
					}, 100);
				});
				$('.main-nav-submenu__item').on('mouseleave', function (e) {
					clearTimeout(myMouseEnterTimer);
					clearTimeout(myMouseEnterTimer2);
					// $(this).find('.main-nav-link').removeClass('active');
				});
				menu.navLink.on('mouseleave', function (e) {
					clearTimeout(myMouseEnterTimer);
					clearTimeout(myMouseEnterTimer2);
					// $(this).removeClass('active');
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

			function desctopMenuHandler(e) {
				clearTimeout(myMouseLeaveTimer);
				e.preventDefault();
				var link = $(this); //$($(this).children()[0]);
				var links = link.parent().parent().find('.main-nav-link');
				myMouseEnterTimer2 = setTimeout(function () {
					links.removeClass('active');
				}, 100);
				
				myMouseEnterTimer = setTimeout(function() {					
					link.addClass('active');
				}, 300);
			}

			$(document).mouseup(function (e) { 
				if ($(window).width() < 1235 || !menu.menuBlock.hasClass('main-nav-home')){
					if (!menu.menuBlock.is(e.target) // if the target of the click isn't the container...
						&& menu.menuBlock.has(e.target).length === 0
						&& !menu.headerBtn.is(e.target)) // ... nor a descendant of the container
					{
						menu.menuBlock.hide();
						menu.headerBtn.removeClass('active');
					}
				}
			});
			
		}
	}(window, document));

	mainNav.init(); // инициализация всех обработчиков событий для меню

	// поиск в меню
	$('.mobile-search-link').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		self.toggleClass('active');
		$('.header-search').slideToggle();
	});
});


// header popups

$(function() {
	var headerPopupTimeout;
	var isFocus = false;
	$('.header-personal__item').on('mouseover', function() {
		clearTimeout(headerPopupTimeout);
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
	$('.header-popup').on('mouseenter', function (e) {
		clearTimeout(headerPopupTimeout);
	});
	$('.header-popup').on('mouseleave', function (e) {
		$(this).removeClass('active');
	});
	$('.header-personal__item').on('mouseleave', function() {
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

	// profile page
	var profilePopupCloseLink = $('.popup-b-close');
	profilePopupCloseLink.on('click', closePopupHandler);


});

// ========================= Owl custom scrollbar ==================

function addCustomScrollbar (owlContainer) {
	'use strict';
	var owlSlider = $(owlContainer);
	var sliderItemWidth = owlSlider.find('.owl-item').width();
	var owlNavNext = owlSlider.find('.owl-next');
	var owlNavPrev = owlSlider.find('.owl-prev');
	var scrollbar;
	addScrollbar(owlSlider);
	setScrollbarWidth (scrollbar, owlSlider);
	
	owlNavNext.on('click', function (e) {
		setScrollbarOffset(scrollbar, owlSlider, sliderItemWidth);
	});
	owlNavPrev.on('click', function (e) {
		setScrollbarOffset(scrollbar, owlSlider, -sliderItemWidth);
	});



	function addScrollbar($obj) {
		var newDiv = document.createElement('div');
		newDiv.classList.add("owl-custom-scrollbar-wrapper");
		newDiv.innerHTML = "<div class='owl-custom-scrollbar' draggable></div>";

		scrollbar = $(newDiv).find('.owl-custom-scrollbar');
		$obj.append(newDiv);
	}

	function setScrollbarWidth (scrollbar, owlContainer) {
		var scrollbarWidth = 100 / (owlContainer.find('.owl-stage').width()/owlContainer.width());
		scrollbar.css('width', scrollbarWidth + '%');
	}

	function setScrollbarOffset (scrollbar, owlContainer, offset) {
		var stage = owlContainer.find('.owl-stage');
	    var matrix = stage.css('transform').replace(/[^0-9\-.,]/g, '').split(',');
		var x = matrix[12] || matrix[4];// предыдущий сдвиг
		var newOffset = x - offset;
		var stageWidth = stage.width(); // полная ширина контейнера с блоками товаров
		if (-newOffset >= stageWidth) {
			newOffset = x;
		} else if (-newOffset <= 0) {
			newOffset = 0;
		}
		var scrollbarOffset = 100 / (stageWidth / newOffset);

		scrollbar.css('margin-left', - scrollbarOffset + '%');
	}
}

// ================================= FOOTER =============================

// переключение между адресами в футере сайта
$(function () {
	if ($('*').is('.prefooter')) {
		var storesInfo = $('.store');

		$('.store-address-tabs-menu__item').on('click', function(e) {
			e.preventDefault();
			var self = $(this);
			$('.store-address-tabs-menu__item').removeClass('active');
			storesInfo.removeClass('store--active');
			self.addClass('active');
			$(self.data("id")).addClass('store--active');

			if ($(window).width() < 768) {
				mobileSelect = self.parent().prev();
				self.parent().hide();
				mobileSelect.removeClass('active');
				mobileSelect.html($(this).html());
			}
		});

		$('.store-gallery__miniatures').on('click', function(e) {
			e.preventDefault();
			if (e.target.nodeName === "IMG") {
				$('.store-gallery__main-image img').attr("src", $(e.target).parent().attr("href"));
				$(this).find('.store-gallery__miniature--active').removeClass('store-gallery__miniature--active');
				$(e.target).parent().parent().addClass('store-gallery__miniature--active');
			}
		});
	}
	var footerGallery = document.querySelectorAll('.store-gallery__miniatures-inner');
	for (var i = 0; i < footerGallery.length; i++) {
		dragElement(footerGallery[i]);
	}

	$('.store-gallery__main-image').on('click', function(e) {
		e.preventDefault();
	})
	
	// function dragBlock($blockObj) {
	// 	'use strict';
	// 	var blockWidth = $blockObj.width();
	// 	var parent = $blockObj.parent();
	// 	var parentWidth = parent.width();
	// 	var offset = blockWidth - parentWidth;
	// 	var minOffset = 0, maxOffset = blockWidth;
	// 	var currentPosition = 0;
	// 	var cursorPosition;
	// 	console.log($blockObj);


	// 		$blockObj.on('touchstart', function(e) {
	// 			e.preventDefault();
	// 			currentPosition = $(this).position().left;
	// 			cursorPosition = e.pageX;
	// 			console.log('touched');
	// 		});
	// 		$blockObj.on('touchmove', function(e) {
	// 			e.preventDefault();
	// 			console.log(e);
	// 			currentPosition += e.pageX - cursorPosition;
	// 			console.log(currentPosition);
	// 			console.log('moving');
	// 			$(this).css('transform', 'translate3d(-' + currentPosition + ',0,0)')
	// 		});

	// }	
});
	
function dragElement(obj) {
	'use strict';
	var wWidth, startPoint, elPosition = 0, moveVal, rightBorder;

	obj.addEventListener('touchstart', handleStart, false);
	obj.addEventListener('touchmove', handleMove, false);
	obj.addEventListener('touchend', handleEnd, false);



	function handleStart(e) {

		wWidth = window.innerWidth;
		startPoint = e.touches[0].pageX;
		var offset = this.offsetLeft;
		var chstart, chend;
		var childs = this.children;
		rightBorder =  childs[childs.length - 1].offsetLeft - this.offsetLeft;
		console.log(rightBorder);
		this.style.transition = 'none';
	}

	function handleMove(e) {			
		moveVal =  e.touches[0].pageX - startPoint;
		console.log('-(elPosition + moveVal) = ' + -(elPosition + moveVal));
		console.log('rightBorder = ' + rightBorder);
		if (elPosition + moveVal < 0 && -(elPosition + moveVal) < rightBorder) {
			this.style.transform = 'translate3d(' + (elPosition + moveVal) +'px, 0, 0)';
		} else if (-(elPosition + moveVal) > rightBorder ){
			this.style.transform = 'translate3d(' + -rightBorder +'px, 0, 0)';
			elPosition = -rightBorder;
		} else {
			this.style.transform = 'translate3d(' + 0 +'px, 0, 0)';
			elPosition = 0;
		}
	}


	function handleEnd(e) {
		if (moveVal !== undefined && typeof moveVal === 'number') {
			elPosition += moveVal;
			moveVal = 0;
		}
	}

	function handleClick(e) {
		e.preventDefault();

		var optionName = this.dataset.targetOption;
		var headerOption = document.querySelector('[data-option="' + optionName + '"]');
		if (e.target.classList.contains('filter-option--start')) {
			headerOption.innerHTML = headerOption.dataset.value;
			headerOption.classList.remove('filter-option--selected');
		} else {
			headerOption.innerHTML = e.target.innerHTML;
			headerOption.classList.add('filter-option--selected');
		}


		myRemoveClass(this.children, 'filter-option--selected');
		e.target.classList.add('filter-option--selected');

		this.style.transition = 'transform .25s ease';
		this.style.transform = 'translate3d(' + -(e.target.offsetLeft - this.offsetLeft) +'px, 0, 0)';
		elPosition = -(e.target.offsetLeft - this.offsetLeft);
	}
}

function tabElemsKeypressHandler(e) { // Trigger the click event from the keyboard
	var code = e.which;
	// 13 = Return, 32 = Space
	if ((code === 13) || (code === 32)) {
		$(this).click();
	}
}