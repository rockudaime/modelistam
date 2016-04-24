<?
//PST-9
//$frame = $this->createFrame()->begin('загрузка фильтра ...');
$this->setFrameMode(true);
//PST-9
?>

<script>
$(function(){
	$('#filter-form').submit(function(){
		if ($('#price-filter .price-min').val()=='') {
			$('#price-filter .price-min').attr('disabled', "disabled");
		}
		if ($('#price-filter .price-max').val()=='') {
			$('#price-filter .price-max').attr('disabled', "disabled");
		}
		$('.numeric-min, .numeric-max').each(function() {
			if ($(this).val()=='') $(this).attr('disabled', "disabled");
		});
	});
    var filterOpener = (function() {
        var mainFilterHeader = $('.filter-main-title'),
            sidebarFilterBlock = $('.filter-inner'),
            sfBlockIsOpen = true;

        mainFilterHeader.on('click', function() {
            if (sfBlockIsOpen) {
                sfBlockIsOpen = false;
                sidebarFilterBlock.slideUp('fast');
            } else {
                sfBlockIsOpen = true;
                sidebarFilterBlock.slideDown('fast');
            }
        })
    })();
});

// Class for creating new Sliders
function classSliderUI(slider, minValue, maxValue, curMin, curMax) {
	var slider = $(slider);
	var parent = slider.siblings('.price-slider-parent');
	var minInput = parent.find('.numeric-min');
	var maxInput = parent.find('.numeric-max');
	
	var minValue = parseInt(minValue);
	var maxValue = parseInt(maxValue);
	
	var curMin = parseInt(curMin) || minValue;
	var curMax = parseInt(curMax) || maxValue;
	
	
	slider.slider({
	  range: true,
	  min: minValue,
	  max: maxValue,
	  values: [curMin, curMax],
	  slide: function( event, ui ) {
		minInput.val(ui.values[0]);
		maxInput.val(ui.values[1]);
	  }
	});
	
	
	minInput.on('change.sliderChangeMin', function() {
		curMin = parseInt($(this).val());
		curMax = parseInt(maxInput.val());
		
		if ( curMin > curMax) {
			curMin = curMax;
			minInput.val(curMin);
		}
		slider.slider("values", 0, curMin);
	})
	
	maxInput.on('change.sliderChangeMax', function() {
		curMin = parseInt(minInput.val());
		curMax = parseInt($(this).val());
		
		if ( curMax > slider.slider("option", "max")) {
			curMax = slider.slider("option", "max");
		}
		
		if (curMin > curMax) {
			curMax = curMin;
		}
		
		maxInput.val(curMax);
		slider.slider("values", 1, curMax);
	})
	
	//default input state
	minInput.attr('placeholder',slider.slider('values', 0));
	maxInput.attr('placeholder',slider.slider('values', 1));
	
	slider.slider({
		stop: function( event, ui) {
			check_items(parent);
		}
	});
}

function check_items (container) {
	$('#filter-result').hide().html('');
	ajax_load('#filter-result', '<?=$arResult['AJAX_CALL_ID']?>', $('#filter-form').serializeArray());
	$('#filter-result').css('top', $(container).offset().top-280);
}

function set_filter (val_id) {
	if ($('#prop_'+val_id).attr('disabled')) { // не активно, стало активно
		$('#prop_'+val_id).removeAttr('disabled');
		$('#prop-filter-'+val_id+' div.checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
	} else { // было неактиво, стало активно
		$('#prop_'+val_id).attr('disabled', "disabled");
		$('#prop-filter-'+val_id+' div.checkbox-black-checked').removeClass('checkbox-black-checked').addClass('checkbox-black');
	}
	check_items('#prop-filter-'+val_id);
}

function set_filter_enum (prop_id, enum_id) {
	if ($('#prop_'+prop_id+'_'+enum_id).attr('disabled')) {
		$('#prop_'+prop_id+'_'+enum_id).removeAttr('disabled');
		$('#product-filter-'+enum_id+' div.checkbox-black').removeClass('checkbox-black').addClass('checkbox-black-checked');
	} else {
		$('#prop_'+prop_id+'_'+enum_id).attr('disabled', "disabled");
		$('#product-filter-'+enum_id+' div.checkbox-black-checked').removeClass('checkbox-black-checked').addClass('checkbox-black');
	}
	check_items('#product-filter-'+enum_id);
}
function set_filter_numeric (prop_id, is_max) {
	check_items('#numeric-filter-'+prop_id);
}
function set_filter_price (is_max) {
	check_items('#price-filter');
}
</script>
<?
$arUriKillParams = array("page", "p","d","reset_sorting", "availability", "clear_cache", "s", "sort", "s_prop", "s_prop_dir", "prop", "price", "back_url"); // Эти параметры удаляются из адреса страницы в постраничной навигации
if (is_array($arParams['FILTER_PROPS']) AND !empty($arParams['FILTER_PROPS'])) $arUriKillParams = array_merge($arUriKillParams, $arParams['FILTER_PROPS']);
?>

<?$clear_url = $APPLICATION->GetCurPageParam(false, $arUriKillParams, false)?>
<div class="filter-main-title">
    Подбор по параметрам
</div>
<div class="filter-inner">
    <div class="sidebar-filter-block">
        <form id="filter-form" method="get" action="<?=$clear_url?>">
            <!--input type="hidden" name="back_url" value="<?=$clear_url?>" /-->
            <?if ($_REQUEST['accessories_for']):?>
                <?if ($arResult['PARENT_ELEMENT']['ID']>0):?>
                    <p>Показаны аксессуары для<br />
                    <a href="<?=$arResult['PARENT_ELEMENT']['DETAIL_PAGE_URL']?>"><?=$arResult['PARENT_ELEMENT']['NAME']?></a></p>
                <?endif;?>
                <input type="hidden" name="accessories_for" value="<?=intval($_REQUEST['accessories_for'])?>" />
            <?endif;?>
            <?if ($arResult['TOTAL_COUNT']>0):?>
            <div class="product-filter">
            <div class="filter-header">
                <div class="filter-total-amount">
                    <strong>Найдено: <?=$arResult['TOTAL_COUNT']?></strong>
                </div>
            </div>
                <div class="filter-values-block">
                    <a class="filter-delete" href="<?=$clear_url?>"><i></i><span>Удалить фильтры</span></a>
                </div>
            </div>
            <?endif;?>

            <div class="product-filter">
                <div class="filter-header">Цена</div>
                <div class="filter-values-block">

                    <div id="price-slider"></div>

                    <div id="price-filter" class="price-slider-parent">
                        от
                        <input class="price-min numeric-min" type="text" size="4" maxlength="10" name="price[min]" onchange="set_filter_price(0)" />
                        до
                        <input class="price-max numeric-max" type="text" size="4" maxlength="10" name="price[max]" onchange="set_filter_price(1)" />
                        <?//PST-4
                        //грн.
                        if (isset($GLOBALS["default_currency"])) {
                            $val_filtr = strtolower(trim($GLOBALS["default_currency"]));
                        } else {
                            $val_filtr = "грн";
                        }

                        if ($val_filtr == "uah"){
                            $val_filtr = "грн";
                        }elseif ($val_filtr == "rub") {
                            $val_filtr = "руб";
                        }
                        echo strtolower($val_filtr);
                        //PST-4?>



                    </div>


                    <?

                    //PM-4
                    $min_price = 20000;
                    $max_price = 0;
                    $edit_filter_price = false;
                    foreach ($arResult['ITEMS_PRICE'] as $items_price){
                                                if (intval($items_price['PRICE']) < $min_price) {
                                                    $min_price = intval($items_price['PRICE']);
                                                    $edit_filter_price = true;
                                                }
                                                if (ceil(floatval($items_price['PRICE'])) > $max_price) {
                                                    $max_price = ceil(floatval($items_price['PRICE']));
                                                    $edit_filter_price = true;
                                                }
                    }

                    if ($edit_filter_price == false) {
                                                $min_price = 0;
                                                $max_price = 20000;
                                            }
                                            //PM-4

                                //PM-4 Oleg
                                    $curMinPriceRequest = 0;
                                    $curMaxPriceRequest = 0;

                                    if (isset($_REQUEST['price']['min'])) {
                                        $curMinPriceRequest = htmlspecialcharsbx(strip_tags($_REQUEST['price']['min']));
                                    }

                                    if (isset($_REQUEST['price']['max'])) {
                                        $curMaxPriceRequest = htmlspecialcharsbx(strip_tags($_REQUEST['price']['max']));
                                    }

                                //PM-4
                    ?>

                    <script>
                        $(function() {
                            new classSliderUI('#price-slider', <?=$min_price?>, <?=$max_price?>, <?=$curMinPriceRequest?>, <?=$curMaxPriceRequest?>);
                        });
                    </script>
                </div>
            </div>

            <?if (!empty($arResult['FILTER_PROPS']) AND is_array($arResult['FILTER_PROPS'])):?>
                <?foreach ($arResult['FILTER_PROPS'] as $filter_prop):?>

                    <div class="product-filter">
                        <div class="filter-header">
                            <strong><?=$filter_prop['NAME']?></strong>
                            <span class="icon-down filterToggler" onclick="if ($(this).hasClass('icon-down')) {$(this).removeClass('icon-down').addClass('icon-up'); $('#product-filter-values-<?=$filter_prop['ID']?>').slideUp('fast');	} else { $(this).removeClass('icon-up').addClass('icon-down'); $('#product-filter-values-<?=$filter_prop['ID']?>').slideDown('fast')}"></span>
                        </div>

                        <?if ($filter_prop['PROPERTY_TYPE']=="L" OR $filter_prop['PROPERTY_TYPE']=="E"):?>
                            <div class="filter-values-block a-<? print isset($filter_prop['VALUES'])?>" id="product-filter-values-<?=$filter_prop['ID']?>">
                                <?foreach ($filter_prop['VALUES'] as $k=>$v):?>
                                    <?if ($filter_prop['COUNT'][$k] OR !isset($filter_prop['COUNT'])):?>
                                        <?if ($filter_prop['COUNT'][$k]):?>
                                            <div class="prop-filter" id="prop-filter-<?=$k?>">
                                                <input type="hidden" value="<?=$k?>" name="<?=$filter_prop['CODE']?>[]" disabled="disabled" id="prop_<?=$k?>" />
                                                <div class="float-left checkbox-black" onclick="set_filter(<?=$k?>)"></div>
                                                <div class="product-filter-link article">
                                                    <a href="<?=$APPLICATION->GetCurPageParam($filter_prop['CODE']."=".$k, array($filter_prop['CODE']), false)?>"><?=$v?></a>
                                                    <?if ($filter_prop['COUNT'][$k]):?> <em>(<?=$filter_prop['COUNT'][$k]?>)</em><?endif;?>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                        <?endif;?>
                                    <?endif;?>
                                <?endforeach;?>
                            </div>
                        <?elseif($filter_prop['PROPERTY_TYPE']=="N"):?>
                            <div id="slider-<?=$filter_prop['CODE']?>"></div>
                            <div id="numeric-filter-<?=$filter_prop['CODE']?>">
                                от <input class="numeric-min" type="text" size="4" maxlength="10" name="<?=$filter_prop['CODE']?>[min]" onchange="set_filter_numeric('<?=$filter_prop['CODE']?>', 0)" />
                                до <input class="numeric-max" type="text" size="4" maxlength="10" name="<?=$filter_prop['CODE']?>[max]" onchange="set_filter_numeric('<?=$filter_prop['CODE']?>', 1)" />
                            </div>

                            <script>
                                /*
                                $(function() {
                                    new classSliderUI("#slider-<?=$filter_prop['CODE']?>, 0, 300");
                                });
                                */
                            </script>

                        <?endif;?>
                    </div>
                <?endforeach;?>
            <?endif;?>

            <?foreach ($arResult['PROPERTIES'] as $prop):?>
                <?
                $enum_counter = 0;
                if ($prop['PROPERTY_TYPE']=="L" AND $prop['ENUM_VALUES']) {
                    foreach ($prop['ENUM_VALUES'] as $enum_value) {
                        $enum_counter += $enum_value['COUNT'];
                    }
                }
                ?>
                <?if (($prop['PROPERTY_TYPE']=="L" AND $prop['ENUM_VALUES'] AND $enum_counter) OR $prop['PROPERTY_TYPE']=="N"):?>

                    <div class="product-filter">

                        <div class="filter-header">
                            <strong><?=$prop['NAME']?></strong>
                            <span class="icon-down filterToggler" onclick="if ($(this).hasClass('icon-down')) {$(this).removeClass('icon-down').addClass('icon-up'); $('#product-filter-values-<?=$prop['ID']?>').slideUp('fast');	} else { $(this).removeClass('icon-up').addClass('icon-down'); $('#product-filter-values-<?=$prop['ID']?>').slideDown('fast')}"></span>
                        </div>
                        <div class="filter-values-block" id="product-filter-values-<?=$prop['ID']?>">
                            <?if ($prop['PROPERTY_TYPE']=="L" AND $prop['ENUM_VALUES']):?>
                                <?$hidden_set=false;
                                $count_enums = 0;?>
                                <?foreach ($prop['ENUM_VALUES'] as $enum_value):?>
                                    <?if ($enum_value['COUNT']>0):?>
                                        <?$count_enums++;?>
                                        <div class="prop-filter" id="product-filter-<?=$enum_value['ID']?>" class="separator" onclick="set_filter_enum(<?=$prop['ID']?>, <?=$enum_value['ID']?>)">
                                            <input type="hidden" value="<?=$enum_value['ID']?>" name="prop[<?=$prop['ID']?>][]" disabled="disabled" id="prop_<?=$prop['ID']?>_<?=$enum_value['ID']?>" />
                                            <div class="float-left checkbox-black"></div>
                                            <div class="product-filter-link article"><?=$enum_value['VALUE']?> <em>(<?=$enum_value['COUNT']?>)</em></div>
                                            <div class="clear"></div>
                                        </div>
                                    <?endif;?>
                                <?endforeach;?>
                            <?elseif($prop['PROPERTY_TYPE']=="N"):?>
                                <?if ($prop['USER_TYPE']=="Checkbox"):?>
                                    <div class="prop-filter" id="prop-filter-<?=$prop['ID']?>" onclick="set_filter(<?=$prop['ID']?>)">
                                        <input type="hidden" value="1" name="prop[<?=$prop['ID']?>]" disabled="disabled" id="prop_<?=$prop['ID']?>" />
                                        <div class="float-left checkbox-black"></div>
                                        <div class="product-filter-link article">Есть</div>
                                        <div class="clear"></div>
                                    </div>
                                <?else:?>
                                    <?
                                    //PM-4
                                    $min_val = 300;
                                    $max_val = 0;
                                    foreach ($arResult['ITEMS'] as $elitems){
                                        foreach ($elitems['PROPERTY_VALUES'] as $prop_value){

                                            if ($prop_value['PROP_ID'] == $prop['ID']){
                                                if ($prop_value['VALUE'] < $min_val) $min_val = $prop_value['VALUE'];
                                                if ($prop_value['VALUE'] > $max_val) $max_val = $prop_value['VALUE'];
                                            }
                                        }
                                    }
                                    //PM-4

                                    //PM-4 Oleg
                                    $curMinRequest = 0;
                                    $curMaxRequest = 0;

                                    if (isset($_REQUEST['prop'][$prop['ID']]['min'])) {
                                        $curMinRequest = htmlspecialcharsbx(strip_tags($_REQUEST['prop'][$prop['ID']]['min']));
                                    }

                                    if (isset($_REQUEST['prop'][$prop['ID']]['max'])) {
                                        $curMaxRequest = htmlspecialcharsbx(strip_tags($_REQUEST['prop'][$prop['ID']]['max']));
                                    }

                                    //PM-4

                                    $measure = "";
                                    $description = "";
                                    if ($prop['USER_TYPE']=="Measured") {
                                        $measure = str_replace("#", "", $prop['USER_TYPE_SETTINGS']['TEMPLATE']);
                                        $description = htmlspecialchars($prop['USER_TYPE_SETTINGS']['DESCRIPTION']);
                                    }
                                    ?>
                                    <div id="slider-<?=$prop['ID']?>"></div>
                                    <div class="price-slider-parent" id="numeric-filter-<?=$prop['ID']?>" title="<?=$description?>">
                                        от
                                        <input class="numeric-min" type="text" size="4" maxlength="10" name="prop[<?=$prop['ID']?>][min]" onchange="set_filter_numeric(<?=$prop['ID']?>, 0)" />
                                        до
                                        <input class="numeric-max" type="text" size="4" maxlength="10" name="prop[<?=$prop['ID']?>][max]" onchange="set_filter_numeric(<?=$prop['ID']?>, 1)" />
                                        <?=$measure?>
                                    </div>


                                    <script>
                                        $(function() {
                                            new classSliderUI("#slider-<?=$prop['ID']?>", <?=$min_val?>, <?=$max_val?>, <?=$curMinRequest?>, <?=$curMaxRequest?>);
                                        });
                                    </script>
                                <?endif;?>
                            <?endif;?>
                        </div>
                    </div>
                <?endif;?>
            <?endforeach;?>
            <input class="submit butt3 filter-button" type="submit" value="Подобрать" />
        </form>
    </div>
    <div id="filter-result"></div>
</div>
<?
//PST-9
//$frame->end();
//PST-9
?>