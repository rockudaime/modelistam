<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string

__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));

$curPage = $GLOBALS['APPLICATION']->GetCurPage($get_index_page=false);
if ($curPage != SITE_DIR)
{
	if (empty($arResult) || $curPage != $arResult[count($arResult)-1]['LINK'])
		$arResult[] = array('TITLE' =>  htmlspecialcharsback($GLOBALS['APPLICATION']->GetTitle(false, true)), 'LINK' => $curPage);
}

if(empty($arResult))
	return "";
	
$strReturn = '<div class="breadcrumb" id="breadcrumb"><a title="'.GetMessage('BREADCRUMB_MAIN').'" href="'.SITE_DIR.'"><img width="12" height="11" src="/bitrix/templates/'.SITE_TEMPLATE_ID.'/images/home.gif" alt="'.GetMessage('BREADCRUMB_MAIN').'" /></a>';


//BSP-11
if (!isset($arResult['NEW_BREADCRUMB'])){
    //НАЧАЛО штатное формирование
    //PM-3
    $itemSize = count($arResult);
    $indexlastitem = $itemSize - 1;
    //PM-3

    for($index = 0, $itemSize; $index < $itemSize; $index++)
    {
        //PM-3
        if($arResult[$index]["LINK"] == "/catalog/") continue;
        //PM-3

        if ($index == 0) {
            $strReturn .= '';
        } else {
            $strReturn .= '<i>&ndash;</i>';
        }

        $title = htmlspecialcharsex($arResult[$index]["TITLE"]);



        if(($arResult[$index]["LINK"] <> "")
            //PM-3
            && ($index < $indexlastitem))
            //PM-3
            $strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>';
        else
            $strReturn .= '<span>'.$title.'</span>';
    }

    $strReturn .= '</div>';

    return $strReturn;
    //КОНЕЦ штатное формирование
}
else{
    $itemSize = count($arResult['SECTIONS']);
    $indexlastitem = $itemSize - 1;
    $index = 0;


    $strReturn .= '<a href="/" title=Главная>Главная</a><i>&ndash;</i>';

    foreach ($arResult['SECTIONS'] as $section=>$sect) {
        if ($index == 0) {
            $strReturn .= '';
        } else {
            $strReturn .= '<i>&ndash;</i>';
        }

        $title = htmlspecialcharsex($sect['NAME']);

        $sect_url = $sect['SECTION_PAGE_URL'];

        if($sect_url <> ''){
            $strReturn .= '<a href="'.$sect_url.'" title="'.$title.'">'.$title.'</a>';
        }
        else
        {
            $strReturn .= '<span>'.$title.'</span>';
        }

        $index++;
    }
    $strReturn .= '</div>';
    echo($strReturn);
    return $strReturn;
}
//BSP-11

?>