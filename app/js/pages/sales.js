$(function() {
	var wWidth = $(window).width();
	// Подключение таймера
	$('[data-countdown]').each(function() {
      var $this = $(this), finalDate = $(this).data('countdown');

      if (wWidth < 1235) {
        $this.countdown(finalDate, function(event) {
          $this.html(event.strftime('%-D %!D:день, дня, дней; %H:%M'));
        });
      } else {
        $this.countdown(finalDate, function(event) {
          $this.html(event.strftime('<div class="countdown-item"><span class="countdown-time">%-D</span> <span class="countdown-label">%!D:день, дня, дней;</span></div>' +
          							'<div class="countdown-item"><span class="countdown-time">%H</span> <span class="countdown-label">%!H:час, часа, часов;</span></div> '+ 
          							'<div class="countdown-item"><span class="countdown-time">%M</span> <span class="countdown-label">%!M:минута, минуты, минут;</span></div>'));
        });
      }
      
    });
});