<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
// Если пользователю доступны несколько типов цен, то покажем ему максимальную цену как старую
if (is_array($arResult['PRICES'])) if (count($arResult['PRICES'])>1) {
    foreach ($arResult['PRICES'] as $price_to_check) {
        if ($price_to_check['PRICE']>$arResult['PRICE']) {
            $arResult['PRICE'] = CCurrencyRates::ConvertCurrency($price_to_check['PRICE'], $price_to_check['CURRENCY'], $arResult['CURRENCY']);
        }
    }
}
?>

<?
/*if ($arResult['PRICE']>$arResult['DISCOUNT_PRICE']):?>
    <div class="old-price">
        <?
        //PST-9
        $frame = $this->createFrame()->begin('');
        //PST-9
        ?>
        <span><?=price($arResult['PRICE'], $arResult['CURRENCY'])?></span>
        <?
        //PST-9
        $frame->end();
        //PST-9
        ?>
    </div>
<?endif;
*/?>

<?
/*
$offer_id_cart = $arResult['ID'];
if (!$arResult['DISCOUNT_PRICE']) {
    // возможно, есть цена в SKU
    if (is_array($arResult['OFFERS']) AND !empty($arResult['OFFERS'])) {
        $active_offer = reset($arResult['OFFERS']);
        $arResult['DISCOUNT_PRICE'] = $active_offer['DISCOUNT_PRICE'];
        $arResult['CURRENCY'] = $active_offer['CURRENCY'];
        $offer_id_cart = $active_offer['ID'];
    }
}
*/
?>
<?if ($arResult['DISCOUNT_PRICE']>0):?>
    <div class="new-price product-price">
        <?
        //PST-9
        $frame = $this->createFrame()->begin('');
        //PST-9
        ?>
        <?=price($arResult['DISCOUNT_PRICE'], $arResult['CURRENCY'])?>
        <?//MM-227?>
        <?if ($arResult["PREVPRICE"] > 0):?>
            <div class="catalog-product__old-price-outer">
                <p><?=price($arResult["PREVPRICE"], $arResult['CURRENCY'])?> </p>
            </div>
            <script>
                $('.catalog-product__old-price-outer').each(function() {
                    var toreplace = $(this).html();
                    toreplace = toreplace.replace("грн.","<p>&nbsp;грн</p>");
                    $(this).html(toreplace);
                });

            </script>
        <?endif;?>
        <?//MM-227?>

        <?
        //PST-9
        $frame->end();
        //PST-9
        ?>
    </div>
    <script>
        $('.product-price').each(function() {
            var toreplace = $(this).html();
            toreplace = toreplace.replace("грн.","<p>грн</p>");
            $(this).html(toreplace);
        });

    </script>
<?else:?>
    <div class="new-price product-price">
        <span>Нет цены</span>
    </div>
<?endif;?>