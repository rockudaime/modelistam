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

		// Добавление нового поля при нажатии на кнопку "добавить еще телефон"
		addPhoneLink.on('click', function(e) {
			var phoneField = $('#phoneBlock input:first-child');
			var idNumber = $('.profile-field-group--phone').length + 1;
			var newId = 'phoneNumber' + idNumber;
			var newPhoneBlock = document.createElement('div');

			var deletePhoneLink = document.createElement('a');
				deletePhoneLink.href = "#";
				deletePhoneLink.innerHTML = "<span>удалить</span>";
				deletePhoneLink.className = "cabinet-link profile-form-add-phone profile-form-delete-phone";

			newPhoneBlock.className = "profile-field-group profile-field-group--phone";
			newPhoneBlock.id = "phoneBlock" + idNumber;
			newPhoneBlock.innerHTML = '<input class="profile-form__input-field profile-form__input-field--phone"'
						+' type="tel" name="tel" placeholder="Ваш телефон" id="' 
						+ newId
						+'">';
			newPhoneBlock.appendChild(deletePhoneLink);
			$(newPhoneBlock).insertAfter($('#phoneBlock' + (idNumber - 1)));

			// удаление блока с полем для телефона при нажатии кнопки "удалить"
			deletePhoneLink.addEventListener('click', removeParentHandler, false);
			
			return false;	
		});

		function removeParentHandler (e) {
			e.preventDefault();
			this.removeEventListener('click', removeParentHandler)
			$(this).parent().remove();

			return false;
		}
		
	}

	// how-save page
	if($('*').is('.cabinet-how-save')) {
		var accordion = (new function (window, document) {
			this.block = document.querySelector('.j-accordion');
			this.openTitle = $(this.block.getElementsByClassName('j-accordion-title'));
			this.content = $(this.block.getElementsByClassName('j-accordion-content'));
			var accordion = this;
			this.init = function () {
				var titles = accordion.openTitle;
				var contents = accordion.content;

				titles.on('click', clickHandler);

				function clickHandler (e) {
					e.preventDefault;

					var title = $(this);
					var contentBlock = title.next();
					if (title.hasClass('active')) {
						title.removeClass('active');
						contentBlock.addClass('collapsed');
					} else {
						titles.removeClass('active');
						contents.addClass('collapsed');

						title.addClass('active');
						contentBlock.removeClass('collapsed');
					}
				}

			}

			return this;
		}(window, document));

		accordion.init();

	}

});


