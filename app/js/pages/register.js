$(function() {
	var toggleLink = $('.signup-form__toggle-link');
	var signupForm = $('.signup-form');

	signupForm.on('submit', function(event) {
		var form = this;
		var name = this.name;
		var tel = this.tel;
		var errorElem = document.createElement('p');
		var valid = true;
		var itm;
		errorElem.classList.add('error-message', 'signup-form__error-message');

		$('.error-message').remove();
		$('.error').removeClass('error');

		if (!tel.value) {
			itm = errorElem.cloneNode(true);
			itm.innerText = 'Телефон - обязательное поле';
			tel.parentNode.insertBefore(itm, tel);
			tel.classList.add('error');
			valid = false;
		}

		if (!name.value) {
			itm = errorElem.cloneNode(true);
			itm.innerText = 'Имя - обязательное поле';
			name.parentNode.insertBefore(itm, name);
			name.classList.add('error');
			valid = false;
		}

		var pass1 = document.getElementById("passwordl");
	    var pass2 = document.getElementById("password2");
	    if (!pass1.value || pass1.value !== pass2.value) {
	    	itm = errorElem.cloneNode(true);
			itm.innerText = 'Проверьте совпадют ли пароли';
			pass1.parentNode.insertBefore(itm, pass1);
			pass1.classList.add('error');
			pass2.classList.add('error');
			valid = false;
	    }

		return valid;
	});

	toggleLink.on('click', toggleLinkClickHandler);
});

function toggleLinkClickHandler (event)
{
	event.preventDefault();

	var toggleLink = $(this);
	var contentBlock = $('#' + toggleLink.data('target-id'));
	contentBlock.slideToggle();
	toggleLink.toggleClass('active');
}

