<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE html>
<html>
<head>
    <?//значения meta, page_title и page_title_h1 устанавливаются в футере?>
    <?$APPLICATION->ShowProperty("meta");?>
    <title><?$APPLICATION->ShowProperty("page_title");?></title>
    <?=$APPLICATION->ShowMeta("keywords")?>
    <?=$APPLICATION->ShowMeta("description")?>
    <meta http-equiv="Content-Type" content="text/html; charset=<?=SITE_CHARSET?>" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <?
    echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true ? ' /':'').'>'."\n";
    ?>
    <link type="image/ico" rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/images/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/normalize.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fancybox.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/flexslider.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/gritter.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/slicknav.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/jquery/rater/rateit.css" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700' rel='stylesheet' type='text/css'>
    <?$APPLICATION->ShowCSS(true, true)?>
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/owl.theme.css" />
    <link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/css/owl.transitions.css" />
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.fancybox.pack.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.ba-url.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.autocomplete.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/script.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/rater/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/hoverIntent.minified.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/jquery.gritter.js"></script>
    <script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery/3d/spritespin.js"></script>

    <?//=$APPLICATION->GetHeadScripts(); // Дополнительные скрипты в head ?>
    <?//=$APPLICATION->GetHeadStrings(); // Дополнительные строки ?>
    <?
    $APPLICATION->ShowHeadStrings();
    $APPLICATION->ShowHeadScripts();
    ?>
    <?$APPLICATION->IncludeFile("includes/init-socials.php");?>
</head>

<?//PST-9?>
<?\Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("dynamic_globals");?>
<span id="dynamic_globals">
<?//PST-9?>
<?
// Получаем содержимое корзины для текущего пользователя
/*if (CModule::IncludeModule("sale")) {
    $arCartContent = array();
    $arWishlistContent = array();
    $rsCart = CSaleBasket::GetList(array("DATE_UPDATE"=>"DESC"), array('FUSER_ID'=>CSaleBasket::GetBasketUserID(), 'ORDER_ID'=>NULL, 'LID'=>SITE_ID), false, false, array('PRODUCT_ID', 'QUANTITY', 'DELAY', 'CAN_BUY'));
    if (is_object($rsCart)) {
        while ($arCart = $rsCart->GetNext()) {
            // , 'DELAY'=>"N", 'CAN_BUY'=>"Y"
            if ($arCart['DELAY']=="Y") {
                $arWishlistContent[$arCart['PRODUCT_ID']] = 1;
            } else {
                $arCartContent[$arCart['PRODUCT_ID']] = $arCart['QUANTITY'];
            }
        }
    }
}
$GLOBALS['cart_content'] = $arCartContent; // Глобализация шагает по планете
$GLOBALS['wishlist_content'] = $arWishlistContent; // Глобализация шагает по планете*/
$template_path = str_replace("\\", "/", substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']))); // Путь к текущему шаблону
?>
<?//PST-9?>
</span>
<?\Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("dynamic_globals", "");?>
<?//PST-9?>
<?
$template_path = str_replace("\\", "/", substr(dirname(__FILE__), strlen($_SERVER['DOCUMENT_ROOT']))); // Путь к текущему шаблону

//PST-9
//$isCatalog = ($APPLICATION->GetPageProperty('is_catalog')=='Y') ? true : false;
//$isPersonalPage = ($APPLICATION->GetPageProperty('is_personal')=='Y') ? true : false;

$isCatalog = CSite::InDir('/catalog/');
$isHome =  CSite::InDir('/index.php');
$isCart = CSite::InDir('/personal/cart/');
$isOrderPage = CSite::InDir('/personal/order/');

if (CSite::InDir('/personal/orders') || CSite::InDir('/personal')) $isPersonalPage = true;

if (CSite::InDir('/404.php')
    || CSite::InDir('/news/brands')
    //MM-107
    || CSite::InDir('/require_purchase/')
    //MM-107
    || ($APPLICATION->GetCurPage(true) == SITE_DIR.'index.php')
    ) $not_show_breadcrumb = true;
//PST-9
?>

<?
$bodyClasses = '';

if ($APPLICATION->GetProperty('no_padding') == "Y") {
    $bodyClasses = ' no-padding';
}

if ($USER->IsAdmin()) {
    $bodyClasses .= ' site-admin-logged';
} elseif ($USER->IsAuthorized()) {
    $arUserGroups = CUser::GetUserGroup(CAllUser::GetID());
    //администраторы интернет магазина
    if (in_array(4, $arUserGroups)) {
        $bodyClasses .= ' site-admin-logged';
    }
}

if ($isHome) {
    $bodyClasses .= ' home-page';
}
if ($isCart) {
    $bodyClasses .= ' cart-page';
}
if ($isOrderPage) {
    $bodyClasses .= ' order-page';
}
?>

<body class="default <?php echo $bodyClasses;?>">
    <div id="panel-wrap"><?if ($USER->isAdmin()) $APPLICATION->GetPanel();?></div>
    <div id="fb-root"></div>
    <?if ($isHome):?>
        <div class="bg-front-items"></div>
    <?endif;?>
<div id="page-wrapper">
    <div class="page-header-wrapper">
        <?if (!$isCart && !$isOrderPage):?>
        <div id="top-menu" class="header__top-menu">
            <div class="header__top-menu__inner i-clearfix">
                <?if (!$isHome):?>
                    <div class="top-menu-left-text">
                        <span>Специализированный магазин моделей и аксесуаров.</span>
                        <span>Продажа и обслуживание</span>
                    </div>
                <?endif;?>
                <div class="header__phones-top-menu">
                    <?$APPLICATION->IncludeFile("includes/phones-tablet.php");?>
                </div>
               <div class="top-client">
                    <a class="client-link" href="/catalog/">
                        <span>Покупателю</span>
                    </a>
                    <div class="to-client">
                        <a href="#" rel="#"><span>Пункт 1</span></a>
                        <a href="#" rel="#"><span>Пункт 2</span></a>
                        <a href="#" rel="#"><span>Пункт 3</span></a>
                        <a href="#" rel="#"><span>Пункт 4</span></a>
                    </div>
               </div>
                <?$APPLICATION->IncludeComponent("bitrix:menu", "horizontal", array(
                    "SPECIAL_ID" =>'TOP',
                    "ROOT_MENU_TYPE" => "top",
                    "MENU_CACHE_TYPE" => "N",
                    "MENU_CACHE_TIME" => "36000000",
                    "MENU_CACHE_USE_GROUPS" => "Y",
                    "MENU_CACHE_GET_VARS" => array(
                    ),
                    "MAX_LEVEL" => "1",
                    "CHILD_MENU_TYPE" => "left",
                    "USE_EXT" => "N",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N"
                    ),
                    false
                );?>

                <?$APPLICATION->IncludeFile("includes/top-login-block.php");?>
                <div class="top-cart">
                    <?$APPLICATION->IncludeComponent("bexx:cart", "top_block", array(
                            "SHOW_DETAILS" => "N",
                            "ORDER_DISCOUNT" => "N",
                            "DELIVERY_ALLOW" => "N",
                            "NOT_DELIVERY_SAME_CITY" => array(
                            ),
                            "WISHLIST" => "N",
                            "SET_TITLE" => "N",
                            "TOP_TEMPLATE" => "Y",
                            "CACHE_TYPE" => "N",
                            "PATH_TO_CART" => "/personal/cart/",
                            "PATH_TO_ORDER" => "/personal/order/",
                        ),
                        false
                    );?>
                </div>
                <div class="top-links-menu">
                    <?$APPLICATION->IncludeFile("includes/top-icons.php");?>
                </div>
            </div>

        </div>
        <?endif;?>
        <div class="page-header-wrapper__inner">
            <div id="header" class="header">
                <div class="header__container i-clearfix">
                    <?if (!$isCart && !$isOrderPage):?>
                    <div class="header__logo">
                        <?$APPLICATION->IncludeFile("includes/logo.php");?>
                        <!--<div class="header__logo__descr">
                            <?//$APPLICATION->IncludeFile("includes/logo-descr.php");?>
                        </div>-->
                    </div>
                        <div class="phone-mobile">
                            <span>(067)144 27 27</span>
                        </div>
                    <?endif;?>
                    <?if ($isCart || $isOrderPage):?>
                    <div class="header__logo logo-cart">
                    <?$APPLICATION->IncludeFile("includes/logo-cart.php");?>
                    <!--<div class="header__logo__descr">
                    <?//$APPLICATION->IncludeFile("includes/logo-descr.php");?>
                     </div>-->
                        <div class = "navigation-items">
                            <ul class="nav-items-list">
                                <li class="nav-items-item"><i></i><span class="cart-border">Ваш заказ</span></li>
                                <li class="nav-items-item"><i></i><span>Заказ оформлен</span></li>
                            </ul>
                        </div>
                    </div>
                    <?endif;?>
                    <?if ($isCart):?>
                        <div class="cart-contacts__content cart-contacts">
                            <div data-box="box-1" class="contacts__tabs__box">
                                <!-- <div class="phone-header"> <span>(057)</span>755-15-00</div>
                                <div class="phone-header"> <span>(067)</span>144-27-27</div>
                                <div class="phone-header"> <span>(066)</span>626-88-44</div>
                                <div class="phone-header"> <span>(093)</span>002-25-88</div> -->
                                <div class="phone-header"> <span>(0 800)</span>210-525</div>
                            </div>
                            <div class="cart-contacts__callback">
                                <a class="cart-contacts__callback-link" id="cart-callback-link" href="javascript:void(0)">перезвонить мне</a>
                            </div>
                        </div>
                    <?endif;?>
                    <?if (!$isCart):?>
                    <div class="header__middle">
                        <div class="header__middle-inner">
                            <div class="header__phones">
                                <?$APPLICATION->IncludeFile("includes/phones.php");?>
                            </div>
                            <!--<div class="header__work-hours">
                                <div class="online-block">
                                    <a href="javascript:void(0);" class="link-online">Онлайн поддержка</a>
                                </div>
                                <?//$APPLICATION->IncludeFile("includes/work-hours.php");?>
                            </div>-->
                        </div>
                        <div class="search-block">
                            <div class="search-block__bottom">
                                <?$APPLICATION->IncludeComponent("bexx:search.form.autocomplete", "bsp", array(
                                        "SEARCH_PATH" => "/search/",
                                        "DEFAULT_TEXT" => "Поиск...",
                                        "EXAMPLES_TEXT" => array(
                                        ),
                                        "EXAMPLES_COUNT" => "1",
                                        "AUTOCOMPLETE" => "Y",
                                        "IBLOCK_TYPE" => "catalog",
                                        "IBLOCK_ID" => "26",
                                        "SECTION_ID" => "",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "EXAMPLES_DB" => "N",
                                        "AUTOCOMPLETE_COUNT" => "15",
                                        "CACHE_TYPE" => "N",
                                        "CACHE_TIME" => "3600"
                                    ),
                                    false
                                );?>
                            </div>
                        </div>
                    </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
    <?if (!$isCart):?>
    <div class="head_color"></div>
    <?endif;?>
    <?if (!$isHome):?>
    <div class="page-main-menu-wrap">
        <div id="main-menu" class="page-main-menu i-clearfix">
            <a class="main-catalog-link" href="#">
            <span class="catalog-icon">
                <i></i><i></i><i></i>
            </span>
                <span>Каталог</span>
            </a>
            <script>
                $(".main-catalog-link").click(function(){
                        if($(window).width() > 640){
                            if($(".front-left").css('display') == 'none' ){
                                $(".front-left").css('display', 'block' );
                            }
                            else{
                                $(".front-left").css('display', 'none');
                            }
                            if($(".not-home-page").css('display') == 'none' ){
                                $(".not-home-page").css('display', 'block' );
                            }
                            else{
                                $(".not-home-page").css('display', 'none');
                            }
                        }
                });
            </script>
            <script>
                $(".main-catalog-link").mouseover(function(){
                            $(".not-home-page").css('display', 'block');
                            $(".front-left").css('display', 'block' );
                });
            </script>
            <?/*
            $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "main_menu", array(
                    "IBLOCK_TYPE" => "catalog",
                    "IBLOCK_ID" => "26",
                    "SECTION_ID" => "",
                    "SECTION_CODE" => "",
                    "COUNT_ELEMENTS" => "Y",
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
                    "CACHE_TIME" => "86400",
                    "CACHE_GROUPS" => "N",
                    "ADD_SECTIONS_CHAIN" => "N"
                ),
                false
            );*/?>

            <?if (!$not_show_breadcrumb):?>
                <div class="breadcrumb-wrap">
                    <div class="top-menu-breadcrumb-text">
                        <span>Специализированный магазин моделей и аксесуаров.</span>
                        <span>Продажа и обслуживание</span>
                    </div>
                    <div id="breadcrumb-search">
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
                        );
                        /*else
                        //TM-9
                            $APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
                                    "START_FROM" => "0",
                                    "PATH" => "",
                                    "SITE_ID" => "-"
                                ),
                                false,
                                Array('HIDE_ICONS' => 'Y')
                            );*/
                        ?>
                    </div>
                </div>
            <?endif;?>
        </div>
    </div>
    <?endif;?>
    <div id="main-menu" class="page-main-menu i-clearfix mobile-menu">
    <?/*
    $APPLICATION->IncludeComponent("bitrix:catalog.section.list", "main_menu", array(
            "IBLOCK_TYPE" => "catalog",
            "IBLOCK_ID" => "26",
            "SECTION_ID" => "",
            "SECTION_CODE" => "",
            "COUNT_ELEMENTS" => "Y",
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
            "CACHE_TIME" => "86400",
            "CACHE_GROUPS" => "N",
            "ADD_SECTIONS_CHAIN" => "N"
        ),
        false
    );*/?>
        <a class="main-catalog-link-mobile" href="#">
            <!--<span class="catalog-icon">
                <i></i><i></i><i></i>
            </span>-->
            <i></i>
            <span>Меню</span>
        </a>
        <script>
                $(".main-catalog-link-mobile").click(function(){
                        if($(".front-left").css('display') == 'none' ){
                            $(".front-left").css('display', 'block' );
                        }
                        else{
                            $(".front-left").css('display', 'none');
                        }

                    if($(window).width() < 640){
                        if($(".not-home-page").css('display') == 'none' ){
                            $(".not-home-page").css('display', 'block' );
                        }
                        else{
                            $(".not-home-page").css('display', 'none');
                        }
                     }
                });
        </script>

    </div>

    <?/* FRONT PAGE TEMPLATE */?>
    <?if ($isHome):?>
        <div class="front-bg">
            <a class="catalog-tablet-home" href="#">
                    <span class="catalog-icon">
                        <i></i><i></i><i></i>
                    </span>
                <span>Каталог</span>
            </a>
            <script>
                $(".catalog-tablet-home").click(function(){
                    if($(window).width() > 640){
                        if($(".front-left").css('display') == 'none' ){
                            $(".front-left").css('display', 'block')
                                .css('position','absolute')
                                .css('z-index','510')
                                .css('width','50%')
                                .css('background','#fff')
                                .css('top','50px')
                                .css('left','20px');
                        }
                        else{
                            $(".front-left").css('display', 'none');

                        }
                    }
                });

            </script>
            <script>
                $(".catalog-tablet-home").mouseover(function(){
                    if($(window).width() > 640){
                    $(".front-left").css('display', 'block' )
                        .css('position','absolute')
                        .css('z-index','510')
                        .css('width','50%')
                        .css('background','#fff')
                        .css('top','50px')
                        .css('left','20px');
                    }
                });
            </script>

             <div class="main-page-header">
         Специализированный магазин моделей и аксессуаров. Продажа и обслуживание</div>
    <?endif;?>
            <?if ($isHome):?>
            <div class="front-middle" id="parent1">
                <?endif;?>
                <?if (!$isHome || $isCart):?>
                <div class="not-home-page">
                    <div class="menu-inside">
                    <?endif;?>
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
                    <?if (!$isHome || $isCart):?>
                </div>
                </div>
                <script>
                    $(".front-left").mouseleave(function(){
                        $(".not-home-page").css('display', 'none');
                        $(".front-left").css('display', 'none' );
                    });
                </script>
            <?endif;?>
            <?if ($isHome):?>
                <div class="front-right">
                    <div class="front-gallery-block">
                        <div class="front-gallery-block__left">
                            <div class="front-wrapper-slider">
                                <?$APPLICATION->IncludeComponent("bisexpert:owlslider", ".default", array(
                                        "CACHE_TYPE" => "A",
                                        "CACHE_TIME" => "3600",
                                        "MAIN_TYPE" => "iblock",
                                        "COUNT" => "4",
                                        "IBLOCK_TYPE" => "slider_type",
                                        "IBLOCK_ID" => "43088",
                                        "LINK_URL_PROPERTY_ID" => "11634",
                                        "TEXT_PROPERTY_ID" => "11636",
                                        "SECTION_ID" => "0",
                                        "INCLUDE_SUBSECTIONS" => "Y",
                                        "SORT_FIELD_1" => "id",
                                        "SORT_DIR_1" => "asc",
                                        "SORT_FIELD_2" => "",
                                        "SORT_DIR_2" => "asc",
                                        "WIDTH_RESIZE" => "",
                                        "HEIGHT_RESIZE" => "",
                                        "IS_PROPORTIONAL" => "N",
                                        "ENABLE_OWL_CSS_AND_JS" => "Y",
                                        "ENABLE_JQUERY" => "N",
                                        "RESPONSIVE" => "Y",
                                        "COMPOSITE" => "Y",
                                        "AUTO_PLAY" => "Y",
                                        "AUTO_PLAY_SPEED" => "20000",
                                        "SCROLL_COUNT" => "1",
                                        "SPECIAL_CODE" => "slider",
                                        "AUTO_HEIGHT" => "Y",
                                        "RANDOM_TRANSITION" => "N",
                                        "TRANSITION_TYPE_FOR_ONE_ITEM" => "default",
                                        "SLIDE_SPEED" => "200",
                                        "PAGINATION_SPEED" => "800",
                                        "REWIND_SPEED" => "1000",
                                        "STOP_ON_HOVER" => "Y",
                                        "IMAGE_CENTER" => "Y",
                                        "RANDOM" => "Y",
                                        "SHOW_DESCRIPTION_BLOCK" => "N",
                                        "NAVIGATION" => "N",
                                        "NAVIGATION_TYPE" => "text",
                                        "PAGINATION" => "Y",
                                        "PAGINATION_NUMBERS" => "N",
                                        "DRAG_BEFORE_ANIM_FINISH" => "Y",
                                        "MOUSE_DRAG" => "Y",
                                        "TOUCH_DRAG" => "Y",
                                        "ITEMS_SCALE_UP" => "N",
                                        "DISABLE_LINK_DEV" => "N",
                                        "NAVIGATION_TEXT_BACK" => "назад",
                                        "NAVIGATION_TEXT_NEXT" => "вперед",
                                        "TEXT_ON_PAGINATION_BUTTON" => "Y",
                                        ),
                                        false
                                    );?>


                            </div>
<!--                            <ul class = "slide_buttons">-->
<!--                                <li><a class="items-slide-button" href="#">Новичкам</a></li>-->
<!--                                <li><a class="items-slide-button" href="#">Квадрокоптеры</a></li>-->
<!--                                <li><a class="items-slide-button" href="#">Авианабор</a></li>-->
<!--                            </ul>-->
<!--                            <script>-->
<!--                                $('.items-slide-button').click(function(){-->
<!--                                    $('a').removeClass('button-active');-->
<!--                                   $(this).addClass('button-active');-->
<!--                                });-->
<!--                            </script>-->
                        </div>
                        <!--<div class="front-gallery-block__right">
                            <?//$APPLICATION->IncludeFile("includes/filter-block.php");?>
                        </div>-->
                    </div>

                    <?//$APPLICATION->IncludeFile("includes/icons-block.php");?>

                    <!--<div class="block-video">
                        <?//$APPLICATION->IncludeFile("includes/news-video.php");?>
                    </div>-->

                    <!--<div class="block-new">
                        <?//$APPLICATION->IncludeFile("includes/front-new-products.php");?>
                    </div>-->

                    <!--<div class="block-news">
                        <?/*global $arrFilterNews;
                        $arrFilterNews = array("SECTION_ID" => 1337);
                        ?>
                        <?$APPLICATION->IncludeComponent("bitrix:news.list", "scroll-news", array(
                                "IBLOCK_TYPE" => "news_type",
                                "IBLOCK_ID" => "22",
                                "NEWS_COUNT" => "10",
                                "SORT_BY1" => "SORT",
                                "SORT_ORDER1" => "ASC",
                                "SORT_BY2" => "SORT",
                                "SORT_ORDER2" => "ASC",
                                "FILTER_NAME" => "arrFilterNews",
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
                        );*/?>
                    </div>-->
                </div>
      <?if ($isHome):?>
            </div>
       <?endif;?>
     <?if ($isHome):?>
        </div>
     <?endif;?>

        <div class="front-category-wrap">
            <div class="front-middle">
                <!--<div class="front-left">
                    &nbsp;
                </div>-->
				<?//MM-209?>
                <div class="block-viewed">
                    <?$APPLICATION->IncludeFile("includes/last-viewed-main.php");?>
                </div>
                <?//MM-209?>
				<?//MM-212?>
				<div class="category-top-items-wrap">
					<?$APPLICATION->IncludeFile("includes/category-top-items.php");?>
				</div>
				<?//MM-212?>
				<?//MM-213?>
                <div class="brands-main">
                    <?$APPLICATION->IncludeFile("includes/brands.php")?>
                </div>
                <?//MM-213?>
                <!--<div class="front-right">
                    <?//$APPLICATION->IncludeFile("includes/front-category.php");?>
                </div>-->
            </div>
        </div>
        <?endif;?>


    <div class="page-inner">
        <div id="content-wrapper">
            <div id="content">
                <div id="workarea">
                    <div class="top-holder">
                        <?$APPLICATION->ShowProperty("page_title_h1");?>
                    </div>
                    <div class="content-wrap">