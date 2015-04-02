<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($_REQUEST["ajax"] != "y"):?>
<!doctype html>
<html lang="ru">
<head>
	<?if(!defined("VERSION")) define("VERSION", "1.0");?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=1000px">
	<title><?$APPLICATION->ShowTitle()?></title>
	<?$APPLICATION->ShowHead();?>
	<?/*global $USER;
	if($USER->IsAdmin())
		$APPLICATION->ShowHead();
	else
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'" />';
		$APPLICATION->ShowMeta("robots");
		$APPLICATION->ShowMeta("keywords");
		$APPLICATION->ShowMeta("description");
	}*/?>
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/static/<?=VERSION?>/css/jquery.kladr.min.css"/>
	<link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/static/<?=VERSION?>/css/screen.css"/>
	<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
	<script src="<?=SITE_TEMPLATE_PATH?>/static/<?=VERSION?>/js/html5shiv.js"></script>
	<script>//marker

		var contactCoordinates = [55.743650,37.637192];

	</script>
</head>
<body>
<?$APPLICATION->ShowPanel();?>
<header<?if($APPLICATION->GetCurPage() == "/"):?> class="main-page"<?endif?>>
<?if($APPLICATION->GetCurPage() != "/cart/"):?>
	<div class="header-top">

		<div class="header__i">

			<nav<?if($APPLICATION->GetCurPage() == "/"):?> class="clearfix"<?endif?>>
				<?$APPLICATION->IncludeComponent("bitrix:menu", "menu_header", Array(
					"ROOT_MENU_TYPE" => "top",	// Тип меню для первого уровня
					"MAX_LEVEL" => "1",	// Уровень вложенности меню
					"CHILD_MENU_TYPE" => "left",	// Тип меню для остальных уровней
					"USE_EXT" => "Y",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
					"MENU_CACHE_TYPE" => "A",	// Тип кеширования
					"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
					"MENU_CACHE_USE_GROUPS" => "Y",	// Учитывать права доступа
					"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
					),
					false
				);?>
			</nav>
		<?global $USER;?>
			<div class="acc-management clearfix"<?if($USER->IsAuthorized()):?> style="width: 210px;"<?endif?>>
		<?if($USER->IsAuthorized()):?>
			<a href="/personal/" class="personal"><span class="email_current_person"><?=$USER->GetEmail()?></span></a>
			<a href="<?=$APPLICATION->GetCurPageParam("logout=yes", array("logout"))?>" class="exit">выход</a>
		<?else:?>
			<a href="/login/" class="acc popup_btn fancybox.ajax<?/*btn-popup fancybox.ajax*/?>"></a>
		<?endif?>
				<a href="#" class="search"></a>
				<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "cart_panel", 
					Array(
						"PATH_TO_BASKET" => "/cart/",	// Страница корзины
						"PATH_TO_ORDER" => "/cart/",	// Страница оформления заказа
						"SHOW_DELAY" => "N",	// Показывать отложенные товары
						"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
						"SHOW_SUBSCRIBE" => "N",	// Показывать товары, на которые подписан покупатель
					),
					false
				);?>
			</div>

		</div>
		<div class="search-block">
			<div class="search-block__i">
				<a href="#" class="btn-close"></a>
				<?$APPLICATION->IncludeComponent(
	"bitrix:search.form", 
	"search_panel", 
	array(
		"USE_SUGGEST" => "N",
		"PAGE" => "/catalog/"
	),
	false
);?>
			</div>
		</div>

	</div>
<?endif?>
	<div class="header-btm">
		<div class="header__i">
		<?if($APPLICATION->GetCurPage() != "/cart/"):?>
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "menu_catalog_top", Array(
			"VIEW_MODE" => "LIST",	// Вид списка подразделов
				"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
				"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
				"IBLOCK_ID" => "12",	// Инфоблок
				"SECTION_ID" => "",	// ID раздела
				"SECTION_CODE" => "",	// Код раздела
				"SECTION_URL" => "/catalog/#SECTION_CODE#/",	// URL, ведущий на страницу с содержимым раздела
				"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
				"TOP_DEPTH" => "2",	// Максимальная отображаемая глубина разделов
				"SECTION_FIELDS" => "",	// Поля разделов
				"SECTION_USER_FIELDS" => "",	// Свойства разделов
				"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
				"CACHE_TYPE" => "A",	// Тип кеширования
				"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
				"CACHE_GROUPS" => "Y",	// Учитывать права доступа
				"CURRENT_SECTION" => $APPLICATION->GetCurPage()
			),
			false
		);?>
		<?endif?>
		<?if($APPLICATION->GetCurPage() == "/"):?>
			<div class="wrap-logo"><a href="/" class="logotype"><img src="<?=SITE_TEMPLATE_PATH?>/static/<?=VERSION?>/img/logotype.png" alt="mavala"/></a></div>
		<?else:?>
			<a href="/" class="logotype2"><img src="<?=SITE_TEMPLATE_PATH?>/static/<?=VERSION?>/img/logotype-dark.png" alt="mavala"/></a>
		<?endif?>

			<div class="contact-info">
			<?if(stripos($APPLICATION->GetCurPage(), "/cart/") === false):?>
				<div class="item">
					<?$APPLICATION->IncludeComponent(
						"bitrix:sale.ajax.locations",
						"city_header",
						array(
							"AJAX_CALL" => "N",
							"COUNTRY_INPUT_NAME" => "",
							"REGION_INPUT_NAME" => "",
							"CITY_INPUT_NAME" => "USER_CITY_ID",
							"CITY_OUT_LOCATION" => "Y",
							"LOCATION_VALUE" => "",
							"SIZE1" => 21,
						),
						null,
						array('HIDE_ICONS' => 'Y')
					);?>
				</div>
			<?endif?>
				<div class="item">
					<p>звоните: <span class="tel"><?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include_areas/phone.php"), Array(), Array("MODE"=>"text", "NAME" => "телефон"));?></span></p>
				</div>

			</div>

		</div>

	</div>
<?if($APPLICATION->GetCurPage() != "/cart/"):?>
<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "menu_catalog_top_sub", Array(
	"VIEW_MODE" => "LIST",	// Вид списка подразделов
		"SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
		"IBLOCK_TYPE" => "catalog",	// Тип инфоблока
		"IBLOCK_ID" => "12",	// Инфоблок
		"SECTION_ID" => "",	// ID раздела
		"SECTION_CODE" => "",	// Код раздела
		"SECTION_URL" => "/catalog/#SECTION_CODE#/",	// URL, ведущий на страницу с содержимым раздела
		"COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
		"TOP_DEPTH" => "2",	// Максимальная отображаемая глубина разделов
		"SECTION_FIELDS" => "",	// Поля разделов
		"SECTION_USER_FIELDS" => "",	// Свойства разделов
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"CURRENT_SECTION" => $APPLICATION->GetCurPage()
	),
	false
);?>
<?endif?>
<?if($APPLICATION->GetCurPage() == "/"):?>
	<?$APPLICATION->IncludeComponent("bitrix:news.list", "main_promo", Array(
		"DISPLAY_DATE" => "N",	// Выводить дату элемента
			"DISPLAY_NAME" => "Y",	// Выводить название элемента
			"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
			"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
			"AJAX_MODE" => "N",	// Включить режим AJAX
			"IBLOCK_TYPE" => "main",	// Тип информационного блока (используется только для проверки)
			"IBLOCK_ID" => "10",	// Код информационного блока
			"NEWS_COUNT" => "500",	// Количество новостей на странице
			"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
			"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
			"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
			"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
			"FILTER_NAME" => "",	// Фильтр
			"FIELD_CODE" => "",	// Поля
			"PROPERTY_CODE" => array(	// Свойства
				0 => "NAME_1",
				1 => "NAME_2",
				2 => "NAME_3",
				3 => "URL",
			),
			"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
			"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
			"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
			"ACTIVE_DATE_FORMAT" => "",	// Формат показа даты
			"SET_TITLE" => "N",	// Устанавливать заголовок страницы
			"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
			"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
			"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
			"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
			"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
			"PARENT_SECTION" => "",	// ID раздела
			"PARENT_SECTION_CODE" => "",	// Код раздела
			"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
			"CACHE_TYPE" => "A",	// Тип кеширования
			"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
			"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
			"CACHE_GROUPS" => "Y",	// Учитывать права доступа
			"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
			"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
			"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
			"PAGER_TITLE" => "Новости",	// Название категорий
			"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
			"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
			"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
			"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
			"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
			"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		),
		false
	);?>
<?endif?>
</header>

<?if($APPLICATION->GetCurPage() != "/"):?>
<div class="head-cling">

	<div class="head-cling__i clearfix">

		<div class="left clearfix">

			<p>звоните: <b><?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include_areas/phone.php"), Array(), Array("MODE"=>"text", "NAME" => "телефон"));?></b></p>
			<a href="/contacts/">Контакты </a>
			<a href="/delivery_and_pay/?ajax=y" class="btn-popup2 fancybox.ajax">Доставка и оплата</a>

		</div>

		<div class="right">
			<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "cart_panel_slide", 
				Array(
					"PATH_TO_BASKET" => "/cart/",	// Страница корзины
					"PATH_TO_ORDER" => "/cart/",	// Страница оформления заказа
					"SHOW_DELAY" => "N",	// Показывать отложенные товары
					"SHOW_NOTAVAIL" => "N",	// Показывать товары, недоступные для покупки
					"SHOW_SUBSCRIBE" => "N",	// Показывать товары, на которые подписан покупатель
				),
				false
			);?>
		</div>

	</div>

</div>
<?endif?>
<?else: $APPLICATION->RestartBuffer(); endif;?>