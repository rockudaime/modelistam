<script>
<?if (is_array($GLOBALS['cart_content'])):?>
    <?foreach ($GLOBALS['cart_content'] as $item_id=>$odin):?>
        <?if (isset($arResult['ITEMS'][$item_id])):?>
            $('#product-order-<?=$item_id?>').html('<a href="/personal/cart/" class="butt1">в корзине</a>');
        <?endif;?>
    <?endforeach;?>
<?endif;?>
</script>