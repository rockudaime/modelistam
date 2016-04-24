<?if ($arResult['ADD2WISHLIST_OK'] OR $GLOBALS['wishlist_content'][$arParams['ID']]==1):?>
	<a id="wishlistProduct-link" href="#" class="top-wishlist-link wishlist-link ajax_link_main_catalog" onclick="ajax_load('#wishlistProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=wishlist&id=<?=intval($_REQUEST['id'])?>'); return false;" title="Убрать из отложенных"><i></i><div class="hover-link">Убрать из<br/> отложенных</div></a>
<?else:?>
	<a id="wishlistProduct-link" href="#" class="top-wishlist-link wishlist-link ajax_link_main_catalog" onclick="ajax_load('#wishlistProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=wishlist&id=<?=intval($_REQUEST['id'])?>'); return false;" title="Отложить"><i></i><div class="hover-link">Отложить</div></a>
<?endif;?>

<?//MM-252 вывод количества отложенных товаров?>
<?
// Получаем содержимое корзины для текущего пользователя
if (CModule::IncludeModule("sale")) {
    $arCartContent = array();
    $arWishlistContent = array();
    $rsCart = CSaleBasket::GetList(array("DATE_UPDATE"=>"DESC"), array('FUSER_ID'=>CSaleBasket::GetBasketUserID(), 'ORDER_ID'=>NULL, 'LID'=>SITE_ID), false, false, array('PRODUCT_ID', 'QUANTITY', 'DELAY', 'CAN_BUY'));
    if (is_object($rsCart)) {
        while ($arCart = $rsCart->GetNext()) {
            // , 'DELAY'=>"N", 'CAN_BUY'=>"Y"
            if ($arCart['DELAY']=="Y") {
                $arWishlistContent[$arCart['PRODUCT_ID']] = 1;
            } else {
                $arCartContent[$arCart['PRODUCT_ID']] = $arCart['QUANTITY'];
            }
        }
    }
}

$GLOBALS['cart_content'] = $arCartContent; // Глобализация шагает по планете
$GLOBALS['wishlist_content'] = $arWishlistContent; // Глобализация шагает по планете
?>

<script>
    if (<?=count($arWishlistContent)?> > 0){
        $("#wishlist-count").empty();
        $('#wishlist-count').append('<div class="wish-count"><?=count($arWishlistContent)?></div>');

    }else{
        $("#wishlist-count").empty();
    }
</script>
<?//MM-252 вывод количества отложенных товаров?>