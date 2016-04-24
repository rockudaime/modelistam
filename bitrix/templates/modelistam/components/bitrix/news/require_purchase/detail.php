<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//MM-107?>
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
    $require_purchaseMetaKey    =   $detailResult['PROPERTIES']['meta_keywords']['VALUE'];
    $require_purchaseMetaDescr  =   $detailResult['PROPERTIES']['meta_description']['VALUE'];
    $require_purchaseTitle      =   $detailResult['PROPERTIES']['custom_title']['VALUE'];
    $require_purchaseh1         =   $detailResult['PROPERTIES']['custom_h1']['VALUE'];

    if (!empty($require_purchaseMetaKey)) {
        $APPLICATION->SetPageProperty("keywords", $require_purchaseMetaKey);
    }
    if (!empty($require_purchaseMetaDescr)) {
        $APPLICATION->SetPageProperty("description", $require_purchaseMetaDescr);
    }
    if (!empty($require_purchaseTitle)) {
        $APPLICATION->SetTitle($require_purchaseTitle);
    }
    ?>

    <?if (!empty($require_purchaseh1)): ?>
    <h1 class="brand-title"><?=$require_purchaseh1;?></h1>
	<?else:?>
	<h1 class="brand-title"><?=$APPLICATION->GetTitle();?></h1>
    <?endif;?>

	<?if ($detailResult['ID']):?>
        <h2>Товары <?=$detailResult['NAME']?></h2>
        <?if ($detailResult['PROPERTIES']['LINKED_ITEMS_PURCHASE']['VALUE']):?>
            <?$APPLICATION->IncludeComponent("bexx:catalog.items", "main_catalog_1", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "ADDITIONAL_FILTER" => array(
                    'ID' => $detailResult['PROPERTIES']['LINKED_ITEMS_PURCHASE']['VALUE']
                ),

                "ITEM_ID" => $arParams['ITEM_ID'],
                "ITEM_CODE" => $arParams['ITEM_CODE'],
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
                "SHOW_SLIDER" => "N",
                ),
                $component
            );?>


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
        <?endif;?>
	<?else:?>
		<?
		header("Status: 404 Not Found");
		?>
		<?=ShowError("Объект не найден")?>
	<?endif;?>
</div>