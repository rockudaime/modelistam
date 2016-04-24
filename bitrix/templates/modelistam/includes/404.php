<?
$APPLICATION->SetTitle("404 ошибка - страница не найдена");
$APPLICATION->SetPageProperty('not_show_page_title', "Y");
$APPLICATION->SetPageProperty('not_show_breadcrumb', "Y");
?>
<div class="page-404">
	<div class="page-404__top">
        <p>К сожалению, страница не была найдена.</p>
		<div class="page-404__top__image">
			<img class="adaptive-img adaptive-img--center" alt="404 - не найдено" src="<?=SITE_TEMPLATE_PATH?>/images/404.jpg" />
		</div>
	</div>
</div>