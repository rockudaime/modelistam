<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_ajax_cart_".$arParams['CODE']);?>
<span id="dynamic_ajax_cart_"<?$arParams['CODE']?>>
<?//PST-9?>

<?if ($arResult):?>

    <a href="/personal/cart/"
       id="<?=$arParams['CODE']?>-cartItemsActive-<?=$arResult;?>"
       class="butt2 buttCartActive">В корзине
    </a>

    <script>
        (function(){
            if(typeof window.update_block_cart == 'function') {
                update_block_cart();
            }

            if(BIS.updateTopCart) {
                BIS.updateTopCart.init();
            }

            $('#<?=$arParams['CODE']?>-cartItemsActive-<?=$arResult?>').parents('.poly-items__bottom').addClass('poly-items__bottom--active');
        })();
    </script>
<?endif;?>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_ajax_cart_".$arParams['CODE'], "");?>
<?//PST-9?>