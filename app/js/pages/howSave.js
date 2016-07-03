$(document).ready(function() {
	var accordionHeading = $(".e-heading");
	var accordionText = $(".e-accordion__text-item");

	accordionHeading.on("click", function(e) {
		e.preventDefault();
		if ($(this).next(".e-accordion__text-item").css("display") == "block") {
			$(this).next(".e-accordion__text-item").hide();
			
		} else {
			accordionText.hide();
			$(this).next(".e-accordion__text-item").show();
		}
	});
});