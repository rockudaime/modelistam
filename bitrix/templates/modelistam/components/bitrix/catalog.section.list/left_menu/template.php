<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>


<ul class="catalog-left-menu">
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
        <li class="<?=$class?> catalog-left-menu__item--submenu-hidden">
			<a href="<?=$sections_urls[$arSection['ID']]?>" class="catalog-left-menu__item-link"><?=$arSection['NAME']?></a>
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
			<ul class="catalog-left-menu__sub-menu">
				<li>
					<?$i=0?>
					<?foreach ($arSection['CHILDS'] as $child_section):?>
						<?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
							<?if ($i==$delimiter):?></li><li class="last"><?$set=true;?><?endif;?>
							<p class="dropdown-level_2"><a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a></p>
							<?$i++?>
						<?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
							<p class="dropdown-level_3 text-small"><a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a></p>
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

<script type="text/javascript">
    var catalogLeftMenu = {
        init: function() {
            var container = $('.catalog-left-menu');
            var topItemLinks = container.find('.catalog-left-menu__item-link');
            var cssHiddenSubMenu = 'catalog-left-menu__item--submenu-hidden';
            var cssActiveLink = 'catalog-left-menu__item-link--active';

            topItemLinks.on('click', function(e) {
                e.preventDefault();
                if ($(this).parent().hasClass(cssHiddenSubMenu)) {
                    $(this).parent().removeClass(cssHiddenSubMenu);
                    $(this).addClass(cssActiveLink);
                } else {
                    $(this).parent().addClass(cssHiddenSubMenu);
                    $(this).removeClass(cssActiveLink);
                }
            })


        }
    }
    $(function() {
        catalogLeftMenu.init();
    })
</script>