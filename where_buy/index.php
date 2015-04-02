<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Где купить");
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"include_clear", 
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => ""
	),
	null,
	array('HIDE_ICONS' => 'Y')
);
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>