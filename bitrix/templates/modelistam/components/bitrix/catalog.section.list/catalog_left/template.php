<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<div class="catalog-left-wrap">
    <div class="catalog-left-wrap__title">
        Каталог товаров
    </div>

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
    $counter = 0;
    ?>

    <div class="catalog-left__inner">

        <div class="catalog-left__inner-current">
            <? if ($arResult['SECTION']['NAME'] || strstr($_SERVER['REQUEST_URI'], '/catalog/') !== false):?>
                <?
                $parentCategoryUrl = CBexxShop::GetSectionUrl($arResult['SECTION']['ID']);
                $cssCatalog = 'is-catalog-inner';
                ?>
                <?if ($arParams['CURRENT_SECTION_ID']==$arResult['SECTION']['ID']):?>
                    <span><?=$arResult['SECTION']['NAME'];?></span>
                <?else:?>
                    <a href="<?=$parentCategoryUrl?>"><?=$arResult['SECTION']['NAME'];?></a>
                <?endif;?>
            <?else:?>
                <?$cssCatalog = 'not-in-catalog';?>
                <span>Каталог товаров</span>
            <?endif;?>
        </div>

        <ul class="catalog-left-menu <?=$cssCatalog;?>">

        <?foreach($arResult["SECTIONS"] as $arSection):?>
            <?$counter++;
            $cssActiveLink = '';
            ?>
            <?if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH):?>
                <?$class="";
                if ($counter==count($arResult["SECTIONS"])) $class .= "last";
                if (!$arSection['CHILDS']) $class .= " no_hover";
                ?>
                <?
                if ($arParams['CURRENT_SECTION_ID'] == $arSection['ID']) {
                    $cssActiveLink = 'catalog-left-menu__item--active';
                } elseif (is_array($arSection['CHILDS'])) {
                    foreach($arSection['CHILDS'] as $arSectionChild) {
                        if ($arParams['CURRENT_SECTION_ID'] == $arSectionChild['ID']) {
                            $currentSectionChildId = $arSectionChild['ID'];
                            $cssActiveLink = 'catalog-left-menu__item--child-active';
                            break;
                        }
                    }
                }
                ?>
                <li class="<?=$class?> <?=$cssActiveLink;?> catalog-left-menu__item--submenu-hidden">
                    <a href="<?=$sections_urls[$arSection['ID']]?>" class="catalog-left-menu__item-link"><?=$arSection['NAME']?></a>
                    <span class="catalog_left_menu__item__icon"></span>

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
                    ?>


                    <ul class="catalog-left-menu__sub-menu">
                        <li>
                            <?$i=0?>

                            <?$flag=false?>
                            <?foreach ($arSection['CHILDS'] as $child_section):?>
                            <?$cssActiveChild = '';?>
                            <?if ($currentSectionChildId == $child_section['ID']) {
                                $cssActiveChild = 'dropdown-level--active';
                            }?>
                            <?if ($flag==false){
                                $qnt = $parts_depth_1['CHILDS_DEPTH_LEVEL_2'][$child_section['ID']]['QNT'];
                                $flag=true;
                            }?>


                            <?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
                            <?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?>

                            <ul class="klm1">
                                <li>
                                    <p class="dropdown-level_2 <?=$cssActiveChild?>">
                                        <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                                        <span></span>
                                    </p>

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
                                <p class="dropdown-level_3  <?=$cssActiveChild?>">
                                    <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                                    <span></span>
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

                    </ul>
                    <?endif;?>
                </li>
            <?endif;?>
        <?endforeach;?>
        </ul>
    </div>
</div>


<script type="text/javascript">
    var catalogLeftMenuObj = {
        init: function() {
            var container = $('.catalog-left-menu');
            var klm2List = container.find('.klm2');
            var cssActive = 'dropdown-level--active';
            var current;
            var currentKlm2;

            if (klm2List.length) {
                klm2List.each(function() {
                    current = $(this).find('.'+cssActive);
                    if (current) {
                        currentKlm2 = current.parents('.klm2');
                        currentKlm2.show();
                    }
                })
            }
        }
    }
    $(function() {
        catalogLeftMenuObj.init();
    })
</script>


