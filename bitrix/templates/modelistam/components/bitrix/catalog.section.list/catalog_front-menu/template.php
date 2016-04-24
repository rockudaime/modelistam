<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<ul class="vertical-dropdown catalog-sections-menu">
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
        <li class="<?=$class?>">
            <?if ($arSection['CHILDS']):?>
            <?endif;?>

            <a href="<?=$sections_urls[$arSection['ID']]?>"
               class="root-menu-item dir">
                <?=$arSection['NAME']?>
            </a>

            <div class="root-image-block">
                <a href="<?=$sections_urls[$arSection['ID']]?>">
                    <?if($arSection['PICTURE']['SRC']):?>
                        <img class="adaptive-img" alt="<?=$arSection['NAME']?>" src="<?=MakeImage($arSection['PICTURE']['SRC'], array('wl'=>184, 'hl'=>126, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                   <?else:?>
                        <img class="adaptive-img" alt="<?=$arSection['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                    <?endif;?>
                </a>
            </div>

            <?if ($arSection['DESCRIPTION']):?>
                <div class="root-menu-item__descr">
                    <?
                    $shortDescr = $arSection['DESCRIPTION'];;
                    if (function_exists(limit_words)) {
                        $linkToCategory = '<a href='.$sections_urls[$arSection['ID']].'> Подробнее</a>';
                        $shortDescr = limit_words($arSection['DESCRIPTION'], 30).$linkToCategory;
                    }
                    echo $shortDescr;
                    ?>
                </div>
            <?endif;?>

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
			if ($ad_module_installed) { // Задание ключевых слов для баннеров
				CAdvBanner::ResetKeywords("product_menu");
				CAdvBanner::SetDesiredKeywords($arAdvKeywords, "product_menu");
			}
			?>
			<ul>
				<li>
					<?$i=0; $iter = 0; $hiddenClass="dropdown--hidden"?>
					<?foreach ($arSection['CHILDS'] as $child_section):?>
						<?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
							<?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?>
							<div class="menu-child-item dropdown-level_2 <?if ($iter > 4) { echo $hiddenClass; }?>">
                                <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                            </div>
							<?$i++?>
						<?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
							<div class="menu-child-item dropdown-level_3 <?if ($iter > 4) { echo $hiddenClass; }?>">
                                <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                            </div>
						<?endif;?>
                    <?$iter++;?>
					<?endforeach;?>
				</li>
                <?if ($iter>4):?>
                    <li>
                    <a class="dropdown__show-all-link" href="javascript:void(0);">Все <?=$arSection['NAME']?> →</a>
                    </li>
                <?endif;?>
			</ul>
			<?endif;?>
		</li>
	<?endif;?>
<?endforeach;?>

</ul>

<script type="text/javascript">
    var verticalMenuFeatures = {
        showAllMenuItems: function() {
            var link = $('.dropdown__show-all-link');
            var hiddenCSSLinks = 'dropdown--hidden';

            if (link.length) {
                link.on('click', function() {
                    if ($(this).hasClass('link--hide')) {
                        $(this).removeClass('link--hide');
                        $(this).parent().parent('ul').find('.'+hiddenCSSLinks).hide();
                        $(this).text('Все группы →');
                    }  else {
                        $(this).addClass('link--hide');
                        $(this).parent().parent('ul').find('.'+hiddenCSSLinks).show();
                        $(this).text('← Свернуть группы');
                    }
                })
            }
        }
    }

    $(function() {
        verticalMenuFeatures.showAllMenuItems();
    })
</script>