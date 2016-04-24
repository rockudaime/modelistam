<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form method="GET" action="<?= $arResult["CURRENT_PAGE"] ?>" name="bfilter">
<!-- it was filter
<table class="sale-personal-order-list-filter data-table">
	<tr>
		<th colspan="2"><?echo GetMessage("SPOL_T_F_FILTER")?></th>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_ID");?>:</td>
		<td><input type="text" name="filter_id" value="<?=htmlspecialcharsbx($_REQUEST["filter_id"])?>" size="10"></td>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_DATE");?>:</td>
		<td><?$APPLICATION->IncludeComponent(
	"bitrix:main.calendar",
	"",
	Array(
		"SHOW_INPUT" => "Y",
		"FORM_NAME" => "bfilter",
		"INPUT_NAME" => "filter_date_from",
		"INPUT_NAME_FINISH" => "filter_date_to",
		"INPUT_VALUE" => $_REQUEST["filter_date_from"],
		"INPUT_VALUE_FINISH" => $_REQUEST["filter_date_to"],
		"SHOW_TIME" => "N"
	)
);?></td>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_STATUS")?>:</td>
		<td><select name="filter_status">
				<option value=""><?=GetMessage("SPOL_T_F_ALL")?></option>
				<?
				foreach($arResult["INFO"]["STATUS"] as $val)
				{
					if ($val["ID"]!="F")
					{
						?><option value="<?echo $val["ID"]?>"<?if($_REQUEST["filter_status"]==$val["ID"]) echo " selected"?>>[<?=$val["ID"]?>] <?=$val["NAME"]?></option><?
					}
				}
				?>
		</select></td>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_PAYED")?>:</td>
		<td><select name="filter_payed">
				<option value=""><?echo GetMessage("SPOL_T_F_ALL")?></option>
				<option value="Y"<?if ($_REQUEST["filter_payed"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
				<option value="N"<?if ($_REQUEST["filter_payed"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
		</select></td>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_CANCELED")?>:</td>
		<td>
			<select name="filter_canceled">
				<option value=""><?=GetMessage("SPOL_T_F_ALL")?></option>
				<option value="Y"<?if ($_REQUEST["filter_canceled"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
				<option value="N"<?if ($_REQUEST["filter_canceled"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td><?=GetMessage("SPOL_T_F_HISTORY")?>:</td>
		<td>
			<select name="filter_history">
				<option value="N"<?if($_REQUEST["filter_history"]=="N") echo " selected"?>><?=GetMessage("SPOL_T_NO")?></option>
				<option value="Y"<?if($_REQUEST["filter_history"]=="Y") echo " selected"?>><?=GetMessage("SPOL_T_YES")?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th colspan="2">
			<input type="submit" class="ui-button-blue ui-button-blue--login-link" name="filter" value="<?=GetMessage("SPOL_T_F_SUBMIT")?>">&nbsp;&nbsp;
			<input type="submit" class="ui-button-blue ui-button-blue--login-link" name="del_filter" value="<?=GetMessage("SPOL_T_F_DEL")?>">
		</th>
	</tr>
</table>
it was filter-->
</form>
<br />
<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
<ul class="sale-personal-order-list data-table responsive-table">
        <!--<li class="order-header">
            <li><?=GetMessage("SPOL_T_ID")?><br /><?=SortingEx("ID")?></li>
            <li><?=GetMessage("SPOL_T_PRICE")?><br /><?=SortingEx("PRICE")?></li>
            <li><?=GetMessage("SPOL_T_STATUS")?><br /><?=SortingEx("STATUS_ID")?></li>
            <li><?=GetMessage("SPOL_T_BASKET")?><br /></li>
            <li><?=GetMessage("SPOL_T_PAYED")?><br /><?=SortingEx("PAYED")?></li>
            <li><?=GetMessage("SPOL_T_CANCELED")?><br /><?=SortingEx("CANCELED")?></li>
            <li><?=GetMessage("SPOL_T_PAY_SYS")?><br /></li>
            <li><?=GetMessage("SPOL_T_ACTION")?></li>
        </li>-->
        <?foreach($arResult["ORDERS"] as $val):?>
            <li class="order-inner">
            <ul>
                <li class="order-header">
                    <ul>
                        <li class="order-number" data-title="<?=GetMessage("SPOL_T_ID")?>"><p><?=$val["ORDER"]["ACCOUNT_NUMBER"]?></p><?=GetMessage("SPOL_T_FROM")?> <?=$val["ORDER"]["DATE_INSERT_FORMAT"]?></li>
                        <li data-title="<?=GetMessage("SPOL_T_PRICE")?>"><b><?=$val["ORDER"]["FORMATED_PRICE"]?></b></li>
                        <li class="order-status" data-title="<?=GetMessage("SPOL_T_STATUS")?>"><p></p><?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?><?//=$val["ORDER"]["DATE_STATUS"]?></li>
                        <ul class="header-icons">
                            <li class="header-icons__item add-more-item">
                                <a class="add-more" href="#" rel="#"><i></i></a>
                                <div class="add-more-pushup"><span>Добавить к заказу еще товары</span></div>
                            </li>
                            <li class="header-icons__item">
                                <a class="message" href="#" rel="#"><i></i></a>
                            </li>
                            <li class="header-icons__item">
                                <a class="print" href="#" rel="#"><i></i></a>
                            </li>
                        </ul>
                        <li class="opened-icon"><i></i></li>
                    </ul>
            <ul class="order-detail">
                <li data-title="<?=GetMessage("SPOL_T_BASKET")?>"><?
                foreach($val["BASKET_ITEMS"] as $vval)
                {
                ?><li><?
                    if (strlen($vval["DETAIL_PAGE_URL"])>0)
                        echo '<a href="'.$vval["DETAIL_PAGE_URL"].'">';
                    echo $vval["NAME"];
                    if (strlen($vval["DETAIL_PAGE_URL"])>0)
                        echo '</a>';
                    echo ' - '.$vval["QUANTITY"].' '.GetMessage("STPOL_SHT");
                    ?></li><?
                }
                ?></li>
                <li data-title="<?=GetMessage("SPOL_T_PAYED")?>"><?=(($val["ORDER"]["PAYED"]=="Y") ? GetMessage("SPOL_T_YES") : GetMessage("SPOL_T_NO"))?></li>
                <li data-title="<?=GetMessage("SPOL_T_CANCELED")?>"><?=(($val["ORDER"]["CANCELED"]=="Y") ? GetMessage("SPOL_T_YES") : GetMessage("SPOL_T_NO"))?></li>
                <li data-title="<?=GetMessage("SPOL_T_PAY_SYS")?>">
                    <?=$arResult["INFO"]["PAY_SYSTEM"][$val["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?> /
                    <?if (strpos($val["ORDER"]["DELIVERY_ID"], ":") === false):?>
                        <?=$arResult["INFO"]["DELIVERY"][$val["ORDER"]["DELIVERY_ID"]]["NAME"]?>
                    <?else:
                        $arId = explode(":", $val["ORDER"]["DELIVERY_ID"]);
                        ?>
                        <?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]?> (<?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"]?>)
                    <?endif?>
                </li>
                <li data-title="<?=GetMessage("SPOL_T_ACTION")?>"><a title="<?=GetMessage("SPOL_T_DETAIL_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_DETAIL"]?>"><?=GetMessage("SPOL_T_DETAIL")?></a><br />
                    <a title="<?=GetMessage("SPOL_T_COPY_ORDER_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_COPY"]?>"><?=GetMessage("SPOL_T_COPY_ORDER")?></a><br />
                    <?if($val["ORDER"]["CAN_CANCEL"] == "Y"):?>
                        <a title="<?=GetMessage("SPOL_T_DELETE_DESCR")?>" href="<?=$val["ORDER"]["URL_TO_CANCEL"]?>"><?=GetMessage("SPOL_T_DELETE")?></a>
                    <?endif;?>
                </li>
            </ul>
                </li>
            </li>
           </ul>
        <?endforeach;?>


</ul>
<?if(strlen($arResult["NAV_STRING"]) > 0):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>