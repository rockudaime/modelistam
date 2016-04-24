<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<ul class="dropdown dropdown-vertical i-clearfix icons-catalog-menu">
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
        <?$class="count-".$counter." ";
        //if ($counter==count($arResult["SECTIONS"])) $class .= "last";
        if (!$arSection['CHILDS']) $class .= " no_hover";
        ?>
        <li class="<?=$class?> dropdown__gen icons-catalog-menu__item">
            <?if ($arSection['CHILDS']):?>
            <?endif;?>
            <div class="main-menu-item-primary">
                <a href="<?=$sections_urls[$arSection['ID']]?>" class="dir dropdown__gen__link icons-catalog-menu__link">
                    <span>
                        <?=$arSection['NAME']?>
                    </span><i></i>
			    </a>
            </div>
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
                                                        <h6 class="dropdown-level_2">
                                                            <a href="<?=$sections_urls[$child_section['ID']]?>" class="text-bold"><?=$child_section['NAME']?></a><i></i>
                                                        </h6>

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
							                                <p class="dropdown-level_3"><a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a></p>
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





<script>
    $(document).mouseover(function() {
        $('.icon-hover-element-item .icons-catalog-menu__link').removeClass("icon-hover-element");
        $('.icons-catalog-menu__item').removeClass("icon-hover-element-item");
        $('.icons-catalog-menu__item:hover').addClass("icon-hover-element-item");
        $('.icon-hover-element-item .icons-catalog-menu__link').addClass("icon-hover-element");
    });
    /*
    $(document).mouseout(function() {
        $('.icons-catalog-menu__link:hover').removeClass("icon-hover-element");
        $('.icons-catalog-menu__link:hover').addClass("icon-hover-element");
    });*/
</script>
<script type="text/javascript">
	BIS.menuCustomModule = {
		elems: {
			dropDown: {},
			itemsKlm1: {},
			itemsKlm2innerElems: {},
			itemsKlm2: {},
			lisDesc: {},
            linkDesc: {}
		},
		init: function() {
            var wWidth = $(window).width();
			//populate elems
			this.elems.dropDown =  $('#main-menu').find('ul.dropdown-vertical');
			this.elems.itemsKlm1 = this.elems.dropDown.find('.klm1');
			this.elems.itemsKlm2innerElems = this.elems.itemsKlm1.find('.dropdown-level_2');
			this.elems.itemsKlm2 = this.elems.dropDown.find('.klm2');
			this.elems.lisDesc = this.elems.dropDown.find('>li');
            this.elems.linksDesc = this.elems.lisDesc.find('.dropdown__gen__link');

			//invoke methods
            this.addCssClassForItems();
            if (wWidth <= 755) {
                this.menuHoverDelayMobile();
            } else {
                this.menuHoverDelayDesktop();
            }
			this.hoverMenuChilds();
            this.addActiveMenuItem();
		},
        addActiveMenuItem: function() {
            var menu = $('#main-menu').find('>.dropdown ');
            var items = menu.find('.dropdown__gen');
            var curUrl = document.location.href;
            var curItemUrl;
            items.each(function() {
                curItemUrl = $.trim($(this).find('.dropdown__gen__link').attr('href'));
                if (curUrl.indexOf(curItemUrl) != -1) {
                    $(this).addClass('active');
                }
            })
        },
		addCssClassForItems: function() {
			this.elems.itemsKlm1.has('.klm2').find('.dropdown-level_2').addClass('has-sub-menu');
		},
		menuHoverDelayDesktop: function() {
			var self = this,
				related,
				curItem;

			self.elems.lisDesc.hoverIntent({
				over: function(e) {
					e = e || window.event;
					related = e.relatedTarget || e.fromElement;
					curItem = $(this);

					try {
						if (related.tagName == 'A' || related.tagName == 'LI'); {
							self.elems.lisDesc.find('>ul').hide();
						}
					} catch(e) {
						//nothing
					}

					curItem.find('>ul').show();
				},
				out: function() {
					$(this).find('>ul').hide();
				},
				timeout: 300
			});
		},
        menuHoverDelayMobile: function() {
            var self = this;

            self.elems.linksDesc.on({
                'click': function(e) {
                    e.preventDefault();
                    $(this).parents('.dropdown__gen').find('>ul').toggle();
                }
            });
        },
		hoverMenuChilds: function() {
			var sibling;

			this.elems.itemsKlm2.on({
				'mouseenter': function(e) {
					sibling = $(e.currentTarget).siblings('.dropdown-level_2').addClass('active');
				},
				'mouseleave': function() {
					sibling.removeClass('active');
				}
			});
		}
	}

	//init menuCustomModule
	$(function() {
		BIS.menuCustomModule.init();
	});


</script>

