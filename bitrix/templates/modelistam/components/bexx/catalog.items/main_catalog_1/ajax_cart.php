<?if ($arResult):?>
    <a href="/personal/cart/" id="cartActive-<?=$arResult;?>" class="butt3 buttCartActive"><i></i><span>В корзине</span></a>

    <script>
        if(typeof window.update_block_cart == 'function') {
            update_block_cart();
        }
        if(BIS.updatePopupTopCart) {
            BIS.updatePopupTopCart.init();
        }
        $('#cartActive-<?=$arResult?>').parents('.product-price-block').addClass('product-price-block--active');
    </script>

<?endif;?>