<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Интернет магазин Modelistam");
$APPLICATION->SetPageProperty("keywords", "modelistam, интернет магазин, интернет, магазин");
$APPLICATION->SetPageProperty("description", "Интернет-магазин modelistam.ru");
$APPLICATION->SetPageProperty("not_show_page_title", "Y");
$APPLICATION->SetPageProperty("not_show_breadcrumb", "Y");
$APPLICATION->SetPageProperty("no_padding", "Y");
$APPLICATION->SetPageProperty("home_page", "Y");
?>


<div class="front-main-page-block">

    <!--.adaptive-content-block-->
    <div class="adaptive-content-block">

        <div id="news-container">
            <div class="inner-block">
                <div class="news-container__inner__title">Свежие новости</div>

                <div class="news-inner-block">
                    <?$APPLICATION->IncludeComponent("bitrix:news.list", "frontpage-list", array(
                        "IBLOCK_TYPE" => "news_type",
                        "IBLOCK_ID" => "22",
                        "NEWS_COUNT" => "10",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "",
                        "FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "/news/#SECTION_ID#/#ELEMENT_ID#/",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "AJAX_OPTION_HISTORY" => "N",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "36000000",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "SET_TITLE" => "N",
                        "SET_STATUS_404" => "N",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "DISPLAY_TOP_PAGER" => "N",
                        "DISPLAY_BOTTOM_PAGER" => "Y",
                        "PAGER_TITLE" => "Новости",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => "",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "Y",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "N",
                        "AJAX_OPTION_ADDITIONAL" => ""
                    ),
                    false
                );?>

                </div>

            </div>
        </div>

        <div id="front-page-content">
            <div class="inner-content">
                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_TEMPLATE_PATH."/includes/front-page-info.php"), false);?>
            </div>
        </div>

        <div id="social-block">
            <div class="inner-social">
                <div class="subscribe-form">
                    <div class="subscribe-form__title">Узнавайте о новых акциях и скидках </div>
                    <?$APPLICATION->IncludeComponent(
                    "bitrix:subscribe.form",
                    "template1",
                    Array(
                        "USE_PERSONALIZATION" => "Y",
                        "SHOW_HIDDEN" => "N",
                        "PAGE" => "#SITE_DIR#personal/subscribe",
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600"
                    )
                );?>
                </div>
            </div>
        </div>
    </div>
    <!--/.adaptive-content-block-->


    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.flexslider.js"></script>
    <script type="text/javascript">
        $(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                slideshow: false,
                pauseOnHover: true,
                touch: false,
                slideshow: true,
                slideshowSpeed: 6000,
                animationSpeed: 800
            });
        });
    </script>

    <div class="flexslider">
        <ul class="slides">
            <li>
                <img src="<?=SITE_TEMPLATE_PATH?>/images/banners/slider-image-2.jpg" usemap="#image_map_1" border="0" width="1200" height="323" alt=""  />
                <a class="helper__links hp__1" href="/catalog/Krupnaya-bytovaya-tehnika/Xolodilnoe-oborudovanie/Xolodilniki/" alt="Холодильники от 930 грн" title="Холодильники от 930 грн" ></a>
                <a class="helper__links hp__2" href="/catalog/Vstraivaemaya-tehnika/Duhovye-shkafy/" alt="Духовки от 1300 грн" title="Духовки  от 1300 грн"></a>
                <a class="helper__links hp__3" href="/catalog/Melkaya-bytovaya-tehnika/Kuhnya/SVCH-pechi/" alt="СВЧ от 430 грн" title="СВЧ от 430 грн"></a>
                <a class="helper__links hp__4" href="/catalog/Vstraivaemaya-tehnika/Posudomoechnye-mashiny-vstraivaemye/" alt="Мойки от 550 грн" title="Мойки от 550 грн" ></a>
                <a class="helper__links hp__5" href="http://prmag.com.ua/#/" alt="Смесители от 390 грн" title="Смесители от 390 грн"></a>
                <a class="helper__links hp__6" href="/catalog/Vstraivaemaya-tehnika/Varochnye-poverhnosti/" alt="Поверхности от 690 грн" title="Поверхности от 690 грн"></a>
            </li>
            <li>
                <img src="<?=SITE_TEMPLATE_PATH?>/images/banners/slider-image-3.jpg" usemap="#image_map_2" border="0" width="1200" height="323" alt="" />
                <a class="helper__links hp__7" href="/catalog/Audio-video-tehnika/" alt="TV-тюнеры от 362 грн" title="TV-тюнеры от 362 грн"></a>
                <a class="helper__links hp__8" href="/catalog/Audio-video-tehnika/Televizory/" alt="Телевизоры от 389 грн" title="Телевизоры от 389 грн"></a>
                <a class="helper__links hp__9" href="/catalog/Audio-video-tehnika/Blu-ray-i-DVD-proigryvateli/" alt="DVD плееры от 189 грн" title="DVD плееры от 189 грн"></a>
                <a class="helper__links hp__10" href="/catalog/Audio-video-tehnika/Akusticheskie-sistemy/" alt="Акустика от 750 грн" title="Акустика от 750 грн"></a>
            </li>
            <li>
                <a title="Лучшие цены на технику Атлант" href="/catalog/Krupnaya-bytovaya-tehnika/Xolodilnoe-oborudovanie/Xolodilniki/?Brand=54311"><img src="<?=SITE_TEMPLATE_PATH?>/images/banners/slider-image-4.jpg" /></a>
            </li>
        </ul>
    </div>

    <div id="adaptive-block">
        <div class="hits-block">
            <div class="inside-block">
                <div class="inner-header">
                    <h3>Лидеры продаж</h3>
                    <a href="/catalog/hit/">Все лидеры</a>
                </div>
                <div class="inner-block">
                    <?$APPLICATION->IncludeComponent("bexx:catalog.items", "small_wide_custom", array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "26",
                        "ADDITIONAL_FILTER" => "",
                        "SECTION_ID" => "0",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "ACTIVE" => "Y",
                        "ACTIVE_DATE" => "Y",
                        "GET_LINKED_ELEMENTS" => "Y",
                        "GET_LINKED_SECTIONS" => "N",
                        "FILTER_PROPS" => array(
                        ),
                        "SKU_ALLOW" => "Y",
                        "ALLOW_BUY_NOT_EXISTING" => "Y",
                        "CHECK_PERMISSIONS" => "N",
                        "CATALOG_PATH" => "/catalog/",
                        "DESCRIPTION_FROM_PROPS" => "N",
                        "COUNT" => "2",
                        "ALLOW_PAGENAV" => "Y",
                        "ALLOW_USER_PAGENAV" => "N",
                        "SORT_FIELD_1" => "shows",
                        "SORT_DIR_1" => "nulls,desc",
                        "SORT_FIELD_2" => "catalog_quantity",
                        "SORT_DIR_2" => "desc,nulls",
                        "SORTING_PANEL_OPTIONS" => array(
                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_WITH_FILTER" => "N",
                        "CACHE_WITH_SORTING" => "N",
                        "CACHE_WITH_PAGING" => "N",
                        "SET_TITLE" => "N",
                        "COLUMNS_COUNT" => "3",
                        "BLOCK_WIDTH" => "175",
                        "SHOW_BORDER" => "Y"
                    ),
                    false
                );?>
                </div>
            </div>
        </div>
        <div class="new-block">
            <div class="inside-block">
                <div class="inner-header">
                    <h3>Новинки</h3>
                    <a href="/catalog/new/">Все новинки</a>
                </div>
                <div class="inner-block">
                    <?$APPLICATION->IncludeComponent("bexx:catalog.items", "small_wide_custom", array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "26",

                        //PM-35
                        "ADDITIONAL_FILTER" => array(
                        "LOGIC" => "AND",
                        array("=PROPERTY_4392" => 56433),
                        array("!=DETAIL_PICTURE" => false),
                        array("!=PRICE_5" => 0)
                        ),
                        //PM-35

                        "SECTION_ID" => "0",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "ACTIVE" => "Y",
                        "ACTIVE_DATE" => "Y",
                        "GET_LINKED_ELEMENTS" => "Y",
                        "GET_LINKED_SECTIONS" => "N",
                        "FILTER_PROPS" => array(
                        ),
                        "SKU_ALLOW" => "Y",
                        "ALLOW_BUY_NOT_EXISTING" => "Y",
                        "CHECK_PERMISSIONS" => "N",
                        "CATALOG_PATH" => "/catalog/",
                        "DESCRIPTION_FROM_PROPS" => "N",
                        "COUNT" => "2",
                        "ALLOW_PAGENAV" => "Y",
                        "ALLOW_USER_PAGENAV" => "N",
                        "SORT_FIELD_1" => "timestamp_x",
                        "SORT_DIR_1" => "desc,nulls",
                        "SORT_FIELD_2" => "property_652",
                        "SORT_DIR_2" => "asc,nulls",
                        "SORTING_PANEL_OPTIONS" => array(
                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_WITH_FILTER" => "N",
                        "CACHE_WITH_SORTING" => "N",
                        "CACHE_WITH_PAGING" => "N",
                        "SET_TITLE" => "N",
                        "COLUMNS_COUNT" => "3",
                        "BLOCK_WIDTH" => "175",
                        "SHOW_BORDER" => "Y"
                    ),
                    false
                );?>
                </div>
            </div>
        </div>
        <div class="sale-block">
            <div class="inside-block">
                <div class="inner-header">
                    <h3>Скидка!</h3>
                    <a href="/catalog/akcii/">Все товары со скидкой</a>
                </div>
                <div class="inner-block">
                    <?$APPLICATION->IncludeComponent("bexx:catalog.items", "small_wide_custom", array(
                        "IBLOCK_TYPE" => "catalog",
                        "IBLOCK_ID" => "26",
                        "ADDITIONAL_FILTER" => "PROPERTY_4392 = 56433",
                        "SECTION_ID" => "0",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "ACTIVE" => "Y",
                        "ACTIVE_DATE" => "Y",
                        "GET_LINKED_ELEMENTS" => "Y",
                        "GET_LINKED_SECTIONS" => "N",
                        "FILTER_PROPS" => array(
                        ),
                        "SKU_ALLOW" => "Y",
                        "ALLOW_BUY_NOT_EXISTING" => "N",
                        "CHECK_PERMISSIONS" => "N",
                        "CATALOG_PATH" => "/catalog/",
                        "DESCRIPTION_FROM_PROPS" => "N",
                        "COUNT" => "2",
                        "ALLOW_PAGENAV" => "N",
                        "SORT_FIELD_1" => "shows",
                        "SORT_DIR_1" => "nulls,desc",
                        "SORT_FIELD_2" => "",
                        "SORT_DIR_2" => "asc,nulls",
                        "SORTING_PANEL_OPTIONS" => array(
                        ),
                        "CACHE_TYPE" => "A",
                        "CACHE_TIME" => "3600",
                        "CACHE_WITH_FILTER" => "N",
                        "CACHE_WITH_SORTING" => "N",
                        "CACHE_WITH_PAGING" => "N",
                        "SET_TITLE" => "N",
                        "COLUMNS_COUNT" => "3",
                        "BLOCK_WIDTH" => "175",
                        "SHOW_BORDER" => "Y"
                    ),
                    false
                );?>
                </div>
            </div>
        </div>
    </div>

    <div class="adaptive-bottom-menu">
        <div class="adaptive-bottom-menu-inner">
            <div id="front-bottom-menu">
                <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "front_bottom_menu", array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "COUNT_ELEMENTS" => "Y",
                    "TOP_DEPTH" => "2",
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
                    "CACHE_TIME" => "7200",
                    "CACHE_GROUPS" => "N",
                    "ADD_SECTIONS_CHAIN" => "N"
                ),
                false
            );?>
            </div>
        </div>
    </div>

    <div class="fix-seo-main-block">&nbsp;</div>

</div>

<script type="text/javascript">
    var fixTextHeight = {
        init: function() {
            var contentBlock = $('.adaptive-content-block'),
                fixBlock = $('.fix-seo-main-block');

            if (contentBlock.length) {
                fixHeight();
            }

            $(window).resize(function() {
                fixHeight();
            })
            function fixHeight() {
                var height = contentBlock.height();
                fixBlock.height(height);
            }
        }
    }

    $(function() {
        fixTextHeight.init();
    })
</script>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>