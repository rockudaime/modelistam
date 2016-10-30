$(document).ready(function() {

	var owl = $("#owl-alike-products");
	
	owl.owlCarousel({
	    loop:true,
	    margin:10,
	    navigationText: false,
	    responsiveClass:true,
	    pagination: true,
	    responsive:{
	    	//- 0:{
	    	//- 	items:1,
	    	//- 	nav:true
	    	//- },
	        460:{
	            items:2,
	            nav: false
	        },
	        768:{
	            items:3,
	            nav:false,
	            paginatioin: true
	        },
	        994:{
	            items:4,
	            nav:true,
	            loop:false,
	            paginatioin: false

	        },
	        1200:{
	            items:5,
	            nav:true,
	            loop:false,
	            paginatioin: false
	        }
	    }
	});


});

window.onload = function(){
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth(); //January is 0!
	var yyyy = today.getFullYear();
	var age = document.getElementById("computed-age");
	var birthYear = document.getElementById("birthYear").value;
	var birthMonth = document.getElementById("birthMonth").value;
	var birthDay = document.getElementById("birthDay").value;

	document.getElementById("birthYear").onchange = function() {
		birthYear = document.getElementById("birthYear").value;
		if (mm > birthMonth) {
			age.innerHTML = (yyyy - birthYear) + " лет";
		} else if (mm == birthMonth) {
			if (dd >= birthDay) {
				age.innerHTML = (yyyy - birthYear) + " лет";
			} else {
				age.innerHTML = (yyyy - birthYear - 1) + " лет";
			}
		} else {
			age.innerHTML = (yyyy - birthYear - 1) + " лет";
		}
	};
	document.getElementById("birthMonth").onchange = function() {
		birthMonth = document.getElementById("birthMonth").value;
	};
	document.getElementById("birthDay").onchange = function() {
		birthDay = document.getElementById("birthDay").value;
	};
};