<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<?if ($arResult['ITEMS']):?>

<div class="poly-items" id="poly-items-<?=$arParams['CODE']?>">

    <div class="poly-items__inner <?if ($showNavigation == 'false') echo 'poly-items__inner--no-buttons'?>">
        <?if ($arParams['BLOCK_TITLE']):?>
            <div class="poly-items__title-category">
                <?=$arParams['BLOCK_TITLE']?>
            </div>
        <?endif;?>

        <div  class="poly-items__inner__inner-category">
                <?foreach ($arResult['ITEMS'] as $item):?>
                    <div class="poly-items__item-category">
                        <div class="poly-items__item-inner">
                            <?if ($item['DETAIL_PICTURE']):?>
                                <div class="poly-items__item-image-block">
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                        <img class="poly-items__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>371, 'h'=>276, 'q'=>100))?>" />
                                    </a>
                                </div>
                            <?else:?>
                                <div class="poly-items__item-image-block">
                                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
                                        <img class="poly-items__item-image adaptive-img" alt="<?=htmlspecialchars($item['NAME']);?>" title="<?=htmlspecialchars($item['NAME']);?>" class="product-image_spec" src="<?=SITE_TEMPLATE_PATH.'/images/no-photo.jpg'?>" />
                                    </a>
                                </div>
                            <?endif;?>

                            <div class="poly-items__item-name">
                                <a class="poly-items__item-name__link" href="<?=$item['DETAIL_PAGE_URL']?>"><?=$item['NAME']?></a>
                            </div>

                            <div class="poly-items__price">
                                <?if ($item['DISCOUNT_PRICE'] > 0):?>
                                    <span><?=price($item['DISCOUNT_PRICE'],$item['CURRENCY'])?></span>
                                    <script>
                                        $('.poly-items__price span').each(function() {
                                            var toreplace = $(this).html();
                                            toreplace = toreplace.replace("грн.","<p>грн</p>");
                                            $(this).html(toreplace);
                                        });

                                    </script>
                                <?else:?>
                                    <span>нет цены</span>
                                <?endif;?>
                            </div>
                        </div>

                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
<!--</div>-->

<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>