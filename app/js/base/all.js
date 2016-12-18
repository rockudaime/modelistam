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