<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<ul class="icons-catalog-menu">
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
        <li class="icons-catalog-menu__item">
            <a class="icons-catalog-menu__link" href="<?=$sections_urls[$arSection['ID']]?>" class="dir"><?=$arSection['NAME']?></a>
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
            <ul>
            <li>
                <?$i=0?>
                <?foreach ($arSection['CHILDS'] as $child_section):?>
                <?if ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+1):?>
                    <?if ($i==$delimiter):?>
				</li>
							
				<li class="last"><?$set=true;?><?endif;?>
                    <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                    <?$i++?>
                    <?elseif ($child_section['DEPTH_LEVEL']==$CURRENT_DEPTH+2):?>
                    <a href="<?=$sections_urls[$child_section['ID']]?>"><?=$child_section['NAME']?></a>
                    <?endif;?>
                <?endforeach;?>
            </li>


            </ul>
            <?endif;?>
        </li>
        <?endif;?>
    <?endforeach;?>
</ul>


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