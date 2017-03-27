$(function() {

	$('.mobile-custom-select').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		$(this).toggleClass('active');
		$(this).next().toggle();
	});



	var tabs = new Tabs($('.top-brands-content__item'), $('.top-brands-menu__item'));
	tabs.init();

	function Tabs($tabs, $tabLinks) {
		var tabs = this;
		tabs.elements = $tabs;
		tabs.links = $tabLinks;

		tabs.init = function () {
			$tabLinks.on('click', showTargetTab);
			$tabLinks.on('keypress', tabElemsKeypressHandler);
		}

		function showTargetTab (e) {
			e.preventDefault();
			var link = $(this);
			var tabId = this.dataset.targetId;
			var tab = $('#' + tabId);
			var focus = tab.find('.focuspoint');

			tabs.links.removeClass('active');
			link.addClass('active');
			tabs.elements.removeClass('active');
			tab.addClass('active');
			if (focus.length > 0) {
				focus.focusPoint();
			}

			if ($(window).width() < 768) {
				var linksContainer = tabs.links.parent()
				mobileSelect = linksContainer.prev();
				linksContainer.hide();
				mobileSelect.removeClass('active');
				mobileSelect.text($(this).text());
			}
		}
	}



	var popularProductsSlider = $("#owl-popular-products");
	var viewedProductsSlider = $("#owl-viewed-products");
	var newProductsSlider = $("#owl-new-products");
	viewedProductsSlider.owlCarousel({
		loop: false,
		margin:0,
		navigationtext: false,
		
		// responsiveclass:true,
		pagination: false,
		nav: true,
		dots: false,
		scrollbar: true,

		responsive:{
			0:{
				items:1,
			},
			544:{
				items:2,
			},
			768:{
				items:3,
			},
			1200:{
				items:3,
			}
		}
	});
});