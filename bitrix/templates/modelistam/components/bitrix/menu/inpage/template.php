<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?
$classes = array( // чередующиеся классы для разноцветных буллетов
    'arr-dbl-green-right',
    'arr-dbl-red-right',
    'arr-dbl-blue-right',
    'arr-dbl-yellow-right'
);
?>
<div class="block">
    <div class="top_line"></div>
    <div class="corners-white top_right"></div>
    <div class="corners-white top_left"></div>
    <div class="content" style=" height: 16px;">
        <ul>
            <li class="grey" style="display: inline; margin-right: 20px;">Самое интересное: </li>
            <?foreach ($arResult as $index=>$item):?>
                <?$class = $classes[$index%count($classes)];?>
                <li style="display: inline; margin-right: 20px;">
                    <a href="<?=$item['LINK']?>" class="black <?=$class?>"><?=$item['TEXT']?></a>
                </li>
            <?endforeach;?>
        </ul>
    </div>
    <div class="corners-white bottom_right"></div>
    <div class="corners-white bottom_left"></div>
    <div class="bottom_line"></div>
</div>
<br class="clear" />

<?endif?>