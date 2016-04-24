<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<ul class="catalog-front-menu">
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
<?foreach($arResult["SECTIONS"] as $arSection):?>
    <?$counter++;?>
	<?if ($arSection['DEPTH_LEVEL']==$CURRENT_DEPTH):?>
        <?$class="";
        if ($counter==count($arResult["SECTIONS"])) $class .= "last";
        if (!$arSection['CHILDS']) $class .= " no_hover";
        ?>

        <li class="<?=$class?>">

            <a  class="catalog-front-menu__item-image" href="<?=$sections_urls[$arSection['ID']]?>">
                <?if ($arSection['PICTURE']['SRC']):?>
                    <img class="adaptive-img" src="<?=MakeImage($arSection['PICTURE']['SRC'], array('w'=>184, 'h'=>126, 'zc'=>0, 'q'=>100, 'aoe'=>0, 'far'=>"C"));?>" alt="<?=$arSection['NAME'];?>" />
                <?else:?>
                    <img class="adaptive-img" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" alt="<?=$arSection['NAME'];?>" />
                <?endif;?>
            </a>

            <div class="catalog-front-menu__item-inner">

                <a href="<?=$sections_urls[$arSection['ID']]?>"
                   class="catalog-front-menu__item-name">
                    <?=$arSection['NAME']?>
                </a>

            <?if ($arSection['CHILDS']):?>
			<?
			// Расчет разделения на две части меню
			$set = false;
			$arAdvKeywords = array();
			$parts = array();
			// Считаем дочек в папах
			if (is_array($arSection['CHILDS'])) {
				$delimiter = 0;
				foreach ($arSection['CHILDS'] as $s) {
					if ($ad_module_installed) $arAdvKeywords[] = $s['NAME'];
					if ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+1) {
						$parts[$s['ID']] = 1;
					} elseif ($s['DEPTH_LEVEL']==$CURRENT_DEPTH+2) {
						$parts[$s['IBLOCK_SECTION_ID']]++;
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
			<div class="catalog-front-menu__bottom">
                <ul class="catalog-front-menu__sub-menu">
                    <li>
                        <?$i=0?>
                        <?foreach ($arSection['CHILDS'] as $child_section):?>
                            <?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
                                <?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?>
                                <div class="catalog-front-menu__sub-menu__item dropdown-level_2"><a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a></div>
                                <?$i++?>
                            <?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
                                <div class="catalog-front-menu__sub-menu__item  dropdown-level_3"><a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a></div>
                            <?endif;?>
                        <?endforeach;?>
                    </li>
                </ul>
            </div>
			<?endif;?>
            </div>

		</li>
	<?endif;?>
<?endforeach;?>
</ul>