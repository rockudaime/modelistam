<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

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
					   $minPictureParams = array('w'=>86, 'h'=>45, 'zc'=>0, 'q'=>100, 'aoe'=>0, 'far'=>"C");
				?>
					<a href="<?=$sections_urls[$arSection['ID']]?>">
                    <img src="<? if ($arSection['PICTURE']['SRC']=='') echo '/bitrix/templates/modelistam/images/img_prv_tehn.png'; else echo MakeImage($arSection['PICTURE']['SRC'], 86, 86400*30, $minPictureParams)."?v=".$timestamp['seconds']; ?>" alt="<?=$arSection['NAME']?>" title="<?=$arSection['NAME']?>" class="front_menu-list__item-image" />
					</a>
                <?else:?>
                    <img src="<?=SITE_TEMPLATE_PATH?>/images/bosch/ui-no-image.png" alt="<?=$arSection['NAME']?>" title="<?=$arSection['NAME']?>" class="front_menu-list__item-image" />
                <?endif;?>  
                <?//BH-3?>    
            </div>

            <a href="<?=$sections_urls[$arSection['ID']]?>" class="dir front-menu-list__anchor"><p><?=$arSection['NAME']?></p></a>

            </li>
            <?endif;?>
        <?endforeach;?>
        </ul>


    </div>

</div>
