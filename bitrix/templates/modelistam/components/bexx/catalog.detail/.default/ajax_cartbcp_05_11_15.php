<?if ($GLOBALS['cart_content'][$arResult['PRODUCT']['ID']]>0 OR $arResult['ADD2BASKET_OK']):?>
	<a class="butt3 butt3--toCart" id="detailCartActive" href="/personal/cart/">В корзине</a>
	<?if ($arResult['ADD2BASKET_OK']):?>
        <script>
            if (BIS.updateTopCartFromCart) {
                BIS.updateTopCartFromCart.init();
            }
        </script>
	<script>
        if (BIS.updateTopCart) {
            BIS.updateTopCart.init();
        }
	</script>
	<?endif;?>
<?endif;?>