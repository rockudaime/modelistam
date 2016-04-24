<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//$frame = $this->createFrame()->begin('');
//PST-9
?>

<div class="news-list">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news-item <?if ($arParams['REVIEWS_TMPL']=="Y") echo 'news-item--review';?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">


        <?//if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
           <!-- <div class="news-date-time"><?//echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>-->
        <?//endif?>
        <?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
            <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                <a class="news_item__img-wrap" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                    <img class="preview_picture adaptive-img" src="<?=MakeImage($arItem["PREVIEW_PICTURE"]["SRC"], array('wl'=>370, 'hl'=>298, 'q'=>100, 'zc'=>1, 'iar'=>0, 'far'=>"C"))?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
                </a>
            <?else:?>
                <img class="news_item__img-wrap" class="preview_picture adaptive-img" src="<?=MakeImage($arItem["PREVIEW_PICTURE"]["SRC"], array('wl'=>370, 'hl'=>298, 'q'=>100, 'zc'=>1, 'iar'=>0, 'far'=>"C"))?>" alt="<?=$arItem["NAME"]?>" title="<?=$arItem["NAME"]?>" />
            <?endif;?>
        <?endif?>
        <div class="news-post">
            <div class="news-main">
                <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
                    <div class="news-item__name-block">
                        <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
                            <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a>
                        <?else:?>
                            <?echo $arItem["NAME"]?><br />
                        <?endif;?>
                    </div>
                <?endif;?>
                <?//if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
                    <div class="items-text-preview">
                        <?echo $arItem["PREVIEW_TEXT"];?>
                        <!--<a class="news-list__link-more" href="<?//=$arItem["DETAIL_PAGE_URL"]?>">Подробнее</a>-->
                    </div>
                <?//endif;?>
            </div>


            <div class="items-text-detail items-text-detail--hide">
                <?echo $arItem["DETAIL_TEXT"];?>
            </div>
        </div>
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<div style="clear:both"></div>
		<?endif?>
		<?foreach($arItem["FIELDS"] as $code=>$value):?>
			<small>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			</small><br />
		<?endforeach;?>
		<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			<small>
			<?=$arProperty["NAME"]?>:&nbsp;
			<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
				<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
			<?else:?>
				<?=$arProperty["DISPLAY_VALUE"];?>
			<?endif?>
			</small><br />
		<?endforeach;?>
	</div>
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>
</div>

<?
//PST-9
//$frame->end();
//PST-9
?>