$(document).ready(function() {

	var myTruncate = function(object_arr, len) {

		function ellipsis(obj, len) {
			var text = obj.innerHTML;
			if (text.length > len) {
				text = text.slice(0, len - 3) + '&hellip;'; 
				obj.innerHTML = text;
			}
		}
		
		for (var i = 0; i < object_arr.length; i++){
			ellipsis(object_arr[i], len);
		}
	}

	if (document.querySelector('.l-good__good-title a')){
		myTruncate(document.querySelectorAll('.l-good__good-title a'), 78);
		console.log('hello');

	}



});

