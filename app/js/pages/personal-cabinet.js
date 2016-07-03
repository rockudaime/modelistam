$(document).ready(function(){
	var navLink = $(".cab-nav-moblie-link");
	var asideNav = $(".cabinet-nav");

	navLink.on("click", function(e) {
		e.preventDefault();
		asideNav.slideToggle();
	});
});