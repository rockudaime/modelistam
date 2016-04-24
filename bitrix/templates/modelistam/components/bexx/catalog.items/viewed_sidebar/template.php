<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$frame = $this->createFrame()->begin();
//PST-9
?>

<?if ($arResult['ITEMS']):?>

<div class="viewed-items">

    <div class="viewed-items__inner">
        <?if ($arParams['BLOCK_TITLE']):?>
            <div class="viewed-items__title">
                <?=$arParams['BLOCK_TITLE']?>
            </div>
        <?endif;?>

        <div class="viewed-items__inner__inner">
            <?foreach ($arResult['ITEMS'] as $item):?>
                <div class="viewed-items__item">
                <div class="viewed-items__item-image-block">
                    <a href="<?=$item['DETAIL_PAGE_URL']?>">
                        <?if ($item['DETAIL_PICTURE']):?>
                        <img class="viewed-items__item-image adaptive-img"
                             alt="<?=htmlspecialchars($item['NAME']);?>"
                             title="<?=htmlspecialchars($item['NAME']);?>"
                             class="product-image_spec"
                             src="<?=MakeImage($item['DETAIL_PICTURE'], array('w'=>75, 'h'=>75, 'zc'=>0, 'q'=>100))?>" />
                        <?else:?>
                            <img class="viewed-items__item-image adaptive-img"
                                 alt="<?=htmlspecialchars($item['NAME']);?>"
                                 title="<?=htmlspecialchars($item['NAME']);?>"
                                 class="product-image_spec"
                                 height="75"
                                 src="<?=SITE_TEMPLATE_PATH.'/images/no-photo.jpg'?>" />
                        <?endif;?>
                    </a>
                </div>

            </div>
            <?endforeach;?>
        </div>
    </div>
</div>

<?endif;?>

<?
//PST-9
$frame->end();
//PST-9
?>