<?//MM-223 вывод количества отслеживаемых цен?>

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


$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->GetNext();


if ($arUser['UF_PRICE_ALERT']) {
    $arPriceAlert = array();
    CModule::IncludeModule("iblock");
    $arSelect = array('ID', 'NAME', 'DETAIL_PICTURE', 'LIST_PAGE_URL', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'ACTIVE', 'CODE', 'CATALOG_QUANTITY');
    $rs = CIBlockElement::GetList(array("SORT"=>"ASC", 'ID'=>"DESC"), array('ID'=>$arUser['UF_PRICE_ALERT'], 'CHECK_PERMISSIONS'=>"Y"), false, $false, $arSelect);
    while ($ar = $rs->GetNext()) {
        $arPriceAlert[$ar['ID']] = $ar;
    }
}

if ($arUser['UF_STOCK_ALERT']) {
    $arAlert = array();
    CModule::IncludeModule("iblock");
    $arSelect = array('ID', 'NAME', 'DETAIL_PICTURE', 'LIST_PAGE_URL', 'DETAIL_PAGE_URL', 'IBLOCK_SECTION_ID', 'ACTIVE', 'CODE', 'CATALOG_QUANTITY');
    $rs = CIBlockElement::GetList(array("SORT"=>"ASC", 'ID'=>"DESC"), array('ID'=>$arUser['UF_STOCK_ALERT'], 'CHECK_PERMISSIONS'=>"Y"), false, $false, $arSelect);
    while ($ar = $rs->GetNext()) {
        $arAlert[$ar['ID']] = $ar;
    }
}

?>

    <div class="top-wishlist-block">
        <?//MM-252 вывод количества отложенных товаров?>

        <a href="/personal/wishlist/" class="header-wishlist-link">
            <i>
                <div id="wishlist-count">
                    <?if (($arUser) && ((is_array($GLOBALS['wishlist_content'])?count($GLOBALS['wishlist_content']):0) > 0)):?>
                        <div class="wish-count"><?=count($GLOBALS['wishlist_content'])?></div>
                    <?endif;?>
                </div>
            </i>
            <span id="product-delayed">
                Желания
            </span>
        </a>
        <?//MM-252 вывод количества отложенных товаров?>
    </div>

    <div class="top-compare-block">
        <a href="/personal/wishlist/" class="header-compare-link"><i></i>
            <span id="product-delayed">
                Сравнение
            </span>
        </a>
    </div>
    <div class="top-price-block">
        <?//MM-223 вывод количества отслеживаемых цен?>

        <a href="/personal/wishlist/" class="header-price-link">
            <i>
                <div id="price-count-alert">
                    <?if ((is_array($arPriceAlert)?count($arPriceAlert):0) > 0):?>
                        <div class="wish-count"><?=count($arPriceAlert)?></div>
                    <?endif;?>
                </div>
            </i>
            <span id="product-delayed">
                Цены
            </span>
        </a>
        <?//MM-223 вывод количества отслеживаемых цен?>
    </div>

    <div class="top-waiting-block">

        <a href="/personal/wishlist/" class="header-waiting-link">
            <i>
                <div id="stock-count-alert">
                    <?if ((is_array($arAlert)?count($arAlert):0) > 0):?>
                        <div class="wish-count "><?=count($arAlert)?></div>
                    <?endif;?>
                </div>
            </i>
            <span id="product-delayed">
                Ожидание
            </span>
        </a>
    </div>
	<div class="top-cart-block">

        <a href="/personal/cart/" class="header-cart-link">
            <i>
                <div id="cart-count-alert">
                                    </div>
            </i>
        </a>
    </div>
<script>
        $('.wish-count .stock-count-alert').html(<?=count($arAlert)?>);
</script>
    <a href="javascript:void(0);" id="pull-search" class="pull-search-block"></a>
