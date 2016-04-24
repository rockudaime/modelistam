<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// этот файл можно использовать под свои нужды
?>
<div class="front-bottom-wrap">
    <?if (!$isCart && !$isOrderPage):?>
    <div class="front-middle-footer">
        <div class="front-location-title">
            <?$APPLICATION->IncludeFile("includes/front-location-title.php");?>
        </div>

        <ul class="location-tab">
            <li class="salon-cities-tabs salon-active"><a data-id="kyiv" href="#" rel="#" class="salon-city-link">В Киеве</a></li>
            <li class="salon-cities-tabs"><a data-id="kharkiv" href="#" rel="#" class="salon-city-link">В Харькове</a></li>
        </ul>
        <div class="cities-location">
            <div id="kyiv" class="front-location-kyiv salon-information">
                <div class="location-main">
                    <div class="location-main-top">
                        <?$APPLICATION->IncludeFile("includes/front-location-kyiv.php");?>
                    </div>
                </div>
            </div>
            <div id="kharkiv" class="front-location-kharkiv salon-information">
                <div class="location-main">
                    <div class="location-main-top">
                        <?$APPLICATION->IncludeFile("includes/front-location-kharkiv.php");?>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="front-left">
                    <?//$APPLICATION->IncludeFile("includes/front-interesting-news.php");?>

                    <div class="block-votes">
                        &nbsp;
                    </div>
                </div>-->

        <div class="front-right">
            <div class="front-text">
                <?$APPLICATION->IncludeFile("includes/front-page-info.php");?>
            </div>
            <div class="front-left">
                <div class="front-sidebar">
                    <?$APPLICATION->IncludeFile("includes/menu-new.php");?>
                    <?$APPLICATION->IncludeFile("includes/front-catalog-menu.php");?>
                    <?$APPLICATION->IncludeFile("includes/menu-new-bottom.php");?>
                    <!--<div class="block-catalog-all">
                        <a href="#"><i class="mobile-menu-icon"></i>Весь каталог</a>
                    </div>-->
                </div>
            </div>
            <!--<div class="delivery-info">
                        <?//$APPLICATION->IncludeFile("includes/delivery-information.php");?>
                    </div>-->
        </div>
    </div>
    <?endif;?>
</div>
</div>
</div>
</div>
</div>

</div>
</div>



<div id="footer-wrapper">
    <div class="footer-login-mobile">
        <?$APPLICATION->IncludeFile("includes/top-login-block.php");?>
    </div>
    <div id="footer">
        <div class="footer__inner">
            <?if ($isCart || $isOrderPage):?>
                <div class="cart-contacts__content cart-contacts-footer">
                    <div data-box="box-1" class="contacts__tabs__box">
                        <div class="phone-header"> <span>(057)</span>755-15-00</div>
                        <div class="phone-header"> <span>(067)</span>144-27-27</div>
                        <div class="phone-header"> <span>(066)</span>626-88-44</div>
                        <div class="phone-header"> <span>(093)</span>002-25-88</div>
                    </div>
                    <div class="cart-contacts__callback">
                        <a class="cart-fcontacts__callback-link" id="cart-fcallback-link" href="javascript:void(0)">перезвонить мне</a>
                    </div>
                </div>
            <?endif;?>
            <?if (!$isCart && !$isOrderPage):?>
           <!-- <div class="footer-catalog">

                <div class="footer-menu-new">
                    <?//$APPLICATION->IncludeFile("includes/menu-new.php");?>
                </div>-->

                <?/*
                $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "template_icons", array(
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
            <div class = "footer-links">
                <div class = "footer-items">
                    <ul class="info-menu">
                        <li class = "info-item">
                            <a href="#">Всегда в наличии</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Самолеты</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Вертолеты</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Яхты</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Квадрокоптеры</a>
                        </li>
                    </ul>
                </div>

                <div class = "footer-info">
                    <ul class="info-menu">
                        <li class = "info-item">
                            <a href="#">Ваши покупки</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Вопросы и ответы</a>
                        </li>
                        <li class = "info-item">
                            <a href="/about/delivery/">Доставка и оплата</a>
                        </li>
                        <li class = "info-item">
                            <a href="/about/guarantee/">Гарантия</a>
                        </li>
                    </ul>
                </div>

                <div class = "information">
                    <ul class="info-menu_last">
                        <li class = "info-item">
                            <a href="#">Блог</a>
                        </li>
                        <li class = "info-item">
                            <a href="/about/contacts/">Контакты</a>
                        </li>
                        <li class = "info-item">
                            <a href="/about/">О нас</a>
                        </li>
                        <li class = "info-item">
                            <a href="#">Вакансии</a>
                        </li>
                    </ul>
                </div>
            </div>
                <?$APPLICATION->IncludeFile("includes/footer-contacts.php");?>
            <?endif;?>
            </div>
            <!--<div class="footer-menu">
                <?/*$APPLICATION->IncludeComponent('bitrix:menu', "bottom", array(
                    "ROOT_MENU_TYPE" => "footermenu",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(),
                    "MAX_LEVEL" => "1",
                    "USE_EXT" => "N",
                    "ALLOW_MULTI_SELECT" => "N"
                    )
                );*/?>
            </div>-->
        </div>

       <!-- <div class="footer__copyright">
            <?//$APPLICATION->IncludeFile("includes/footer-copyright.php");?>
        </div>-->

        <div class="bis-logo">
            <a href="http://bis-expert.com">
                <img src="<?=SITE_TEMPLATE_PATH?>/images/bis/logo.png" alt="BIS-Expert logo" title="магазин разработан в bis-expert.com">
            </a>
        </div>

    </div>
</div>

<?$APPLICATION->IncludeFile('includes/up-arrow.php');?>
<?$APPLICATION->IncludeFile("includes/callback.php");?>
<?$APPLICATION->IncludeFile("includes/JS.php");?> <?/* additional JS */?>

<?
//MM-63
$add_title_filter = '';

$return_title = $APPLICATION->GetPageProperty('add_page_title'); //шаблон для верхнего раздела, анпример Автомобили
$add_title_filter = $APPLICATION->GetPageProperty('add_title_filter');
$return_title = str_replace("#FILTER#", $add_title_filter, $return_title);

//MM-134
$add_meta_description = $APPLICATION->GetPageProperty("add_meta_description");
$add_meta_keywords = $APPLICATION->GetPageProperty("add_meta_keywords");
$add_custom_h1 = $APPLICATION->GetPageProperty("add_custom_h1");
$add_custom_title = $APPLICATION->GetPageProperty("add_custom_title");

if ($add_custom_title) $return_title = $add_custom_title;
if ($add_meta_keywords) $APPLICATION->SetPageProperty("keywords", $add_meta_keywords);
if ($add_meta_description) $APPLICATION->SetPageProperty("description", $add_meta_description);
//MM-134

if (!$return_title){
    $return_title = $add_title.$APPLICATION->GetProperty("browser_title"); // Заголовок окна браузера
}
//$return_title = $APPLICATION->GetProperty("browser_title"); // Заголовок окна браузера
//MM-63

if (!$return_title) $return_title = $APPLICATION->GetTitle(); // Заголовок страницы
if (!$return_title) $return_title = $MAIN_LANGS_CACHE[SITE_ID]['NAME']; // Название сайта
if (!$return_title) $return_title = $MAIN_OPTIONS['-']['main']['site_name']; // Название системы

$APPLICATION->SetPageProperty("page_title", $return_title);

if ($APPLICATION->GetProperty('not_show_page_title')!="Y")
    if ($APPLICATION->GetProperty('custom_h1') !="Y")
        //$APPLICATION->SetPageProperty("page_title_h1", "<h1 class='pagetitle'>".$APPLICATION->ShowTitle(false).$APPLICATION->ShowProperty("ADDITIONAL_TITLE", "")."</h1>");
        $APPLICATION->SetPageProperty("page_title_h1", "<h1 class='pagetitle'>".$return_title.$APPLICATION->ShowProperty("ADDITIONAL_TITLE", "")."</h1>");
    else
        $APPLICATION->SetPageProperty("page_title_h1", "<h1 class='pagetitle'>".$APPLICATION->ShowProperty('custom_h1_text')."</h1>");
?>

<?//MM-134
if ($add_custom_h1) $APPLICATION->SetPageProperty("page_title_h1", "<h1 class='pagetitle'>".$add_custom_h1."</h1>");
//MM-134?>

<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_footer_props");?>
<span id="dynamic_footer_props">
<?//PST-9?>

<?
    $noindex = ($APPLICATION->GetPageProperty('noindex')=='Y') ? true : false;
    if ($noindex) {
        $APPLICATION->SetPageProperty("meta", "<meta name='robots' content='noindex,nofollow' />");
    }
    else
    {
    $reqURI = $_SERVER['REQUEST_URI'];
    if ((strstr($reqURI, "[]"))
        || (strstr($reqURI, "//"))
        || (strstr($reqURI, "?") and !strpos($reqURI, 'page=') and !strpos($reqURI, 'Brand='))
        || (strpos($reqURI, "&") !== false)) {
            $APPLICATION->SetPageProperty("meta", '<meta name="robots" content="noindex,nofollow" />');
        } else if ((strpos($reqURI, "page=") !== false) || (strpos($reqURI, "Brand=") !== false)) {
            $APPLICATION->SetPageProperty("meta", '<meta name="robots" content="index,follow" />');
        }
    }
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>

<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>

<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_footer_props", "");?>
<?//PST-9?>

<!--</div>-->

<script src="<?=SITE_TEMPLATE_PATH?>/js/city_adress_mobile_tabs.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/category_filter_button.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/js/sidebar_menu.js"></script>
</body>
</html>
