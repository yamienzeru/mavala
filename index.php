<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Главная страница");
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"main", 
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	),
	null,
	array('HIDE_ICONS' => 'Y')
);
?>
<?$APPLICATION->IncludeComponent("bitrix:news.detail", "main_history", Array(
	"IBLOCK_TYPE" => "main",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "11",	// Код информационного блока
		"ELEMENT_ID" => "",	// ID новости
		"ELEMENT_CODE" => "history",	// Код новости
		"CHECK_DATES" => "N",	// Показывать только активные на данный момент элементы
		"FIELD_CODE" => array(	// Поля
			0 => "",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
		),
		"IBLOCK_URL" => "",	// URL страницы просмотра списка элементов (по умолчанию - из настроек инфоблока)
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"BROWSER_TITLE" => "-",	// Установить заголовок окна браузера из свойства
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"META_KEYWORDS" => "-",	// Установить ключевые слова страницы из свойства
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"META_DESCRIPTION" => "-",	// Установить описание страницы из свойства
		"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"ADD_ELEMENT_CHAIN" => "N",	// Включать название элемента в цепочку навигации
		"ACTIVE_DATE_FORMAT" => "",	// Формат показа даты
		"USE_PERMISSIONS" => "N",	// Использовать дополнительное ограничение доступа
		"DISPLAY_DATE" => "N",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить детальное изображение
		"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
		"USE_SHARE" => "N",	// Отображать панель соц. закладок
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"PAGER_TITLE" => "Страница",	// Название категорий
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
	),
	false
);?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>