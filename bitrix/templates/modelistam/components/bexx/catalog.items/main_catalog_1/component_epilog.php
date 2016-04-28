<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_wishlist");?>
<span id="dynamic_wishlist">
<?//PST-9?>

<?
$user_id = CBexxShop::GetRatingUserID($arParams['COMMENTS_ONLY_AUTHORIZED']=="Y");
?>
<script>
    $(function () {
    <?if (is_array($GLOBALS['cart_content'])):?>
        <?foreach ($GLOBALS['cart_content'] as $item_id=>$odin):?>
            <?if (isset($arResult['ITEMS'][$item_id])):?>
                $('#product-order-<?=$item_id?>').html('<a href="/personal/cart/" class="butt3 buttCartActive"> <i></i><span> В корзине</span> </a>').parents('.product-price-block').addClass('product-price-block--active');
            <?endif;?>
        <?endforeach;?>
    <?endif;?>

    <?if (is_array($GLOBALS['wishlist_content'])):?>
        <?foreach ($GLOBALS['wishlist_content'] as $item_id=>$odin):?>
            <?if (isset($arResult['ITEMS'][$item_id])):?>
                $('#product-wishlist-<?=$item_id?>').html('<a class="top-wishlist-link wishlist-link wishlist-link--active" href="/personal/"><i></i><div class="hover-link"> Отложено</div></a>');
            <?endif;?>
        <?endforeach;?>
    <?endif;?>
    
    <?if (is_array($arResult['ITEMS'])):?>
        <?foreach ($arResult['ITEMS'] as $item_id=>$item):?>
            <?if (!is_array($item['PROPERTY_VALUES']['score_users']['DESCRIPTION'])) $item['PROPERTY_VALUES']['score_users']['DESCRIPTION'] = array();?>
            $('#product-rating-<?=$item_id?>').rateit({
                max: 5,
                step: 1,
                backingfld: '#product-ratingback-<?=$item_id?>',
                starwidth: 16.4,
                starheight: 16,
                <?if (in_array($user_id, $item['PROPERTY_VALUES']['score_users']['DESCRIPTION'])):?>
                    readonly: true,
                <?endif;?>
                resetable: false
            });
            $("#product-rating-<?=$item_id?>").bind('rated', function (event, value) {
                ajax_load('#product-ratingс-<?=$item_id?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=rate&id=<?=$item_id?>&rating='+value);
            });
            <?if ($_SESSION['compare'][$item_id] == 1):?>
                $('#product-compare-<?=$item_id?> .float-left').removeClass('checkbox-black').addClass('checkbox-black-checked');
                $('#product-compare-<?=$item_id?> .product-compare-link').addClass('compared');
                $('div.compared').html('<a href="<?=$APPLICATION->GetCurUri("compare", false)?>">к сравнению</a>');
                var active_compare_<?=$item_id?> = 1;
            <?else:?>
                var active_compare_<?=$item_id?> = 0;
            <?endif;?>
        <?endforeach;?>
    <?endif;?>
    });
</script>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_wishlist", "");?>
<?//PST-9?>