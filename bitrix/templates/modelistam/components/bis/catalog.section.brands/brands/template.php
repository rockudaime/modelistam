<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?if (is_array($arResult['ITEMS'])):?>
    <div class="brands-container__content">
        <div class = brand-list>
            <?//$i=0;?>
            <?foreach ($arResult['ITEMS'] as $item):?>
                <?//if ($i == 0):?>
                <?//endif;?>
                <?//$i++;?>
                <div class="brand-item">
                    <a href="/brands/<?=$item['CODE']?>/"><?=$item['NAME'];?></a>
                </div>

                <?//if ($i == 4):?>
                    <?//$i = 0;?>
                <?//endif;?>
            <?endforeach;?>
         </div>
    </div>

<?endif;?>


