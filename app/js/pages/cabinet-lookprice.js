window.onload = function() {
  var link = document.querySelectorAll(".product-setprice__link");
  var submitBtn = document.querySelectorAll('.product-setprice__form-submit');

  for (var i = 0; i < link.length; i++) {
    link[i].addEventListener("click", toggleFieldToSetUserPrice);
  };

  for (var i = 0; i < submitBtn.length; i++) {
    submitBtn[i].addEventListener("click", toggleFieldToSetUserPrice);
  };

  function toggleFieldToSetUserPrice (e) {
    e.preventDefault();

    var parentBlock = this.parentElement.parentElement;
    var userPrice = parentBlock.querySelector('.product-setprice__price');
    var inputPrice = parentBlock.querySelector('.product-setprice__form');

    if (!userPrice.classList.contains('hideField')) {
      userPrice.classList.add('hideField');
      inputPrice.classList.remove('hideField');
    } else {
      inputPrice.classList.add('hideField');
      userPrice.classList.remove('hideField');
    };
  };
}