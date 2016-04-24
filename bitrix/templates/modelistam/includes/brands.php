<div class="brand-main-inner">
    <div class="brand-title">
        <h1>Топ по брендам</h1>
    </div>
    <div class="brand-inner">
        <div class="brand-categories">
            <ul class="brand-menu">
                <li class="brand-menu-item">
                    <a data-id="top10" href="#" rel="#" class="brand-category-item"> ТОП 10</a>
                </li>
                <li class="brand-menu-item">
                    <a data-id="avia" href="#" rel="#" class="brand-category-item"> Авиа</a>
                </li>
                <li class="brand-menu-item">
                    <a data-id="korabli" href="#" rel="#" class="brand-category-item"> Корабли</a>
                </li>
                <li class="brand-menu-item">
                    <a data-id="kvadro" href="#" rel="#" class="brand-category-item"> Квадрокоптеры</a>
                </li>
                <li class="brand-menu-item">
                    <a data-id="kompl" href="#" rel="#" class="brand-category-item"> Комплектующие</a>
                </li>
            </ul>


            <script>
                /*$('.brand-menu-item').click(function(){
                    $('li').removeClass('brand-active');
                    $(this).addClass('brand-active');
                });*/
            </script>
        </div>

        <script type="text/javascript">
            BIS.BrandsObj = {
                init: function() {
                    var self = this;
                    var w = $(window);
                    var wWidth = w.width();
                    var minWidth = 640;
                    var isMobile = false;

                    self.enableMobileLinks();
                },


                enableMobileLinks: function() {
                    var links = $('.brand-category-item');
                    var blocks = $('.brands-container');
                    var blocktop10 = $('#top10');
                    var blockavia = $('#avia');
                    var blockkorabli = $('#korabli');
                    var blockkvadro = $('#kvadro');
                    var blockkompl = $('#kompl');
                    var dataId;
                    var currentBlock;
                    var cssActiveLink = 'brand-active';

                    blocktop10.hide();
                    blockavia.hide();
                    blockkorabli.hide();
                    blockkvadro.hide();
                    blockkompl.hide();

                    links.on('click.mobile', function(e) {
                        e.preventDefault();
                        blocks.hide();
                        links.parent('.brand-menu-item').removeClass(cssActiveLink);

                        dataId = $(this).data('id');
                        currentBlock = $('#'+dataId);

                        currentBlock.show();
                        $(this).parent('.brand-menu-item').addClass(cssActiveLink);
                    })
                },
                disableMobileLinks: function() {
                    var links = $('.brand-menu-item');
                    var blocks = $('.brands-container');

                    blocks.show();
                    links.off('click.mobile');
                }
            }
            $(function() {
                BIS.BrandsObj.init();
            })
        </script>

        <div id="top10" class="brands-container">
            <?$APPLICATION->IncludeComponent(
                "bexx:catalog.items",
                "brands",
                Array(
                    "IBLOCK_TYPE" => "info",
                    "IBLOCK_ID" => "25",
                    "ADDITIONAL_FILTER" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SET_TITLE" => "N",
                    "ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "SECTION_ID" => "0",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "FILTER_PROPS" => array(),
                    "ALLOW_BUY_NOT_EXISTING" => "N",
                    "CHECK_PERMISSIONS" => "N",
                    "SORT_FIELD_1" => "sort",
                    "SORT_DIR_1" => "asc",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "desc,nulls",
                    "SORTING_PANEL_OPTIONS" => array("sort"),
                    "SORTING_PANEL_OPTIONS_sort" => "",
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "DESCRIPTION_FROM_PROPS" => "N",
                    "COUNT" => "10",
                    "ALLOW_PAGENAV" => "N",
                    "ALLOW_USER_PAGENAV" => "N",
                    "CACHE_WITH_FILTER" => "N",
                    "CACHE_WITH_SORTING" => "N",
                    "CACHE_WITH_PAGING" => "N"
                ),
                $component
            );?>
        </div>

        <div id="avia" class="brands-container">
            <?$APPLICATION->IncludeComponent(
                "bis:catalog.section.brands",
                "brands",
                Array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "BRANDS_IBLOCK_ID" => "25",
                    "ADDITIONAL_FILTER" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SET_TITLE" => "N",
                    "ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "SECTION_ID" => "",
                    "LIST_SECTION_ID" => array('2801', '2804'),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "FILTER_PROPS" => array(),
                    "ALLOW_BUY_NOT_EXISTING" => "N",
                    "CHECK_PERMISSIONS" => "N",
                    "SORT_FIELD_1" => "sort",
                    "SORT_DIR_1" => "asc",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "desc,nulls",
                    "SORTING_PANEL_OPTIONS" => array("sort"),
                    "SORTING_PANEL_OPTIONS_sort" => "",
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "DESCRIPTION_FROM_PROPS" => "N",
                    "COUNT" => "20",
                    "ALLOW_PAGENAV" => "N",
                    "ALLOW_USER_PAGENAV" => "N",
                    "CACHE_WITH_FILTER" => "N",
                    "CACHE_WITH_SORTING" => "N",
                    "CACHE_WITH_PAGING" => "N"
                ),
                $component
            );?>
        </div>

        <div id="korabli" class="brands-container">
            <?$APPLICATION->IncludeComponent(
                "bis:catalog.section.brands",
                "brands",
                Array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "BRANDS_IBLOCK_ID" => "25",
                    "ADDITIONAL_FILTER" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SET_TITLE" => "N",
                    "ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "SECTION_ID" => "",
                    "LIST_SECTION_ID" => array('2807'),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "FILTER_PROPS" => array(),
                    "ALLOW_BUY_NOT_EXISTING" => "N",
                    "CHECK_PERMISSIONS" => "N",
                    "SORT_FIELD_1" => "sort",
                    "SORT_DIR_1" => "asc",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "desc,nulls",
                    "SORTING_PANEL_OPTIONS" => array("sort"),
                    "SORTING_PANEL_OPTIONS_sort" => "",
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "DESCRIPTION_FROM_PROPS" => "N",
                    "COUNT" => "20",
                    "ALLOW_PAGENAV" => "N",
                    "ALLOW_USER_PAGENAV" => "N",
                    "CACHE_WITH_FILTER" => "N",
                    "CACHE_WITH_SORTING" => "N",
                    "CACHE_WITH_PAGING" => "N"
                ),
                $component
            );?>
        </div>

        <div id="kvadro" class="brands-container">
            <?$APPLICATION->IncludeComponent(
                "bis:catalog.section.brands",
                "brands",
                Array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "BRANDS_IBLOCK_ID" => "25",
                    "ADDITIONAL_FILTER" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SET_TITLE" => "N",
                    "ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "SECTION_ID" => "",
                    "LIST_SECTION_ID" => array('2802'),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "FILTER_PROPS" => array(),
                    "ALLOW_BUY_NOT_EXISTING" => "N",
                    "CHECK_PERMISSIONS" => "N",
                    "SORT_FIELD_1" => "sort",
                    "SORT_DIR_1" => "asc",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "desc,nulls",
                    "SORTING_PANEL_OPTIONS" => array("sort"),
                    "SORTING_PANEL_OPTIONS_sort" => "",
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "DESCRIPTION_FROM_PROPS" => "N",
                    "COUNT" => "20",
                    "ALLOW_PAGENAV" => "N",
                    "ALLOW_USER_PAGENAV" => "N",
                    "CACHE_WITH_FILTER" => "N",
                    "CACHE_WITH_SORTING" => "N",
                    "CACHE_WITH_PAGING" => "N"
                ),
                $component
            );?>
        </div>

        <div id="kompl" class="brands-container">
            <?$APPLICATION->IncludeComponent(
                "bis:catalog.section.brands",
                "brands",
                Array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "BRANDS_IBLOCK_ID" => "25",
                    "ADDITIONAL_FILTER" => "",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "3600",
                    "SET_TITLE" => "N",
                    "ACTIVE" => "Y",
                    "ACTIVE_DATE" => "Y",
                    "SECTION_ID" => "",
                    "LIST_SECTION_ID" => array('2753'),
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "FILTER_PROPS" => array(),
                    "ALLOW_BUY_NOT_EXISTING" => "N",
                    "CHECK_PERMISSIONS" => "N",
                    "SORT_FIELD_1" => "sort",
                    "SORT_DIR_1" => "asc",
                    "SORT_FIELD_2" => "shows",
                    "SORT_DIR_2" => "desc,nulls",
                    "SORTING_PANEL_OPTIONS" => array("sort"),
                    "SORTING_PANEL_OPTIONS_sort" => "",
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "DESCRIPTION_FROM_PROPS" => "N",
                    "COUNT" => "20",
                    "ALLOW_PAGENAV" => "N",
                    "ALLOW_USER_PAGENAV" => "N",
                    "CACHE_WITH_FILTER" => "N",
                    "CACHE_WITH_SORTING" => "N",
                    "CACHE_WITH_PAGING" => "N"
                ),
                $component
            );?>
        </div>

        <div class="brands-container"> <?$APPLICATION->IncludeComponent(
            "bexx:catalog.items",
            "brands",
            Array(
                "BLOCK_TITLE" => "Наши бренды",
                "BLOCK_URL" => "/catalog/hit/",
                "BLOCK_URL_TITLE" => "все бренды",
                "IBLOCK_TYPE" => "info",
                "IBLOCK_ID" => "25",
                "ADDITIONAL_FILTER" => "",
                "CACHE_TYPE" => "A",
                "CACHE_TIME" => "3600",
                "SET_TITLE" => "N",
                "ACTIVE" => "Y",
                "ACTIVE_DATE" => "Y",
                "GET_LINKED_ELEMENTS" => "Y",
                "GET_LINKED_SECTIONS" => "Y",
                "SECTION_ID" => "0",
                "INCLUDE_SUBSECTIONS" => "Y",
                "FILTER_PROPS" => array(),
                "ALLOW_BUY_NOT_EXISTING" => "N",
                "CHECK_PERMISSIONS" => "N",
                "SORT_FIELD_1" => "sort",
                "SORT_DIR_1" => "asc",
                "SORT_FIELD_2" => "shows",
                "SORT_DIR_2" => "desc,nulls",
                "SORTING_PANEL_OPTIONS" => array("sort"),
                "SORTING_PANEL_OPTIONS_sort" => "",
                "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                "DESCRIPTION_FROM_PROPS" => "N",
                "COUNT" => "20",
                "ALLOW_PAGENAV" => "Y",
                "ALLOW_USER_PAGENAV" => "N",
                "CACHE_WITH_FILTER" => "N",
                "CACHE_WITH_SORTING" => "N",
                "CACHE_WITH_PAGING" => "N"
            ),
        $component
        );?> </div>
    </div>
</div>