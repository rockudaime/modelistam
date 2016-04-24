
<div class="page-main-menu-wrap" id="parent2">
<div class="item_menu_fon_bg"></div>
    <div id="main-menu" class="page-main-menu i-clearfix">
        <?
        /*$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "template_icons_custom", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "COUNT_ELEMENTS" => "N",
                "TOP_DEPTH" => "4",
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
                "CACHE_TIME" => "3600",
                "CACHE_GROUPS" => "N",
                "ADD_SECTIONS_CHAIN" => "N"
            ),
            false
        );*/

        $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "template_icons_custom", array(
                "IBLOCK_TYPE" => "info",
                "IBLOCK_ID" => "101742",
                "SECTION_ID" => "",
                "SECTION_CODE" => "",
                "COUNT_ELEMENTS" => "N",
                "TOP_DEPTH" => "3",
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
                "CACHE_TIME" => "1",
                "CACHE_GROUPS" => "N",
                "ADD_SECTIONS_CHAIN" => "N"
            ),
            false
        );

		//комплектующие
        $APPLICATION->IncludeComponent("bis:catalog.custom.section.list", "template_icons_custom", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "ADD_FILTER" => array("3241", "3232", "3256"),
                "SECTION_CODE" => "",
                "COUNT_ELEMENTS" => "N",
                "TOP_DEPTH" => "4",
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
                "CACHE_TIME" => "1",
                "CACHE_GROUPS" => "N",
                "ADD_SECTIONS_CHAIN" => "N",
                "DOP_SECTIONS" => "Y",

            ),
            false
        );


        ?>
    </div>
</div>

<!--<div class="front-catalog-menu last">
    <div class="front-catalog-menu__title">
        Комплектующие
    </div>
    <?
   /* $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "template_icons", array(
        "IBLOCK_TYPE" => "catalog",
        "IBLOCK_ID" => "26",
        "SECTION_ID" => "",
        "SECTION_CODE" => "",
        "COUNT_ELEMENTS" => "N",
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
        "CACHE_TIME" => "3600",
        "CACHE_GROUPS" => "N",
        "ADD_SECTIONS_CHAIN" => "N"
        ),
        false
    );
    */?>
</div>-->