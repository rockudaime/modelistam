$(function() {
	$('.focuspoint').focusPoint();

	$('.mobile-custom-select').on('click', function(e) {
		e.preventDefault();
		var self = $(this);
		$(this).toggleClass('active');
		$(this).next().toggle();
	});



	var tabs = new Tabs($('.tab'), $('.tab-link'));
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

			tabs.links.removeClass('active');
			link.addClass('active');
			tabs.elements.removeClass('active');
			tab.addClass('active');

			tab.find('.focuspoint').focusPoint();

			if ($(window).width() < 768) {
				var linksContainer = tabs.links.parent()
				mobileSelect = linksContainer.prev();
				linksContainer.hide();
				mobileSelect.removeClass('active');
				mobileSelect.text($(this).text());
			}
		}
	}
});

$(document).ready(function() {
    $('img[src$=".svg"]').each(function() {
        var $img = jQuery(this);
        var imgURL = $img.attr('src');
        var attributes = $img.prop("attributes");

        $.get(imgURL, function(data) {
            // Get the SVG tag, ignore the rest
            var $svg = jQuery(data).find('svg');

            // Remove any invalid XML tags
            $svg = $svg.removeAttr('xmlns:a');

            // Loop through IMG attributes and apply on SVG
            $.each(attributes, function() {
                $svg.attr(this.name, this.value);
            });

            // Replace IMG with SVG
            $img.replaceWith($svg);
        }, 'xml');
    });
});