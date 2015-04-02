<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Подписка");
?><?$APPLICATION->IncludeComponent(
	"bitrix:subscribe.form", 
	"subscribe", 
	array(
		"USE_PERSONALIZATION" => "Y",
		"PAGE" => "/personal/subscribe/",
		"SHOW_HIDDEN" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => ""
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>