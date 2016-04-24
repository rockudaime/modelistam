<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>
<?if (is_array($arResult['ITEMS'])):?>
<div class="detail-brands__inner">
    <div class="detail-brands__inner-content">
        <?foreach ($arResult['ITEMS'] as $item):?>
            <? $activeItemCSS = '';
            if ($arParams['CURRENT_PRODUCT_ID'] == $item['ID']) {
                $activeItemCSS = 'detail-brands__inner__item--active';
            }
            ?>
            <div class="detail-brands__inner__item <?=$activeItemCSS?>">
                <?if ($activeItemCSS):?>
                    <span><?=$item['NAME']?></span>
                <?else:?>
                    <a class="detail-brands__inner-link" href="<?=$item['DETAIL_PAGE_URL']?>" title="<?=$item['NAME']?>"><?=$item['NAME']?></a>
                <?endif;?>
            </div>
        <?endforeach;?>
    </div>
    <span class="detail-brands__inner-count--hidden"><?=count($arResult['ITEMS']);?></span>
</div>
<?endif;?>