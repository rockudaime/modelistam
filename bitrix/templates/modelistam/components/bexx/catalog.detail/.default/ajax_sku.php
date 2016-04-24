<?if (!empty($arResult['SKU'])):?>
    <?
    // найдем доступные значения неиспользованных вариантов
    $prop_code = reset($arParams['SKU_PROPS']);
    $sku_props_correct = array();
    foreach ($arResult['SKU'] as $sku) {
        // $arResult['SKU_PROP_SET']
        if (is_array($sku['PROPERTIES'][$prop_code]['DESCRIPTION']) AND !empty($sku['PROPERTIES'][$prop_code]['DESCRIPTION'])) {
            foreach ($sku['PROPERTIES'][$prop_code]['DESCRIPTION'] as $k=>$prop_name) {
                if (!$arResult['SKU_PROP_SET'][trim($prop_name)]) {
                    $val = $sku['PROPERTIES'][$prop_code]['VALUE'][$k];
                    if (empty($_REQUEST['param'][$prop_name])) {
                        $sku_props_correct[$prop_name][$val]++;
                    }
                }
            }
        }
    }
    if (is_array($sku_props_correct)) {
        echo "<span class='product-price__text'>уточните ".implode(", ", array_keys($sku_props_correct))."</span>";
    }
    ?>

<?elseif($arResult['FINAL_SKU']):?>

    <?=price($arResult['FINAL_SKU']['PRICE']['PRICE'], $arResult['FINAL_SKU']['PRICE']['CURRENCY'])?>
    <script>
    $(function(){
        $('#add2cart_form_do').val('add2cart');
        $('#add2cart_form_id').val('<?=$arResult['FINAL_SKU']['ID']?>');

    });
    </script>

<?else:?>
    не найден
<?endif;?>
