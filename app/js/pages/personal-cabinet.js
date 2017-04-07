$(document).ready(function(){
  var wWidth = $(window).width();
  var navLink = $(".cabinet-menu__custom-select");
  var asideNav = $(".cabinet-menu");
  var menuBlock = $('cabinet-menu-block');

  navLink.on("click", function(e) {
    e.preventDefault();
    navLink.toggleClass('active');
    asideNav.toggle();
  });
  if (wWidth < 1235){
    $(document).mouseup(function (e) { 
        if (!menuBlock.is(e.target) // if the target of the click isn't the container...
          && menuBlock.has(e.target).length === 0
          && !navLink.is(e.target)) // ... nor a descendant of the container
        {
          asideNav.hide();
          navLink.removeClass('active');
        }
    });
  }



  // profile page

  if($('*').is('.profile-form')) { // проверка существования формы на странице
    var addPhoneLink = $('#addPhoneField');

    // Добавление нового поля при нажатии на кнопку "добавить еще телефон"
    addPhoneLink.on('click', function(e) {
      var phoneField = $('#phoneBlock input:first-child');
      var idNumber = $('.profile-field-group--phone').length + 1;
      var newId = 'phoneNumber' + idNumber;
      var newPhoneBlock = document.createElement('div');

      var deletePhoneLink = document.createElement('a');
        deletePhoneLink.href = "#";
        deletePhoneLink.innerHTML = "<span>удалить</span>";
        deletePhoneLink.className = "cabinet-link profile-form-add-phone profile-form-delete-phone";

      newPhoneBlock.className = "profile-field-group profile-field-group--phone";
      newPhoneBlock.id = "phoneBlock" + idNumber;
      newPhoneBlock.innerHTML = '<input class="profile-form__input-field profile-form__input-field--phone"'
            +' type="tel" name="tel" placeholder="Ваш телефон" id="' 
            + newId
            +'">';
      newPhoneBlock.appendChild(deletePhoneLink);
      $(newPhoneBlock).insertAfter($('#phoneBlock' + (idNumber - 1)));

      // удаление блока с полем для телефона при нажатии кнопки "удалить"
      deletePhoneLink.addEventListener('click', removeParentHandler, false);
      
      return false; 
    });

    function removeParentHandler (e) {
      e.preventDefault();
      this.removeEventListener('click', removeParentHandler)
      $(this).parent().remove();

      return false;
    }
    
  }

  // how-save page
  if($('*').is('.cabinet-how-save') || $('*').is('.cabinet-my-orders')) {
    var accordion = (new function (window, document) {
      this.block = document.querySelector('.j-accordion');
      this.openTitle = $(this.block.getElementsByClassName('j-accordion-title'));
      this.content = $(this.block.getElementsByClassName('j-accordion-content'));
      var accordion = this;
      this.init = function () {
        var titles = accordion.openTitle;
        var contents = accordion.content;

        titles.on('click', clickHandler);
        titles.on('keydown', tabElemsKeypressHandler)

        function clickHandler (e) {
          // e.preventDefault;

          var title = $(this);
          var contentBlock = title.next();

          if (title.hasClass('active')) {
            title.removeClass('active');
            contentBlock.addClass('collapsed');
          } else {
            titles.removeClass('active');
            contents.addClass('collapsed');

            title.addClass('active');
            contentBlock.removeClass('collapsed');
          }
          $('html, body').animate({
              scrollTop: (contentBlock.offset().top - title.outerHeight() + 1)
          }, 500);
        }

      }

      return this;
    }(window, document));

    accordion.init();

    $('[data-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');

      if (wWidth < 1235) {
        $this.countdown(finalDate, function(event) {
          $this.html(event.strftime('%-D %!D:день, дня, дней; %H:%M'));
        });
      } else {
        $this.countdown(finalDate, function(event) {
          $this.html(event.strftime('%-D %!D:день, дня, дней; %H %!H:час, часа, часов; %M %!M:минута, минуты, минут;'));
        });
      }
      
    });

  }


  // my orders page
  if($('*').is('.cabinet-my-orders')) {
    var orderedGoodsText = document.querySelectorAll('.ordered-good__text a');
    if (wWidth < 768) {
      for (var i=0; i < orderedGoodsText.length; i++) {
        MYFUNCS.ellipsis(orderedGoodsText[i], 52);
      }
      
    }

    $(function() {
      var ratingBlock = $('.review-star-rating');
      ratingBlock.children().on('mouseover', function(){
        'use strict';
        var current = $(this);
        var ratingBlock = current.parent();
        ratingBlock.children().removeClass('star-rating-hover');
        $(this).addClass('star-rating-hover');
        while (current.prev().length > 0) {
          current.prev().addClass('star-rating-hover');
          current = current.prev();
        }
      });

      ratingBlock.on('mouseleave', function() {

        $(this).children().removeClass('star-rating-hover');
      });

      ratingBlock.children().on('click', function () {
        'use strict';

        var current = $(this);
        var ratingBlock = current.parent();
        ratingBlock.children().removeClass('star-rating-on');

        

        $(this).addClass('star-rating-on');
        while (current.prev().length > 0) {
          current.prev().addClass('star-rating-on');
          current = current.prev();
        }
        var rate = ratingBlock.children('.star-rating-on').length;
        var rateInput = ratingBlock.parent().find('.personal-review-form__rate');
        rateInput.attr('value',rate);
        return false;
      });

    }); // end of ratingBlock function

    // отправка формы

    $(".personal-review__form").submit(function(e) {
      if (!this.rate.value || !this.review.value || !this.usePeriod.value) {
        console.log('please, fill the form!');
        return false;
      };
      
    });

  }

});

$(function() {
  var sliders = $('.owl-compared-products');

  if (sliders.length > 0) {
    sliders.owlCarousel({
      loop: false,
      margin:0,
      navigationtext: false,
      pagination: false,
      nav: true,
      dots: false,
      scrollbar: true,

      responsive:{
        0:{
          items: 2,
        },
        544:{
          items: 2,
        },
        768:{
          items: 3,
        },
        1200:{
          items: 2,
        }
      }
    });
  }
});