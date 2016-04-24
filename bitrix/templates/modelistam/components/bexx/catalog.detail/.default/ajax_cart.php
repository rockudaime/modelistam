<?if ($GLOBALS['cart_content'][$arResult['PRODUCT']['ID']]>0 OR $arResult['ADD2BASKET_OK']):?>
    <a class="butt1 butt1--big" id="detailCartActive" href="/personal/cart/">В корзине</a>
    <?if ($arResult['ADD2BASKET_OK']):?>
        <script>
            if (BIS.updatePopupTopCart) {
                BIS.updatePopupTopCart.init();
            }
            $('#detailCartActive').parents('.detail-price__inner').addClass('detail-price__inner--active');
        </script>
    <?endif;?>
<?endif;?>