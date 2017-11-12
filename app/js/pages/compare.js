$(function() {
  'use strict';

  $('.mobile-custom-select').on('click', function(e) {
    e.preventDefault();
    var self = $(this);
    $(this).toggleClass('active');
    $(this).next().toggle();
  });

  $('.compare-characteristics__heading').on('click', function(e) {
    e.preventDefault();
    $(this).toggleClass('up');
    $(this).next().slideToggle();
  });

  $('.compare-menu__item').on('click', function(e) {
    e.preventDefault();

    var targetClass = $(this).data('target-class'),
      menuItem = $(this),
      itemsTab = $('.compare-item'),
      characteristicsTab = $('.compare-characheristics-tab');

      itemsTab.filter('[data-class="' + targetClass +  '"]')
              .add(menuItem)
              .add(characteristicsTab.filter('[data-class="' + targetClass +  '"]'))
              .addClass('active')
              .siblings()
              .removeClass('active');
      if ($(window).width() < 1235) {
        $('.compare-menu').hide();
         $('.mobile-custom-select').removeClass('active');
      }
  });

  var viewedProductsSlider = $(".owl-compared-products");
  viewedProductsSlider.owlCarousel({
    loop: false,
    margin:0,
    navigationtext: false,
    pagination: false,
    nav: true,
    dots: false,
    scrollbar: true,

    responsive:{
      0:{
        items:2,
      },
      544:{
        items:2,
      },
      768:{
        items:3,
      },
      1200:{
        items:4,
      }
    }
  });

  var comparedProductsCharacteristics = $('.compare-table__characteristics-slider');

  comparedProductsCharacteristics.owlCarousel({
    loop: false,
    margin:0,
    navigationtext: false,
    
    pagination: false,
    nav: false,
    dots: false,
    scrollbar: false,
    touchDrag: false,
    mouseDrag: false,

    responsive:{
      0:{
        items:2,
      },
      544:{
        items:2,
      },
      768:{
        items:3,
      },
      1200:{
        items:4,
      }
    }
  });

  viewedProductsSlider.each(function() {
    var targetClass = $(this).parent().data('class');
    var characteristicsTab = $('.compare-characheristics-tab[data-class="' + targetClass +  '"]');
    var characteristicsSlider = characteristicsTab.find('.compare-table__characteristics-slider');


    syncTwoSliders($(this), characteristicsSlider);
  });

  function syncTwoSliders($slider, $sliderToSync) {
    $slider.on('change.owl.carousel', function(event) {
      if (event.namespace && event.property.name === 'position') {
      var target = event.relatedTarget.relative(event.property.value, true);
      $sliderToSync.owlCarousel('to', target, 300, true);
      }
    });
  }

  //  Стили для обработки всплывающего окна очистки списка
	//  при нажатии на кнопку удалить все. 
		$(".compare__header-link--delete").on("click", function (e) {
			e.preventDefault();
			var ppBlock = $(this).parent().find('.popup-back');
			ppBlock.show();
			ppBlock.parent().addClass("in-tr-background");
		});
});

