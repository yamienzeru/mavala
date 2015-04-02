<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["NUM_PRODUCTS"] = 0;
$arResult["SUM_PRODUCTS"] = 0;
foreach($arResult["ITEMS"] as $arItem)
{
	$arResult["NUM_PRODUCTS"] += $arItem["QUANTITY"];
	$arResult["SUM_PRODUCTS"] += $arItem["QUANTITY"] * $arItem["PRICE"];
}?>