<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<ul class="main-menu-wrap-list">

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

    <li class="main-catalog-item">
        <a class="main-catalog-link" href="/catalog/">
            <span class="catalog-icon">
                <i></i><i></i><i></i>
            </span>
            <span>Каталог</span>
        </a>
        <ul class="main-menu-list">

        <?foreach($arResult["SECTIONS"] as $arSection):?>
            <?$counter++;?>
            <?if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH):?>
                <?$class="count-".$counter." ";
                //if ($counter==count($arResult["SECTIONS"])) $class .= "last";
                if (!$arSection['CHILDS']) {
                    $class .= " no-childs";
                } else {
                    $class .= " has-childs";
                } ;
                ?>
                <li class="dropdown__gen <?=$class?>">
                    <a href="<?=$sections_urls[$arSection['ID']]?>" class="dir dropdown__gen__link">
                        <span><?=$arSection['NAME']?></span>
                    </a>
                    <?if ($arSection['CHILDS']):?>
                    <?
                    // Расчет разделения на две части меню
                    $set = false;
                    $arAdvKeywords = array();
                    $parts = array();
                                //PM-2
                                $parts_depth_1 = array();
                                $parts_depth_2 = array();
                                $parts_depth_for_find = array();
                                //PM-2
                    // Считаем дочек в папах
                    if (is_array($arSection['CHILDS'])) {
                        $delimiter = 0;
                        foreach ($arSection['CHILDS'] as $s) {
                                            if ($ad_module_installed) $arAdvKeywords[] = $s['NAME'];
                                            if ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+1) {
                                                $parts[$s['ID']] = 1;


                                                //PM-2
                                                $qnt = 0;
                                                $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$s['ID']] = array(
                                                "QNT" => $qnt
                                                );
                                                //PM-2


                                            } elseif ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+2) {
                                                $parts[$s['IBLOCK_SECTION_ID']]++;
                                                //PM-2
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
                                                //PM-2
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
                    <ul class="parent-inner-menu">
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
                                                                <li>
                                                                    <div class="dropdown-level_2">
                                                                        <a class="parent-iner-menu__link parent-iner-menu__link--level-two" href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                                                                    </div>

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
                                                                <li>
                                                                    <p class="dropdown-level_3">
                                                                        <a class="parent-iner-menu__link parent-iner-menu__link--level-three" href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                                                                    </p>
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

                        <? /* Популярный товар */ ?>
                        <?/*<div class="menu-hits-block">
                            <div class="inside-block">
                                <div class="inner-header">
                                    <div class="inner-header__title">Популярный товар</div>
                                </div>
                                <div class="inner-block">
                                    <?$APPLICATION->IncludeComponent("bexx:catalog.items", "menu_popular_product", array(
                                        "IBLOCK_TYPE" => "catalog",
                                        "IBLOCK_ID" => "26",

                                        //PM-50
                                        //"ADDITIONAL_FILTER" => "",
                                        "ADDITIONAL_FILTER" => array(
                                        "LOGIC" => "AND",
                                        array("=PROPERTY_4392" => 56433),
                                        array("!=DETAIL_PICTURE" => false),
                                        array("!=PRICE_5" => 0)
                                        ),
                                        //PM-50

                                        "SECTION_ID" => $arSection['ID'],
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "FILTER_PROPS" => array(
                                        ),
                                        "ALLOW_BUY_NOT_EXISTING" => "Y",
                                        "CHECK_PERMISSIONS" => "N",
                                        "ACTIVE" => "Y",
                                        "ACTIVE_DATE" => "Y",
                                        "CATALOG_PATH" => "/catalog/",
                                        "DESCRIPTION_FROM_PROPS" => "N",
                                        "ALLOW_PAGENAV" => "Y",
                                        "SORT_FIELD_1" => "property_103",
                                        "SORT_DIR_1" => "desc,nulls",
                                        "SORT_FIELD_2" => "property_101",
                                        "SORT_DIR_2" => "asc,nulls",
                                        "SORTING_PANEL_OPTIONS" => array(
                                        ),
                                        "COUNT" => "1",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "86400",
                                        "CACHE_WITH_FILTER" => "N",
                                        "CACHE_WITH_SORTING" => "N",
                                        "CACHE_WITH_PAGING" => "N",
                                        "SET_TITLE" => "N",
                                        "CODE" => "hit",
                                        "SCROLL_SKIP" => "4",
                                        "BLOCK_TITLE" => "",
                                        "BLOCK_URL" => "/catalog/hit/",
                                        "BLOCK_URL_TITLE" => "все хиты продаж",
                                        "BLOCK_IMAGE_SRC" => "/bitrix/templates/main/images/pic-hit.png"
                                        ),
                                        false
                                    );?>
                                </div>
                            </div>
                        </div>
                        */ ?>


                    </ul>
                    <?endif;?>
                </li>
            <?endif;?>
        <?endforeach;?>
        </ul>
    </li>
</ul>

<script type="text/javascript">
    BIS.menuResponsiveModule = {
        init: function() {
            var wWidth = $(window).width();
            var dropDown =  $('.main-menu-wrap-list');
            var mainLink = dropDown.find('.main-catalog-link');

            if (wWidth < 780) {
                mainLink.on({
                    'click': function(e) {
                        e.preventDefault();
                        $(this).siblings('.main-menu-list').toggle();
                    }
                });
            }
        }
    }

    //init menuCustomModule
    $(function() {
        BIS.menuResponsiveModule.init();
    });


</script>
