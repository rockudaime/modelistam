$(document).ready(function() {
	if (document.querySelector('.o-compared-item__heading a')){
		var el = document.querySelectorAll('.o-compared-item__heading a');
		function ellipsis(obj, len) {
			var text = obj.innerHTML;
			if (text.length > len) {
				text = text.slice(0, len - 3) + '&hellip;'; 
				obj.innerHTML = text;
			}
		}
		
		for (var i = 0; i < el.length; i++){
			ellipsis(el[i], 65);
		}
	}
});


$(document).ready(function() {
 
	//- var owl = $("#owl-alike-products");
	if ($("#commentForm").text()){
		var form = $("#commentForm");
		var textarea = $(".commenttext");
		var inputContent;
		textarea.blur(function() {
			inputContent = $(this).val();
			if (inputContent === "") {
				$(this).val("Оставьте свой комментарий ...");
				$(this).addClass("u-placeholder-text");
			}
		});
		textarea.focus(function(){
			inputContent = $(this).val();
			if (inputContent == "Оставьте свой комментарий ..."){
				$(this).val("");
				$(this).removeClass("u-placeholder-text");
			}
		});
		textarea.keydown(function (e) {
			if (!e.shiftKey && e.keyCode == 13){
				form.submit();
			}

		});

	}

});
