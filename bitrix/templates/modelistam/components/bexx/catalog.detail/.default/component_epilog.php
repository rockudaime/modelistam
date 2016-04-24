<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_epilog_detail_cart");?>
<span id="dynamic_epilog_detail_cart">
<?//PST-9?>

<script>
<?if (is_array($GLOBALS['cart_content'])):?>
    <?foreach ($GLOBALS['cart_content'] as $item_id=>$odin):?>
        <?//if (isset($arResult['ITEMS'][$item_id])):?>
            $('#product-order-<?=$item_id?>').html('<a href="/personal/cart/" class="butt3 butt3--toCart">В корзине</a>').parents('.detail-price__inner').addClass('detail-price__inner--active');
        <?//endif;?>
    <?endforeach;?>
<?endif;?>


<?if (is_array($GLOBALS['wishlist_content'])):?>
    <?foreach ($GLOBALS['wishlist_content'] as $item_id=>$odin):?>
        <?if (isset($arResult['ITEMS'][$item_id])):?>
            $('#product-wishlist-<?=$item_id?>').html('<a href="/personal/wishlist/">В списке желаний</a>');
        <?endif;?>
    <?endforeach;?>
<?endif;?>
</script>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_epilog_detail_cart", "");?>
<?//PST-9?>