<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("История покупок");
$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"include_clear", 
	Array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"BLOCK_CLASSES" => "header-catalog current clearfix"
	),
	null,
	array('HIDE_ICONS' => 'Y')
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>