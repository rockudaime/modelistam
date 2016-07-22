function ellipsis(obj, len) {
	var text = obj.innerHTML;
	if (text.length > len) {
		text = text.slice(0, len - 3) + '...'; 
		obj.innerHTML = text;
	}
}

