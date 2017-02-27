$(function() {
	var toggleLink = $('.signup-form__toggle-link');
	var signupForm = $('.signup-form');

	signupForm.on('submit', function(event) {
		checkPasswords();
	});
	toggleLink.on('click', toggleLinkClickHandler);
});

function toggleLinkClickHandler (event)
{
	event.preventDefault();
	console.log('clicked')

	var toggleLink = $(this);
	var contentBlock = $('#' + toggleLink.data('target-id'));
	contentBlock.slideToggle();
	toggleLink.toggleClass('active');
}

function checkPasswords()
{
    var passl = document.getElementById("passwordl");
    var pass2 = document.getElementById("password2");
    var isMatch = passl.value === pass2.value;
    console.log(isMatch);
    if(!isMatch) {
        passl.setCustomValidity("Пароли  не совпадают. Пожалуйста, проверьте  идентичность паролей в обоих полях!");
    }
    else {
        passl.setCustomValidity("");
    }

    return isMatch;
}