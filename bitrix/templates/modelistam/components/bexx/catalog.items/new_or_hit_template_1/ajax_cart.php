<?if ($arResult):?>
    <a href="/personal/cart/" class="button-buy-grey float-right">в корзине</a>
    <script>
    var cart_count = $('#cart_items_count').html();
    if (!cart_count) {
        cart_count = 0;
    } else {
        cart_count++;
    }
    $('#cart_items_count').html(cart_count);
    if(typeof window.update_block_cart == 'function') {
        update_block_cart();
    }
    if(BIS.updatePopupTopCart) {
        BIS.updatePopupTopCart.init();
    }
    </script>
<?endif;?>