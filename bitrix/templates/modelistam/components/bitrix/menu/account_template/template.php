<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    //PST-9
    $this->setFrameMode(true);
    //PST-9
?>

<?if (!empty($arResult)):?>
    <ul class="account__left__list">
        <?foreach($arResult as $arItem):?>
            <li>
                <a class="account__left__list-item <? if ($arItem['SELECTED']) echo 'account__left__list-item--active'?> <?if ($arItem['PARAMS']['SPECIAL_CLASS_NO_ARROW']) { echo 'account__left__list-item--no-arrow';}?> <?=$arItem['PARAMS']['SPECIAL_CLASS_FIRST_ITEM']?>" href="<?=$arItem["LINK"]?>">
                    <?=$arItem["TEXT"]?>
                    <b></b>
                </a>
            </li>
        <?endforeach?>
    </ul>
<?endif?>