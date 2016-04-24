<?
$filter_props = false;
$arResult['CURRENT_FILTER'] = array();
if (is_array($_GET) AND !empty($_GET) AND is_array($arParams['FILTER_PROPS'])) {
    $filter_props = array_intersect($arParams['FILTER_PROPS'], array_keys($_GET));
}

if (is_array($filter_props) AND !empty($filter_props)) {
    foreach ($filter_props as $filter_prop) {
        $arResult['CURRENT_FILTER'][$filter_prop] = $_GET[$filter_prop];
    }
}

// Определим текущие настройки фильтра
if ($_GET['prop'] OR $_GET['price']) {
    if (is_array($_GET['prop'])) $arResult['CURRENT_FILTER']['prop'] = $_GET['prop'];
    if (floatval($_GET['price']['min'])>0) $arResult['CURRENT_FILTER']['price']['min'] = floatval($_GET['price']['min']);
    if (floatval($_GET['price']['max'])>0) $arResult['CURRENT_FILTER']['price']['max'] = floatval($_GET['price']['max']);
}
?>
<?if (!empty($arResult['CURRENT_FILTER']) AND is_array($arResult['CURRENT_FILTER'])):?>
    <script>
    $(function(){
	    <?foreach ($arResult['CURRENT_FILTER'] as $prop_id=>$value):?>
		    <?if (in_array($prop_id, $arParams['FILTER_PROPS'])):?>
			    <?if (is_array($value)):?>
				    <?if ($value['min'] OR $value['max']):?>
					    <?if ($value['min']):?>
						    $('#numeric-filter-<?=$prop_id?> .numeric-min').val(<?=$value['min']?>);
					    <?endif;?>
					    <?if ($value['max']):?>
						    $('#numeric-filter-<?=$prop_id?> .numeric-max').val(<?=$value['max']?>);
					    <?endif;?>
				    <?else:?>
					    <?foreach ($value as $v):?>
						    $('#prop-filter-<?=$v?> #prop_<?=$v?>').removeAttr('disabled');
						    $('#prop-filter-<?=$v?> .checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');	
					    <?endforeach;?>
				    <?endif;?>
			    <?else:?>
				    $('#prop-filter-<?=$value?> #prop_<?=$value?>').removeAttr('disabled');
				    $('#prop-filter-<?=$value?> .checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');	
			    <?endif;?>
		    <?endif;?>
	    <?endforeach;?>
	    
	    <?if (is_array($arResult['CURRENT_FILTER']['brands'])):?>
		    <?foreach ($arResult['CURRENT_FILTER']['brands'] as $brand_id):?>
		    $('#brands-filter-<?=$brand_id?> #brands_<?=$brand_id?>').removeAttr('disabled');
		    $('#brands-filter-<?=$brand_id?> .checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
		    <?endforeach;?>
	    <?endif?>
	    
	    <?if ($arResult['CURRENT_FILTER']['price']['min']):?>
		    $('#price-filter .price-min').val(<?=$arResult['CURRENT_FILTER']['price']['min']?>);
		    $('#price-filter .price-min').removeAttr('disabled');
	    <?endif?>
	    <?if ($arResult['CURRENT_FILTER']['price']['max']):?>
		    $('#price-filter .price-max').val(<?=$arResult['CURRENT_FILTER']['price']['max']?>);
		    $('#price-filter .price-max').removeAttr('disabled');
	    <?endif?>
	    
	    <?if (is_array($arResult['CURRENT_FILTER']['prop'])):?>
		    <?foreach ($arResult['CURRENT_FILTER']['prop'] as $prop_id=>$prop_values):?>
                <?if (is_array($prop_values) AND !empty($prop_values)):?>
                    <?if (isset($prop_values['min']) OR isset($prop_values['max'])):?>
                        <?if (floatval($prop_values['min'])>0):?>
                            $('#numeric-filter-<?=$prop_id?> .numeric-min').removeAttr('disabled');
                            $('#numeric-filter-<?=$prop_id?> .numeric-min').val('<?=$prop_values['min']?>');
                        <?endif;?>
                        <?if (floatval($prop_values['max'])>0):?>
                            $('#numeric-filter-<?=$prop_id?> .numeric-max').removeAttr('disabled');
                            $('#numeric-filter-<?=$prop_id?> .numeric-max').val('<?=$prop_values['max']?>');
                        <?endif;?>
                    <?else:?>
                        <?foreach ($prop_values as $enum_val):?>
                            $('#numeric-filter-<?=$prop_id?> .numeric-mix').val('<?=$enum_val?>');
                            $('#numeric-filter-<?=$prop_id?> .numeric-max').val('<?=$enum_val?>');
                            $('#product-filter-<?=$enum_val?> #prop_<?=$prop_id?>_<?=$enum_val?>').removeAttr('disabled');
                            $('#product-filter-<?=$enum_val?> .checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
                        <?endforeach;?>
                    <?endif;?>
                <?else:?>
                    <?if ($arResult['PROPERTIES'][$prop_id]['USER_TYPE']=="Checkbox" AND $prop_values==1):?>
                        $('#prop-filter-<?=$prop_id?> .checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
                        $('#prop_<?=$prop_id?>').removeAttr('disabled');
                    <?endif;?>
                <?endif;?>
		    <?endforeach;?>
	    <?endif?>
    });
    </script>
<?endif;?>