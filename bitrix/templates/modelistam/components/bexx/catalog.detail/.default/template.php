<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>


<?
//PST-9
//$this->setFrameMode(true);
//PST-9
?>

<?if ($arResult['ID']):?>


<?//MM-99
if ($_REQUEST['zapchasti']):?>
<!--запчасти -->
<div class="detail-accessories">
    <?if($arResult['PROPERTIES']['ORIGINAL_PARTS']):?>
        <h6>
            Оригинальные запчасти
        </h6>

        <?$accessoriesResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "main_catalog_1", array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "ADDITIONAL_FILTER" => array(
                    'ID' => $arResult['PROPERTIES']['ORIGINAL_PARTS']['VALUE'],
                ),
                "CURRENT_VIEW" => 'block',

                "SECTION_ID" => "0",
                "INCLUDE_SUBSECTIONS" => "Y",
                "FILTER_PROPS" => "",
                "ALLOW_BUY_NOT_EXISTING" => "Y",
                "CHECK_PERMISSIONS" => "Y",
                "CHECK_ACTIVE" => "Y",
                "SORT_FIELD_1" => "id",
                "SORT_DIR_1" => "desc",
                "SORTING_PANEL_OPTIONS" => array(),
                "ALWAYS_EXISTING_FIRST" => "N",
                "USE_EXTERNAL_FILTERING" => "N",
                "DESCRIPTION_FROM_PROPS" => "N",
                "COUNT" => "20",
                "IGNORE_ITEMS_PER_PAGE" => "Y",
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "SET_TITLE" => "N",
                "COLUMNS_COUNT" => "4",
                "BLOCK_WIDTH" => "180",
                "SHOW_BORDER" => "Y",
            ),
            $component
        );?>
    <?endif;?>
</div>




<?//MM-99?>
<?else:?>
<?//MM-99?>



<?if ($APPLICATION->GetProperty('custom_h1') !="Y"):?>
    <h1 class="pagetitle"><?=$arResult['NAME']?></h1>
<?endif;?>

<div class="product-card">
	<div class="product-card-inner">

        <div class="product-cart__image">
            <?
            $bigPictureParams = array('w'=>640, 'h'=>480, 'zc'=>0, 'q'=>'100', 'aoe'=>0, 'far'=>"C", 'only_big_images'=>"Y");
            $main_image = 0;
            if ($arResult['DETAIL_PICTURE'] > 0) $main_image = $arResult['DETAIL_PICTURE'];
            if (!$main_image AND $arResult['PREVIEW_PICTURE'] > 0) $main_image = $arResult['PREVIEW_PICTURE'];
            if (!$main_image AND $arResult['PROPERTIES']['MORE_PHOTO']['VALUE']) $main_image = reset($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']);
            ?>

            <div class="product-image-block">

                <?if ($main_image):?>
                    <?//VTL-5?>
                    <script type="text/javascript">
                        var detailPhotoUI = {
                            initColorsAndSizes: function() {
                                var imageAjax = $('<img />').attr('src', "<?=SITE_TEMPLATE_PATH?>/images/ajax-loader.gif");
                                var detailPropLinks = $('.detail__prop__link');
                                var curDetailPropLink;
                                var self = this;

                                $('.order-btn').append(imageAjax);
                                imageAjax.hide();

                                if (detailPropLinks.length) {

                                    detailPropLinks.on('click', function(e) {
                                        e.preventDefault();
                                        curDetailPropLink = $(this);

                                        curDetailPropLink.parent().parent().find('a').removeClass("active");
                                        curDetailPropLink.addClass("active");

                                        $('#add2cart_form_id').val($('#add2cart_form_orig_id').val());
                                        if (curDetailPropLink.hasClass("disabled")) return false;
                                        $('#add2cart_form_do').val("recount_offer"); // пересчитываем SKU

                                        var offer_text = curDetailPropLink.text();

                                        curDetailPropLink.parent().parent().parent().find('input[type=hidden]').val(offer_text);
                                        var data = $('#add2cart_form').serializeArray();

                                        $('#basket-button').hide();
                                        imageAjax.show();

                                        ajax_load('.product-price', '<?=$arResult['AJAX_CALL_ID']?>', data);
                                        $( document ).ajaxComplete(function() {
                                            $('#basket-button').show();
                                            imageAjax.hide();
                                        })

                                        //klm GT-100
                                        // manipulations with main image
                                        var off_text = offer_text;
                                        off_text = off_text.replace(/[^a-zA-ZА-Яа-я0-9_]/g,'');
                                        var jpegname = $("#"+off_text+'_main').val();

                                        var mainImageLink = $('.link_mainImage');
                                        var mainImage = $('.image_mainImage');

                                        if (jpegname != "" && jpegname != null && jpegname != undefined) {
                                            mainImageLink.attr('href', jpegname);
                                            mainImage.attr('src', jpegname);
                                        }
                                        //klm GT-100
                                    });
                                }
                            }
                        }

                        $(function() {
                            detailPhotoUI.initColorsAndSizes();
                        });
                    </script>
                <?//VTL-5?>

                <div class="product-main-image">
                    <?
                    $main_image = CFile::_GetImgParams($main_image);
                    if (strlen(trim($main_image['ALT']))) {
                        $main_image_alt = strip_tags(trim($main_image['ALT']));
                    } else {
                        $main_image_alt = strip_tags(trim($arResult['SECTION']['UF_ITEM_NAME']." ".$arResult['NAME']));
                    }
                    ?>

                    <div class="description__labels">
                        <?if (strlen($arResult['PROPERTIES']['SALE']['VALUE'])):?>
                            <div class="label-status label--sale">Распродажа</div>
                        <?elseif (strlen($arResult['PROPERTIES']['SPECIALOFFER']['VALUE'])):?>
                            <div class="label-status label--akciya">Aкция <i></i> </div>
                        <?//MM-330?>
                        <?//elseif (MakeTimeStamp($arResult['DATE_CREATE'])+86400*30>time()):?>
                        <?elseif($arResult['NEW']==1):?>
                        <?//MM-330?>
                            <div class="label-status label--new">Новинка</div>
                        <?elseif(strlen($arResult['PROPERTIES']['featured']['VALUE'])):?>
                            <?if (MakeTimeStamp($arResult['PROPERTIES']['featured']['VALUE'])>time()):?>
                                <div class="label-status label--hit">Топ продаж</div>
                            <?endif;?>
                        <?endif;?>
                    </div>

                    <a href="<?=MakeImage($main_image['SRC'], $bigPictureParams)?>" class="link_toImageMain" title="<?=$main_image_alt?>">
                        <img class="product-cart__img" width="360" height="240" title="<?=$main_image_alt?>" alt="<?=$main_image_alt?>" src="<?=MakeImage($main_image['SRC'], array('w'=>360, 'h'=>240, 'aoe'=>0, 'q'=>100, 'zc'=>0, 'detail_image'=>"Y", 'far'=>"C"))?>" />
                    </a>
                </div>

                <?if ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']):?>
                    <?$arResult['PROPERTIES']['MORE_PHOTO']['VALUE'][] = $main_image['SRC'];?>
                    <div class="noprint">
                        <div class="detail__gallery">
                            <?$ind_photo = 1;?>
                            <?foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $more_photo):?>
                                <div class="detail__gallery__item">
                                    <a href="<?=MakeImage($more_photo, $bigPictureParams)?>" class="link_toImage" title="Фотографии и видеоролики <?=$arResult['NAME']?>">
                                        <img alt="<?=$arResult['NAME']?>" src="<?=MakeImage($more_photo, array('wl'=>95, 'hl'=>80, 'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                    </a>
                                </div>

                                <?if ($ind_photo == 4) {
                                    //затемняем последнюю фото
                                    break;
                                }?>
                                <?$ind_photo ++;?>
                            <?endforeach;?>
                        </div>
                    </div>
                <script type="text/javascript">
                    /*
                    $(function() {
                        $('.detail__gallery').owlCarousel({
                            items: "3",
                            navigation: false,
                            pagination: true
                        });
                    })
                    */
                </script>
                <?endif;?>

                <div style="display: none;">
                    <div id="image_gallery" class="detail__popup-gallery">

                        <div id="image_gallery_main" style="overflow: hidden;">
                            <img class="adaptive-img" src="<?=MakeImage($main_image, $bigPictureParams)?>" width="640" height="480" alt="<?=$arResult['NAME']?>" />
                        </div>

                        <?if (is_array($arResult['PROPERTIES']['MORE_PHOTO']['VALUE']) AND !empty($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'])):?>
                            <div class="detail__popup-gallery-wrap">
                                <div class="detail__gallery detail__gallery--popup">
                                    <?foreach ($arResult['PROPERTIES']['MORE_PHOTO']['VALUE'] as $more_photo):?>
                                        <div class="detail__gallery__item">
                                            <a href="#" onclick="$('#image_gallery_main img').attr('src', '<?=MakeImage($more_photo, $bigPictureParams)?>'); return false;">
                                                <img alt="<?=$arResult['NAME']?>" src="<?=MakeImage($more_photo, array('wl'=>80, 'hl'=>80,'q'=>100, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                            </a>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        <?endif;?>

                    </div>
                </div>

                <script type="text/javascript">
                    $(function() {
                        var wWidth = $(window).width();
                        var minWindowWidth = 600;

                        if (wWidth > minWindowWidth) {
                            $("a.link_toImageMain").fancybox({
                                'padding': 40,
                                'overlayShow': true,
                                'hideOnContentClick': false,
                                'titleShow': false,
                                'href': "#image_gallery",
                                'helpers':  {
                                    title:  null
                                }
                            });
                        }

                        $(".link_toImageMain").on('click', function() {
                            $('#image_gallery_main img').attr('src', $(this).attr('href'));
                        });

                        $("a.link_toImage").on('click', function(e) {
                            e.preventDefault();

                            $('#image_gallery_main img').attr('src', $(this).attr('href'));

                            $('.product-cart__img')
                                .attr('src', $(this).attr('href'))
                                .parents('.link_toImageMain')
                                .attr('href', $(this).attr('href'));
                        });



                    });
                </script>
                <?else:?>
                <div class="product-main-image">
                    <?if ($arResult['IBLOCK_ID']=='43054'):?>
                         <img class="product-status-image card ucenka" src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-ucenka.png" alt="Уценка" />
                    <?elseif (strlen($arResult['PROPERTIES']['SPECIALOFFER']['VALUE'])):?>
                        <img class="product-status-image card hit" src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-akciya-detail.png" alt="Акция" title="Акция" />
                    <?elseif (strlen($arResult['PROPERTIES']['featured']['VALUE']) AND MakeTimeStamp($arResult['PROPERTIES']['featured']['VALUE'])>time()):?>
                        <img class="product-status-image card hit" src="<?=SITE_TEMPLATE_PATH?>/images/ui-icon-recommend.png" alt="Хит продаж!" title="Хит продаж!" />
                    <?elseif(MakeTimeStamp($arResult['DATE_CREATE'])+86400*30>time()):?>
                        <img class="product-status-image card new" src="<?=SITE_TEMPLATE_PATH?>/images/ui-label-new.png" alt="Новинка" title="Новинка" />
                    <?endif;?>

                    <img class="adaptive-img" title="<?=$main_image_alt?>" alt="<?=$main_image_alt?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                </div>
                <?endif;?>

            </div>

        </div>

		<div class="product-right-block">
            <div class="product-right-block__inner">

                <div class="top-right-block">
                    <div class="detail-rating">

                        <?//PST-9
                        $frame = $this->createFrame()->begin('');
                        //PST-9?>
                        <?//VTL-5?>

                      <!--  <div class="detail__matrix-block">
                            <form method="post" action="" id="add2cart_form">
                            <input type="hidden" name="orig_id" id="add2cart_form_orig_id" value="<?=$arResult['ID']?>" />
                            <input type="hidden" name="do" id="add2cart_form_do" value="add2cart" />
                            <input type="hidden" name="id" id="add2cart_form_id" value="<?=$arResult['ID']?>" />

                            <?/*if (count($arResult['OFFERS'])):?>
                                <?
                                // найдем варианты и составим матрицу
                                $offer_props_values = array();
                                $photo_color_values = array();
                                $textures_color_values = array();

                                foreach ($arResult['OFFERS'] as $offer) {
                                    foreach ($offer['DISPLAY_PROPERTIES'] as $offer_prop_key=>$offer_prop) {
                                        if (in_array($offer_prop_key, $arParams['SKU_PROPS'])) {
                                            if (!empty($offer_prop['VALUE']) AND !empty($offer_prop['DESCRIPTION'])) {
                                                foreach ($offer_prop['VALUE'] as $prop_val_key=>$prop_val) {
                                                    $offer_props_values[$offer_prop['DESCRIPTION'][$prop_val_key]][$prop_val]++;

                                                    if ($offer_props_values[$offer_prop['DESCRIPTION'][$prop_val_key]][$prop_val] > 1) Continue;
                                                    if ($offer_prop['DESCRIPTION'][$prop_val_key] == 'Цвет'){

                                                        if($offer['PROPERTIES']['TEXTURA_CVETA']['VALUE'] !== ''){
                                                            $textures_color_values[$prop_val] = $offer['PROPERTIES']['TEXTURA_CVETA']['VALUE'];
                                                        }

                                                        if($offer['PROPERTIES']['PHOTOCOLOR']['VALUE'] !== ''){
                                                            $pos = strpos($main_image['SRC'], $offer['PROPERTIES']['PHOTOCOLOR']['VALUE']);
                                                            if ($pos === false) {
                                                                if ($offer['PROPERTIES']['PHOTOCOLOR']['DESCRIPTION'] !== ''){
                                                                    $filename = MakeImage('/upload/iblock/'.substr($offer['PROPERTIES']['PHOTOCOLOR']['VALUE'], 0, 3).'/'.$offer['PROPERTIES']['PHOTOCOLOR']['VALUE'].'.'.$offer['PROPERTIES']['PHOTOCOLOR']['DESCRIPTION'], $bigPictureParams);
                                                                    $photo_color_values[$prop_val] = $filename;
                                                                }
                                                                else
                                                                {
                                                                    $filename = MakeImage('/upload/iblock/'.substr($offer['PROPERTIES']['PHOTOCOLOR']['VALUE'], 0, 3).'/'.$offer['PROPERTIES']['PHOTOCOLOR']['VALUE'].'.jpeg', $bigPictureParams);
                                                                    $photo_color_values[$prop_val] = $filename;
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $photo_color_values[$prop_val] = MakeImage($main_image['SRC'], $bigPictureParams);
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                ?>

                                <?
                                $clr = explode(";", $arResult['PROPERTIES']['lC_COLOR_LINK']['VALUE']);
                                $ind = 0;
                                $mass_clr = array();
                                foreach ($clr as $kk=>$clr_item){
                                    if ($ind == 0){
                                        $path = $clr_item;
                                        $ind = 1;
                                        continue;
                                    }
                                    if ($ind == 1){
                                        $color = $clr_item;
                                        $ind = 0;
                                    }

                                    if ($color!=='') $mass_clr[] = array('PATH'=>$path, 'COLOR'=>$color);
                                }

                                ?>
                                <?foreach ($mass_clr as $clr=>$photo_color):?>
                                    <?
                                    $clr = trim($photo_color['COLOR']);
                                    $clr = preg_replace('/[^a-zA-ZА-Яа-я0-9_]/u','', $clr);
                                    ?>

                                    <input type="hidden" class="input-photo-link" data-color="<?=$clr;?>" value="<?=$photo_color['PATH'];?>" />
                                <?endforeach;?>

                                <?
                                foreach ($photo_color_values as $clr=>$photo_color):?>
                                    <?
                                    $clr = trim($clr);
                                    $clr = preg_replace('/[^a-zA-ZА-Яа-я0-9_]/u','', $clr);

                                    ?>
                                    <input type="hidden" id="<?=$clr.'_main'?>" name="" value=<?=$photo_color?>>
                                <?endforeach;?>
                                <?
                                $arCvetRazmer = array();

                                if (is_array($arResult['OFFERS'])) {
                                    foreach ($arResult['OFFERS'] as $k=>$offer) {
                                        if (is_array($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DISPLAY_VALUE'])) {
                                            $tCvet =='';
                                            foreach ($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DISPLAY_VALUE'] as $m=>$offer_display_properties) {
                                                if ($m == 0){
                                                    $tCvet = $offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DISPLAY_VALUE'][$m].'001';
                                                }

                                                if ($m == 1){
                                                    $key = array_search($tCvet.$offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DISPLAY_VALUE'][$m], $arCvetRazmer);
                                                    if ($key === false){
                                                        if ($arResult['OFFERS'][$k]['CATALOG_QUANTITY']!=="0"){
                                                            $arCvetRazmer[] = $tCvet.$offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DISPLAY_VALUE'][$m].'001';
                                                        }
                                                    }
                                                }
                                            }
                                        }else{
                                            foreach ($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['VALUE'] as $m=>$offer_value) {
                                                if ($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DESCRIPTION'][$m] == 'Размер'){
                                                    $key = array_search($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][$m], $arCvetRazmer);
                                                    if ($key === false){
                                                        if ($arResult['OFFERS'][$k]['CATALOG_QUANTITY']!=="0"){
                                                            $arCvetRazmer[] = $offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][$m].'001';
                                                        }
                                                    }
                                                }
                                                if ($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['DESCRIPTION'][$m] == 'Цвет'){
                                                    $key = array_search($offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][$m], $arCvetRazmer);
                                                    if ($key === false){
                                                        if ($arResult['OFFERS'][$k]['CATALOG_QUANTITY']!=="0"){
                                                            $arCvetRazmer[] = $offer['DISPLAY_PROPERTIES']['CML2_ATTRIBUTES']['VALUE'][$m].'001';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                ?>

                                <?foreach ($arCvetRazmer as $k=>$arCvetRazm):?>
                                    <?
                                    $offerKey = $arCvetRazmer[$k];
                                    $offerKey=trim($offerKey);
                                    $offerKey = preg_replace('/[^a-zA-ZА-Яа-я0-9_]/u','', $offerKey);
                                    ?>
                                    <input type="hidden" id="<?=$offerKey?>" name="" value=1>
                                <?endforeach;?>
                                <?

                                if (is_array($offer_props_values) AND !empty($offer_props_values)):?>
                                    <?
                                    // сопоставление классов и цветов
                                    if (file_exists($_SERVER['DOCUMENT_ROOT']."/colors.php")) include_once($_SERVER['DOCUMENT_ROOT']."/colors.php");
                                    $counter = 0;
                                    ?>

                                    <?foreach ($offer_props_values as $offer_prop_name=>$offer_prop_variants):?>
                                        <? $offerClass = '';?>
                                        <?if (ToUpper($offer_prop_name) == 'РАЗМЕР') $offerClass = 'detail_page_offers--razmer';?>
                                        <div class="detail_page_offers_block <?=$offerClass;?>">
                                            <input type="hidden" id="param<?=++$counter?>" name="param[<?=$offer_prop_name?>]" value="">
                                            <input type="hidden" class="prop_sku_hidden" id="param<?=++$counter?>" name="param[<?=$offer_prop_name?>]" value="">

                                            <strong><?=$offer_prop_name?></strong>
                                            <ul class="detail__offers" id="prop_<?=md5(trim($offer_prop_name))?>">
                                                <?foreach ($offer_prop_variants as $variant=>$musor):?>
                                                    <?
                                                    $class = "";
                                                    if ($offer_colors[$variant]) $class = 'class="'.$offer_colors[$variant].'"';
                                                    ?>

                                                    <li class="detail__prop">

                                                        <a class="detail__prop__link" href="#" id="prop_val_<?=md5(trim($offer_prop_name).trim($variant))?>">
                                                            <?if ($offerClass):?>
                                                                <span class="detail__prop-square">
                                                                    <span class="detail__prop-text"><?=$variant?></span>
                                                                </span>
                                                            <?else:?>
                                                                <span class="detail__prop-square">

                                                                    <?
                                                                    $variantEdited = trim($variant);
                                                                    $variantEdited = preg_replace('/[^a-zA-ZА-Яа-я0-9_]/u','', $variantEdited);
                                                                    ?>
                                                                    <?foreach($photo_color_values as $productColorName=>$productColorSRC):?>
                                                                        <?$hasImageBinding = '';?>
                                                                        <?
                                                                        $productColorNameEdited = trim($productColorName);
                                                                        $productColorNameEdited = preg_replace('/[^a-zA-ZА-Яа-я0-9_]/u','', $productColorNameEdited);
                                                                        ?>
                                                                        <?if ($variantEdited == $productColorNameEdited):?>
                                                                            <?$hasImageBinding = $productColorSRC;?>
                                                                            <?break;?>
                                                                        <?endif;?>
                                                                    <?endforeach;?>


                                                                    <?if ($hasImageBinding):?>
                                                                        <img src="<?=MakeImage($hasImageBinding, array('w'=>50, 'q'=>100, 'h'=>50, 'aoe'=>0, 'far'=>"C"))?>"/>
                                                                    <?else:?>
                                                                        <img src="<?=MakeImage($textures_color_values[$variant], array('w'=>50, 'q'=>100, 'h'=>50, 'aoe'=>0, 'far'=>"C"))?>"/>
                                                                    <?endif;?>
                                                                    </span>
                                                                <span class="detail__prop-text"><?=$variant?></span>
                                                            <?endif;?>
                                                        </a>
                                                    </li>
                                                <?endforeach;?>
                                            </ul>
                                        </div>
                                    <?endforeach;?>
                                <?endif;?>
                            <?endif;*/?>


                            <div class="detail_page_qty_input">
                                <span>Количество</span>
                                <input type="number" min="1" step="1" name="qty" id="add2cart_form_qty" value="1" />
                            </div>
                            </form>
                        </div>-->
                        <?//VTL-5?>

                        <div class="item-top-product">
                            <?if ($arResult['PROPERTIES']['BEST_PRICE_GUARANTEE']['VALUE'] == 1):?>
                                <div class="best_price_guarantee">
                                    <i></i><span> Гарантия лучшей цены</span>
                                </div>
                            <?endif;?>
                            <?/* Есть в наличии? */?>
                            <div class="availability">
                                <?if ($arResult['PROPERTIES']['availability']['VALUE'] == 'Нет в наличии'):?>
                                    <div class="product-avail-no">
                                        Нет в наличии
                                    </div>
                                <?else:?>
                                    <div class="product-avail-yes">
                                        <?=$arResult['PROPERTIES']['availability']['VALUE'];?>
                                    </div>
                                <?endif;?>
                            </div>
                            <div class="detail__id">
                                <?=$arResult['PROPERTIES']['brand']['LINKED_ELEMENT']['NAME']?>
                                <?if ($arResult['PROPERTIES']['brand']['LINKED_ELEMENT']['NAME'] AND $arResult['PROPERTIES']['partnumber']['VALUE']) echo "/";?>
                                <?if ($arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']):?>
                                    Код: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE'];?>
                                <?endif;?>
                            </div>
                     </div>
                        <?//PST-9
                        $frame->end();
                        //PST-9?>
                    </div>
                </div>
                <?//MM-99?>
                <div class="detail-price-block">
                    <div class="detail-price__inner">
                        <div id="cart_ajax" style="display: none;"></div>
                        <div class="detail-price">
                            <?include("price_block.php");?>
                        </div>


                        <div class="detail-main-buy-block">
                            <!-- Кнопка купить-->
                            <?if ($arResult['DISCOUNT_PRICE']> 0):?>
                                <?if ($arResult['CATALOG_QUANTITY']>0):?>

                                    <div class="detail__price-container__buttons">
                                        <?if ($arResult['CATALOG_QUANTITY']>0 OR $arParams['ALLOW_BUY_NOT_EXISTING']=="Y"):?>

                                            <?//VTL-5?>
                                            <?if (count($arResult['OFFERS'])):?>
                                                <div id="product-order-<?=$arResult['ID']?>" class="order-btn">
                                                    <a href="#product-order-<?=$arResult['ID']?>" id="basket-button" class="butt3 butt3--toCart" title="купить <?=$arResult['SECTION']['UF_ITEM_NAME']?> <?=$arResult['NAME']?>"><i></i><span>В корзину</span></a>
                                                </div>
                                            <?else:?>
                                            <?//VTL-5?>
                                                <div id="product-order-<?=$arResult['ID']?>" class="order-btn">
                                                    <a href="#product-order-<?=$arResult['ID']?>" onclick="ajax_block('#product-order-<?=$arResult['ID']?>');" id="basket-button-without-offer" class="butt3 butt3--toCart ajax_link" rel="<?=$arResult['AJAX_CALL_ID']?>" params="do=add2cart&id=<?=$offer_id_cart?>" title="купить <?=$arResult['SECTION']['UF_ITEM_NAME']?> <?=$arResult['NAME']?>"><i></i><span>Купить</span></a>
                                                </div>
                                            <?endif;?>
                                        <?endif;?>
                                    </div>

                                <?endif;?>
                            <?else:?>
                                <?//PST-7?>
                                <div class="noprint">

                                    <div>
                                        <?if ($arResult['PROPERTIES']['availability']['VALUE'] == 'Нет в наличии'):?>
                                            <a href="#reserv" id="reserv_link" class="butt3 noavail butt3--toCart"><i></i><span>Зарезервировать</span></a>
                                        <?else:?>
                                            <a href="#reserv" id="reserv_link" class="butt3 butt3--toCart"><i></i><span>Зарезервировать</span></a>
                                        <?endif;?>
                                    </div>

                                    <div style="display: none;">
                                        <div id="reserv" class="detail__reserv-block">
                                            <img width="100" height="100" src="<?=SITE_TEMPLATE_PATH?>/images/big_ajax_loader.gif" alt="Загрузка" />
                                        </div>
                                    </div>
                                    <script>
                                        $("a#reserv_link").fancybox({
                                            'padding': 10,
                                            'maxWidth': 480,
                                            'maxHeight': 280,
                                            'autoSize': false,
                                            'afterLoad': function(){
                                                ajax_load('#reserv', '<?=$arResult['AJAX_CALL_ID']?>', 'do=reserv&id=<?=$arResult['ID']?>');
                                            },
                                            'afterClose': function(){
                                                $('#reserv').html("загрузка...");
                                            }
                                        });
                                    </script>
                                </div>
                                <?//PST-7?>
                            <?endif;?>
                            <!-- /Кнопка купить-->
                        </div>
                    </div>
                </div>
                <div class="product-ucenka-block">
                <?if($arResult['UCENKA_ELEMENTS']):?>
                    <?foreach($arResult['UCENKA_ELEMENTS'] as $ucenka_item):?>
                        <a href="<?=$ucenka_item['DETAIL_PAGE_URL']?>" class="butt3">Купить дешевле уцененный товар</a>
                    <?endforeach;?>
                <?endif;?>

                <?if($arResult['IBLOCK_CODE']=='ucenka'):?>
                    <?if($arResult['NO_UCENKA_ELEMENTS']):?>
                        <?foreach($arResult['NO_UCENKA_ELEMENTS'] as $ucenka_item):?>
                            <a href="<?=$ucenka_item['DETAIL_PAGE_URL'];?>" class="butt3">Купить новый товар</a>
                        <?endforeach;?>
                    <?endif;?>
                <?endif;?>
                </div>

                <div class="product-actions">
                    <div class="product-actions__left">
                        <div class="product-actions__left-title">
                            Другие варианты покупки:
                        </div>
                        <div class="buy-credit-block" id="buyCreditProduct">
                            <a id="followbuyCreditProduct-link" href="#buyCreditProduct" class="followbuyCredit-block-links" title="В кредит">В кредит</a>
                        </div>
                        <?if ($arResult['DISCOUNT_PRICE']> 0):?>
                            <?if ($arResult['CATALOG_QUANTITY']>0 OR $arParams['ALLOW_BUY_NOT_EXISTING']=="Y"):?>
                                <div class="fast-buy-block">
                                    <noindex>
                                        <a href="#fast_buy" class="fastbuy-link" id="fast_buy_link">Купить быстро</a>
                                    </noindex>

                                    <div style="display: none;">
                                        <div id="fast_buy" class="detail__fast-buy-block">
                                            <img width="100" height="100" src="<?=SITE_TEMPLATE_PATH?>/images/big_ajax_loader.gif" alt="Загрузка" />
                                        </div>
                                    </div>

                                    <script>
                                        $("a#fast_buy_link").fancybox({
                                            'padding': 15,
                                            'maxWidth': 660,
                                            'maxHeight': 360,
                                            'autoSize': false,
                                            'afterLoad': function(){
                                                ajax_load('#fast_buy', '<?=$arResult['AJAX_CALL_ID']?>', 'do=fast_buy&id=<?=$arResult['ID']?>');
                                            },
                                            'afterClose': function(){
                                                $('#fast_buy').html("загрузка...");
                                            }
                                        });
                                    </script>
                                </div>
                            <?endif;?>
                        <?endif;?>
                        <div style="display: none">
                            <div id="followProduct">
                                <div class="follow__title">Подписка на товар</div>

                                <form method="post" action="<?=$APPLICATION->GetCurPageParam()?>">
                                    <input type="hidden" name="do" value="subscribe" />
                                    <input type="hidden" name="id" value="<?=$arResult['ID']?>" />
                                    <?
                                    // Получим значение пользовательских полей
                                    $user_fields = $GLOBALS["USER_FIELD_MANAGER"]->GetUserFields("USER", $USER->GetId());
                                    if (!is_array($user_fields['UF_PRICE_ALERT']['VALUE'])) $user_fields['UF_PRICE_ALERT']['VALUE'] = array();
                                    if (!is_array($user_fields['UF_STOCK_ALERT']['VALUE'])) $user_fields['UF_STOCK_ALERT']['VALUE'] = array();
                                    if (!is_array($user_fields['UF_BUNDLE_ALERT']['VALUE'])) $user_fields['UF_BUNDLE_ALERT']['VALUE'] = array();
                                    if (!is_array($user_fields['UF_NEW_COMMENTS']['VALUE'])) $user_fields['UF_NEW_COMMENTS']['VALUE'] = array();
                                    ?>
                                    <table class="table-follow-product">
                                        <tr>
                                            <td><input type="checkbox" id="alert_price" name="alert_price" value="1" <?if (in_array($arResult['ID'], $user_fields['UF_PRICE_ALERT']['VALUE'])):?>checked<?endif;?> /></td>
                                            <td width="100%"><label for="alert_price">Изменение цены</label></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" id="alert_stock" name="alert_stock" value="1" <?if (in_array($arResult['ID'], $user_fields['UF_STOCK_ALERT']['VALUE'])):?>checked<?endif;?> /></td>
                                            <td width="100%"><label for="alert_stock">Появление в наличии</label></td>
                                        </tr>
                                        <?if (!$USER->IsAuthorized()):?>
                                            <tr>
                                                <td colspan="2">
                                                    Ваш e-mail:
                                                    <input type="text" name="email" value="" size="25" maxlength="255" />
                                                </td>
                                            </tr>
                                        <?endif;?>
                                        <tr>
                                            <td colspan="2">
                                                <input type="submit" value="Подтвердить" class="ui-button-blue-input" />
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>

                        <script type="text/javascript">
                            /*$(function() {
                                $("a#followProduct-link").fancybox({
                                    'maxWidth': 800
                                });
                            });*/
                        </script>

                    </div>


                    <div class="detail-action-block">
                        <?//PST-9?>
                        <!--<span id="dyn-detail-compare-wishlist">-->
                        <?
                        //$frame = $this->createFrame('dyn-detail-compare-wishlist')->begin('');
                        //PST-9
                        ?>
                            <?//PST-9?>
                            <span id="dyn-product-wishlist-compare-<?=$item['ID']?>" class="items-links">
                        <?
                        $frame = $this->createFrame('dyn-product-wishlist-compare-'.$item['ID'])->begin('');
                        //PST-9
                        ?>
                                <? /* Ссылка отложить */?>
                                <?//MM-252 отложенные товары?>
                                <div id="wishlistProduct" class="product-wishlist-block">
                                    <?if ($GLOBALS['wishlist_content'][$arResult['ID']]==1):?>
                                        <a id="wishlistProduct-link" href="#" class="top-wishlist-link wishlist-link ajax_link_main_catalog top-wishlist-link-hovered" onclick="ajax_load('#wishlistProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=wishlist&id=<?=$arResult['ID']?>'); return false;" title="Убрать из отложенных"><i></i><div class="hover-link">Убрать из<br/> отложенных</div> </a>
                                    <?else:?>
                                        <a id="wishlistProduct-link" href="#" class="top-wishlist-link wishlist-link ajax_link_main_catalog" onclick="ajax_load('#wishlistProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=wishlist&id=<?=$arResult['ID']?>'); return false;" title="Отложить"><i></i><div class="hover-link">Отложить</div> </a>
                                    <?endif;?>
                                </div>
                                <?//MM-252 отложенные товары?>

                                <? /* Ссылка сравнить */?>
                                <?if ($arParams['SHOW_COMPARE_LINK']!="N"):?>
                                    <div id="product-compare-<?=$item['ID']?>" class="product-compare-block">
                                        <div data-compare-id="<?=$item['ID']?>" class="float-left checkbox-black" onclick="ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$arResult['ID']?>&back_url=<?=urlencode($APPLICATION->GetCurPageParam());?>');"></div>
                                        <div class="product-compare-link"><span class="hover-link">Сравнить</span></div>
                                    </div>
                                <?endif;?>
                                <?//link money?>
                                <?//MM-223 отслеживание цены?>
                                    <div id="pricealertProduct" class="price-alert-block">
                                        <?if (in_array($arResult['ID'], $user_fields['UF_PRICE_ALERT']['VALUE'])):?>
                                            <a id="followProduct-link" href="#" class="follow-block-links item_money item_money-hovered" onclick="ajax_load('#pricealertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=price_alert&id=<?=$arResult['ID']?>'); return false;" title="Не отслеживать цену"><i></i><div class="hover-link">Не отслеживать<br/> цену</div></a>
                                        <?else:?>
                                            <a id="followProduct-link" href="#" class="follow-block-links item_money" onclick="ajax_load('#pricealertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=price_alert&id=<?=$arResult['ID']?>'); return false;" title="Следить за ценой"><i></i><div class="hover-link">Следить<br/> за ценой</div></a>
                                        <?endif;?>
                                    </div>
                                <?//MM-223?>

                                <?//MM-249?>
                                <div id="stockalertProduct" class="stock-alert-block">
                                    <?if (in_array($arResult['ID'], $user_fields['UF_STOCK_ALERT']['VALUE'])):?>
                                        <a id="followProduct-link" href="#" class="follow-block-links waiting-link-item waiting-link-item-hovered" onclick="ajax_load('#stockalertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=stock_alert&id=<?=$arResult['ID']?>'); return false;" title="Не отслеживать наличие"><i></i><div class="hover-link">Не отслеживать<br/> наличие</div></a>
                                    <?else:?>
                                        <a id="followProduct-link" href="#" class="follow-block-links waiting-link-item" onclick="ajax_load('#stockalertProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=stock_alert&id=<?=$arResult['ID']?>'); return false;" title="Следить за наличием"><i></i><div class="hover-link">Следить <br/>за наличием</div></a>
                                    <?endif;?>
                                </div>
                                <?//MM-249?>

                                <?//PST-9?>
                                <script>
                                    $(".ajax_link_main_catalog").click(function(){
                                        ajax_load($(this).attr('href'), $(this).attr('rel'), $(this).attr('params'));
                                        return false;
                                    });
                                </script>

                                <?$frame->end();?>
                            </span>
                            <?//PST-9?>
                        <!--Следить за товаром, Отложить, Добавить к сравнению-->
                        <!--<div class="follow-block">
                            <noindex>
                                <div class="product-card-quick-actions">
                                    <div class="wishlist-block" id="wishlistProduct">
                                        <?if ($GLOBALS['wishlist_content'][$arResult['ID']]==1):?>
                                            <a id="wishlistProduct-link" href="#" class="follow-block-links wishlist-links" title="Убрать из отложенных">Убрать из списка желаний</a>
                                        <?else:?>
                                            <a id="wishlistProduct-link" href="#" class="follow-block-links wishlist-links" title="Отложить">В список желаний</a>
                                        <?endif;?>
                                    </div>
                                </div>
                            </noindex>

                            <?//PST-9 вынесено из onclick?>
                            <script>
                                $("body").on('click','.wishlist-links', function(e) {
                                    e.preventDefault();
                                    ajax_load('#wishlistProduct', '<?=$arResult['AJAX_CALL_ID']?>', 'do=wishlist&id=<?=$arResult['ID']?>');
                                });
                            </script>
                            <?//PST-9?>
                        </div>

                        <div class="detail__compare">
                            <!-- compare checkbox
                            <div id="product-compare-<?=$arResult['ID']?>">
                                <?if ($_SESSION['compare'][intval($arResult['ID'])] == 1):?>
                                    <div class="product-compare-link compared">
                                        <span>Убрать из сравнения</span>
                                    </div>
                                <?else:?>
                                    <div class="product-compare-link">
                                        <span>К сравнению</span>
                                    </div>
                                <?endif;?>

                            </div>

                            <script>
                                $('.product-compare-link').click(function() {
                                    if ($(this).is('.product-compare-link')) {
                                        $(this).toggleClass('compared');
                                    }
                                    ajax_load('#product-compare-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=intval($arResult['ID'])?>');
                                });
                            </script>
                            <!-- / compare checkbox

                        </div>

                        <?//PST-9?>
                        <?//$frame->end();?>
                        </span>-->
                        <?//PST-9?>

                    </div>

                </div>
                <div class="rating-block">
                    <div class="rating-content">
                        <input type="hidden"
                               id="product-ratingback-<?=$arResult['ID']?>"
                               value="<?=doubleval($arResult['PROPERTIES']['score']['VALUE'])?>" />

                        <div id="product-rating-<?=$arResult['ID']?>"></div>
                        <div id="product-ratingс-<?=$arResult['ID']?>"></div>

                        <script type="text/javascript">
                            $(function () {
                                $('#product-rating-<?=$arResult['ID']?>').rateit({
                                    max: 5,
                                    step: 0,
                                    backingfld: '#product-ratingback-<?=$arResult['ID']?>',
                                    starwidth: 16.4,
                                    starheight: 16,
                                    <?if ($user_voted):?>
                                    readonly: true,
                                    <?endif;?>
                                    resetable: false
                                });
                                $("#product-rating-<?=$arResult['ID']?>").bind('rated', function (event, value) {
                                    ajax_load('#product-ratingс-<?=$arResult['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=rate&id=<?=$arResult['ID']?>&rating='+value);
                                });
                            });
                        </script>
                    </div>

                    <?if ($arResult['PROPERTIES']['score_count']['VALUE']):?>
                        <div class="how-many-ratings">
                            <?="на базе ".padej($arResult['PROPERTIES']['score_count']['VALUE'], "оценки", "оценок", "оценок")?>
                        </div>
                    <?endif;?>

                    <div class="rating-result_<?=$arResult['ID']?>">
                        <?=$user_voted?"вы уже голосовали":""?>
                    </div>
                </div>
               <!-- <div class="product-static-block">
                    <?//$APPLICATION->IncludeFile("includes/product-static-block.php");?>
                </div>-->

                <?if ($arResult['PROPERTIES']['Review_3D']['VALUE']):?>
                <? $image3d = CFile::GetFileArray($arResult['PROPERTIES']['Review_3D']['VALUE']);
                $pathToImage3d = $image3d['SRC'];
                ?>
                <div class="product__3d-block">
                    <a id="link-3d-gallery" class='no-3d-initialized link-3d-gallery-default' href="#">
                        <img alt="3d обзор товара" src="<?=SITE_TEMPLATE_PATH?>/images/ui-button-3d.png" />
                    </a>

                    <div id="spritespin-wrap" style="display: none;">
                        <div id='spritespin'></div>
                        <div class="btn-toolbar">
                            <div class="btn-group">
                                <button id="spritespin__prev" class="spritespin-btn spritespin-btn--prev">Назад</button>
                                <button id="spritespin__play" class="spritespin-btn spritespin-btn--play ">Играть</button>
                                <button id="spritespin__pause" class="spritespin-btn spritespin-btn--pause">Пауза</button>
                                <button id="spritespin__stop" class="spritespin-btn spritespin-btn--stop">Стоп</button>
                                <button id="spritespin__next" class="spritespin-btn spritespin-btn--next">Вперед</button>
                            </div>
                        </div>
                    </div>

                    <script type='text/javascript'>
                        var enable3DSupport = {
                            init: function() {
                                var link = $('#link-3d-gallery');
                                var self = this;
                                var contentSpritespin = $('#spritespin-wrap');

                                link.on('click', function(e) {
                                    e.preventDefault();

                                    if ($(this).hasClass('no-3d-initialized')) {
                                        self.initSpritespin();
                                        $(this).removeClass('no-3d-initialized');
                                    }
                                    self.showPopup();
                                })
                            },
                            showPopup: function() {
                                var contentSpritespin = $('#spritespin-wrap');
                                $.fancybox(contentSpritespin);
                            },
                            initSpritespin: function() {
                                $("#spritespin").spritespin({
                                    width    : 640,  // window width
                                    height   : 480,  // window height
                                    frames   : 32,   // number of frames
                                    resX     : 21760,// sprite sheet resolution
                                    resY     : 437,  // sprite sheet resolution
                                    sense    : -1,   // inverts drag direction to match the spin of the photograph
                                    source   : "<?=$pathToImage3d;?>",
                                    animate: false,
                                    loop: true
                                });

                                // button jumping to previous frame
                                // get current frame and update spritespin to the previous frame
                                $( "#spritespin__prev" ).click(function(){
                                    $("#spritespin").spritespin("prev");
                                });

                                // button to start/pause the animation
                                $( "#spritespin__play" ).click(function() {
                                    $("#spritespin").spritespin("animate", true);
                                });

                                // button to stop the animation and return to first frame
                                $( "#spritespin__stop" ).click(function() {
                                    $("#spritespin").spritespin("animate", false);
                                    $("#spritespin").spritespin("frame", 0);
                                });

                                $( "#spritespin__pause" ).click(function() {
                                    $("#spritespin").spritespin("animate", "toggle");
                                });

                                // button jumping to next frame
                                $( "#spritespin__next" ).click(function(){
                                    $("#spritespin").spritespin("next");
                                });
                            }
                        }
                        $(function() {
                            enable3DSupport.init();
                        })
                    </script>
                </div>
                <?endif;?>

            </div>
            <div class="product-right-block__inner-left">
                <div class="manufacturer">
                    Производитель: <?=$arResult['BRAND']['NAME']?>
                </div>
            <?if ($arResult['PROPERTIES']['lC_Srokgarantijno5']['VALUE']):?>
                <div class="warranty">
                        <?=$arResult['PROPERTIES']['lC_Srokgarantijno5']['NAME']?><br/>
                        <?=$arResult['PROPERTIES']['lC_Srokgarantijno5']['VALUE']?>
                </div>
                    <?endif;?>
                <div class="shop_works-time">
                   <a href="/about/shop/">Магазин</a> открыт до 21
                </div>
                <ul class = "product-right-block__inner-left-bottom">
                    <li class="left-bottom-item"><a href="/about/delivery/">Доставка и оплата</a></li>
                    <li class="left-bottom-item"><a href="/about/changeandback/">Возврат и обмен</a></li>
                    <li class="left-bottom-item"><a href="/about/guarantee/">Гарантия качества</a></li>
                    <li class="left-bottom-item"><a href="/about/consultation/">Консультация</a></li>
                    <li class="left-bottom-item"><a href="/about/service/">Сервисный центр</a></li>
                </ul>
            </div>
		</div>
	</div>
	<!--/.product-card-inner-->
  <div style="display: inline-block; width: 100%;">
  <div class="item-detail-menu">
    <div id="demoTabs">
          <ul class="item-detail-menu-wrap">
              <li class="item-detail-menu-item item-detail-menu-item-active">
                  <a data-id="about" href="#" rel="#" class="ui-icon-tab-menu-item">О товаре</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="charachteristic" href="#" rel="#" class="ui-icon-tab-menu-item">Характеристики</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="answers" href="#" rel="#" class="ui-icon-tab-menu-item">Отзывы</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="acksesories" href="#" rel="#" class="ui-icon-tab-menu-item">Аксесуары</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="items-detal" href="#" rel="#" class="ui-icon-tab-menu-item">Запчасти</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="questions" href="#" rel="#" class="ui-icon-tab-menu-item">Вопросы и ответы</a>
              </li>
              <li class="item-detail-menu-item">
                  <a data-id="consultation" href="#" rel="#" class="ui-icon-tab-menu-item">Получить консультацию</a>
              </li>
          </ul>
    </div>


      <div id="about" class="item-detail-menu-container">
        <!-- Начало блока видео -->
        <div class="video-item-detail">
            <?if (is_array($arResult['PROPERTIES']['video']['VALUE'])):?>
                <div id="tab02" class="tab-holder tab-holder--video">
                    <div class="detail__video">
                        <?foreach($arResult['PROPERTIES']['video']['VALUE'] as $videoItem):?>
                            <div class="detail__video__item">
                                <?=htmlspecialchars_decode($videoItem);?>
                            </div>
                        <?endforeach;?>
                    </div>
                    <script>
                        // By Chris Coyier & tweaked by Mathias Bynens
                        $(function() {
                            var $allVideos = $(".detail__video").find('iframe'),
                                $fluidEl = $(".tab-holder--video");

                            // Figure out and save aspect ratio for each video
                            $allVideos.each(function() {
                                $(this).data('aspectRatio', this.height / this.width)
                                    // and remove the hard coded width/height
                                    .removeAttr('height')
                                    .removeAttr('width');
                            });

                            // When the window is resized
                            // (You'll probably want to debounce this)
                            $(window).resize(function() {
                                var newWidth = $fluidEl.width();

                                // Resize all videos according to their own aspect ratio
                                $allVideos.each(function() {
                                    var $el = $(this);
                                    $el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
                                });
                                // Kick off one resize to fix all videos on page load
                            }).resize();

                        });
                    </script>
                </div>
            <?endif;?>
        </div>
        <!-- Конец блока видео -->
        <div id="product-bottom" class="product-bottom">
              <?
              $detail_text = $arResult['DETAIL_TEXT']?$arResult['DETAIL_TEXT']:$arResult['PREVIEW_TEXT'];
              if (strlen(trim(strip_tags($detail_text)))):?>
                  <div class="product-text-info-wrap description-container" id="about">
                      <div class="product-text-info">
                          <div class="product-text-info__title">О продукте</div>
                          <div class="product-text-info__inner">
                              <?=$detail_text;?>
                          </div>
                      </div>
                  </div>
              <?endif;?>
          <?
          $needDetailTabs = false;
          if (count($arResult['ITEM_PROPS']) > 0
              || is_array($arResult['PROPERTIES']['video']['VALUE'])
              || is_array($arResult['PROPERTIES']['FILES']['VALUE'])) {
              $needDetailTabs = true;
          }
          ?>
          <div class="product__descr">
              <?if ($arResult['MAIN_PROPS']):?>
                  <div class="prop_title">
                      Характеристики
                  </div>
                  <div class="detail__main-props">
                      <?foreach($arResult['MAIN_PROPS'] as $value):?>
                          <?
                          if (($value['USER_TYPE']=="Checkbox") && ($value['VALUE']!=="0") && ($value['VALUE']!=="") && ($value['VALUE']!==0)) {
                              //if (($value['USER_TYPE']=="Checkbox") && ($value['VALUE']!===false)) {
                              $value['VALUE'] = "Есть";
                              //BSP-126
                          } elseif (($value['USER_TYPE']=="Checkbox") && (($value['VALUE']=="0") || ($value['VALUE']=="") || ($value['VALUE']==0))) {
                              //} elseif (($value['USER_TYPE']=="Checkbox") && ($value['VALUE']===false)) {
                              $value['VALUE'] = "Нет";
                              //BSP-126
                          } elseif ($value['USER_TYPE']=="Measured" AND $value['USER_TYPE_SETTINGS']['TEMPLATE']) {
                              $value['VALUE'] = str_replace("#", $value['VALUE'], $value['USER_TYPE_SETTINGS']['TEMPLATE']);
                          }
                          if (is_array($value['VALUE'])) $value['VALUE'] = implode(", ", $value['VALUE']);
                          ?>

                          <?if ($value['VALUE']):?>
                              <div class="detail__main-props__item">
                                  <div><span class="prop_name"><?=$value['NAME'];?></span></div>
                                  <div style="float: right"><span class="prop_value"> <?=$value['VALUE'];?></span></div>
                              </div>
                          <?endif;?>
                      <?endforeach;?>
                  </div>
              <?endif;?>
          </div>
       </div><!-- end of .product-bottom -->

    </div><!-- / .item-detail-menu-container -->
    <div class="resp-tabs-container">
      <div id="charachteristic" class="item-detail-menu-container">
          <? if (count($arResult['ITEM_PROPS'])>0):?>

              <div class="detail-properties">
                  <?
                  $prev_id = 0;
                  $arNoBorder = array();
                  if (is_array($arResult['ITEM_PROPS'])) {
                      foreach ($arResult['ITEM_PROPS'] as $prop) {
                          if ($prop['USER_TYPE']=="Delimiter") $arNoBorder[] = $prev_id;
                          $prev_id = $prop['ID'];
                      }
                  }
                  ?>

                  <?if (is_array($arResult['ITEM_PROPS'])):?>
                      <?
                      $descriptions_exists = false; // показываем или как
                      $allowed_headers = array(); // прверяем, какие разделители показывать
                      $last_checking_header = "";
                      foreach ($arResult['ITEM_PROPS'] as $item_prop) {
                          if ($item_prop['USER_TYPE']=="Delimiter") $last_checking_header = $item_prop['ID'];
                          if ($item_prop['USER_TYPE']!="Delimiter" AND !empty($item_prop['VALUE'])) {
                              $descriptions_exists = true;
                              if ($last_checking_header) $allowed_headers[$last_checking_header]++;
                          }
                      }
                      if ($descriptions_exists):
                          ?>

                          <div class="detail-properties__title"><?=$arResult['NAME']?></div>

                          <div class="block">
                              <table class="product-properties" cellpadding="0" cellspacing="0" >

                                  <?foreach ($arResult['ITEM_PROPS'] as $item_prop):?>

                                      <?
                                      //GT-275
                                      if ($item_prop['CODE']=="BITRIKSAKTIVNOST") Continue;
                                      //GT-275
                                      //GT-302
                                      if ($item_prop['CODE']=="FILL") Continue;
                                      //GT-302
                                      //привязал проверку к коду
                                      // TR-71 Oleg
                                      //if($item_prop['NAME'] == 'Базовый цвет') continue;
                                      $pos = strpos($item_prop['CODE'], 'Bazovyjcvet');
                                      if ($pos !== false) continue;
                                      // TR-71 Oleg

                                      // BSP-24
                                      $pos = strpos($item_prop['CODE'], 'Diapazon');
                                      if ($pos !== false) continue;
                                      // BSP-24
                                      ?>

                                      <?if ($item_prop['USER_TYPE']=="Delimiter" AND intval($allowed_headers[$item_prop['ID']])>0):?>
                                          <tr class="delimiter-prop"><td colspan="2"><div class="corners-white_blue"><strong><?=$item_prop['NAME']?></strong></div></td></tr>
                                      <?elseif ($item_prop['VALUE']):?>
                                          <?
                                          $class = 'class="solid-line-bottom"';
                                          ?>
                                          <tr <?=$class?>>
                                              <td class="property property-name">
                                                  <?=$item_prop['NAME']?>
                                                  <?if ($item_prop['USER_TYPE_SETTINGS']['DESCRIPTION']):?>
                                                      <a href="#" rel="<?=$item_prop['ID']?>" class="bexx_detail_property_hint">?</a>
                                                      <div id="prop_description_<?=$item_prop['ID']?>" style="display: none;" class="bexx_catalog_detail_prop_description">
                                                          <span class="closer">X</span>
                                                          <div class="bexx_detail__hint"><?=$item_prop['NAME']?></div>
                                                          <?=nl2br(htmlspecialcharsback($item_prop['USER_TYPE_SETTINGS']['DESCRIPTION']))?>
                                                      </div>
                                                  <?endif;?>
                                              </td>
                                              <td class="property property-value">
                                                  <div>
                                                      <?
                                                      $value = ($item_prop['MULTIPLE']=="Y" AND is_array($item_prop['VALUE']))?implode(", ", $item_prop['VALUE']):$item_prop['VALUE'];
                                                      if ($item_prop['USER_TYPE_SETTINGS']['TEMPLATE'] AND $item_prop['USER_TYPE']=="Measured") $value = str_replace("#", $value, $item_prop['USER_TYPE_SETTINGS']['TEMPLATE']);
                                                      elseif ($item_prop['USER_TYPE']=="Checkbox" AND $value==1) $value = "Есть";

                                                      // Oleg
                                                      $httpString = 'http://';
                                                      $isHttpLink = strstr($value, $httpString);

                                                      if ($isHttpLink) {
                                                          echo "<noindex><a rel='nofollow' class='uri-value' target='_blank' href='".$value."'>Перейти на сайт</a></noindex>";
                                                      } else {
                                                          echo $value;
                                                      }

                                                      ?>
                                                  </div>
                                              </td>
                                          </tr>
                                      <?endif;?>
                                  <?endforeach;?>
                              </table>
                          </div>

                          <script>
                              $(function(){
                                  $(".bexx_detail_property_hint").click(function(){
                                      $("#prop_description_"+$(this).attr('rel')).show();
                                      return false;
                                  });
                                  $(".closer").click(function(){
                                      $(".bexx_catalog_detail_prop_description").hide();
                                      return false;
                                  });
                                  $(".bexx_catalog_detail_prop_description").click(function(){
                                      $(this).hide();
                                      return false;
                                  });
                              });
                          </script>
                      <?endif;?>
                  <?endif;?>
              </div>
          <?endif;?>

      </div><!-- end of #characteristics -->

      <div id="answers" class="item-detail-menu-container">
        Here will be answers on the questions.
      </div><!-- end of #canswers -->

      <div id="acksesories" class="item-detail-menu-container">
          <!--Аксессуары к товару -->
          <div class="detail-accessories">
              <?if (!empty($arResult['PROPERTIES']['accessories']['VALUE']) AND is_array($arResult['PROPERTIES']['accessories']['VALUE'])):?>
                  <div class="poly-items__title">
                      <?=$arResult['PROPERTIES']['accessories']['NAME']?$arResult['PROPERTIES']['accessories']['NAME']:"Аксессуары"?> <span> к <?=$arResult['NAME']?> </span>
                  </div>
                  <?$accessoriesResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "viewed_items", array(
                          "IBLOCK_TYPE" => $arParams['IBLOCK_TYPE'],
                          "IBLOCK_ID" => $arResult['PROPERTIES']['accessories']['LINK_IBLOCK_ID']?$arResult['PROPERTIES']['accessories']['LINK_IBLOCK_ID']:$arParams['IBLOCK_ID'],
                          "ADDITIONAL_FILTER" => array(
                              'ID' => $arResult['PROPERTIES']['accessories']['VALUE'],
                          ),
                          "SECTION_ID" => "",
                          "INCLUDE_SUBSECTIONS" => "Y",
                          "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                          "CHECK_ACTIVE" => $arParams['CHECK_ACTIVE'],
                          "SORT_FIELD_1" => "id",
                          "SORT_DIR_1" => "DESC",
                          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                          "CACHE_TIME" => $arParams['CACHE_TIME'],
                          "SET_TITLE" => "N",
                          "CATALOG_PATH" => $arParams['CATALOG_PATH'],
                          "SHOW_OLD_PRICE" => "N",
                          "DESCRIPTION_FROM_PROPS" => "N",
                          "SHOW_NAVIGATION" => "N",
                          "COUNT" => "9",
                          "ALLOW_PAGENAV" => "Y",
                          "ALWAYS_EXISTING_FIRST" => $arParams['ALWAYS_EXISTING_FIRST'],
                      ),
                      $component
                  );?>
                  <?//if (count($arResult['PROPERTIES']['accessories']['VALUE'])>5):?>
                  <!--  <a class="" href="<?//=$arParams['SEF_FOLDER']?$arParams['SEF_FOLDER']:"/"?>accessories.html?for=<?//=$arResult['ID']?>"><?//=($arResult['PROPERTIES']['accessories']['NAME']?$arResult['PROPERTIES']['accessories']['NAME']:"Аксессуары")?> для <?//=$arResult['NAME']?></a>-->
                  <?//=count($arResult['PROPERTIES']['accessories']['VALUE']);?>
                  <?//endif;?>
              <?endif;?>
          </div>
      </div><!-- end of #accessories -->

      <div id="items-detal" class="item-detail-menu-container">
          <?//MM-107?>
          <!--запчасти -->
          <div class="detail-accessories">
              <?if($arResult['PROPERTIES']['ORIGINAL_PARTS']['VALUE']):?>

                  <p class="title orange"><strong>Оригинальные запчасти:</strong> <img align="baseline"/></p>

                  <?/*$originalpartsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "small_block_wide", array(
                          "IBLOCK_TYPE" => "catalog",
                          "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                          "ADDITIONAL_FILTER" => array(
                              'ID' => $arResult['PROPERTIES']['ORIGINAL_PARTS']['VALUE'],
                          ),
                          "SECTION_ID"=>'',  //категория запчастей!!!!
                          "INCLUDE_SUBSECTIONS" => "Y",
                          "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                          "CHECK_ACTIVE" => $arParams['CHECK_ACTIVE'],
                          "SORT_FIELD_1" => "id",
                          "SORT_DIR_1" => "DESC",
                          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                          "CACHE_TIME" => $arParams['CACHE_TIME'],
                          "SET_TITLE" => "N",
                          "CATALOG_PATH" => $arParams['CATALOG_PATH'],
                          "SHOW_OLD_PRICE" => "N",
                          "DESCRIPTION_FROM_PROPS" => "N",
                          "SHOW_NAVIGATION" => "N",
                          "COUNT" => "9",
                          "ALLOW_PAGENAV" => "Y",
                          "ALWAYS_EXISTING_FIRST" => $arParams['ALWAYS_EXISTING_FIRST'],
                      ),
                      $component
                  );*/?>

                  <?$originalpartsResult = $APPLICATION->IncludeComponent("bexx:catalog.items", "viewed_items", array(
                          "IBLOCK_TYPE" => "catalog",
                          "IBLOCK_ID" => $arParams['IBLOCK_ID'],
                          "ADDITIONAL_FILTER" => array(
                              'ID' => $arResult['PROPERTIES']['ORIGINAL_PARTS']['VALUE'],
                          ),
                          "SECTION_ID"=>'',  //категория запчастей!!!!
                          "INCLUDE_SUBSECTIONS" => "Y",
                          "CHECK_PERMISSIONS" => $arParams['CHECK_PERMISSIONS'],
                          "CHECK_ACTIVE" => $arParams['CHECK_ACTIVE'],
                          "SORT_FIELD_1" => "id",
                          "SORT_DIR_1" => "DESC",
                          "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                          "CACHE_TIME" => $arParams['CACHE_TIME'],
                          "SET_TITLE" => "N",
                          "CATALOG_PATH" => $arParams['CATALOG_PATH'],
                          "SHOW_OLD_PRICE" => "N",
                          "DESCRIPTION_FROM_PROPS" => "N",
                          "SHOW_NAVIGATION" => "N",
                          "COUNT" => "9",
                          "CODE" => "original_parts",
                          "VIEWED" => "N",
                          "ALLOW_PAGENAV" => "Y",
                          "ALWAYS_EXISTING_FIRST" => $arParams['ALWAYS_EXISTING_FIRST'],
                      ),
                      $component
                  );
                  ?>

              <?endif;?>
          </div>

          <?//MM-99?>
      </div><!-- end of #items-detail -->

      <div id="questions" class="item-detail-menu-container">
        6
      </div><!-- end of #questions -->

      <div id="consultation" class="item-detail-menu-container">
        7
      </div><!-- end of #consultation -->
    </div><!-- End of .resp-tabs-container  -->
    <script src="<?=SITE_TEMPLATE_PATH?>/js/easyResponsiveTabs.js"></script>
    <script>
         $('#demoTab').easyResponsiveTabs();
    </script>

<!--       <script type="text/javascript">
          BIS.itemMenuObj = {
              init: function() {
                  var self = this;
                  var w = $(window);
                  var wWidth = w.width();
                  var minWidth = 640;
                  var isMobile = false;

                  self.enableMobileLinks();
              },


              enableMobileLinks: function() {
                  var links = $('.ui-icon-tab-menu-item');
                  var blocks = $('.item-detail-menu-container');
                  var blockab = $('#about');
                  var blockch = $('#charachteristic');
                  var blockan = $('#answers');
                  var blockac = $('#acksesories');
                  var blockid = $('#items-detal');
                  var blockqw = $('#questions');
                  var blockcon = $('#consultation');

                  var dataId;
                  var currentBlock;
                  var cssActiveLink = 'item-detail-menu-item-active';

                  blockab.show();
                  blockch.hide();
                  blockan.hide();
                  blockac.hide();
                  blockid.hide();
                  blockqw.hide();
                  blockcon.hide();

                  links.on('click.mobile', function(e) {
                      e.preventDefault();
                      blocks.hide();
                      links.parent('.item-detail-menu-item').removeClass(cssActiveLink);

                      dataId = $(this).data('id');
                      currentBlock = $('#'+dataId);

                      currentBlock.show();
                      $(this).parent('.item-detail-menu-item').addClass(cssActiveLink);
                  })
              },
              disableMobileLinks: function() {
                  var links = $('.item-detail-menu-item');
                  var blocks = $('.item-detail-menu-container');

                  blocks.show();
                  links.off('click.mobile');
              }
          }
          $(function() {
              BIS.itemMenuObj.init();
          })
      </script> -->
  </div>
    <!--<div id="product-bottom" class="product-bottom">
        <div class="product-bottom__inner">
            <?if ($needDetailTabs):?>
            <div id="product-tabset" class="detail-tabs">

              <!--  <ul class="detail-tabs__list tabs">
                    <?//if (count($arResult['ITEM_PROPS']) > 0):?>
                    <li>
                        <a href="#tab01">Характеристики</a>
                    </li>
                    <?//endif;?>

                    <?//if (is_array($arResult['PROPERTIES']['video']['VALUE'])):?>
                    <li>
                        <a href="#tab02">Видео</a>
                    </li>
                    <?//endif;?>

                    <?//if (is_array($arResult['PROPERTIES']['FILES']['VALUE'])):?>
                    <li>
                        <a href="#tab03">Файлы</a>
                    </li>
                    <?//endif;?>
                </ul>
                <?if (is_array($arResult['PROPERTIES']['FILES']['VALUE'])):?>
                <div id="tab03" class="tab-holder tab-holder--files">
                    <div class="detail__files">
                        <?foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $fileID):?>
                            <?$currentFile = CFile::GetFileArray($fileID);?>
                            <div class="detail__files__entity">
                                <a class="detail__files__entity-link" target="_blank" href="<?=$currentFile['SRC'];?>"><?=$currentFile['DESCRIPTION'];?></a>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
                <?endif;?>

            </div>
            <?endif;?>
        </div>

    </div>-->
  </div>
    <?//MM-107?>
  <div>
    <div class = "have_to_buy" style="margin-bottom: 15px;">
        <?if ($arResult['COUNT_REQUIRE_PURCHASE'] > 0):?>
            <p class="title orange"><strong>Требуется докупить:</strong> <img align="baseline"/></p>
            <?$APPLICATION->IncludeComponent("bitrix:news", "require_purchase", array(
                    "IBLOCK_TYPE" => "info",
                    "IBLOCK_ID" => "57360",
                    "ADDITIONAL_FILTER" => array(
                        'PROPERTY_LINKED_ITEMS' => $arResult['ID'],
                    ),

                    "ITEM_ID" => $arResult['ID'],
                    "ITEM_CODE" => $arResult['CODE'],

                    "NEWS_COUNT" => "120",
                    "USE_SEARCH" => "N",
                    "USE_RSS" => "N",
                    "USE_RATING" => "N",
                    "USE_CATEGORIES" => "N",
                    "USE_FILTER" => "N",
                    "SORT_BY1" => "SORT",
                    "SORT_ORDER1" => "ASC",
                    "SORT_BY2" => "",
                    "SORT_ORDER2" => "",
                    "CHECK_DATES" => "Y",
                    "SEF_MODE" => "Y",
                    "SEF_FOLDER" => "/require_purchase/",
                    "AJAX_MODE" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "AJAX_OPTION_HISTORY" => "N",
                    "CACHE_TYPE" => "A",
                    "CACHE_TIME" => "86400",
                    "CACHE_FILTER" => "N",
                    "CACHE_GROUPS" => "N",
                    "SET_TITLE" => "Y",
                    "SET_STATUS_404" => "N",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "Y",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "USE_PERMISSIONS" => "N",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "LIST_ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "LIST_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "LIST_PROPERTY_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                    "DISPLAY_NAME" => "Y",
                    "META_KEYWORDS" => "meta_keywords",
                    "META_DESCRIPTION" => "meta_description",
                    "BROWSER_TITLE" => "custom_title",
                    "DETAIL_ACTIVE_DATE_FORMAT" => "d.m.Y",
                    "DETAIL_FIELD_CODE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "DETAIL_DISPLAY_TOP_PAGER" => "N",
                    "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
                    "DETAIL_PAGER_TITLE" => "Страница",
                    "DETAIL_PAGER_TEMPLATE" => "",
                    "DETAIL_PAGER_SHOW_ALL" => "Y",
                    "DISPLAY_TOP_PAGER" => "N",
                    "DISPLAY_BOTTOM_PAGER" => "Y",
                    "PAGER_TITLE" => "Требуется докупить",
                    "PAGER_SHOW_ALWAYS" => "Y",
                    "PAGER_TEMPLATE" => "",
                    "PAGER_DESC_NUMBERING" => "N",
                    "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                    "PAGER_SHOW_ALL" => "N",
                    "CATALOG_IBLOCK_TYPE" => "catalog",
                    "CATALOG_IBLOCK_ID" => "",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "SEF_URL_TEMPLATES" => array(
                        "news" => "/require_purchase/",
                        /*"section" => "#SECTION_CODE#/",
                        "detail" => "#ELEMENT_CODE#/",*/
                        "detail" => "#ELEMENT_CODE#/#TOVAR_CODE#/",
                        //"detail" => "/require_purchase/#TOVAR_CODE#/#ELEMENT_CODE#/",
                    "CODE" => "require_purchase",
                    )
                ),
                false
            );?>
        <?endif;?>
    </div>
  </div>

    <?//similar models?>
    <div class="detail__items-block">
        <?$APPLICATION->IncludeComponent("bexx:catalog.items", "viewed_items", array(
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

                "BLOCK_TITLE" => "С этой моделью также смотрят"
            ),
            $component
        );?>
    </div>
    <?//VTL-5?>
    <script>
        $(function(){
            $('#basket-button-without-offer').click(function(){
                ajax_block('#product-order-<?=$arResult['ID']?>');
                $.gritter.add({title: '<div class="thumbsup"></div>', text: 'Вы добавили <b><?=$arResult['NAME']?></b> в корзину. <br/><br/><a href=\'/personal/cart/\'>Перейти в корзину</a>', time: 2000});
                ajax_load('#cart_ajax', '<?=$arResult['AJAX_CALL_ID']?>', $('#add2cart_form').serializeArray());
                return false;
            });

            $('#basket-button').click(function(){
                // проверка, все ли поля указаны
                var error = false;
                var skufullname = '';
                var qntsku = 0;
                $('.prop_sku_hidden').each(function(){
                    skufullname = skufullname + $(this).val()+'001';
                    if ($(this).val()=='') {
                        error = true;
                    }
                });
                if (error) {
                    alert('Укажите все параметры');
                    return false;
                }

                skufullname = skufullname.replace(/[^a-zA-ZА-Яа-я0-9_]/g,'');

                qntsku = $("#"+skufullname).val();

                if (qntsku != 1) {
                    alert('Товара нет в наличии');
                    return false;
                }

                ajax_block('#product-order-<?=$arResult['ID']?>');
                $.gritter.add({title: '<div class="thumbsup"></div>', text: 'Вы добавили <b><?=$arResult['NAME']?></b> в корзину. <br/><br/><a href=\'/personal/cart/\'>Перейти в корзину</a>', time: 2000});
                ajax_load('#cart_ajax', '<?=$arResult['AJAX_CALL_ID']?>', $('#add2cart_form').serializeArray());
                return false;
            });
        });

    </script>
    <?//VTL-5?>
</div>

<?//MM-99?>
<?endif;?>
<?//MM-99?>

<!-- product-card -->
<?endif;?>