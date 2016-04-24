<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<div class="section__items__inner" id="section-items-container">
    <ul>
        <li><a href="#tab-1">Лидеры продаж</a></li>
        <li><a href="#tab-2">Новинки</a></li>
    </ul>

    <div id="tab-1">
        <?
        $filterPopular = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0),array("!=CATALOG_PRICE_5"=>'null'));
        $hitItemsResult=$APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "ADDITIONAL_FILTER" => $filterPopular,
                "SECTION_ID" => $arResult['SECTION']['ID'],
                "INCLUDE_SUBSECTIONS" => "Y",
                "VIEWED" => "N",
                "ACTIVE" => "A",
                "ACTIVE_DATE" => "A",
                "GET_LINKED_ELEMENTS" => "Y",
                "GET_LINKED_SECTIONS" => "N",
                "FILTER_PROPS" => array(
                ),
                "SKU_ALLOW" => "Y",
                "ALLOW_BUY_NOT_EXISTING" => "Y",
                "CHECK_PERMISSIONS" => "N",
                "CATALOG_PATH" => "/catalog/",
                "DESCRIPTION_FROM_PROPS" => "N",
                "COUNT" => "8",
                "ALLOW_PAGENAV" => "N",
                "SORT_FIELD_1" => "rand",
                "SORT_DIR_1" => "desc,nulls",
                "SORT_FIELD_2" => "sort",
                "SORT_DIR_2" => "desc,nulls",
                "SORTING_PANEL_OPTIONS" => array(
                    0 => "price",
                    1 => "name",
                ),
                "SORTING_PANEL_OPTIONS_price" => "",
                "SORTING_PANEL_OPTIONS_name" => "",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "3600",
                "CACHE_WITH_FILTER" => "N",
                "CACHE_WITH_SORTING" => "N",
                "CACHE_WITH_PAGING" => "N",
                "SET_TITLE" => "N",
                "CODE" => "hit",
                "SCROLL_SKIP" => "3",
                "BLOCK_TITLE" => "Лидеры продаж",
                "BLOCK_URL" => "/catalog/hit/",
                "BLOCK_URL_TITLE" => "",
                "BLOCK_IMAGE_SRC" => "/bitrix/templates/main/images/pic-hit.png"
            ),
            $component
        );
        ?>
    </div>

    <div id="tab-2">
        <?
        $filterNew = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0));
        $hitItemsResult=$APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "ADDITIONAL_FILTER" => $filterNew,
                "SECTION_ID" => $arResult['SECTION']['ID'],
                "INCLUDE_SUBSECTIONS" => "Y",
                "VIEWED" => "N",
                "ACTIVE" => "A",
                "ACTIVE_DATE" => "A",
                "GET_LINKED_ELEMENTS" => "Y",
                "GET_LINKED_SECTIONS" => "N",
                "FILTER_PROPS" => array(
                ),
                "SKU_ALLOW" => "Y",
                "ALLOW_BUY_NOT_EXISTING" => "Y",
                "CHECK_PERMISSIONS" => "N",
                "CATALOG_PATH" => "/catalog/",
                "DESCRIPTION_FROM_PROPS" => "N",
                "COUNT" => "8",
                "ALLOW_PAGENAV" => "N",
                "SORT_FIELD_1" => "id",
                "SORT_DIR_1" => "desc",
                "SORT_FIELD_2" => "sort",
                "SORT_DIR_2" => "desc",
                "SORTING_PANEL_OPTIONS" => array(
                    0 => "price",
                    1 => "name",
                ),
                "SORTING_PANEL_OPTIONS_price" => "",
                "SORTING_PANEL_OPTIONS_name" => "",
                "CACHE_TYPE" => "N",
                "CACHE_TIME" => "3600",
                "CACHE_WITH_FILTER" => "N",
                "CACHE_WITH_SORTING" => "N",
                "CACHE_WITH_PAGING" => "N",
                "SET_TITLE" => "N",
                "CODE" => "new",
                "SCROLL_SKIP" => "3",
                "BLOCK_TITLE" => "Новинки",
                "BLOCK_URL" => "",
                "BLOCK_URL_TITLE" => "",
                "BLOCK_IMAGE_SRC" => ""
            ),
            $component
        )
        ;?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $('#section-items-container').tabs();
    })
</script>