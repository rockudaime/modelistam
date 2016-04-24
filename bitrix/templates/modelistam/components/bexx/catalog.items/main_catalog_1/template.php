<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
//$this->setFrameMode(true);
//PST-9
?>

<?//d($arResult);?>
<?if (is_array($arResult['ITEMS'])):?>
    <?
    // Небольшие настройки шаблона
    $new_days = 200; // Количество дней с момента появления товара, в течение которых товар считается новым
    $arUriKillParams = array( // Эти параметры удаляются из адреса страницы в постраничной навигации
        "page", // номер страницы
        "p", // количество элементов на страницу
        "s", // поле для сортировки
        "d", // направление сортировки
        "sort", // сортировка (устаревшее)
        "s_prop", // поле для сортировки по характеристикам
        "s_prop_dir", // направление для сортировки по характеристикам
        "reset_sorting", // сброс сортировки
        "view", // отображение списка товаров (block или list)
        "clear_cache",
        "prop",
        "price",
        "back_url",
        "availability",
        "Brand"
    );
    ?>
    <?if ($arParams['ALLOW_USER_PAGENAV']=="Y"):?>
        <!-- panel -->
        <form id="sort-form" method="get" action="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>">
            <input type="hidden" name="sort" id="sort-order" value="" />
            <input type="hidden" name="p" id="paging" value="" />
            <div class="sort sort-main-block">

               <!-- <div id="product-sort-simple" class="product-sort-simple">
                    <?if (is_array($arParams['SORTING_PANEL_OPTIONS']) AND !empty($arParams['SORTING_PANEL_OPTIONS'])):?>
                        <div class="product-sort-simple__inner">

                            <?if (isset($_SESSION['sorting'])):?>
                                <a class="product-sort__clear" href="<?=$APPLICATION->GetCurPageParam("reset_sorting", $arUriKillParams, false)?>">Сбросить</a>
                            <?endif;?>

                            <select class = "sort_select" onChange="if(value!=''){location=value}else{options[selectedIndex=0];}">
                                <option disabled selected><b>Сортировать</b></option>
                            <?$counter=0?>
                            <?foreach ($arResult['SORTING_NAMES'] as $sk=>$sort_name):?>
                                <?$counter++?>
                                <?if ($sk):?>
                                    <?
                                    if (strpos($sk, "property_")===0 AND $sort_name==1) {
                                        $sort_name = $arResult['PROPERTIES'][str_replace("property_", "", $sk)]['NAME'];
                                    }
                                    ?>
                                    <?if ($_SESSION['sorting']==$sk):?>
                                        <option value="<?=$APPLICATION->GetCurPageParam("s=".$sk."&d=".($_SESSION['sorting_dir']=="asc"?"desc":"asc"), $arUriKillParams, false)?>">
                                        <a class="selected product-sort__link"><?=strtolower($sort_name)?>
                                            <img src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-sort-<?=$_SESSION['sorting_dir']=="asc"?"up":"down"?>.gif" alt="<?=strtolower($sort_name)?>" />
                                        </a>
                                        </option>
                                    <?else:?>
                                       <option value="<?=$APPLICATION->GetCurPageParam("s=".$sk, $arUriKillParams, false)?>"><a class="product-sort__link" ><?=strtolower($sort_name)?></a></option>
                                    <?endif;?>
                                <?endif;?>
                            <?endforeach;?>
                            </select>
                        </div>
                    <?endif;?>
                </div>-->
                <div id="product-sort-simple" class="product-sort-simple">
                    <?if (is_array($arParams['SORTING_PANEL_OPTIONS']) AND !empty($arParams['SORTING_PANEL_OPTIONS'])):?>
                        <div class="product-sort-simple__inner">
                            <b>Сортировать:</b>
                            <?$counter=0?>
                            <?foreach ($arResult['SORTING_NAMES'] as $sk=>$sort_name):?>
                                <?$counter++?>
                                <?if ($sk):?>
                                    <?
                                    if (strpos($sk, "property_")===0 AND $sort_name==1) {
                                        $sort_name = $arResult['PROPERTIES'][str_replace("property_", "", $sk)]['NAME'];
                                    }
                                    ?>
                                    <?if ($_SESSION['sorting']==$sk):?>
                                        <a class="selected product-sort__link" href="<?=$APPLICATION->GetCurPageParam("s=".$sk."&d=".($_SESSION['sorting_dir']=="asc"?"desc":"asc"), $arUriKillParams, false)?>"><?=strtolower($sort_name)?>
                                            <img src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-sort-<?=$_SESSION['sorting_dir']=="asc"?"up":"down"?>.gif" alt="<?=strtolower($sort_name)?>" />
                                        </a>
                                    <?else:?>
                                        <a class="product-sort__link" href="<?=$APPLICATION->GetCurPageParam("s=".$sk, $arUriKillParams, false)?>"><?=strtolower($sort_name)?></a>
                                    <?endif;?>
                                <?endif;?>
                            <?endforeach;?>
                            <?if (isset($_SESSION['sorting'])):?>
                                <a class="product-sort__clear" href="<?=$APPLICATION->GetCurPageParam("reset_sorting", $arUriKillParams, false)?>">Сбросить</a>
                            <?endif;?>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </form>
        <!-- / panel -->
    <?endif;?>

    <div id="catalog-container">
    <div class="front-right">
        <div class="front-gallery-block">
            <div class="front-gallery-block__left">
                <?if ($arParams['SHOW_SLIDER'] !== 'N'):?>

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
                            "NAVIGATION_TEXT_NEXT" => "вперед"
                        ),
                        false
                    );?>


                </div>
                <?endif;?>
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

        <div class="main-catalog-products main-catalog-products--<?=$arParams['CURRENT_VIEW'];?>">
            <?$i=0;?>
            <?include("view_".$arParams['CURRENT_VIEW'].".php");?>
        </div>

        <?//TM-19?>
        <?if (!strstr($_SERVER['REQUEST_URI'], "?") || strpos($_SERVER['REQUEST_URI'], 'p=')):?>
       <!-- <div class="show-more-block">
            <img class="show-more-ajax-loader" alt="Loading.." src="<?//=SITE_TEMPLATE_PATH?>/images/big_ajax_loader.gif" />
            <a href="#" id="ajax-link-show-more" class="button-show-more">Еще <span class="ajax-items-count"><?//=$arParams['COUNT'];?></span> товаров</a>
        </div>-->
        <?endif;?>
        <?//TM-19?>

        <?
        //PST-9
        $frame = $this->createFrame()->begin('');
        //PST-9
        ?>

        <script type="text/javascript">
            BIS.catalogItemsObj = {
                init: function() {
                    this.addAjaxBuyFunc();
                    this.addSkuChangeHandler();
                },
                addAjaxBuyFunc: function() {
                     var container = $('.main-catalog-products');

                    container.on('click', '.ajax-buy-product', function() {
                        var id = $(this).attr('href');
                        var data = $('#product-order-form-'+id).serializeArray();

                        ajax_load('#product-order-'+id, '<?=$arResult['AJAX_CALL_ID']?>', data);
                        $.gritter.add({
                            title: 'Товар в корзине!',
                            text: "Вы успешно добавили товар в <a href='/personal/cart/'>корзину</a>",
                            time: 2000
                        });
                        return false;
                    });
                },
                addSkuChangeHandler: function() {
                    var sku = $('.sku_change');

                    sku.change(function(){
                        var parent_id = $(this).attr('rel');
                        var sku_id = $(this).val();
                        $('.sku_price').hide();
                        $('#sku_price_'+sku_id).show();
                        $('#product-order-id-'+parent_id).val(sku_id);
                        //ajax_load('#sku_price_'+parent_id, '<?=$arResult['AJAX_CALL_ID']?>', {'do': "update_sku", 'id': parent_id, 'sku': sku_id});
                        return false;
                    });
                }
            };

            BIS.ajax24More = {
                container: $('.main-catalog-products'),
                products: '',
                ajaxID: "<?=$arResult['AJAX_CALL_ID']?>",
                ajaxLink: $('#ajax-link-show-more'),
                ajaxLinkCount: $('.ajax-items-count'),
                totalItemsLeft: <?=$arResult['NAV']['TOTAL']?>,
                pagerNextID: '',
                params: {
                    'do': 'show_more',
                    'count': <?=$arParams['COUNT']?>,
                    'ids': []
                },
                addHandlerForShowMoreLink: function() {
                    var self = this;

                    var pagerBlock = $('.pager-main-block');
                    var pagerCurrent = $('.pager__inner-elem--current');
                    var pagerCurrentID = parseInt(pagerCurrent.text());
                    var pagerNext;
                    var pagerShowedElem = $('#pager-total-showed');
                    var pagerShowedVal = self.params.count;

                    //for pager (works only if pagerCurrentID == 1)
                    if(pagerCurrentID == 1) {
                        self.pagerNextID = pagerCurrentID;
                    }

                    self.updateUI();
                    self.updateParams();

                    self.ajaxLink.on('click', function(e) {
                        e.preventDefault();
                        self.updateAjaxItems();

                        // for paging UI update
                        if (self.pagerNextID > 0) {
                            self.pagerNextID = self.pagerNextID + 1;
                            pagerNext =  pagerBlock.find(".pager__inner-elem[data-nav='" + self.pagerNextID + "']")
                            pagerNext.html("<span>"+self.pagerNextID+"</span>");

                            if (self.totalItemsLeft > self.params.count) {
                                pagerShowedVal = pagerShowedVal + self.params.count;
                            } else {
                                pagerShowedVal = pagerShowedVal + self.totalItemsLeft;
                            }

                            pagerShowedElem.html(pagerShowedVal)
                        }

                    });
                },
                updateUI: function() {
                    var self = this;

                    self.ajaxLink.hide();

                    if (self.totalItemsLeft > self.params.count) {
                        self.ajaxLink.show();

                        self.totalItemsLeft = self.totalItemsLeft - self.params.count;

                        if (self.totalItemsLeft < self.params.count) {
                            self.ajaxLinkCount.text(self.totalItemsLeft);
                        } else {
                            self.ajaxLinkCount.text(self.params.count);
                        }
                    }
                },
                updateParams: function() {
                    var self = this;

                    self.products = $('#catalog-container').find('.product');
                    self.params.ids.length = 0;

                    if (self.products.length) {
                        self.products.each(function() {
                            self.params.ids.push($(this).find('.product__code > span').text());
                        })
                    }
                },
                updateAjaxItems: function() {
                    var ajaxLoader = $('.show-more-ajax-loader');
                    var self = this;
                    var params;

                    self.ajaxLink.hide();
                    ajaxLoader.show();

                    if (!$.isArray(self.params)) {
                        params = $.queryString(self.params);
                    }

                    $.post('/bitrix/tools/ajax.php?ajax_call='+self.ajaxID, params, function (data) {
                        if (self.container) {
                            $(self.container).append(data);
                        }
                    }).done(function() {
                        ajaxLoader.hide();
                        self.updateUI();
                        self.updateParams();
                    });
                }
            }

            $(function() {
                BIS.catalogItemsObj.init();
                BIS.ajax24More.addHandlerForShowMoreLink();
            });
        </script>
        <?//TM-19?>

        <?
        //PST-9
        $frame->end();
        //PST-9
        ?>


        <? /* Pager bottom */ ?>
        <?if ($arResult['NAV']['PAGES_COUNT']>1 AND $arParams['ALLOW_PAGENAV']=="Y"):?>
            <div class="catalog-bottom-pager">

                <div class="pager-main-block">
                    <div class="catalog-nav">
                    <?if ($arResult['NAV']['CURRENT_PAGE']>1):?>
                        <?
                        /* SEO RECOMMENDATIONS */
                        $returnToBeginPage = $APPLICATION->GetCurPageParam("", array("page"), false);
                        if ($arResult['NAV']['CURRENT_PAGE'] != 2) {
                            $returnPage = $APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']-1), array("page"), false);
                        } else {
                            $returnPage = $returnToBeginPage;
                        }
                        ?>
                        <!--<a class="pmb-black" href="<?=$returnToBeginPage;?>">В начало</a>-->
                        <a class="pmb-black prev-navigation" href="<?=$returnPage;?>"><i></i>Предыдущая</a>
                    <?endif;?>
                <div class="nav-elems">
                    <?
                    $left_space = 0;
                    $right_space = 0;
                    for ($i=1; $i<=$arResult['NAV']['PAGES_COUNT']; $i++) {
                        if ($arResult['NAV']['PAGES_COUNT'] < 5) {
                            if ($arResult['NAV']['CURRENT_PAGE'] == $i):?>
                                <span class="pager__inner-elem pager__inner-elem--current"><?=$i?></span> &nbsp;
                            <?else:?>
                                <span class="pager__inner-elem" data-nav="<?=$i?>"> <a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"<?if ($arResult['NAV']['CURRENT_PAGE'] == $i) echo ' class="current_page"';?>><?=$i?></a> </span> &nbsp;
                            <?endif;
                        } else {
                            if ($arResult['NAV']['CURRENT_PAGE'] == $i) {
                                ?> <span class="pager__inner-elem pager__inner-elem--current strong"><?=$i?></span> &nbsp; <?
                            } else {
                                if ($i-1 == $arResult['NAV']['CURRENT_PAGE'] OR $i+1 == $arResult['NAV']['CURRENT_PAGE']
                                    OR $i-2 == $arResult['NAV']['CURRENT_PAGE'] OR $i+2 == $arResult['NAV']['CURRENT_PAGE']) {
                                    ?> <span class="pager__inner-elem" data-nav="<?=$i?>"><a href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a></span> &nbsp; <?
                                } elseif ($i < $arResult['NAV']['PAGES_COUNT'] AND $i > $arResult['NAV']['CURRENT_PAGE']) {
                                    if ($right_space == 0) echo "&nbsp;&rarr;&nbsp;";$right_space++;
                                } elseif ($i > 1 AND $i < $arResult['NAV']['CURRENT_PAGE']) {
                                    if ($left_space == 0) echo "&nbsp;&larr;&nbsp;"; $left_space++;
                                } else {
                                    ?> <span class="pager__inner-elem" data-nav="<?=$i?>"><a  href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a></span> &nbsp; <?
                                }
                            }
                        }
                    }
                    ?>
                </div>
                    <?if ($arResult['NAV']['CURRENT_PAGE']<$arResult['NAV']['PAGES_COUNT']):?>
                        <a class="pmb-black next-navigation" href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']+1), array("page"), false)?>">Следующая<i></i></a>
                        <!--<a class="pmb-black" href="<?=$APPLICATION->GetCurPageParam("page=".$arResult['NAV']['PAGES_COUNT'], array("page"), false)?>">В конец</a>-->
                    <?endif;?>
                    </div>
                </div>

                <!--<div class="pager-bottom-block">
                    <!-- paging
                    <?if ($arResult['NAV']['PAGES_COUNT'] > 1 OR $arParams['ALLOW_PAGENAV']=="Y"):?>
                        <form id="paging-form" method="get" action="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>">
                            <div class="pager">
                            <span class="grey">
                                <?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+1?>
                                -
                                <span id="pager-total-showed"><?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+count($arResult['ITEMS'])?></span>
                                из
                            </span>
                                <span class="strong"><?=$arResult['NAV']['TOTAL']?></span>
                                <?if ($arParams['ALLOW_USER_PAGENAV']=="Y"):?>
                                    <span class="grey">| показывать по</span>
                                    <select name="p" onchange="$('#paging-form').submit();">
                                        <?if (!is_array($arParams['PER_PAGE_VARIANTS']) OR empty($arParams['PER_PAGE_VARIANTS'])) {
                                            $arParams['PER_PAGE_VARIANTS'] = array(10, 20, 30, 50, 100); // дефолтное значение
                                        }?>
                                        <?foreach ($arParams['PER_PAGE_VARIANTS'] as $v):?>
                                            <?if ($v):?>
                                                <option value="<?=$v?>" <?if ($arParams['COUNT']==$v):?>selected<?endif;?>><?=$v?></option>
                                            <?endif;?>
                                        <?endforeach;?>
                                    </select>
                                <?endif;?>
                            </div>
                        </form>
                    <?endif;?>
                    <!-- / paging
                </div>-->

            </div>
        <?endif;?>
    </div>
    <!-- / #catalog-container -->

<?else:?>
    <p>Ничего не найдено</p>
<?endif;?>