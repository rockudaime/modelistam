<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//PST-9
$this->setFrameMode(true);
//PST-9
?>

<?
//delayed function must return a string

__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/'.basename(__FILE__));

//TM-9

if ($arResult['IS_CATALOG']==false){
    unset($arResult['IS_CATALOG']);

    if(empty($arResult))
        return "";

    $strReturn = '<div class="breadcrumb" id="breadcrumb">';
    $strReturn .= '<i class="breadcrumb__sep"></i>';
    $itemSize = count($arResult);

    for($index = 0, $itemSize; $index < $itemSize; $index++)
    {
        if ($index == 0) {
            $strReturn .= '';
        } else {
            $strReturn .= '<i class="breadcrumb__sep"></i>';
        }

        $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

        if($arResult[$index]["LINK"] <> "")
            $strReturn .= '<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a>';
        else
            $strReturn .= '<span>'.$title.'</span>';
    }

    $strReturn .= '</div>';
    echo($strReturn);
}else{
//TM-9
    unset($arResult['IS_CATALOG']);
    $curPage = $GLOBALS['APPLICATION']->GetCurPage($get_index_page=false);
    if ($curPage != SITE_DIR)
    {
        if (empty($arResult) || $curPage != $arResult[count($arResult)-1]['LINK'])
            $arResult[] = array('TITLE' =>  htmlspecialcharsback($GLOBALS['APPLICATION']->GetTitle(false, true)), 'LINK' => $curPage);
    }

    if(empty($arResult))
        return "";

    $strReturn = '<div class="breadcrumb" id="breadcrumb">';

    $itemSize = count($arResult['SECTIONS']);
    $indexlastitem = $itemSize - 1;
    $index = 0;


    $strReturn .= '<i class="breadcrumb__sep"></i>';

    foreach ($arResult['SECTIONS'] as $section=>$sect) {
        if ($index == 0) {
            $strReturn .= '';
        } else {
            $strReturn .= "<i class='breadcrumb__sep'></i>";
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
    }
?>