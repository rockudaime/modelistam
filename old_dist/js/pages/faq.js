$(function () {
	$('.question__heading span').click(function () {
		var heading = $(this).parent();
		var questionsCategoryBlock = heading.closest('.questions-category');
		var answerBlock = $('.question__answer');
		var visible = heading.next().is(":visible");

		answerBlock.slideUp();
		if (!visible) {
			heading.next().slideDown();
		}



	});
	$('.question__heading').on('keypress', function (e) {
		var code = e.which;
		// 13 = Return, 32 = Space
		if ((code === 13) || (code === 32)) {
			$(this).find('span').click();
		}
	});
	$('.mobile-custom-select').on('click', function (e) {
		e.preventDefault();
		var self = $(this);
		$(this).toggleClass('active');
		$(this).next().toggle();
	});

	var tabs = new Tabs($('.questions-category'), $('.mobile-custom-select__options-menu>li'));
	tabs.init();
});