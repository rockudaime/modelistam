<?
/******************
 * ВАЖНО! для работы аякса нормально!
 * Обязательно в вызове каждого компонента указывать уникальный код:
 * "CODE" => "motorcycle",
 * а также в poly_items\template.php:
 * на строчке 23 добавить в переменную:
 * var arrWithCodes = arrWithCodes || ['new','hit', 'similar', 'viewed', 'motorcycle'];
 */
?>

<div class="block-new__title">Новинки</div>

<div class="block-new__content" id="front-new-tabs">
    <ul class="front-new-tabs">
        <li><a href="#tab01">Мотоциклы</a></li>
        <li><a href="#tab02">Воздушные змеи</a></li>
        <li><a href="#tab03">Роботы, игрушки</a></li>
    </ul>

    <div id="tab01" class="tab-holder">
        <? $APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            //"ADDITIONAL_FILTER" => array("ID"=>"37929"),
            "SECTION_ID" => "2580",
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
            "COUNT" => "3",
            "DISABLE_RATING" => "Y",
            "DISABLE_BUY_FUNCTIONALITY" => "N",
            "SCROLL_ITEMS" => "3",
            "SCROLL_HIDE_NAVIGATION" => "Y",
            "SCROLL_HIDE_PAGINATION" => "Y",
            "ALLOW_PAGENAV" => "N",
            "SORT_FIELD_1" => "rand",
            "SORT_DIR_1" => "asc",
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
            "CODE" => "motorcycle",
            "BLOCK_TITLE" => "",
            "BLOCK_URL" => "",
            "BLOCK_URL_TITLE" => "",
            "BLOCK_IMAGE_SRC" => ""
            ),
            $component
        );
        ?>
    </div>

    <div id="tab02" class="tab-holder">
        <? $APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                //"ADDITIONAL_FILTER" => array("ID"=>"37929"),
                "SECTION_ID" => "2581",
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
                "COUNT" => "3",
                "DISABLE_RATING" => "Y",
                "DISABLE_BUY_FUNCTIONALITY" => "N",
                "SCROLL_ITEMS" => "3",
                "SCROLL_HIDE_NAVIGATION" => "Y",
                "SCROLL_HIDE_PAGINATION" => "Y",
                "ALLOW_PAGENAV" => "N",
                "SORT_FIELD_1" => "rand",
                "SORT_DIR_1" => "asc",
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
                "CODE" => "vozd-zmei",
                "BLOCK_TITLE" => "",
                "BLOCK_URL" => "",
                "BLOCK_URL_TITLE" => "",
                "BLOCK_IMAGE_SRC" => ""
            ),
            $component
        );
        ?>
    </div>

    <div id="tab03" class="tab-holder">
        <? $APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                //"ADDITIONAL_FILTER" => array("ID"=>"37929"),
                "SECTION_ID" => "2586",
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
                "COUNT" => "3",
                "DISABLE_RATING" => "Y",
                "DISABLE_BUY_FUNCTIONALITY" => "N",
                "SCROLL_ITEMS" => "3",
                "SCROLL_HIDE_NAVIGATION" => "Y",
                "SCROLL_HIDE_PAGINATION" => "Y",
                "ALLOW_PAGENAV" => "N",
                "SORT_FIELD_1" => "rand",
                "SORT_DIR_1" => "asc",
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
                "CODE" => "roboti-igrushki",
                "BLOCK_TITLE" => "",
                "BLOCK_URL" => "",
                "BLOCK_URL_TITLE" => "",
                "BLOCK_IMAGE_SRC" => ""
            ),
            $component
        );
        ?>
    </div>
</div>


<script>
    $(function() {
        $('#front-new-tabs').tabs();
    })
</script>