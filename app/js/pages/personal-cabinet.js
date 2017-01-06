$(document).ready(function(){
	var navLink = $(".cabinet-menu__custom-select");
	var asideNav = $(".cabinet-menu");
	var menuBlock = $('cabinet-menu-block');

	navLink.on("click", function(e) {
		e.preventDefault();
		navLink.toggleClass('active');
		asideNav.toggle();
	});

	$(document).mouseup(function (e) { 
		if ($(window).width() < 1235){
			if (!menuBlock.is(e.target) // if the target of the click isn't the container...
				&& menuBlock.has(e.target).length === 0
				&& !navLink.is(e.target)) // ... nor a descendant of the container
			{
				asideNav.hide();
				navLink.removeClass('active');
			}
		}
	});



	// profile page

	if($('*').is('.profile-form')) { // проверка существования формы на странице
		console.log('This is profile page');
		var addPhoneLink = $('#addPhoneField');

		addPhoneLink.on('click', function(e) {
			var phoneField = $('#phoneBlock input:first-child');
			var idNumber = $('#phoneBlock input').length + 1;
			console.log(idNumber);
			var newId = 'phoneNumber' + idNumber;
			var newField = phoneField.clone();
			newField.attr({id: newId, value: ""}).insertBefore(addPhoneLink);
			
			return false;	
		});
		
		
		

		
	}

});


