<?//d($arResult);?>
<?if ($ga_id = COption::GetOptionString("bexx.shop", "google_analytics_id", false)): // интеграция с Google Analytics?>
	<?
	foreach ($arResult['ORDER_PROPERTIES'][$arResult['CURRENT']['CUSTOMER_TYPE']] as $order_prop) {
		if ($order_prop['TYPE']=="LOCATION" AND $order_prop['IS_LOCATION']=="Y") {
			$city = $order_prop['CITIES'][$arResult['CURRENT']['PROPS'][$order_prop['ID']]];
			break;
		}
	}
	?>
	<script type="text/javascript">
		try {
		  var pageTracker = _gat._getTracker("<?=$ga_id?>");
		  pageTracker._initData();
		  pageTracker._trackPageview();
		
		  pageTracker._addTrans(
		    "<?=$arResult['ORDER_ID']?>", // Order ID
		    "", // Affiliation
		    "<?=$arResult['TOTAL_PRICE']?>", // Total
		    "0", // Tax
		    "<?=$arResult['DELIVERY_PRICE']?>", // Shipping
		    "<?=$city?>",                                 // City
		    "",                               // State
		    ""                                       // Country
		  );
		  
		<?foreach ($arResult['CART'] as $item):?>
		  pageTracker._addItem(
		    "<?=$arResult['ORDER_ID']?>", // Order ID
		    "<?=$item['PRODUCT_ID']?>", // SKU
		    "<?=htmlspecialchars($item['NAME']);?>", // Product Name 
		    "", // Category
		    "<?=$item['PRICE']?>", // Price
		    "<?=$item['QUANTITY']?>" // Quantity
		  );
		<?endforeach;?>
		  pageTracker._trackTrans();
		} catch(err) {}
	</script>
<?endif;?>

<div class="success-order">
	<p class="green">Благодарим, ваш заказ принят!<p>
	<p>Ему присвоен номер <strong><?=$arResult['ORDER_ID']?></strong>.</p>
	<p>В самое ближайшее время менеджер интернет-магазина позвонит вам и уточнит детали заказа.</p>
</div>

<?
$action_exist = (file_exists($arResult['PAYMENT_ACTION']['ACTION_FILE']) AND is_readable($arResult['PAYMENT_ACTION']['ACTION_FILE']))?true:false;
?>

<?if ($action_exist AND $arResult['PAYMENT_ACTION']['NEW_WINDOW'] == "N"):?>
	<div><?include_once($arResult['PAYMENT_ACTION']['ACTION_FILE']);?></div>
<?elseif ($action_exist AND $arResult['PAYMENT_ACTION']['NEW_WINDOW'] == "Y"):?>
	<div id="payment_content" style="display: none; visible: none;">
		<?include_once($arResult['PAYMENT_ACTION']['ACTION_FILE']);?>
	</div>
	<script>
	function open_payment_window () {
		var frog = window.open("","wildebeast","width=750,height=500,scrollbars=1,resizable=1");
		frog.document.open();
		frog.document.write($('#payment_content').html());
		frog.document.close();
	}
	</script>
	<div><input type="button" value="Оплатить" onclick="open_payment_window()" /></div>
<?endif;?>

<?if ($arResult['NEW_USER']):?>
	<p>Вы были зарегистрированы на сайте. Вам присвоен логин <strong><?=$arResult['NEW_USER']['LOGIN']?></strong>, 
	установлен пароль <span style="color: #fff; padding: 2px 5px;"><?=$arResult['NEW_USER']['PASSWORD']?></span> 
	(выделите курсором, чтобы увидеть пароль). Регистрационная информация отправлена на ваш 
	e-mail <?=$arResult['NEW_USER']['EMAIL']?></p>
<?endif;?>