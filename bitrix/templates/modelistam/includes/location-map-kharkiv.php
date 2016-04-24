<div>
    <?/*$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
            "INIT_MAP_TYPE" => "MAP",
            "MAP_DATA" => "a:4:{s:10:\"yandex_lat\";d:50.01223784869625;s:10:\"yandex_lon\";d:36.24296665277888;s:12:\"yandex_scale\";i:16;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:36.242918373016;s:3:\"LAT\";d:50.012856629446;s:4:\"TEXT\";s:43:\"Салон и сервисный центр\";}}}",
            "MAP_WIDTH" => "",
            "MAP_HEIGHT" => "351",
            "CONTROLS" => array(
                0 => "ZOOM",
                1 => "MINIMAP",
                2 => "TYPECONTROL",
                3 => "SCALELINE",
            ),
            "OPTIONS" => array(
                0 => "ENABLE_SCROLL_ZOOM",
                1 => "ENABLE_DBLCLICK_ZOOM",
                2 => "ENABLE_DRAGGING",
            ),
            "MAP_ID" => ""
        ),
        false
    );*/

	?>
	
	<?$APPLICATION->IncludeComponent(
	"bitrix:map.google.view", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"CONTROLS" => array(
			0 => "SCALELINE",
		),
		"INIT_MAP_TYPE" => "ROADMAP",
		"MAP_DATA" => "a:4:{s:10:\"google_lat\";d:50.015584160077076;s:10:\"google_lon\";d:36.24497679672242;s:12:\"google_scale\";i:16;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:4:\"TEXT\";s:14:\"Магазин\";s:3:\"LON\";d:36.24391794204712;s:3:\"LAT\";d:50.015240464108395;}}}",
		"MAP_HEIGHT" => "351",
		"MAP_ID" => "",
		"MAP_WIDTH" => "",
		"OPTIONS" => array(
			0 => "ENABLE_KEYBOARD",
		)
	),
	false
);
	
    ?>
</div>