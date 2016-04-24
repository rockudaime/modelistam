<div class="front-block-filter">
	<div class="front-block-filter__title">
		<i></i>Быстрый подбор
	</div>
	<div class="front-block-filter__content">
        <?//MM-38?>
        <?$APPLICATION->IncludeComponent(
            "bis:catalog.fastfilter",
            "",
            Array(
                "IBLOCK_TYPE" => "catalog",
                "IBLOCK_ID" => "26",
                "FILTER_PROPS" => array(
                    0 => "Brand",
                    1 => "NOMENCLATURE_GROUP",
                    2 => "CATEGORY"
                ),
                "SECTION_ID" => $arResult['SECTION']['ID'],
                "ADDITIONAL_FILTER" => $ADDITIONAL_FILTER,
                "CACHE_TYPE" => $arParams['CACHE_TYPE'],
                "CACHE_TIME" => $arParams['CACHE_TIME'],
                "CATALOG_PATH" => $arParams['SEF_FOLDER'],
            ),
            $component
        );?>
        <?//MM-38?>
	</div>
</div>