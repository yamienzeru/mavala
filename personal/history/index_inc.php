<?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.payment.receive",
	"",
	Array(
		"PAY_SYSTEM_ID" => "2",
		"PERSON_TYPE_ID" => "0"
	)
);?><?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.list", "personal_history", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "3600",	// Время кеширования (сек.)
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"PATH_TO_DETAIL" => "",	// Страница c подробной информацией о заказе
		"PATH_TO_COPY" => "",	// Страница повторения заказа
		"PATH_TO_CANCEL" => "/personal/history/cancel.php?ID=#ID#",	// Страница отмены заказа
		"PATH_TO_BASKET" => "/cart/",	// Страница корзины
		"ORDERS_PER_PAGE" => "500",	// Количество заказов, выводимых на страницу
		"ID" => $ID,	// Идентификатор заказа
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SAVE_IN_SESSION" => "N",	// Сохранять установки фильтра в сессии пользователя
		"NAV_TEMPLATE" => "",	// Имя шаблона для постраничной навигации
		"HISTORIC_STATUSES" => array(	// Исторические статусы
			0 => "F",
		)
	),
	false
);?>