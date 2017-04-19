$(function() {
  'use strict';

  $('.mobile-custom-select').on('click', function(e) {
    e.preventDefault();
    var self = $(this);
    $(this).toggleClass('active');
    $(this).next().toggle();
  });

  $('.compare-menu__item').on('click', function(e) {
    e.preventDefault();

    var targetClass = $(this).data('target-class'),
      menuItem = $(this),
      itemsTab = $('.compared-category'),
      characteristicsTab = $('.compare-characheristics-tab');

      itemsTab.filter('[data-class="' + targetClass +  '"]')
              .add(menuItem)
              .add(characteristicsTab.filter('[data-class="' + targetClass +  '"]'))
              .addClass('active')
              .siblings()
              .removeClass('active');
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
    console.log($(this).parent().data('class'));
    var targetClass = $(this).parent().data('class');
    var characteristicsTab = $('.compare-characheristics-tab[data-class="' + targetClass +  '"]');
    var characteristicsSlider = characteristicsTab.find('.compare-table__characteristics-slider');


    syncTwoSliders($(this), characteristicsSlider);
  });

  // viewedProductsSlider.on('change.owl.carousel', function(event) {
  //   if (event.namespace && event.property.name === 'position') {
  //   var target = event.relatedTarget.relative(event.property.value, true);
  //   comparedProductsCharacteristics.owlCarousel('to', target, 300, true);
  //   }
  // });

  function syncTwoSliders($slider, $sliderToSync) {
    $slider.on('change.owl.carousel', function(event) {
      if (event.namespace && event.property.name === 'position') {
      var target = event.relatedTarget.relative(event.property.value, true);
      $sliderToSync.owlCarousel('to', target, 300, true);
      }
    });
  }
});

