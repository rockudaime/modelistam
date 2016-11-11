function ellipsis(obj, len) {
	var text = obj.innerHTML;
	if (text.length > len) {
		text = text.slice(0, len - 3) + '...'; 
		obj.innerHTML = text;
	}
}


// Custom swipe events
// fc = fast click
// swl = swipe left and swr, swu, swd = right, up, down accordingly
window.onload=function(){
	(function(d){
	 var ce = function(e,n){
		var a=document.createEvent("CustomEvent");
		a.initCustomEvent(n,true,true,e.target);
		e.target.dispatchEvent(a);
		a = null;
		return false;
	 }
	 var nm = true, sp = {x:0,y:0}, ep = {x:0,y:0}; // sp = start point, ep = end point
	 var touch={
		touchstart: function(e) {
			sp={ x:e.touches[0].pageX, // inititalize start point of the touch
				 y:e.touches[0].pageY
			}
		},
		touchmove: function(e) {
			nm =false;
			ep ={
					x:e.touches[0].pageX,
					y:e.touches[0].pageY
				}
			},
		touchend: function(e) {
			if(nm) {
				ce(e,'fc')
			} else {
				var x = ep.x-sp.x;
				var xr = Math.abs(x);
				var y = ep.y-sp.y;
				var yr = Math.abs(y);
				if(Math.max(xr,yr) > 20) { // if swipe was more than 20px then decide what type of swipe it was
					ce(e, (xr > yr ? (x < 0 ? 'swl' : 'swr') : (y < 0 ? 'swu' : 'swd' )));
				}
			};
			nm = true;
		},
		touchcancel:function(e){nm=false}
	 };
	 for(var a in touch){d.addEventListener(a,touch[a],false);}
	})(document);
	//EXAMPLE OF USE
	var h=function(e){console.log(e.type,e)};
	document.body.addEventListener('fc',h,false);// 0-50ms vs 500ms with normal click
	document.body.addEventListener('swl',h,false);
	document.body.addEventListener('swr',h,false);
	document.body.addEventListener('swu',h,false);
	document.body.addEventListener('swd',h,false);
}
