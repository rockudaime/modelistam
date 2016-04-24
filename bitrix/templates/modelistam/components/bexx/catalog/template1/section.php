<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?$APPLICATION->SetPageProperty("no_padding", "Y");?>
<?$APPLICATION->SetPageProperty("not_show_page_title", "Y");?>

<?

$APPLICATION->SetPageProperty("custom_h1", "Y");

if($arResult['SECTION']['NAME']) {
    $APPLICATION->SetTitle($arResult['SECTION']['NAME']);
    $APPLICATION->SetPageProperty("description", "Отличный выбор ".$arResult['SECTION']['NAME']);
    $APPLICATION->SetPageProperty("keywords", $arResult['SECTION']['NAME']);
    $APPLICATION->SetPageProperty("custom_h1", "Y");
    $APPLICATION->SetPageProperty("custom_h1_text", $arResult['SECTION']['NAME']);
} else {
    $APPLICATION->SetPageProperty("title","Каталог товаров");
    $APPLICATION->SetTitle("Каталог товаров");
}
?>


<?
if(isset($_REQUEST["view"])){
    $view = htmlspecialcharsbx($_REQUEST["view"]);
    $APPLICATION->set_cookie("view", $view);
}
else {
    $view = $APPLICATION->get_cookie("view")?$APPLICATION->get_cookie("view"):"block";
}

$anotherView = ($view == 'block')?"list":"block";
if ($anotherView == 'block') {
    $linkViewText = 'плиткой';
} else {
    $linkViewText = 'списком';
}
?>



<?
$cssMobileHidden = '';
if (strstr($_SERVER['REQUEST_URI'], "?") !== false) {
    $cssMobileHidden = 'mobile-hidden';
}?>



<?
CModule::IncludeModule("bexx.shop");
CModule::IncludeModule("iblock");

/**
* Данный файл используется как шаблон для разделов, но не для первого уровня каталога товаров. Данный шаблон будет показан
* в разделе /catalog/tv/lcd/ , например. В зависимости от различных условий, в этом шаблоне могут подключаться другие файлы.
*/

/*
if (!$arResult['ELEMENT_CODE'] AND !$arResult['SECTION']) {
    include("top.php");
    return false;
}
*/

// некоторые дополнительные действия до подключения шаблонов
if (isset($_GET['compare_clear'])) unset($_SESSION['compare']);

// подключение шаблонов по условию
if (isset($_GET['compare'])):
    include("compare.php");
else:?>
<?
?>

<?
    $IsSectionRoot = (($arResult['SECTION']['DEPTH_LEVEL'] == "1" OR $arResult['SECTION']['DEPTH_LEVEL'] == "2")
        //BSP-76
        AND !$arResult['SECTIONS'][$arResult['SECTION']['ID']]['QNT']
        //BSP-76
        ) ? 'Y': '';
?>

<h1 class="catalog-h1"><?$APPLICATION->ShowProperty('custom_h1_text');?>.<span> Порекомендуем, что выбрать. Всегда есть аксесуары. Надежный сервис</span></h1>

<div class="sidebar-left" id="sidebar">
    <?
    /**
     * Сравнение товаров
     */
    $ids = array(0);
    if (is_array($_SESSION['compare']) AND !empty($_SESSION['compare'])) {
        $ids = array_keys($_SESSION['compare']); // по умолчанию показываем все типы товаров для сравнения
    }
    ?>

    <?if (!$IsSectionRoot):?>
        <div class="compare-section-container">
            <?
            $compareItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "compare_block_1", array(
                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                "ADDITIONAL_FILTER" => array('ID'=>$ids),
                "SECTION_ID" => $arResult['SECTION']['ID'],
                "INCLUDE_SUBSECTIONS" => "Y",
                "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                "ACTIVE" => $arParams['CHECK_ACTIVE'],
                "ACTIVE_DATE" => $arParams['CHECK_ACTIVE'],
                "FILTER_PROPS" => array(),
                "SORT_FIELD_1" => "sort",
                "SORT_DIR_1" => "asc",
                //PST-9
                //"CACHE_TYPE" => $arParams['CACHE_TYPE'],
                "CACHE_TYPE" => "N",
                //PST-9
                "CACHE_TIME" => $arParams['CACHE_TIME'],
                "SET_TITLE" => "N",
                "CATALOG_PATH" => $arParams['CATALOG_PATH'],
                "SHOW_OLD_PRICE" => "N",
                "DESCRIPTION_FROM_PROPS" => "N",
                "SHOW_NAVIGATION" => "N",
                "COUNT" => "10",
                "IGNORE_ITEMS_PER_PAGE" => "Y",
                "BLOCK_TITLE" => "Сравнить",
                "ALWAYS_EXISTING_FIRST" => $arParams['ALWAYS_EXISTING_FIRST'],
                "BLOCK_URL" => "/catalog/compare.php",
                ),
                $component
            );?>
        </div>
	
        <div class="sidebar-filter <?=$cssMobileHidden;?>">
            <?
            $ADDITIONAL_FILTER = array();

            foreach ($_GET as $k=>$v) {
                if (in_array($k, $arParams['FILTER_PROPS']) AND $k AND $v) {
                    if (!is_array($v)) $v = intval($v);
                    $ADDITIONAL_FILTER['PROPERTY_'.$k] = $v;
                }
            }

            if (is_array($_GET['prop']) AND !empty($_GET['prop'])) {
                CBexxShop::GetSectionResult($arResult['SECTION']['ID'], $arResult['IBLOCK']['ID']);

                if ($arResult['PRIMARY_TYPE']) {
                    $childFilter = array('IBLOCK_ID'=>$arResult['PRIMARY_TYPE']);
                    foreach ($_GET['prop'] as $prop_id=>$prop_val) {
                        $childFilter['PROPERTY_'.$prop_id] = $prop_val;
                    }
                    $rs = CIblockElement::GetList(array(), $childFilter, false, false, array('ID'));
                    while ($ar = $rs->Fetch()) {
                        $ADDITIONAL_FILTER['PROPERTY_type'][] = $ar['ID'];
                    }
                }
            }
            ?>

            <?$APPLICATION->IncludeComponent(
                "bexx:catalog.filter",
                "",
                Array(
                    "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                    "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "SECTION_ID" => $arResult['SECTION']['ID'],
                    "ADDITIONAL_FILTER" => $ADDITIONAL_FILTER,
                    "FILTER_PROPS" => $arParams['FILTER_PROPS'],
                    "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                    "CACHE_TIME" => $arParams['CACHE_TIME'],
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                ),
                $component
            );?>
        </div>
    <?endif;?>

  <!--  <div class="section__left-menu section__left-block <?//=$cssMobileHidden;?>">
        <?
        //klm
        //получаем ИД корневой подгруппы товаров
       /* foreach($arResult['SECTIONS'] as $key => $value){
            $MAIN_SECTION_ID = $value[ID];
            break;
        }
        $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "catalog_left", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            //klm
            "SECTION_ID" => $MAIN_SECTION_ID,
            //klm
            //oleg
            "CURRENT_SECTION_ID" => $arResult['SECTION']['ID'],
            //oleg
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
            "CACHE_TIME" => "86400",
            "CACHE_GROUPS" => "N",
            "ADD_SECTIONS_CHAIN" => "N"
        ), false
        );
        */?>
    </div>-->

    <?if (!$IsSectionRoot):?>
        <div class="section-viewed-block">
            <?$APPLICATION->IncludeFile("includes/last-viewed.php");?>
        </div>
    <?endif;?>

    <!--<div class="catalog-interesting-block">
        <?//$APPLICATION->IncludeFile("includes/front-interesting-news.php");?>
    </div>-->

</div>

<div class="catalog-content i-clearfix" id="catalog-content">
    <div class="sub-categories">
        <select>
            <option>subcategory</option>
        </select>
    </div>
    <ul class="catalog-top-menu">
        <li class="catalog-top-menu__item">
            <a href="/info/howtochoice" rel="#" class="catalog-top-menu__link top-menu-choice-item"><i></i><span>Как выбрать</span></a>
        </li>
        <li class="catalog-top-menu__item">
            <a href="/info/ongift" rel="#" class="catalog-top-menu__link top-menu-present-item"><i></i><span>На подарок</span></a>
        </li>
        <li class="catalog-top-menu__item">
            <a href="/info/overviews" rel="#" class="catalog-top-menu__link top-menu-views-item"><i></i><span>Обзоры</span></a>
        </li>
        <li class="catalog-top-menu__item">
            <a href="/info/video" rel="#" class="catalog-top-menu__link top-menu-video-item"><i></i><span>Видео</span></a>
        </li>
        <li class="catalog-top-menu__item">
            <a href="/info/accesories" rel="#" class="catalog-top-menu__link top-menu-accesories-item"><i></i><span>Аксессуары</span></a>
        </li>
    </ul>


    <?/*
    <div class="section__items <?=$cssMobileHidden;?>">
        <?include_once('top_items.php');?>
    </div>
    */?>

    <?if ($IsSectionRoot):?>
        <div class="catalog-top-block">
            <div class="catalog-top-block__left">
                <?global $arrCatalogTopNews;
                $arrCatalogTopNews = array(
                    "SECTION_ID" => 2589,
                    "PROPERTY_CATGROUP" => $arResult['SECTION']['ID']
                );
                ?>
                <?$APPLICATION->IncludeComponent("bitrix:news.list", "catalog_news", array(
                        "IBLOCK_TYPE" => "news_type",
                        "IBLOCK_ID" => "22",
                        "NEWS_COUNT" => "1",
                        "SORT_BY1" => "SORT",
                        "SORT_ORDER1" => "ASC",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER2" => "ASC",
                        "FILTER_NAME" => "arrCatalogTopNews",
                        "FIELD_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "PROPERTY_CODE" => array(
                            0 => "",
                            1 => "",
                        ),
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "/news/#ELEMENT_CODE#/",
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
            <div class="catalog-top-block__right">
                <?$APPLICATION->IncludeFile("includes/icons-block.php");?>
            </div>
        </div>
    <?endif;?>

    <?if (!$IsSectionRoot):?>
        <?
        $arUriKillParams = array( // Эти параметры удаляются из адреса страницы в постраничной навигации
        "page", // номер страницы
        "p", // количество элементов на страницу
        "s", // поле для сортировки
        "d", // направление сортировки
        "sort", // сортировка (устаревшее)
        "s_prop", // поле для сортировки по характеристикам
        "s_prop_dir", // направление для сортировки по характеристикам
        "reset_sorting", // сброс сортировки
        "view" // отображение списка товаров (block или list)
        );
        ?>

        <div class="catalog-view-changer">
            <a title="Показать блоками" class="view-changer-link <?if ($view == 'block') echo 'view-changer-link--active';?>" href="?view=block">
                <span class="icon-view-block">
                    <i></i>
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </a>
            <a title="Показать списком" class="view-changer-link <?if ($view == 'list') echo 'view-changer-link--active';?>" href="?view=list">
                <span class="icon-view-list">
                    <i></i>
                    <i></i>
                    <i></i>
                </span>
            </a>
        </div>
        <div class="mobile-filter-links clearfix">
            <div class="filter-link">Подбор </div>
            <div class="sort-link">Сортировать</div>
        </div>

        <?
        $listItems = $APPLICATION->IncludeComponent("bexx:catalog.items",'main_catalog_1', array(
            "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
            "IBLOCK_ID" => $arParams['IBLOCK_ID'],
            "CURRENT_VIEW" => $view,
            "ADDITIONAL_FILTER" => "",
            "SECTION_ID" => $arResult['SECTION']['ID'],
            "INCLUDE_SUBSECTIONS" => "Y",
            "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
            "CATALOG_PATH" => $arParams['SEF_FOLDER'],
            "ACTIVE" => $arParams['CHECK_ACTIVE'],
            "ACTIVE_DATE" => $arParams['CHECK_ACTIVE'],
            "DESCRIPTION_FROM_PROPS" => $arParams['DESCRIPTION_FROM_PROPS'],
            "USE_EXTERNAL_FILTERING" => $arParams['USE_EXTERNAL_FILTERING'],
            "SKU_PROPS" => $arParams['SKU_PROPS'],
            "SKU_SORT_FIELD" => $arParams['SKU_SORT_FIELD'],
            "SKU_SORT_DIR" => $arParams['SKU_SORT_DIR'],
            "SKU_ONLY" => $arParams['SKU_ONLY'],
            "ALLOW_PAGENAV" => "Y",
            "ALLOW_USER_PAGENAV" => $arParams['ALLOW_USER_PAGENAV'],
            "COUNT" => $arParams['ITEMS_PER_PAGE'],
            "SORT_FIELD_1" => $arParams['SORT_FIELD_1'],
            "SORT_DIR_1" => $arParams['SORT_DIR_1'],
            "SORT_FIELD_2" => $arParams['SORT_FIELD_2'],
            "SORT_DIR_2" => $arParams['SORT_DIR_2'],

            //PST-9
            //"CACHE_TYPE" => $arParams['CACHE_TYPE'],
            "CACHE_TYPE" => "N",
            //PST-9

            "CACHE_TIME" => $arParams['CACHE_TIME'],
            "CACHE_WITH_FILTER" => $arParams['CACHE_WITH_FILTER'],
            "CACHE_WITH_SORTING" => $arParams['CACHE_WITH_SORTING'],
            "CACHE_WITH_PAGING" => $arParams['CACHE_WITH_PAGING'],
            "SET_TITLE" => $arParams['SET_TITLE'],
            "FILTER_PROPS" => $arParams['FILTER_PROPS'],
            "SORTING_PANEL_OPTIONS" => $arParams['SORTING_PANEL_OPTIONS'],
            "ALLOW_BUY_NOT_EXISTING" => $arParams['ALLOW_BUY_NOT_EXISTING'],
            "PER_PAGE_VARIANTS" => $arParams['PER_PAGE_VARIANTS'],
            "COMMENTS_ONLY_AUTHORIZED" => $arParams['COMMENTS_ONLY_AUTHORIZED'],
            ),
            $component
        );
        ?>
    <?else:?>
        <div class="section__main-content">

            <div class="section__main-content__left">
                <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "catalog_front-menu", array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    //klm
                    "SECTION_ID" => $arResult['SECTION']['ID'],
                    //klm
                    "SECTION_CODE" => "",
                    "CURRENT_SECTION_NAME" => $h1_text, //custom param (текущий раздел)
                    "COUNT_ELEMENTS" => "N",
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
                    "CACHE_TIME" => "86400",
                    "CACHE_GROUPS" => "N",
                    "ADD_SECTIONS_CHAIN" => "N"
                ), false
                );
                ?>
            </div>

            <div class="section__main-content__right">
                <div class="section-viewed-block">
                    <?$APPLICATION->IncludeFile("includes/last-viewed.php");?>
                </div>

                <div class="section-news-video-block">
                    <?$APPLICATION->IncludeFile("includes/news-video.php");?>
                </div>
            </div>

        </div>
    <?endif;?>

    <? /* SEO block */ ?>

    <?//MM-134?>
    <?/*$alternative_description = $APPLICATION->GetPageProperty('add_description');?>
    <?if (strlen($alternative_description)):?>
        <div class="catalog-seo-block">
            <p><?=htmlspecialcharsBack($alternative_description);?></p>
        </div>
    <?else:?>
    <?//MM-134?>

        <?if ($arResult['SECTION']['DESCRIPTION'] AND intval($_GET['page'])<=1 AND (!isset($_SESSION['sorting']))):?>
            <?if (strstr($_SERVER['REQUEST_URI'], "?") === false):?>
            <div class="catalog-seo-block">
                <p><?=$arResult['SECTION']['DESCRIPTION']?></p>
            </div>
            <?endif;?>
        <?endif;?>
    <?endif;*/?>


    <?
    if ($arResult['SECTION']['UF_SECTION_TITLE']) {
        $APPLICATION->SetTitle($arResult['SECTION']['UF_SECTION_TITLE']);
    }
    // Установка кастомного заголовка: Название группы товаров 2уровень. Название группы товаров 1уровень. Текст.
    if ($arResult['SECTION']['UF_BROWSER_TITLE']) {
        $APPLICATION->SetPageProperty("browser_title", $arResult['SECTION']['UF_BROWSER_TITLE']);
    }
    ?>

    <?/*
    <div class="section-articles-wrap">
        <?include_once('section_articles.php');?>
    </div>
    */?>


</div>
    <!--tabs mobile-->
    <div class="content-tabs-catalog">
        <ul class="menu-tabs-catalog">
            <li class="menu-tabs-catalog-item">
                <div class="menu-tabs-catalog-item__title"><?$APPLICATION->ShowProperty('custom_h1_text');?> по брендам<b></b></div>
                <ul class="parent-inner-information">
                    <li class="parent-inner-information__item">
                        <div class="detail__brands">
                            <div class="detail__brands__content">
                                <?$APPLICATION->IncludeComponent("bexx:catalog.items", "brands", array(
                                        "IBLOCK_TYPE" => "info",
                                        "IBLOCK_ID" => "25",
                                        "BLOCK_TITLE"=> "Производители",
                                        "PARENT_IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                        "PARENT_IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                        "SECT_ID" => $arResult['SECTION']['ID'], //custom param
                                        "IBLOCK_CATALOG_ID" => $arParams['IBLOCK_ID'], //custom param
                                        "CURRENT_PRODUCT_ID" => $detailResult['ID'], //custom param
                                        "CURRENT_BRAND_ID" => $detailResult['PROPERTIES']['Brand']['VALUE'], //custom param
                                        "SECTION_ID" => "",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                                        "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                                        "ACTIVE" => $arParams['CHECK_ACTIVE'],
                                        "ACTIVE_DATE" => $arParams['CHECK_ACTIVE'],
                                        "DESCRIPTION_FROM_PROPS" => $arParams['DESCRIPTION_FROM_PROPS'],
                                        "USE_EXTERNAL_FILTERING" => $arParams['USE_EXTERNAL_FILTERING'],
                                        "ALLOW_PAGENAV" => "Y",
                                        "ALLOW_USER_PAGENAV" => $arParams['ALLOW_USER_PAGENAV'],
                                        "COUNT" => "25",
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TYPE" => "N",
                                        "CACHE_TIME" => "36000000",
                                        "CACHE_WITH_FILTER" => $arParams['CACHE_WITH_FILTER'],
                                        "CACHE_WITH_SORTING" => $arParams['CACHE_WITH_SORTING'],
                                        "CACHE_WITH_PAGING" => $arParams['CACHE_WITH_PAGING'],
                                        "SET_TITLE" => "N",
                                    ),
                                    $component
                                );
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="menu-tabs-catalog-item">
                <div class="menu-tabs-catalog-item__title"><a href="/info/accesories" rel="#"><i class="menu-item-accedories"></i> Аксесуары<b></b></a></div>
                <ul class="parent-inner-information">
                    <li class="parent-inner-information__item">Аксесуары</li>
                </ul>
            </li>
            <li class="menu-tabs-catalog-item">
                <div class="menu-tabs-catalog-item__title"><i class="menu-item-service"><a href="/info/service" rel="#"></i>Обслуживание<b></b></a></div>
                <ul class="parent-inner-information">
                    <li class="parent-inner-information__item">Обслуживание</li>
                </ul>
            </li>
            <li class="menu-tabs-catalog-item last">
                <div class="menu-tabs-catalog-item__title"><i class="menu-item-choise"><a href="/info/howtochoice" rel="#"></i>Как выбрать<b></b></div></div>
                <ul class="parent-inner-information">
                    <li class="parent-inner-information__item">Как выбрать</li>
                </ul>
            </li>
        </ul>
    </div>
    <!--/ tabs mobile-->
    <!--brands-catalog
    <div class="detail__brands brands-catalog">
        <div class="detail-brands-title">
            <?
            //TM-9
            //if ($isCatalog)
            $APPLICATION->IncludeComponent("bis:breadcrumb", ".default", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "-"
                ),
                false,
                Array('HIDE_ICONS' => 'Y')
            );?>
            <span> по брендам</span>
            <a href="#" rel="#" class="products-service"><i></i><span>Обслуживание</span></a>
            <a href="#" rel="#" class="products-choise"><i></i><span>Как выбрать</span></a>
        </div>
        <div class="detail__brands__content">
            <?/*$APPLICATION->IncludeComponent("bexx:catalog.items", "brands", array(
                    "IBLOCK_TYPE" => "info",
                    "IBLOCK_ID" => "25",
                    "BLOCK_TITLE"=> "Производители",
                    "PARENT_IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                    "PARENT_IBLOCK_ID" => $arParams['IBLOCK_ID'],
                    "SECT_ID" => $arResult['SECTION']['ID'], //custom param
                    "IBLOCK_CATALOG_ID" => $arParams['IBLOCK_ID'], //custom param
                    "CURRENT_PRODUCT_ID" => $detailResult['ID'], //custom param
                    "CURRENT_BRAND_ID" => $detailResult['PROPERTIES']['Brand']['VALUE'], //custom param
                    "SECTION_ID" => "",
                    "INCLUDE_SUBSECTIONS" => "Y",
                    "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                    "CATALOG_PATH" => $arParams['SEF_FOLDER'],
                    "ACTIVE" => $arParams['CHECK_ACTIVE'],
                    "ACTIVE_DATE" => $arParams['CHECK_ACTIVE'],
                    "DESCRIPTION_FROM_PROPS" => $arParams['DESCRIPTION_FROM_PROPS'],
                    "USE_EXTERNAL_FILTERING" => $arParams['USE_EXTERNAL_FILTERING'],
                    "ALLOW_PAGENAV" => "Y",
                    "ALLOW_USER_PAGENAV" => $arParams['ALLOW_USER_PAGENAV'],
                    "COUNT" => "25",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "36000000",
                    "CACHE_WITH_FILTER" => $arParams['CACHE_WITH_FILTER'],
                    "CACHE_WITH_SORTING" => $arParams['CACHE_WITH_SORTING'],
                    "CACHE_WITH_PAGING" => $arParams['CACHE_WITH_PAGING'],
                    "SET_TITLE" => "N",
                ),
                $component
            );
            */?>
        </div>
    </div>
    brands-catalog-->
    <div class="block-viewed catalog-viewed">
        <?$APPLICATION->IncludeFile("includes/last-viewed-main.php");?>
    </div>


<?endif; // if ($_GET['compare'])?>