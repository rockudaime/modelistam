<div class="category-top-items-block">
    <?
    //Автомобили
    $filterViewed = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0),array("!=CATALOG_QUANTITY"=>0));

    $hitItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "category_top_items", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            "ADDITIONAL_FILTER" => $filterViewed,
            //"VIEWED" => "Y",
            "SECTION_ID" => "2744",
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
            "COUNT" => "1",
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
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_WITH_FILTER" => "N",
            "CACHE_WITH_SORTING" => "N",
            "CACHE_WITH_PAGING" => "N",
            "SET_TITLE" => "N",
            //"CODE" => "viewed",
            "SCROLL_SKIP" => "3",
            "BLOCK_TITLE" => "Автомобили",
            "BLOCK_URL" => "",
            "BLOCK_URL_TITLE" => "",
            "BLOCK_IMAGE_SRC" => ""
        ),
        $component
    );
    ?>
</div>
<div class="category-top-items-block">
    <?
    //Самолеты
    //$filterViewed = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0),array("!=CATALOG_QUANTITY"=>0));

    $hitItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "category_top_items", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            "ADDITIONAL_FILTER" => $filterViewed,
            //"VIEWED" => "Y",
            "SECTION_ID" => "2801",
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
            "COUNT" => "1",
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
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_WITH_FILTER" => "N",
            "CACHE_WITH_SORTING" => "N",
            "CACHE_WITH_PAGING" => "N",
            "SET_TITLE" => "N",
            //"CODE" => "viewed",
            "SCROLL_SKIP" => "3",
            "BLOCK_TITLE" => "Самолеты",
            "BLOCK_URL" => "",
            "BLOCK_URL_TITLE" => "",
            "BLOCK_IMAGE_SRC" => ""
        ),
        $component
    );
    ?>
</div>
<div class="category-top-items-block">
    <?
    //Вертолеты
    //$filterViewed = array("LOGIC"=>"AND",array("!=DETAIL_PICTURE"=>false),array("!=CATALOG_PRICE_5"=>0),array("!=CATALOG_QUANTITY"=>0));

    $hitItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "category_top_items", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            "ADDITIONAL_FILTER" => $filterViewed,
            //"VIEWED" => "Y",
            "SECTION_ID" => "2792",
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
            "COUNT" => "1",
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
            "CACHE_TYPE" => "A",
            "CACHE_TIME" => "3600",
            "CACHE_WITH_FILTER" => "N",
            "CACHE_WITH_SORTING" => "N",
            "CACHE_WITH_PAGING" => "N",
            "SET_TITLE" => "N",
            //"CODE" => "viewed",
            "SCROLL_SKIP" => "3",
            "BLOCK_TITLE" => "Вертолеты",
            "BLOCK_URL" => "",
            "BLOCK_URL_TITLE" => "",
            "BLOCK_IMAGE_SRC" => ""
        ),
        $component
    );
    ?>
</div>
<div class="category-top-items-block">
<?$APPLICATION->IncludeComponent("bis:catalog.section.list", "front_scroll_menu_1", array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "26",
        "SECTION_ID" => "",
		"ADDITIONAL_FILTER" => array("!ID"=>array("2744", "2801", "2792")),
        //"ADDITIONAL_FILTER" => array("!=DETAIL_PICTURE"=>false),
        "SECTION_CODE" => "",
        "COUNT_ELEMENTS" => "Y",
        "TOP_DEPTH" => "1",
        "SECTION_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SECTION_USER_FIELDS" => array(
            0 => "",
            1 => "",
        ),
        "SECTION_URL" => "",
        "CACHE_TYPE" => "A",
        "CACHE_TIME" => "86400",
        "CACHE_GROUPS" => "N",
        "ADD_SECTIONS_CHAIN" => "N"
    ),
    false
);?>
</div>