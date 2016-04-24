<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?$APPLICATION->SetPageProperty('not_show_page_title', 'Y'); ?>



<div class="news">
	<?$detailResult = $APPLICATION->IncludeComponent(
		"bexx:iblock.detail",
		"",
		Array(
            "ID" => $arResult["VARIABLES"]["ELEMENT_ID"]?$arResult["VARIABLES"]["ELEMENT_ID"]:$arResult["VARIABLES"]["ELEMENT_CODE"],
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => "0",
            "ADDITIONAL_FILTER" => "",
            "ACTIVE" => "Y",
            "ACTIVE_DATE" => "Y",
            "CHECK_PERMISSIONS" => "N",
            "SHOW_PROPERTIES_ALL" => "Y",
            "GET_LINKED_ELEMENTS" => "N",
            "GET_LINKED_SECTIONS" => "N",
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "SET_TITLE" => $arParams["SET_TITLE"],
		),
		$component
	);?>

    <?
    $brandMetaKey    =   $detailResult['PROPERTIES']['meta_keywords']['VALUE'];
    $brandMetaDescr  =   $detailResult['PROPERTIES']['meta_description']['VALUE'];
    $brandTitle      =   $detailResult['PROPERTIES']['custom_title']['VALUE'];
    $brandh1         =   $detailResult['PROPERTIES']['custom_h1']['VALUE'];

    if (!empty($brandMetaKey)) {
        $APPLICATION->SetPageProperty("keywords", $brandMetaKey);
    }
    if (!empty($brandMetaDescr)) {
        $APPLICATION->SetPageProperty("description", $brandMetaDescr);
    }
    if (!empty($brandTitle)) {
        $APPLICATION->SetTitle($brandTitle);
    }
    ?>

    <?if (!empty($brandh1)): ?>
    <h1 class="brand-title"><?=$brandh1;?></h1>
	<?else:?>
	<h1 class="brand-title"><?=$APPLICATION->GetTitle();?></h1>
    <?endif;?>

	<?if ($detailResult['ID']):?>
        <h2>Товары <?=$detailResult['NAME']?></h2>
		
		<?//d($detailResult['ID']);?>
    <div class="brand-inner">
        <?$APPLICATION->IncludeComponent("bexx:catalog.items", "main_catalog_1", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            "ADDITIONAL_FILTER" => array(
                'PROPERTY_brand' => $detailResult['ID']
            ),
            "CURRENT_VIEW" => 'block',
            "SECTION_ID" => "0",
            "INCLUDE_SUBSECTIONS" => "Y",
            "FILTER_PROPS" => "",
            "ALLOW_BUY_NOT_EXISTING" => "Y",
            "CHECK_PERMISSIONS" => "Y",
            "CHECK_ACTIVE" => "Y",
            "SORT_FIELD_1" => "id",
            "SORT_DIR_1" => "desc",
            "SORTING_PANEL_OPTIONS" => array(),
            "ALWAYS_EXISTING_FIRST" => "N",
            "USE_EXTERNAL_FILTERING" => "N",
            "DESCRIPTION_FROM_PROPS" => "N",
            "COUNT" => "20",
            "IGNORE_ITEMS_PER_PAGE" => "Y",
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "SET_TITLE" => "N",
            "COLUMNS_COUNT" => "4",
            "BLOCK_WIDTH" => "180",
            "SHOW_BORDER" => "Y",
            ),
            $component
        );?>
    </div>
        <div>
            <ul class="action-list">
                <li ><a class="arr-2-right-orange text-small" href="<?=$arResult["FOLDER"]?>"><?=$arParams['PAGER_TITLE']?$arParams['PAGER_TITLE']:"Вернуться к списку"?></a></li>
            </ul>
        </div>

        <script>
            var h1ChangePosition = {
                init: function() {
                    var h1 = $('.brand-title');
                    var navigation = $('.navigation');

                    if (navigation.length) {
                        if (h1.length) {
                            h1.insertAfter(navigation);
                        }
                    }
                }
            }
            $(function() {
                h1ChangePosition.init();
            })
        </script>

	<?else:?>
		<?
		header("Status: 404 Not Found");
		?>
		<?=ShowError("Бренд не найден")?>
	<?endif;?>
</div>