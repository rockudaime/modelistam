<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<ul class="dropdown dropdown-vertical i-clearfix icons-catalog-menu"><?
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
?><?foreach($arResult["SECTIONS"] as $arSection):?><?$counter++;?><?if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH):?><?$class="count-".$counter." ";
        //if ($counter==count($arResult["SECTIONS"])) $class .= "last";
        if (!$arSection['CHILDS']) $class .= " no_hover";
    ?><li class="<?=$class?> dropdown__gen icons-catalog-menu__item"><?if ($arSection['CHILDS']):?><?endif;?><div class="main-menu-item-primary"><div class="main-menu-item-primary_two"><a href="<?=$sections_urls[$arSection['ID']]?>" class="dir dropdown__gen__link icons-catalog-menu__link"><span><?=$arSection['NAME']?></span><i></i><?//MM-313?><img src="<? if($arSection['PICTURE']['SRC']=='') { echo "/upload/iblock/5f8/5f8a7c5727df19a8e7396212525d789d.png";  } else echo $arSection['PICTURE']['SRC'];?>" alt="" title="" style="top: -<? echo 51+$counter*34 ?>px;"/><?//MM-313?></a></div></div><?if ($arSection['CHILDS']):?><?
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
			?><ul class="parent-inner-menu"><li><?$i=0?><?$flag=false?><?foreach ($arSection['CHILDS'] as $child_section):?><?if ($flag==false){$qnt = $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$child_section['ID']]['QNT']; $flag=true;}?><?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?><?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?> <ul class="klm1"><li class="icons-catalog-menu__item-level_2"><h6 class="dropdown-level_2"><?if ($child_section['CODE'] ==''):?><div class="menu_child_off"><?=$child_section['NAME']?></div><?else:?><?//if ($child_section['EXTERNAL_ID'] == 'menu_links'):?><?if ($child_section['PICTURE']):?><a href="<?=$child_section['CODE']?>" class="text-bold"><img src="<?=$child_section['PICTURE']['SRC']?>" alt="" title=""/><?=$child_section['NAME']?></a><?else:?><a href="<?=$sections_urls[$child_section['ID']]?>" class="text-bold icons-catalog-menu__link-level_2"><?=$child_section['NAME']?><i <? if ($child_section['ID']=='3051') echo 'style="    margin-top: -15px;"'; ?>></i></a><?endif;?><?endif;?></h6><?if (($qnt !== 0) and ($flag==true)):?><ul class="klm2 parent-inner-menu__level2"><?endif;?><?if ($qnt == 0):?></li></ul><?$flag=false;?><?endif;?><?$i++?><?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
<li><?if ($child_section['CODE'] ==''):?><h6 class="just-text"><p><?=$child_section['NAME']?></a><i></i></p></h6>
<?else:?><h6 class="dropdown-level_3"><a href="<?=$sections_urls[$child_section['ID']]?>" class="text-bold"><?=$child_section['NAME']?></a><i></i></h6><?endif;?></li><?$qnt = $qnt  - 1;?><?if ($qnt == 0):?><?$flag=false;?></ul></li></ul><?endif;?><?endif;?><?endforeach;?></li></ul><?endif;?></li><?endif;?><?endforeach;?></ul>