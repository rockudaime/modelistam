$(function() {
	var wWidth = $(window).width();
  // мобильный селект, с выпадающим меню
  $('.mobile-custom-select').on('click', function(e) {
    e.preventDefault();
    var self = $(this);
    $(this).stop().toggleClass('active');
    $(this).next().stop().slideToggle('fast');
    
  })


	// Подключение таймера
	$('[data-countdown]').each(function() {
    var $this = $(this), finalDate = $(this).data('countdown');

    $this.countdown(finalDate, function(event) {
      $this.html(event.strftime(
        '<div class="countdown-item countdown-day"><span class="countdown-time countdown-time__day">%-D</span> <span class="countdown-label">%!D:день, дня, дней;</span></div>' +
				'<div class="countdown-item countdown-hour"><span class="countdown-time countdown-time__hour">%H</span><span class="countdown-label">%!H:час, часа, часов;</span></div> '+ 
				'<div class="countdown-item countdown-min"><span class="countdown-time countdown-time__min">:%M</span> <span class="countdown-label">%!M:мин, мин, мин;</span></div>'));
    });

      
  });

  var sidebar = $('.sidebar-filter');
  var filterLink = $('.filter-link');

  filterLink.click(function() {
    var offset = filterLink.position();
    var sidebarOffset = sidebar.offset();
    if(offset !== undefined) {
      var top = offset.top;
      var left = offset.left;
    }
    sidebar.css('width', $(this).outerWidth() + 'px');
    sidebar.css('top', top + filterLink.outerHeight()    + 'px' );
    sidebar.css('left', left + 'px');
    sidebar.toggle();
    $(this).toggleClass('active');
  });

  var filterPopup = $('.filter-popup');
  var filterPopupCloseLink = $('.filter-popup-close-link');

  filterPopupCloseLink.on('click', function (e) {
    e.preventDefault();

    filterPopup.fadeOut();
  });
  if (wWidth < 1235) {
    hideElementOnEmptyClick(sidebar, filterLink);
  }

});