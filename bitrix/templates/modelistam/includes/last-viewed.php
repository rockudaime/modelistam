<div class="last-viewed-block">
    <?
    //TM-8
    //$filterViewed = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0));
    //TM-8
    $hitItemsResult=$APPLICATION->IncludeComponent("bexx:catalog.items", "viewed_sidebar", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            //TM-8
            //"ADDITIONAL_FILTER" => $filterViewed,
            "VIEWED" => "Y",
            //TM-8
            "SECTION_ID" => "",
            "INCLUDE_SUBSECTIONS" => "Y",
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
            "COUNT" => "4",
            "ALLOW_PAGENAV" => "N",
            "SORT_FIELD_1" => "",
            "SORT_DIR_1" => "",
            "SORT_FIELD_2" => "",
            "SORT_DIR_2" => "",
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
            "CODE" => "viewed",
            "SCROLL_SKIP" => "3",
            "BLOCK_TITLE" => "Вы смотрели",
            "BLOCK_URL" => "",
            "BLOCK_URL_TITLE" => "",
            "BLOCK_IMAGE_SRC" => ""
        ),
        $component
    );
    ?>
</div>