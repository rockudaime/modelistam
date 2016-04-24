<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if ($arResult['ID']>0):?>
    <table cellpadding="5" cellspacing="0" width="100%"><tr valign="top">
        <?if ($arResult["DETAIL_PICTURE"]>0):?>
            <td width="200"><?=CFile::ShowImage(MakeImage($arResult["DETAIL_PICTURE"], array('w'=>200)))?></td>
        <?endif;?>
        <td width="100%">
            <div class="description"><?=$arResult["DETAIL_TEXT"];?></div>
        </td>
    </tr></table>
<?endif;?>