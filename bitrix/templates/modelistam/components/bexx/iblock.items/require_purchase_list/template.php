<?if (is_array($arResult['ITEMS'])):?>

<div class="brands-container__content">
    <ul class="brand-container__content-list">
        <?foreach ($arResult['ITEMS'] as $item):?>
            <?if (!$item['PROPERTY_VALUES']):?>
                <li>
                    <?if ($item['DETAIL_PICTURE']):?>
                        <a href="/require_purchase/<?=$item['CODE']?>/">
                            <img alt="<?=$item['NAME']?>" align="left" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>150, 'hl'=>47, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                        </a>
                        <a href="/require_purchase/<?=$item['CODE']?>/<?=$arParams['ITEM_CODE']?>/"><?=$item['NAME'];?></a>

                        <?foreach ($arResult['ITEMS'] as $item_2):?>
                            <?if ($item_2['PROPERTY_VALUES']['MAIN_ELEMENT']['VALUE'] == $item['ID']):?>
                                или 
                                <a href="/require_purchase/<?=$item['CODE']?>/">
                                    <img alt="<?=$item_2['NAME']?>" align="left" src="<?=MakeImage($item['DETAIL_PICTURE'], array('wl'=>150, 'hl'=>47, 'zc'=>0, 'iar'=>0, 'far'=>"C"))?>" />
                                </a>
                                <a href="/require_purchase/<?=$item_2['CODE']?>/<?=$arParams['ITEM_CODE']?>/"><?=$item_2['NAME'];?></a>
                            <?endif;?>
                        <?endforeach;?>
                    <?else:?>
                        <a href="/require_purchase/<?=$item['CODE']?>/<?=$arParams['ITEM_CODE']?>/"><?=$item['NAME'];?></a>
                        <?foreach ($arResult['ITEMS'] as $item_2):?>
                            <?if ($item_2['PROPERTY_VALUES']['MAIN_ELEMENT']['VALUE'] == $item['ID']):?>
                                или <a href="/require_purchase/<?=$item_2['CODE']?>/<?=$arParams['ITEM_CODE']?>/"><?=$item_2['NAME'];?></a>
                            <?endif;?>
                        <?endforeach;?>
                    <?endif;?>
                </li>
            <?endif;?>
        <?endforeach;?>
    </ul>
</div>
<?
$arResult['NAV'] = $arResult['NAV_CUSTOM'];
?>

<!-- paging -->
<?if ($arResult['NAV']['PAGES_COUNT'] > 1 AND $arParams['ALLOW_PAGENAV']=="Y"):?>
    <form id="paging-form" method="get" action="<?=$APPLICATION->GetCurPageParam("", $arUriKillParams, false)?>">
        <div class="pager">
            <div class="float-left">
                <?if ($arResult['NAV']['CURRENT_PAGE']>1):?>
                <?/*<a href="<?=$APPLICATION->GetCurPageParam("", array("page"), false)?>"><img alt="в начало" title="в начало" src="<?=SITE_TEMPLATE_PATH?>/images/first-orange.gif" /></a>*/?>
                <a class="pager__step-link" href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']-1), array("page"), false)?>">
                    <img alt="предыдущая" title="предыдущая" src="<?=SITE_TEMPLATE_PATH?>/images/redesign_v_2/ui-arrow-left-pager.png" />
                    <span>Пред.</span>
                </a>
                <?endif;?>
                <?
                $left_space = 0;
                $right_space = 0;
                for ($i=1; $i<=$arResult['NAV']['PAGES_COUNT']; $i++) {
                    if ($arResult['NAV']['PAGES_COUNT'] < 5) {
                        if ($arResult['NAV']['CURRENT_PAGE'] == $i):?>
                            <span class="pager__link--current"><?=$i?></span>
                            <?else:?>
                            <a class="pager__link" href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"<?if ($arResult['NAV']['CURRENT_PAGE'] == $i) echo ' class="current_page"';?>><?=$i?></a>
                            <?endif;
                    } else {
                        if ($arResult['NAV']['CURRENT_PAGE'] == $i) {
                            ?> <span class="pager__link--current"><?=$i?></span> &nbsp; <?
                        } else {
                            if ($i-1 == $arResult['NAV']['CURRENT_PAGE'] OR $i+1 == $arResult['NAV']['CURRENT_PAGE']
                                OR $i-2 == $arResult['NAV']['CURRENT_PAGE'] OR $i+2 == $arResult['NAV']['CURRENT_PAGE']) {
                                ?> <a class="pager__link" href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a> &nbsp; <?
                            } elseif ($i < $arResult['NAV']['PAGES_COUNT'] AND $i > $arResult['NAV']['CURRENT_PAGE']) {
                                if ($right_space == 0) echo "&nbsp;&rarr;&nbsp;";$right_space++;
                            } elseif ($i > 1 AND $i < $arResult['NAV']['CURRENT_PAGE']) {
                                if ($left_space == 0) echo "&nbsp;&larr;&nbsp;"; $left_space++;
                            } else {
                                ?> <a class="pager__link" href="<?=$APPLICATION->GetCurPageParam(($i>1)?"page=".$i:"", array("page"), false)?>"><?=$i?></a> &nbsp; <?
                            }
                        }
                    }
                }
                ?>
                <?if ($arResult['NAV']['CURRENT_PAGE']<$arResult['NAV']['PAGES_COUNT']):?>
                <a class="pager__step-link" href="<?=$APPLICATION->GetCurPageParam("page=".($arResult['NAV']['CURRENT_PAGE']+1), array("page"), false)?>">
                    <span>След.</span>
                    <img alt="следущая" title="следущая" src="<?=SITE_TEMPLATE_PATH?>/images/redesign_v_2/ui-arrow-right-pager.png" />
                </a>
                <?/*<a href="<?=$APPLICATION->GetCurPageParam("page=".$arResult['NAV']['PAGES_COUNT'], array("page"), false)?>"><img alt="в конец" title="в конец" src="<?=SITE_TEMPLATE_PATH?>/images/last-orange.gif" /></a>*/?>
                <?endif;?>
            </div>
            <div class="float-right">
                <span class="grey">
                    <?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+1?>
                    -
                    <?=$arResult['NAV']['CURRENT_PAGE']*$arParams['COUNT']-$arParams['COUNT']+count($arResult['ITEMS'])?>
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
                        <option style="padding: 0; font-size: 10px;" value="<?=$v?>" <?if ($arParams['COUNT']==$v):?>selected<?endif;?>><?=$v?></option>
                        <?endif;?>
                    <?endforeach;?>
                </select>
                <?endif;?>
            </div>
        </div>
    </form>
    <?endif;?>
<!-- / paging -->

<br class="clear"/>
<?endif;?>