<?//d($arResult)?>

<div class="fastbuy">
    <?if ($arResult['ITEM']):?>
	<div class="fastbuy__title">Купить быстро</div>

	<div class="fastbuy__wrap">
        <form id="order_click_form" method="post" action="#">
            <input type="hidden" name="do" value="fast_buy_count" id="hidden_do" />
            <input type="hidden" name="id" value="<?=$arResult['ITEM']['ID']?>" />

            <div class="fastbuy__wrap__left">

                <div class="fastbuy__info">
                    В корзине
                    <span>
                        (
                        <span id="fastbuy-count-num">
                            <?=$arResult['ITEM']['QUANTITY'];?>
                        </span>
                        ) =
                        <span id="fastbuy_total">
                            <?=price($arResult['ITEM']['PRICE']*$arResult['ITEM']['QUANTITY'], $arResult['ITEM']['CURRENCY'])?>
                        </span>
                    </span>
                </div>

                <div class="fastbuy__image">
                    <?if ($arResult['ITEM']['DETAIL_PICTURE']):?>
                    <img class="adaptive-img" src="<?=MakeImage($arResult['ITEM']['DETAIL_PICTURE'], array('w'=>220, 'h'=>220, 'q'=>100, 'zc'=>0))?>" alt="<?=$arResult['ITEM']['NAME'];?>" />
                    <?else:?>
                    <img class="adaptive-img" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" alt="<?=$arResult['ITEM']['NAME'];?>" />
                    <?endif;?>
                </div>

                <div class="fastbuy__return-block">
                    <a class="fastbuy__return-link" href="#">продолжить покупки</a>
                    <span>(вернуться в магазин)</span>
                </div>

            </div>

            <div class="fastbuy__wrap__right">
               <div class="fastbuy__name"><?=$arResult['ITEM']['NAME']?></div>

                <div class="fastbuy__counts">
                    <span>Количество</span>
                    <div class="butt4 basket-add btn">+</div>
                    <input type="text" name="qty" class="ui-grey-input fastbuy__counts-input" id="fastbuy_qty" value="<?=$arResult['ITEM']['QUANTITY']?>" readonly="readonly" />
                    <div class="butt4 basket-del btn disable">-</div>

                </div>

                <div class="fastbuy__price-container">
                    <div class="fastbuy__total-price">
                        <span id="order_total_cost"><?=price($arResult['ITEM']['PRICE']*$arResult['ITEM']['QUANTITY'], $arResult['ITEM']['CURRENCY'])?></span>
                    </div>
                </div>

                <div class="fastbuy__bottom">
                    <div class="fastbuy__bottom__title">Купить быстро</div>
                    <div class="fastbuy__bottom__text">
                        Заказать без заполнения формы, оставить свой номер телефона.<br/>
                        Наш консультант свяжется с вами.
                    </div>
                </div>

                <div class="fastbuy__phone-block">
                    <?/*<input type="text" name="name" value="<?=htmlspecialchars(strip_tags($_POST['name']))?>" id="fastbuy_name" />*/?>
                    <input class="fastbuy__phone-input" type="text" placeholder="+ 38 (093) 12 - 34 - 567" name="phone" value="<?=htmlspecialchars(strip_tags($_POST['phone']))?>" id="fastbuy_phone" />
                    <a href="#" id="fastbuy-button" class="ui-button-blue ui-button-blue--login-link">Отправить</a>
                </div>
            </div>
        </form>
	</div>

    <script type="text/javascript">
        var qty = <?=$arResult['ITEM']['QUANTITY']?>;
        $(function(){
            $('.basket-del').click(function(){
                qty--;
                if (qty<=1) {
                    qty = 1;
                    $('.basket-del').addClass('disable');
                }
                update_fastbuy();
            });
            $('.basket-add').click(function(){
                qty++;
                $('.basket-del').removeClass('disable');
                update_fastbuy();
            });
            $('#fastbuy-button').click(function(){
                if (!$('#fastbuy_phone').val()) {
                    alert('Укажите номер телефона');
                } else {
                    $('#order_click_form').append('<input type="hidden" name="do" value="fast_buy_send">');
                    ajax_load('#fast_buy', '<?=$arResult['AJAX_CALL_ID']?>', $('#order_click_form').serializeArray());
                }
                return false;
            });
            $('.fastbuy__return-link').on('click', function(e) {
                e.preventDefault();
                $('.fancybox-close').trigger('click');
            })
        });
        function update_fastbuy () {
            $('#fastbuy_qty').val(qty);
            $('#fastbuy-count-num').text(qty);
            ajax_load('#order_total_cost', '<?=$arResult['AJAX_CALL_ID']?>', $('#order_click_form').serializeArray());
        }
    </script>


	<?
	if (is_array($arResult['ERRORS']) AND !empty($arResult['ERRORS'])) {
		echo ShowError(implode("<br />", $arResult['ERRORS']));
	}
	?>
	<?endif;?>
</div>