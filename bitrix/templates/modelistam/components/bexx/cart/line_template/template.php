<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

/* Данные для arResult корзины в шапке (ajax) */
$arResult['TOP_TMPL'] = array();
if (is_array($arResult['ITEMS']) && count($arResult['ITEMS'])>0) {
    $cssFullCart = 'cart-link--full';
    $emptyCart = false;
    //VTL-5
    //$arResult['TOP_TMPL']['COUNT'] = count($arResult['ITEMS']);
    $arResult['TOP_TMPL']['COUNT'] = count($arResult['CART_ITEMS']);
    //VTL-5
    $arResult['TOP_TMPL']['CSS_ACTIVE'] = 'cart-link--active';
    $arResult['TOP_TMPL']['CART_NAME'] = 'В корзине:';
    $totalQuantity = 0;
    foreach($arResult['CART_ITEMS'] as $item) {
        $totalQuantity = $totalQuantity + format_qty($item['QUANTITY']);
    }
} else {
    $emptyCart = true;
    $arResult['TOP_TMPL']['COUNT'] = 0;
    $arResult['TOP_TMPL']['CART_NAME'] = 'Корзина:';
    $totalQuantity = 0;
}
?>
<span> В корзине <?=$arResult['TOP_TMPL']['COUNT'];?> товаров на <?=price($arResult['TOTAL_PRICE'], $arResult['CURRENCY'])?></span>
