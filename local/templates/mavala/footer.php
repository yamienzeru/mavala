<?//print_p($_SESSION);?>
<?if($_REQUEST["ajax"] != "y"):?>
<?if($APPLICATION->GetCurPage() != "/cart/"):?>
<footer>
	<div class="footer-top clearfix">
		<div class="left clearfix">

			<?$APPLICATION->IncludeComponent("bitrix:news.list", "social_groups", Array(
				"DISPLAY_DATE" => "N",	// Выводить дату элемента
					"DISPLAY_NAME" => "Y",	// Выводить название элемента
					"DISPLAY_PICTURE" => "N",	// Выводить изображение для анонса
					"DISPLAY_PREVIEW_TEXT" => "N",	// Выводить текст анонса
					"AJAX_MODE" => "N",	// Включить режим AJAX
					"IBLOCK_TYPE" => "socials",	// Тип информационного блока (используется только для проверки)
					"IBLOCK_ID" => "15",	// Код информационного блока
					"NEWS_COUNT" => "500",	// Количество новостей на странице
					"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
					"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
					"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
					"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
					"FILTER_NAME" => "",	// Фильтр
					"FIELD_CODE" => "",	// Поля
					"PROPERTY_CODE" => array(	// Свойства
						0 => "URL",
						1 => "SOCIAL",
					),
					"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
					"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
					"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
					"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
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

			<div class="soc-links">
				<h2 class="title">поделиться</h2>

				<div class="social-likes" data-counters="yes">

					<div class="widget vkontakte" ></div>

					<div class="widget facebook"></div>

					<div class="widget odnoklassniki"></div>

				</div>

			</div>

			<div class="decor-arrow"></div>
		</div>

		<div class="right">
			<?$APPLICATION->IncludeComponent("bitrix:subscribe.form", "subscribe_panel", Array(
				"USE_PERSONALIZATION" => "Y",	// Определять подписку текущего пользователя
					"PAGE" => "/personal/subscribe/",	// Страница редактирования подписки (доступен макрос #SITE_DIR#)
					"SHOW_HIDDEN" => "N",	// Показать скрытые рубрики подписки
					"CACHE_TYPE" => "A",	// Тип кеширования
					"CACHE_TIME" => "3600",	// Время кеширования (сек.)
					"CACHE_NOTES" => ""
				),
				false
			);?>
		</div>
	</div>
	<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "menu_catalog_bottom", Array(
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
	<div class="footer-bottom">
		<div class="footer__i">
			<nav class="clearfix">
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
		</div>
	</div>
	<div class="footer__i">
		<p class="copy">&#169; 1997-2014 </p>

		<p class="develop">Made in <a href="http://ruformat.ru/" target="_blank">Руформат</a></p>
	</div>

</footer>
<?endif?>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.fancybox.pack.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery-ui.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.scrollTo.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/modernizr.custom.94064.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/select2.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.touchSwipe.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/social-likes.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.elevateZoom-3.0.8.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.custom-radio-checkbox.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.carouFredSel-6.2.1-packed.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.validate.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.autocomplete.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.form.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.mask.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/jquery.kladr.min.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/start.js"></script>
<script src="<?=SITE_TEMPLATE_PATH?>/static/js/init.js?i=<?=rand()?>"></script>

</body>
</html>
<?else: die(); endif;?>