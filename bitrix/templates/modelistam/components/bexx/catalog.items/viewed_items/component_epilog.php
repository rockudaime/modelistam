<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_epilog_".$arParams['CODE']);?>
<span id="dynamic_epilog_"<?$arParams['CODE']?>>
<?//PST-9?>

<?
$user_id = CBexxShop::GetRatingUserID($arParams['COMMENTS_ONLY_AUTHORIZED']=="Y");
?>
<script>
    $(function () {
    <?if (is_array($GLOBALS['cart_content'])):?>
        <?foreach ($GLOBALS['cart_content'] as $item_id=>$odin):?>
            <?if (isset($arResult['ITEMS'][$item_id])):?>
                $('.wrap-order-<?=$arParams['CODE']?>').find('#product-order-<?=$item_id?>').html('<a href="/personal/cart/" class="butt2 buttCartActive">В корзине</a>').parents('.poly-items__bottom').addClass('poly-items__bottom--active');
            <?endif;?>
        <?endforeach;?>
    <?endif;?>

    <?if (is_array($GLOBALS['wishlist_content'])):?>
        <?foreach ($GLOBALS['wishlist_content'] as $item_id=>$odin):?>
            <?if (isset($arResult['ITEMS'][$item_id])):?>
                $('#poly-items-<?=$arParams['CODE']?>').find('#product-wishlist-<?=$item_id?>').html('<a class="top-wishlist-link wishlist-link wishlist-link--active" href="/personal/"><div>Отложено</div></a>');
            <?endif;?>
        <?endforeach;?>
    <?endif;?>
    
    <?if (is_array($arResult['ITEMS'])):?>
        <?foreach ($arResult['ITEMS'] as $item_id=>$item):?>
            <?if (!is_array($item['PROPERTY_VALUES']['score_users']['DESCRIPTION'])) $item['PROPERTY_VALUES']['score_users']['DESCRIPTION'] = array();?>
            $('#poly-items-<?=$arParams['CODE']?>').find('#product-rating-<?=$arParams['CODE']?>-<?=$item_id?>').rateit({
                max: 5,
                step: 1,
                backingfld: '#product-ratingback-<?=$arParams['CODE']?>-<?=$item_id?>',
                starwidth: 16.4,
                starheight: 16,
                <?if (in_array($user_id, $item['PROPERTY_VALUES']['score_users']['DESCRIPTION'])):?>
                    readonly: true,
                <?endif;?>
                resetable: false
            });
            $('#poly-items-<?=$arParams['CODE']?>').find("#product-rating-<?=$arParams['CODE']?>-<?=$item_id?>").bind('rated', function (event, value) {
                ajax_load('#product-ratingс-<?=$arParams['CODE']?>-<?=$item_id?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=rate&id=<?=$item_id?>&rating='+value);
            });

        <?endforeach;?>
    <?endif;?>
    });
</script>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_epilog_".$arParams['CODE'], "");?>
<?//PST-9?>