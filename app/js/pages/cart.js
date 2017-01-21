//Табы для переключения форм в корзине

$(function () {
	if ($(".order-checkout-tabs").html()){
		console.log('hello');
		$(".order-checkout-tabs__tab").on("click", function(e) {
			var blocks = $("[data-js='tabcontent']");
			var targetcontentblockid = '#' + $(this).data("target");
			blocks.removeClass('active');
			$(targetcontentblockid).addClass('active');
			$(".order-checkout-tabs__tab").removeClass("active");
			$(this).addClass("active");
		});
	}

	$('.commentToggleLink').on('click', function (e) {
		e.preventDefault();

		var contentBlock = $(this).parent().next();
		var link = $(this);

		if (contentBlock.hasClass('collapsed')) {
			link.html('Скрыть комментарий');
			contentBlock.removeClass('collapsed');
		} else {
			link.html('Добавить комментарий к заказу');
			contentBlock.addClass('collapsed');
		}
	});
});


// //  Стили для обработки всплывающего окна редактирования корзины
// //  при нажатии на крестик в провом верхнем углу. 
// $(".cart-product__item-delete").on("click",function(e){
// 	e.preventDefault();
// 	var ppBlock = $(this).parent().find('.popup-back');
// 	ppBlock.show();
// 	ppBlock.parent().addClass("in-tr-background");
// });
// $(".close-popup").on("click",function(e){
// 	e.preventDefault();
// 	$(".page-cart__delete_checkbox-item").show();
// 	$(this).parent().hide();
// 	$(this).parent().parent().removeClass("in-tr-background");
// });

// // Открытие области корзины по клику в мобильном виде
// $('.cart-mobile-opener').on("click", function(e) {
// 	$(".order-block__right").slideToggle( "slow" );
// });
// // Ссылка изменить для бывших покупателей
// $('.contentToggleLink').on("click", function(e) {
// 	e.preventDefault();
// // $(".change-info > input").removeAttr("hidden");
// $(this).next().slideToggle("slow");
// });


// // Раскрытие поля для ввода комментария к заказу
// $("#orderCommentLink").on("click", function(e){
// 	e.preventDefault();
// 	$("#orderComment").toggle();
// });


// var select = document.querySelectorAll('.custom-select__select');
// for (var i = 0; i < select.length; i++) {
// 	if(select[i].value.length > 15){
// 		select[i].value = select[i].value.slice(0,12) + '...';
// 	}
// }

// // ----------------------------
// // добавление товара

// $(document).ready(function(){
// 	$('.cart-product__quantity--add').on('click', function(e){
// 		e.preventDefault();
// 		var productId = this.dataset.product;
// 		var productInp = document.getElementById(productId);
// 		var productQty = parseInt(productInp.value) + 1;

// 		productInp.value = productQty;
// 		this.previousSibling.innerHTML = productQty + ' шт';
// 		var productPrBlock = this.nextSibling;
// 		var productPrice = parseInt(productPrBlock.innerHTML.replace(/[^0-9]/, '')) / (productQty - 1);
// 		productPrBlock.innerHTML = splitSum(productPrice * productQty) + ' грн';
// 		calculateTotal();
// 	});

// 	$('.cart-product__quantity--del').on('click', function(e){
// 		e.preventDefault();
// 		var productId = this.dataset.product;
// 		var productInp = document.getElementById(productId);
// 		var productQty = parseInt(productInp.value);
// 		if (productQty > 1){
// 			productInp.value = productQty - 1;
// 			this.nextSibling.innerHTML = productInp.value + ' шт';

// 			var productPrBlock = this.nextSibling.nextSibling.nextSibling;
// 			var productPrice = parseInt(productPrBlock.innerHTML.replace(/[^0-9]/, '')) / (productQty);
// 			productPrBlock.innerHTML = splitSum(productPrice * (productQty - 1)) + ' грн';
// 			calculateTotal();
// 		}
// 	});

// 	function calculateTotal(){
// 		var prices = document.querySelectorAll('.cart-product__price');
// 		var totalPrice = 0;
// 		for (var i = 0; i < prices.length; i++){				
// 				totalPrice += parseInt(prices[i].innerHTML.replace(/[^0-9]/, ''));
				
// 			// totalPrice += parseInt(prices[i].innerHTML.replace(/[^0-9]/, ''));
// 		}
// 		document.querySelector('.order-total-sum span').innerHTML = splitSum(totalPrice) + ' грн';
// 		document.querySelector('.cart-mobile-opener span').innerHTML = splitSum(totalPrice) + ' грн';
// 	}

// 	function splitSum(s){
// 		s = String(s);
// 		if (s.length > 3){
// 			var n = Math.floor(s.length / 3);
// 			var m = s.length % 3;
// 			var newStr = '';
// 			if ( m !== 0) {
// 					newStr += s.slice(0, m) + ' ';
// 					s = s.slice(m);
// 			} 			
// 			for (var i = 0; i <= n; i++){				
// 				newStr += s.slice(3*i, 3*i + 3) + ' ';
// 			}
// 			return newStr;
// 		}
// 		return s;
		
// 	}

// });


// // Ограничение количества знаков текста в названии комплектного товара


// $(document).ready(function() {
// 	function ellipsis(obj, len) {
// 		var text = obj.innerHTML;
// 		if (text.length > len) {
// 			text = text.slice(0, len - 3) + '&hellip;'; 
// 			obj.innerHTML = text;
// 		}
// 	}
	
// 	if (document.querySelector('.product-set__good-name a')){
// 		var el = document.querySelectorAll('.product-set__good-name a');		
// 		for (var i = 0; i < el.length; i++){
// 			ellipsis(el[i], 40);
// 		}
// 	}
// });

// // promokod

// $(document).ready(function() {
// 	if (document.querySelector('.promokod-icon')){
// 		var el = document.querySelector('.promokod-icon');
// 		el.addEventListener('click', function() {
// 			$('.promokod-info').fadeIn('slow');
// 			setTimeout(function() { 
// 				$('.promokod-info').fadeOut();
// 			}, 1500);
// 		});
// 	}
// });