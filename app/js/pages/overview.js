
$(function () {
	var wWidth = $(window).width();
	var subcategories = $('.category-menu__subcategories');
	var menuLinks = $('.subcategory');
	var filterLink = $('.filter-link');
	var sidebar = $('.category-sidebar-menu');
	// open sidebar filter by clicking on mobile filter link (подбор)
	filterLink.click(function() {
		var offset = filterLink.position();
		var sidebarOffset = sidebar.offset();
		if(offset !== undefined) {
			var top = offset.top;
			var left = offset.left;
		}
		sidebar.css('width', $(this).outerWidth() + 'px');
		sidebar.css('top', (offset.top) + filterLink.outerHeight()    + 'px' );
		sidebar.css('left', (offset.left) + 'px');
		sidebar.toggle();
		$(this).toggleClass('filter-link-active');
	});

		// close sidebar by clicking on free space
	$(document).mouseup(function (e)
	{ if ($(document).width() <= 994){
			if (!sidebar.is(e.target) // if the target of the click isn't the container...
				&& sidebar.has(e.target).length === 0 // ... nor a descendant of the container
				&& !filterLink.is(e.target) && sidebar.css('display') === 'block') 
			{
				sidebar.hide();
				filterLink.removeClass('filter-link-active');
			}
		}
	});
	
	//    раскрытие пунктов меню сайдбара
	menuLinks.on('click', function(e) {
		if (e.target.nodeName !== 'A'){
			e.preventDefault();
			menuLink = $(this);
			if (menuLink.hasClass('opened')) {
				menuLink.next().slideUp();
				menuLink.removeClass('opened');
			} else {
				if (!menuLink.parent().hasClass('category-menu__item--no-subcategories')) {
					menuLinks.removeClass('opened');
					menuLink.addClass('opened');
					subcategories.slideUp();
					menuLink.next().slideDown();
				}
				
			}
		}
	});
});


// $(document).ready(function() {
// 	if (document.querySelector('.o-compared-item__heading a')){
// 		myTruncate(document.querySelectorAll('.o-compared-item__heading a'), 65); 
// 		// var el = document.querySelectorAll('.o-compared-item__heading a');
// 		// function ellipsis(obj, len) {
// 		// 	var text = obj.innerHTML;
// 		// 	if (text.length > len) {
// 		// 		text = text.slice(0, len - 3) + '&hellip;'; 
// 		// 		obj.innerHTML = text;
// 		// 	}
// 		// }
		
// 		// for (var i = 0; i < el.length; i++){
// 		// 	ellipsis(el[i], 65);
// 		// }
// 	}

// 	if (document.querySelector('.ov-similar-item__preview-text p')) {

// 		myTruncate(document.querySelectorAll('.ov-similar-item__preview-text p'), 161); 
// 		// var el = document.querySelectorAll('.ov-similar-item__preview-text p');
// 		// function ellipsis(obj, len) {
// 		// 	var text = obj.innerHTML;
// 		// 	if (text.length > len) {
// 		// 		text = text.slice(0, len - 3) + '&hellip;'; 
// 		// 		obj.innerHTML = text;
// 		// 	}
// 		// }
		
// 		// for (var i = 0; i < el.length; i++){
// 		// 	ellipsis(el[i], 65);
// 		// }
// 	}
// });

// $(document).ready(function() {
 
// 	//- var owl = $("#owl-alike-products");
// 	if ($("#commentForm").text()){
// 		var form = $("#commentForm");
// 		var textarea = $(".commenttext");
// 		var inputContent;
// 		textarea.blur(function() {
// 			inputContent = $(this).val();
// 			if (inputContent === "") {
// 				$(this).val("Оставьте свой комментарий ...");
// 				$(this).addClass("u-placeholder-text");
// 			}
// 		});
// 		textarea.focus(function(){
// 			inputContent = $(this).val();
// 			if (inputContent == "Оставьте свой комментарий ..."){
// 				$(this).val("");
// 				$(this).removeClass("u-placeholder-text");
// 			}
// 		});
// 		textarea.keydown(function (e) {
// 			if (!e.shiftKey && e.keyCode == 13){
// 				form.submit();
// 			}

// 		});

// 	}

// });

// function myTruncate(object_arr, len) {

// 	function ellipsis(obj, len) {
// 		var text = obj.innerHTML;
// 		if (text.length > len) {
// 			text = text.slice(0, len - 3) + '&hellip;'; 
// 			obj.innerHTML = text;
// 		}
// 	}
	
// 	for (var i = 0; i < object_arr.length; i++){
// 		ellipsis(object_arr[i], len);
// 	}
// }
