<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent(
	"bitrix:sale.order.ajax", 
	"cart", 
	array(
		"ALLOW_NEW_PROFILE" => "N",
		"SHOW_PAYMENT_SERVICES_NAMES" => "Y",
		"SHOW_STORES_IMAGES" => "N",
		"PATH_TO_BASKET" => "/cart/empty.php",
		"PATH_TO_PERSONAL" => "/personal/",
		"PATH_TO_PAYMENT" => "/cabinet/pay.php",
		"PATH_TO_AUTH" => "/auth/",
		"PAY_FROM_ACCOUNT" => "N",
		"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
		"COUNT_DELIVERY_TAX" => "Y",
		"ALLOW_AUTO_REGISTER" => "Y",
		"SEND_NEW_USER_NOTIFY" => "Y",
		"DELIVERY_NO_AJAX" => "Y",
		"DELIVERY_NO_SESSION" => "N",
		"TEMPLATE_LOCATION" => ".default",
		"DELIVERY_TO_PAYSYSTEM" => "d2p",
		"SET_TITLE" => "N",
		"USE_PREPAYMENT" => "N",
		"DISABLE_BASKET_REDIRECT" => "N",
		"PRODUCT_COLUMNS" => array(
			0 => "PREVIEW_PICTURE",
			1 => "PROPS",
			2 => "DISCOUNT_PRICE_PERCENT_FORMATED",
			3 => "PROPERTY_CML2_ARTICLE",
		),
		"PROP_1" => array(
		)
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>