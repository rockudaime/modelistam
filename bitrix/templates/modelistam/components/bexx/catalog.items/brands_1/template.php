<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?if (is_array($arResult['ITEMS'])):?>

    <?if (strlen($arParams['BLOCK_TITLE'])):?>
    <div class="brands-container__title-block">
        <div class="detail__brands__title">
           <span><?=$arParams['BLOCK_TITLE']?></span>
        </div>
    </div>
    <?endif;?>

    <div class="brands-container__content">
        <ul class="brand-container__content-list">
            <?foreach ($arResult['ITEMS'] as $item):?>
                <li class="brand-container__content-list-item <?if ($item['ID'] == $arParams['CURRENT_BRAND_ID']):?>brand-container__content-list-item--active<?endif;?>">
                    <div class="brands-item__inner">
                        <a class="brands-item__inner-link" href="#"><?=$item['NAME'];?> <span>(<span class="brands-item__inner-count"></span>)</span></a>
                    </div>

                    <?$APPLICATION->IncludeComponent("bexx:catalog.items", "detail_brands", array(
                            "IBLOCK_TYPE" => $arParams['PARENT_IBLOCK_TYPE'],
                            "IBLOCK_ID" => $arParams['PARENT_IBLOCK_ID'],
                            "CURRENT_PRODUCT_ID" => $arParams['CURRENT_PRODUCT_ID'], //custom param
                            "ADDITIONAL_FILTER" => array(
                                'PROPERTY_brand' => $item['ID']
                            ),
                            //BSP-40
                            "SECTION_ID" => $arParams['SECT_ID'],
                            //BSP-40
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
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "SET_TITLE" => "N",
                        ),
                        $component
                    )?>
                </li>
            <?endforeach;?>
        </ul>
    </div>




<?endif;?>

