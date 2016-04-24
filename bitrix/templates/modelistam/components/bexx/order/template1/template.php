<?
//PST-9
$frame = $this->createFrame()->begin('');
//PST-9
?>

<?if (is_array($arResult['CART']) AND !empty($arResult['CART'])):?>
<?if ($arParams['AJAX_ENABLED'] != "Y"):?>

<script>
function order_form_reload() {
    $('#workarea #order_form #hidden_do').val('update');
    ajax_block('#workarea #order_form');
    ajax_load('#workarea #order_form', '<?=$arResult['AJAX_CALL_ID']?>', $('#workarea #order_form').serializeArray());
}
</script>


<form method="post" action="" id="order_form">
<?endif;?>
    
    <?
    //PM-10 
     if (is_array($arResult['ERRORS'])) {
        if (count($arResult['ERRORS'])) {
            $errs = implode("<br />", $arResult['ERRORS']);
            echo ShowError($errs);
            if (substr_count($errs, 'Пользователь с таким e-mail') > 0)        
            echo "<a id='login-on-site' class='underline' href=/login/?backurl=%2Fpersonal%2Forder%2F>Авторизуйтесь на сайте</a>";  
        }
    //PM-10     
    }?>
	
	<script>
		BIS.pageOrderAppendLinkToError = {
			init: function() {
				var loginLink = $('#login-on-site');
				var errorBlock = $('.errortext');
				
				if (loginLink.length) {
					loginLink.appendTo(errorBlock);
				}
			}
		}
		$(function() {
			BIS.pageOrderAppendLinkToError.init();
		})
	</script>
    
    <?
    //PM-10
//    if (is_array($arResult['ERRORS'])) {
//        if (count($arResult['ERRORS'])) {
//            echo ShowError(implode("<br />", $arResult['ERRORS']));
//        }   
//    }
    //PM-10
    ?>

    <div class="order-block">
        <div class="order-block__main-title">
            Оформление заказа
        </div>

        <div class="order-block__left">
            <? /*
            //PM-10
            <?include_once("order_1.php")?>
            //PM-10
            */ ?>
            <div class="order-block__left-inner">
                <?include_once("order_2.php")?>
            </div>

            <div class="order-block-left__bottom">
                <input type="hidden" name="do" value="send_order" id="hidden_do" />
                <input type="submit" title="Заказать" class="butt3 butt3--big" value="Подтвердить заказ" />
            </div>

            <? /*
                //PM-10
                <?include_once("order_3.php")?>
                <?include_once("order_4.php")?>
                //PM-10
            */ ?>
        </div>

        <div class="order-block__right">
            <div class="order-block__cart">
                <div class="cart-title">
                    <span>Ваша корзина</span>
                    <a href="/personal/cart/">Редактировать</a>
                </div>
                <div class="order-block__cart-inner">
                    <?include_once("order_5.php")?>
                    <div class="order-block__total">
                        <div class="order-block__total__left">Итоговая стоимость</div>
                        <div class="order-block__total__right">
                            <?=price($arResult['TOTAL_PRICE'], $arResult['CURRENCY'])?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


	
	
    <?if ($arParams['AJAX_ENABLED'] != "Y"):?>
</form>
<?endif;?>
<?else:?>
    <?=ShowError("Пустая корзина, оформление заказа невозможно");?>
<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>