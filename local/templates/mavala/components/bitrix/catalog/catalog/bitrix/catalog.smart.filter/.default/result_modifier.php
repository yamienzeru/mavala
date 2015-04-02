<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$tmpPrices = array();
$tmpItems = array();
foreach($arResult["ITEMS"] as $arItem)
	if(isset($arItem["PRICE"]))
		$tmpPrices[$arItem["CODE"]] = $arItem;
	else
		$tmpItems[$arItem["CODE"]] = $arItem;
$arResult["PRICES"] = $tmpPrices;
$arResult["ITEMS"] = $tmpItems;
//print_p($arResult);die();
?>