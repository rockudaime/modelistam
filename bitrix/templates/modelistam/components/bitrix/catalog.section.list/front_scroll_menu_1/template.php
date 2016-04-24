<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>


<script type="text/javascript">
    $(function() {
        $("#menu-slider-<?=$arParams['SECTION_ID']?>").jcarousel({
            scroll: 4,
            buttonNextHTML: null,
            buttonPrevHTML: null,
            itemFallbackDimension: 200
        });
    });
</script>

<div class="front-menu-main-container" id="menu-slider-<?=$arParams['SECTION_ID']?>">

    <div class="front-inner-container">

        <? //d($arResult["SECTIONS"]); ?>
        <ul class="front-menu-list jcarousel-list i-clearfix">

        <?
        CModule::IncludeModule('bexx');
        $CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1; // $arResult["SECTION"] - текущий раздел
        $sections = $arResult["SECTIONS"];
        $parent = false;
        $arResult["SECTIONS"] = array();
        $sections_ids = array();
        foreach($sections as $arSection) {
            $sections_ids[] = $arSection['ID'];
            if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH) { // первый уровень
                $arResult["SECTIONS"][$arSection['ID']] = $arSection;
                $parent = $arSection['ID'];
            } else { // второй уровень
                if ($parent) {
                    $arResult["SECTIONS"][$parent]['CHILDS'][] = $arSection;
                }
            }
        }

        $sections_urls = CBexxShop::GetSectionUrl($sections_ids); // реальные пути разделов

    // Если установлен модуль рекламы, задействуем его
        $ad_module_installed = IsModuleInstalled("advertising");
        if ($ad_module_installed) {
            CModule::IncludeModule("advertising");
        }
        $counter = 0;
        ?>
        <?foreach($arResult["SECTIONS"] as $arSection):?>
        <?$counter++;?>
        <?if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH):?>
            <?$class="";
            if ($counter==count($arResult["SECTIONS"])) $class .= "last";
            if (!$arSection['CHILDS']) $class .= " no_hover";
            ?>
        <li class="<?=$class?> front-menu-list__item jcarousel-item">

            <? /* Картинка главной категории  */ ?>
            <div class="front_menu-list__item-image-block">
                <?//BH-3?>
                <?if(isset($arSection["PICTURE"])):?>
					<? $timestamp = getdate();
					   $minPictureParams = array('w'=>105, 'h'=>69, 'zc'=>0, 'q'=>100, 'aoe'=>0, 'far'=>"C");
				?>
                    <img src="<?=MakeImage($arSection['PICTURE']['SRC'], 105, 86400*30, $minPictureParams)."?v=".$timestamp['seconds']?>" alt="<?=$arSection['NAME']?>" title="<?=$arSection['NAME']?>" class="front_menu-list__item-image" />
                <?else:?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/bosch/ui-no-image.png" alt="<?=$arSection['NAME']?>" title="<?=$arSection['NAME']?>" class="front_menu-list__item-image" />
                <?endif;?>  
                <?//BH-3?>    
            </div>

            <a href="<?=$sections_urls[$arSection['ID']]?>" class="dir front-menu-list__anchor"><?=$arSection['NAME']?></a>
            <?if ($arSection['CHILDS']):?>
                <?
                // Расчет разделения на две части меню
                $set = false;
                $arAdvKeywords = array();
                $parts = array();

                //Bosch
                $parts_depth_1 = array();
                $parts_depth_2 = array();
                $parts_depth_for_find = array();
                //Bosch

                // Считаем дочек в папах
                if (is_array($arSection['CHILDS'])) {
                    $delimiter = 0;
                    foreach ($arSection['CHILDS'] as $s) {
                        if ($ad_module_installed) $arAdvKeywords[] = $s['NAME'];
                        if ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+1) {
                            $parts[$s['ID']] = 1;

                            //Bosch
                            $qnt = 0;
                            $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$s['ID']] = array(
                                "QNT" => $qnt
                            );
                            //Bosch

                        } elseif ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+2) {
                            $parts[$s['IBLOCK_SECTION_ID']]++;

                            //Bosch
                            $key = array_search($s['IBLOCK_SECTION_ID'], $parts_depth_for_find);
                            if ($key === false) {
                                $parts_depth_for_find[] = $s['IBLOCK_SECTION_ID'];
                                $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$s['IBLOCK_SECTION_ID']] = array(
                                    "QNT" => 1,
                                    "IBLOCK_SECTION_ID" => $s['IBLOCK_SECTION_ID']
                                );
                            }
                            else
                            {
                                $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$s['IBLOCK_SECTION_ID']]['QNT']++;
                            }
                            //Bosch

                        }
                    }
                    if (is_array($parts)) { // Этот злоебучий алгоритм может захватить вселенную
                        $count = count($parts);
                        if ($count>1) {
                            $center_detected = false;
                            for ($i=0; $i<$count; $i++) {
                                $first_part = array_sum(array_slice($parts, 0, $i));
                                $last_part = array_sum(array_slice($parts, $i, $count-$i));
                                if ($first_part>=$last_part AND $i<$count AND !$center_detected) {
                                    $center_detected = true;
                                    $delimiter = $i;
                                    break;
                                } elseif ($i+1==$count) {
                                    $delimiter = $i;
                                }
                            }
                        }
                    }
                }
                if ($ad_module_installed) { // Задание ключевых слов для баннеров
                    CAdvBanner::ResetKeywords("product_menu");
                    CAdvBanner::SetDesiredKeywords($arAdvKeywords, "product_menu");
                }
                ?>
			<ul class="front-menu-list__submenu">
				<li>
					<?$i=0?>

                <?$flag=false?>
                <?foreach ($arSection['CHILDS'] as $child_section):?>
                    <?if ($flag==false){
                        $qnt = $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$child_section['ID']]['QNT'];
                        $flag=true;
                    }?>


                    <?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
                        <?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?>

                                                    <ul class="klm1">
                                                        <li front-menu-list__item-level_2>
                                                            <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>

                        <?if (($qnt !== 0) and ($flag==true)):?>
                                                            <ul class="klm2">
                                                        <?endif;?>

                        <?if ($qnt == 0):?>
                                                            </li>
                                                            </ul>
                                                            <?$flag=false;?>
                            <?endif;?>

                        <?$i++?>
                        <?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
                        <li class="front-menu-list__item-level_3">
                            <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                        </li>
                        <?$qnt = $qnt  - 1;?>
                        <?if ($qnt == 0):?>
                            <?$flag=false;?>
                                                              </ul>
                                                              </li>
                                                            </ul>
                                                        <?endif;?>
                        <?endif;?>
                    <?endforeach;?>

                </li>
                <?if ($ad_module_installed):?>
                    <li class="last">
                        <div>
                            <div style="padding: 0 10px 10px 0">
                                <?$APPLICATION->IncludeComponent(
                                "bitrix:advertising.banner",
                                "",
                                Array(
                                    "TYPE" => "product_menu",
                                    "CACHE_TYPE" => "A",
                                    "CACHE_TIME" => 911+$arSection['ID']
                                ),
                                false
                            );?>
                            </div>
                        </div>
                    </li>
                    <?endif;?>
                </ul>
                <?endif;?>
            </li>
            <?endif;?>
        <?endforeach;?>
        </ul>


    </div>

    <div class="jcarousel-control jcarousel-control-horizontal">
        <div id="product-<?=$arParams['SECTION_ID']?>-prev" class="jcarousel-prev" title="назад"></div>
        <div id="product-<?=$arParams['SECTION_ID']?>-next" class="jcarousel-next" title="еще"></div>
    </div>

</div>
