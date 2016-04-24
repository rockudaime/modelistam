<?foreach ($arResult['ITEMS'] as $item):?>

    <?//klm ZN-27
    $item['availability_value'] = $arResult['IBLOCK']['PROPERTIES']['availability']['ENUM_VALUES'][$item['PROPERTY_VALUES']['availability']['VALUE']]['VALUE'];
    //klm ZN-27?>
    <?
    $i++;
    $offer_id = $item['ID'];
    ?>

    <div class="product">
    <div class="product-inner">

    <div class="description">

        <div class="description__left">
            <?/* Картинка */?>
            <div class="product-image">

                <a href="<?=$item['DETAIL_PAGE_URL']?>">

                    <div class="description__labels">
                        <?if (strlen($item['PROPERTY_VALUES']['SALE']['VALUE'])):?>
                            <div class="label-status label--sale">Распродажа</div>
                        <?elseif (strlen($item['PROPERTY_VALUES']['SPECIALOFFER']['VALUE'])):?>
                            <div class="label-status label--akciya">Aкция<i></i></div>
                        <?//MM-330?>
                        <?//elseif (MakeTimeStamp($item['DATE_CREATE'])+86400*$new_days>time()):?>
                        <?elseif ($item['NEW']==1):?>
                        <?//MM-330?>
                            <div class="label-status label--new">Новинка</div>
                        <?elseif(strlen($item['PROPERTY_VALUES']['featured']['VALUE'])):?>
                            <?if (MakeTimeStamp($item['PROPERTY_VALUES']['featured']['VALUE'])>time()):?>
                                <div class="label-status label--hit">Топ продаж</div>
                            <?endif;?>
                        <?endif;?>
                    </div>

                    <?if ($item['DETAIL_PICTURE']):?>
                        <?//MM-79 добавлен параметр 'zc'=>1  было 'h'=>100 изменено на 'h'=>150 и возвращено 'zc'=>0?>
						<img class="product-image__image" alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>150, 'h'=>150, 'zc'=>0, 'q'=>100))?>" />
                    <?else:?>
                        <img class="adaptive-img" alt="<?=$item['NAME']?>" title="<?=$item['NAME']?>" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
                    <?endif;?>
                </a>
            </div>
        </div>

        <div class="description__right">

            <div class="description__right__left">
                <div class="product-title">
                    <h4>
                        <a class="product-title-link" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                    </h4>
                </div>

                <div class="product-preview-text">
                    <?=$item['PREVIEW_TEXT'];?>
                </div>
                <div class="description__bottom">
                    <div class="description__bottom__right">
                        <?/*Рейтинг товара */?>
                        <?//PST-9
                        $frame = $this->createFrame()->begin('');
                        //PST-9?>
                        <? /* Availability */?>
                        <div class="product__avail-block">
                            <?if ($item['availability_value'] == 'Нет в наличии'):?>
                                <div class="product-avail-no">Нет в наличии</div>
                            <?else:?>
                                <div class="product-avail-yes">
                                    <?=$item['availability_value'];?>
                                </div>
                            <?endif;?>
                        </div>
                        <div class="product-rating-block">
                            <div class="rating-content" title="Всего оценок: <?=intval($item['PROPERTY_VALUES']['score_count']['VALUE'])?>, средняя оценка <?=number_format(floatval($item['PROPERTY_VALUES']['score']['VALUE']), 2, ".", " ");?>">
                                <input type="hidden" id="product-ratingback-<?=$item['ID']?>" value="<?=intval($item['PROPERTY_VALUES']['score']['VALUE'])?>" />
                                <div id="product-rating-<?=$item['ID']?>"></div>
                                <div id="product-ratingс-<?=$item['ID']?>"></div>
                            </div>
                        </div>
                        <?//PST-9
                        $frame->end();
                        //PST-9?>
                        <?//PST-9?>
                        <span id="dyn-product-wishlist-compare-<?=$item['ID']?>" class="items-links">
                        <?
                        $frame = $this->createFrame('dyn-product-wishlist-compare-'.$item['ID'])->begin('');
                        //PST-9
                        ?>
                            <? /* Ссылка отложить */?>
                            <div id="product-wishlist-<?=$item['ID']?>" class="product-wishlist-block">
                                <a href="#product-wishlist-<?=$item['ID']?>"
                                   rel="<?=$arResult['AJAX_CALL_ID']?>"
                                   class="top-wishlist-link wishlist-link ajax_link_main_catalog"
                                   params="do=add2wishlist&id=<?=$offer_id?>"><i></i> <div class="hover-link"></div>
                                </a>
                            </div>

                            <? /* Ссылка сравнить */?>
                            <?if ($arParams['SHOW_COMPARE_LINK']!="N"):?>
                                <div id="product-compare-<?=$item['ID']?>" class="product-compare-block">
                                    <div data-compare-id="<?=$item['ID']?>" class="float-left checkbox-black" onclick="ajax_load('#product-compare-<?=$item['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=compare&id=<?=$item['ID']?>&back_url=<?=urlencode($APPLICATION->GetCurPageParam());?>');"></div>
                                    <!--<div class="product-compare-link"><span></span></div>-->
                                </div>
                            <?endif;?>
                            <?//link money?>
                            <div class="item_money">
                                <a href="#" rel="#"></a>
                            </div>

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
                    </div>
                </div>
            </div>

            <div class="description__right__right">
                <div class="product__code">
                    Код: <span><?=$item['PROPERTY_VALUES']['CML2_ARTICLE']['VALUE'];?></span>
                </div>
                <div class="product-price-wrap">
                    <div class="product-price-block">
                        <?//PST-9?>
                        <span id="item-price-<?=$item['ID']?>">
                            <?//PST-9?>
                            <?
                            //PST-9
                            $frame = $this->createFrame('item-price-'.$item['ID'])->begin('');
                            //PST-9
                            ?>
                            <?$specialoffer = false;?>
                            <?if ($item['PRICE']>0 OR (is_array($item['OFFERS']) AND !empty($item['OFFERS']))):?>
                                <?if ($item['DISCOUNT_PRICE']<$item['PRICE'] AND $item['DISCOUNT_PRICE']>0):?>
                                    <?//MM-227?>
                                    <div class="catalog-product__old-price-outer red-new-price">
                                        <?=price($item['PRICE'], $item['CURRENCY']);
                                        $specialoffer = true;
                                        ?>
                                    </div>
                                    <?//MM-227?>
                                <?endif;?>

                                <div class="inner-price-block">
                                    <?
                                    // если цена = 0 и есть товарные предложения, то показваем первое товарное предложение
                                    if (!$item['DISCOUNT_PRICE'] AND (is_array($item['OFFERS']) AND !empty($item['OFFERS']))) {
                                        $offer = reset($item['OFFERS']);
                                        $offer_id = $offer['ID'];
                                        $item['DISCOUNT_PRICE'] = $offer['PRICE'];
                                        $item['CURRENCY'] = $offer['CURRENCY'];
                                    }
                                    ?>
                                    <?if (!empty($item['OFFERS']) AND is_array($item['OFFERS'])):?>
                                        <?foreach ($item['OFFERS'] as $offer):?>
                                            <?
                                            $hidden = "";
                                            if ($offer_id!=$offer['ID']) $hidden = 'style="display: none;"';
                                            ?>
                                            <div class="price-offer">
                                                <strong class="sku_price" id="sku_price_<?=$offer['ID']?>"<?=$hidden?>><?=price($offer['PRICE'], $offer['CURRENCY'])?></strong>
                                            </div>
                                        <?endforeach;?>
                                    <?else:?>
                                        <?if ($specialoffer == true):?>
                                            <div id="sku_price_<?=$item['ID']?>" class="price-offer price-offer-red" >
                                                <?=price($item['DISCOUNT_PRICE'], $item['CURRENCY']);?>
                                            </div>
                                        <?else:?>
                                            <div id="sku_price_<?=$item['ID']?>" class="price-offer" >
                                                <?=price($item['DISCOUNT_PRICE'], $item['CURRENCY']);?>
                                            </div>
                                        <?endif;?>
                                    <?endif;?>
                                </div>
                                <script>
                                    $('.price-offer').each(function() {
                                        var toreplace = $(this).html();
                                        toreplace = toreplace.replace("грн.","<p>&nbsp;грн</p>");
                                        $(this).html(toreplace);
                                    });
                                </script>
                            <?else:?>
                                <div class="inner-price-block">
                                    <div class="price-offer price-offer--no-price">
                                        нет цены
                                    </div>
                                </div>
                            <?endif;?>

                            <?
                            //PST-9
                            $frame->end();
                            //PST-9
                            ?>

                            </span>

                        <?//klm ZN-27?>
                        <? if ($item['availability_value'] == 'Есть в наличии' OR $arParams['ALLOW_BUY_NOT_EXISTING'] == "Y"): ?>
                            <? if ($item['PRICE']>0): ?>
                                <div class="product-add-basket">
                                    <form method="post" action="" id="product-order-form-<?= $item['ID'] ?>">
                                        <input type="hidden" name="do" value="add2cart" />
                                        <input type="hidden" name="qty" value="1" />
                                        <input type="hidden" name="id" id="product-order-id-<?= $item['ID'] ?>" value="<?= $offer_id ? $offer_id : $item['ID'] ?>" />
                                        <div id="product-order-<?= $item['ID'] ?>">
                                            <a class="butt3 ajax-buy-product" href="<?= $item['ID'] ?>"><i></i><span>Купить</span></a>
                                        </div>
                                    </form>
                                </div>
                            <?else:?>
                                <div class="product-add-basket">
                                    <?//PST-7?>
                                    <div>
                                        <div>

                                            <?if ($item['availability_value'] == 'Нет в наличии'):?>
                                                <a href="#reserv-<?=$item['ID']?>" id="reserv_link-<?= $item['ID'] ?>" class="butt3 noavail"><i></i><span>Резерв</span></a>
                                            <?else:?>
                                                <a href="#reserv-<?=$item['ID']?>" id="reserv_link-<?= $item['ID'] ?>" class="butt3"><i></i><span>Резерв</span></a>
                                            <?endif;?>
                                        </div>

                                        <div style="display: none;">
                                            <div id="reserv-<?=$item['ID']?>" class="detail__reserv-block">
                                                <img width="100" height="100" src="<?=SITE_TEMPLATE_PATH?>/images/big_ajax_loader.gif" alt="Загрузка" />
                                            </div>
                                        </div>
                                        <script>
                                            $("a#reserv_link-<?= $item['ID'] ?>").fancybox({
                                                'padding': 10,
                                                'maxWidth': 480,
                                                'maxHeight': 280,
                                                'autoSize': false,
                                                'afterLoad': function(){
                                                    ajax_load('#reserv-<?=$item['ID']?>', '<?=$arResult['AJAX_CALL_ID']?>', 'do=reserv&id=<?=$item['ID']?>');
                                                },
                                                'afterClose': function(){
                                                    $('#reserv-<?=$item['ID']?>').html("загрузка...");
                                                }
                                            });
                                        </script>
                                    </div>
                                    <?//PST-7?>
                                </div>
                            <?endif;?>
                        <?endif; ?>
                        <?//klm ZN-27?>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <?if ($arResult['MAIN_PROPS'] AND !empty($item['DESCRIPTION'])):?>
        <!--<div class="description__main-props">
            <div class="product-properties">
                <?/*
                if ($arResult['TYPE_PROP']) {
                    $item_type = $item['PROPERTY_VALUES'][$arResult['IBLOCK']['PROPERTIES'][$arResult['TYPE_PROP']]['CODE']?$arResult['IBLOCK']['PROPERTIES'][$arResult['TYPE_PROP']]['CODE']:$arResult['TYPE_PROP']]['DESCRIPTION'];
                } else {
                    $item_type = $arResult['PRIMARY_TYPE'];
                }
                ?>
                <?foreach ($item['DESCRIPTION'] as $k=>$v):?>
                    <?if (!empty($v['VALUE']) AND !empty($arResult['MAIN_PROPS'][$item_type][$k])):?>
                        <?
                        $main_prop = $arResult['MAIN_PROPS'][$item_type][$k];
                        if ($main_prop['USER_TYPE']=="Checkbox") $v['VALUE'] = "Есть";
                        elseif ($main_prop['USER_TYPE']=="Measured" AND $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']) $v['VALUE'] = str_replace("#", $v['VALUE'], $main_prop['USER_TYPE_SETTINGS']['TEMPLATE']);
                        elseif ($main_prop['PROPERTY_TYPE']=="L") {
                            if ($main_prop['MULTIPLE']=="Y") {
                                foreach ($v['VALUE'] as $ke=>$ve) {
                                    $v['VALUE'][$ke] = $main_prop['ENUM_VALUES'][$ve];
                                }
                            } else {
                                $v['VALUE'] = $main_prop['ENUM_VALUES'][$v['VALUE']];
                            }
                        }
                        if (is_array($v['VALUE'])) $v['VALUE'] = implode(", ", $v['VALUE']);
                        ?>
                        <strong><?=$main_prop['NAME']?>:</strong> <?=$v['VALUE']?>,
                    <?endif;?>
                <?endforeach;*/?>
            </div>
        </div>-->
    <?endif;?>


    </div>
    </div>
<?endforeach;?>
