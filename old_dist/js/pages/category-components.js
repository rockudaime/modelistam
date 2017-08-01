

$(document).ready(function(){

	var myTruncate = function(object_arr, len) {

		function ellipsis(obj, len) {
			var text = obj.innerHTML;
			if (text.length > len) {
				text = text.slice(0, len - 3) + '&hellip;'; 
				obj.innerHTML = text;
			}
		}
		
		for (var i = 0; i < object_arr.length; i++){
			ellipsis(object_arr[i], len);
		}
	};

	var debounce = function(func, wait, immediate) {
	    // Returns a function, that, as long as it continues to be invoked, will not
	    // be triggered. The function will be called after it stops being called for
	    // N milliseconds. If `immediate` is passed, trigger the function on the
	    // leading edge, instead of the trailing.
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};
	

	var wWidth = $(window).width();
	var accBtn= $('.components-category__heading');
	var accContent = $('.components-category__inner');

	var updateLayout = debounce(function(e){
		wWidth = $(window).width();
		if(wWidth < 544) {
			myTruncate(document.querySelectorAll('.component-item__name a'), 27);
		}

		if (wWidth > 768){
			accContent.css('display', 'block');
			accBtn.removeClass('components-category__heading--active');
		}
	}, 500);
	
	if(wWidth < 544) {
		myTruncate(document.querySelectorAll('.component-item__name a'), 27);
	}

	

	// клик на заголовок для раскрытия аккордеона

	if(accBtn){
		accBtn.on('click', function(e){
			if (wWidth < 768){
				e.preventDefault();
				if ($(this).next().css('display') === 'block'){
					$(this).next().slideUp('slow');
					$(this).removeClass('components-category__heading--active');
				} else {
					accContent.slideUp('slow');
					accBtn.removeClass('components-category__heading--active');
					$(this).next().slideDown('slow');
					$(this).addClass('components-category__heading--active');
				}
			}
		});
	}
	// Добавляем прослушку события ресайза
	window.addEventListener("resize", updateLayout, false);
});