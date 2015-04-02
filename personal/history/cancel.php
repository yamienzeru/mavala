<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("История покупок");
?> <?$APPLICATION->IncludeComponent("bitrix:sale.personal.order.cancel", "cancel", Array(
	"PATH_TO_LIST" => "/profile/history/",	// Страница со списком заказов
	"PATH_TO_DETAIL" => "",	// Страница с подробной информацией о заказе
	"ID" => $ID,	// Идентификатор заказа
	"SET_TITLE" => "N",	// Устанавливать заголовок страницы
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>