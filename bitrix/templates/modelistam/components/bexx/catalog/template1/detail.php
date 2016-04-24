<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?
$APPLICATION->SetPageProperty("no_padding", "Y");
$APPLICATION->SetPageProperty("not_show_page_title","Y");
?>

<?
	if ((!empty($_SESSION['compare']) AND is_array($_SESSION['compare'])) OR (!empty($_GET['compare']) AND is_array($_GET['compare']))) {
		if (is_array($_SESSION['compare'])) {
			$ids = array_keys($_SESSION['compare']);
		}
		if (is_array($_GET['compare'])) {
			$ids = $_GET['compare'];
			$_SESSION['compare'] = array_combine($_GET['compare'], array_fill(0, count($_GET['compare']), 1));
		}
	}
?>

<?if ($arResult['ELEMENT_CODE']):?>

<div class="detail-container" id="detail-container">
	<div class="detail-container__content" id="detail-inner">
		<?$detailResult = $APPLICATION->IncludeComponent(
			"bexx:catalog.detail",
			"",
			Array(
				"IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
				"IBLOCK_ID" => $arParams['IBLOCK_ID'],
				"SECTION_ID" => '',
				"ID" => $arResult['ELEMENT_CODE'],
				"CATALOG_PATH" => $arParams['SEF_FOLDER'],
				"ALLOW_BUY_NOT_EXISTING" => $arParams['ALLOW_BUY_NOT_EXISTING'],
				"CHECK_ACTIVE" => $arParams['CHECK_ACTIVE'],
				"CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
				"GET_LINKED_ELEMENTS" => array(),
				"COMMENTS_ONLY_AUTHORIZED" => $arParams['COMMENTS_ONLY_AUTHORIZED'],
				"BUNDLES_IBLOCK_TYPE" => $arParams['BUNDLES_IBLOCK_TYPE'],
				"BUNDLES_IBLOCK_ID" => $arParams['BUNDLES_IBLOCK_ID'],
				"BUNDLES_COUNT" => $arParams['BUNDLES_COUNT'],
				"SKU_PROPS" => $arParams['SKU_PROPS'],
				"SKU_COUNT" => $arParams['SKU_COUNT'],
				"SKU_SORT_FIELD" => $arParams['SKU_SORT_FIELD'],
				"SKU_SORT_DIR" => $arParams['SKU_SORT_DIR'],
				"SKU_ONLY" => $arParams['SKU_ONLY'],
                //PST-9
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                //"CACHE_TYPE" => "N",
                //PST-9
				"CACHE_TIME" => is_numeric($arParams['DETAIL_PAGE_CACHE_TIME'])?$arParams['DETAIL_PAGE_CACHE_TIME']:$arParams['CACHE_TIME'],
				"SET_TITLE" => $arParams['SET_TITLE']
			),
			$component
		);?>

        <?/*
        if($detailResult['ID']):?>
            <div id="detail__comments" class="comment-block">
                <?if ($arParams['COMMENTS_IBLOCK_ID']):?>
                <a name="comments"></a>
                <div class="detail__comments__title">Отзывы покупателей </div>
                <?
                $APPLICATION->IncludeComponent("bexx:comments", "template_1", array(
                        "IBLOCK_TYPE" => $arParams['COMMENTS_IBLOCK_TYPE'],
                        "IBLOCK_ID" => $arParams['COMMENTS_IBLOCK_ID'],
                        "ELEMENT_ID" => $detailResult['ID'],
                        "ONLY_AUTHORIZED" => $arParams['COMMENTS_ONLY_AUTHORIZED'],
                        "MODERATE" => $arParams['COMMENTS_MODERATE'],
                        "EVENT_SEND" => $arParams['COMMENTS_EVENT_SEND'],
                        "MANAGED_CACHE_ID" => "comments".$detailResult['ID'],
                        "CAPTCHA" => $arParams['COMMENTS_CAPTCHA'],
                        "COUNT" => $arParams['COMMENTS_COUNT'],
                        //PST-9
                        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                        //"CACHE_TYPE" => "N",
                        //PST-9
                        "CACHE_TIME" => $arParams['CACHE_TIME'],
                    ),
                    $component
                );
                ?>
                <?endif;?>
            </div>
        <?endif; */?>
	</div>

   <?
   //BSP-40
   /*$array_brand_id = array();
   $rsEl = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 26, "SECTION_ID" => $detailResult['IBLOCK_SECTION_ID']), false, false);
   while ($obEl = $rsEl->GetNextElement()) {
       $arItem = $obEl->GetFields();
       $arItem['PROPERTIES'] = $obEl->GetProperties();
       if ($arItem['PROPERTIES']['Brand']['VALUE']) $array_brand_id[] = $arItem['PROPERTIES']['Brand']['VALUE'];
   }
   $array_brand_id = array_unique($array_brand_id);*/
   //BSP-40
   ?>

    <?if($detailResult['ID']):?>

    <div class="detail-container__bottom">
        <!--<div class="detail-container__reviews">
            <noindex>
                <div id="disqus_thread"></div>
                <script type="text/javascript">
                    /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
                    var disqus_shortname = 'modelistam'; // required: replace example with your forum shortname

                    /* * * DON'T EDIT BELOW THIS LINE * * */
                    (function() {
                        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                    })();
                </script>
                <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            </noindex>
        </div>-->
        <div class="detail__brands">
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
                    <a href="/info/service/" rel="#" class="products-service"><i></i><span>Обслуживание</span></a>
                    <a href="/info/howtochoice" rel="#" class="products-choise"><i></i><span>Как выбрать</span></a>
            </div>
            <div class="detail__brands__content">
                <?
                if($detailResult['PROPERTIES']['Brand']['VALUE'] != '') {
                    $APPLICATION->IncludeComponent("bexx:catalog.items", "brands", array(
                            "IBLOCK_TYPE" => "info",
                            "IBLOCK_ID" => "25",
                            "BLOCK_TITLE"=> "Производители",
                            "PARENT_IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                            "PARENT_IBLOCK_ID" => $arParams['IBLOCK_ID'],
                            //BSP-40
                            "SECT_ID" => $detailResult['IBLOCK_SECTION_ID'], //custom param
                            "IBLOCK_CATALOG_ID" => $arParams['IBLOCK_ID'], //custom param
                            //"ADDITIONAL_FILTER" => array("ID" => CIBlockElement::SubQuery("PROPERTY_Brand", array("IBLOCK_ID" => 26, "ID" => 1682))),
                            //"ADDITIONAL_FILTER" => array("ID" => $array_brand_id),
                            //BSP-40
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
                            //PST-9
                            //"CACHE_TYPE" => "A",
                            "CACHE_TYPE" => "N",
                            //PST-9
                            "CACHE_TIME" => "36000000",
                            "CACHE_WITH_FILTER" => $arParams['CACHE_WITH_FILTER'],
                            "CACHE_WITH_SORTING" => $arParams['CACHE_WITH_SORTING'],
                            "CACHE_WITH_PAGING" => $arParams['CACHE_WITH_PAGING'],
                            "SET_TITLE" => "N",
                        ),
                        $component
                    );
                }
                ?>
            </div>
            <script type="text/javascript">
                BIS.treeBrandsMenu = {
                    init: function() {
                        var cssContainer = 'brand-container__content-list';
                        var cssItems = 'brand-container__content-list-item';
                        var cssActiveItem = 'brand-container__content-list-item--active';
                        var cssInnerItems = 'detail-brands__inner';
                        var cssBrandLink = 'brands-item__inner-link';
                        var cssCount = 'brands-item__inner-count';
                        var cssCountHidden = 'detail-brands__inner-count--hidden';

                        var container = $('.'+cssContainer);
                        var items = container.find('.'+cssItems);
                        var itemInnerItems = items.find('.'+cssInnerItems);
                        var activeItem = container.find('.'+cssActiveItem);
                        var activeInnerItem = activeItem.find('.'+cssInnerItems);
                        var brandLink = $('.'+cssBrandLink);
                        var countItems = items.find('.'+cssCount);
                        var countHiddenItems = items.find('.'+cssCountHidden);
                        var countValue;

                        if (countHiddenItems.length) {
                            countHiddenItems.each(function() {
                                countValue = $.trim($(this).text());
                                $(this).parents('.'+cssItems).find('.'+cssCount).append(countValue);
                            })

                        }

                        itemInnerItems.hide();
                        activeInnerItem.show();

                        brandLink.on('click', function(e) {
                            e.preventDefault();
                            if ($(this).parents('.'+cssItems).hasClass(cssActiveItem)) {
                                $(this).parents('.'+cssItems).removeClass(cssActiveItem);
                                $(this).parent().siblings('.'+cssInnerItems).hide();
                            } else {
                                $(this).parents('.'+cssItems).addClass(cssActiveItem);
                                $(this).parent().siblings('.'+cssInnerItems).show();
                            }
                        })
                    }
                }
                $(function() {
                    BIS.treeBrandsMenu.init();
                })

            </script>
        </div>

        <?//MM-209?>
        <div class="block-viewed">
            <?$APPLICATION->IncludeFile("includes/last-viewed-main.php");?>
        </div>
        <?//MM-209?>

       <!-- <div class="detail-container__additional-block">

            <div id="detail-tabs-additional" class="detail-tabs-additional">
                <ul>
                    <?//if($detailResult['PROPERTIES']['Brand']['VALUE'] != ''):?>
                        <li><a href="#detail-tabs-1">Список производителей</a></li>
                    <?//endif;?>

                    <?/* Для акссесуаров необходимо настроить фильтр
                    <li><a href="#detail-tabs-2">Аксессуары</a></li>
                    */?>

                    <li><a href="#detail-tabs-3">Похожие модели</a></li>

                    <?
                    $ids = array(0);
                    if (is_array($_SESSION['compare']) AND !empty($_SESSION['compare'])) {
                        $hasCompareItems = true;
                        $ids = array_keys($_SESSION['compare']); // по умолчанию показываем все типы товаров для сравнения
                    }
                    ?>
                    <li><a href="#detail-tabs-4">Список сравнения</a></li>
                    <li><a href="#detail-tabs-5">Просмотренные</a></li>
                </ul>

               <!-- <div id="detail-tabs-1">

               <!-- </div>

                <?/*
                <div id="detail-tabs-2">

                </div>
                */?>

                <div id="detail-tabs-3">
                    <div class="detail__items-block">
                        <?/*$APPLICATION->IncludeComponent("bexx:catalog.items", "poly_items_list", array(
                                "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                                "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                                "ADDITIONAL_FILTER" => array(
                                    "LOGIC"=>"AND",
                                    array("!ID"=>$detailResult['ID']),
                                    //VTL-21
                                    array("!=catalog_PRICE_5"=>0),
                                    array("!=catalog_PRICE_5"=>false)
                                    //VTL-21
                                ),
                                "SECTION_ID" => $detailResult['IBLOCK_SECTION_ID'],
                                "CODE"=>"similar-products",
                                "INCLUDE_SUBSECTIONS" => "Y",
                                "ALLOW_BUY_NOT_EXISTING" => "Y",
                                "CHECK_PERMISSIONS" => "N",
                                "CHECK_ACTIVE" => "Y",
                                "SORT_FIELD_1" => "property_4392",
                                "SORT_DIR_1" => "asc",
                                "SORT_FIELD_2" => "shows",
                                "SORT_DIR_2" => "desc,nulls",
                                "ALWAYS_EXISTING_FIRST" => "N",
                                "USE_EXTERNAL_FILTERING" => "N",
                                //PST-9
                                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                                //"CACHE_TYPE" => "N",
                                //PST-9
                                "CACHE_TIME" => $arParams['CACHE_TIME'],
                                "CATALOG_PATH" => $arParams['CATALOG_PATH'],
                                "DESCRIPTION_FROM_PROPS" => "N",
                                "COUNT" => "5",
                                "ALLOW_PAGENAV" => "N",
                                "SET_TITLE" => "N",

                                "BLOCK_TITLE" => "Похожие товары"
                            ),
                            $component
                        );?>
                    </div>
                </div>

                <div id="detail-tabs-4">
                    <div class="detail__compare">
                        <?
                        $compareItemsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "compare_block_detail_page_1", array(
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
                                "BLOCK_URL" => "",
                            ),
                            $component
                        );*/?>
                    </div>
               </div>

               <div id="detail-tabs-5">
                   <?//$APPLICATION->IncludeFile("includes/last-viewed.php");?>
               </div>

            </div>

            <script>
                $(function() {
                    $( "#detail-tabs-additional" ).tabs();
                });
            </script>

        </div>


    </div>-->

    <?else:?>
        <?
        $APPLICATION->SetTitle("404 - страница не найдена");
        CHTTP::SetStatus("404 Not Found");
        @define("ERROR_404","Y");
        ?>
    <?endif;?>

</div>
<?else:?>
	<?=ShowError("Не найдено");?>
<?endif;?>
