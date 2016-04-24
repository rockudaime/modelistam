<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?if (is_array($arResult['ITEMS'])):?>
<div class="detail-small-block">
    <?if (strlen($arParams['BLOCK_TITLE'])):?>
        <div class="detail-small-block__title"><?=$arParams['BLOCK_TITLE']?></div>
    <?endif;?>
    <div class="detail-small-block__inner">
    <?$counter=0?>
    <?foreach ($arResult['ITEMS'] as $item):?>
    <?$counter++;?>
        <div class="block item<?if ($counter>=count($arResult['ITEMS'])):?> last<?endif;?>">
            <?if ($item['DETAIL_PICTURE']):?>
            <a href="<?=$item['DETAIL_PAGE_URL']?>">
                <img class="detail-small-block__image" alt="<?=$item['NAME']?>" align="left" width="80" height="80" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>80, 'hl'=>80, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
            </a>
            <?else:?>
                <img class="detail-small-block__image" alt="<?=$item['NAME']?>" align="left" width="80" src="<?=SITE_TEMPLATE_PATH?>/images/no-photo.jpg" />
            <?endif;?>
            <div class="product-special">
                <a href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
                <span class="price-span"><?=price($item['DISCOUNT_PRICE'], $item['CURRENCY'])?></span>
            </div>
        </div>
    <?endforeach;?>
    </div>
</div>
<?endif;?>