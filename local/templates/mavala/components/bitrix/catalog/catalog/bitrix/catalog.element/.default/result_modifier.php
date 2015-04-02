<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["PAGER"] = getNextPrevByID($arResult["ID"], array($arParams["ELEMENT_SORT_FIELD"] => $arParams["ELEMENT_SORT_ORDER"]), $arFilter);
$arResult["PREVIEW_TEXT"] = implode(".", array_slice(explode(".", strip_tags($arResult["DETAIL_TEXT"])), 0, 2)).".";
foreach($arResult["PROPERTIES"] as $keyProp => $arProp)
	if($arProp["PROPERTY_TYPE"] == "S")
		$arResult["PROPERTIES"][$keyProp]["~VALUE"] = FormatText($arProp["VALUE"]);
$arResult["COLOR_ITEMS"] = array();
if(strlen($arResult['PROPERTIES']['NOMER_TONA']['VALUE']))
{
	$rsColors = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => $arResult["IBLOCK_ID"], "SECTION_ID" => $arResult["IBLOCK_SECTION_ID"], "CATALOG_AVAILABLE" => "Y", "SECTION_ACTIVE" => "Y", "ACTIVE" => "Y", "!PROPERTY_NOMER_TONA" => false, "!PROPERTY_PICT_TONA" => false), false, false, array("*", "PROPERTY_NOMER_TONA", "PROPERTY_PICT_TONA"));
	while($arColor = $rsColors->GetNext())
		$arResult["COLOR_ITEMS"][] = $arColor;
}
$arResult["~QUICK_BUY"] = $arResult["DETAIL_PAGE_URL"].(stripos($arResult["DETAIL_PAGE_URL"], '?') === false ? '?' : '&').$arParams["ACTION_VARIABLE"]."=QUICKBUY&".$arParams["PRODUCT_ID_VARIABLE"]."=".$arResult["ID"];
$arResult["QUICK_BUY"] = htmlspecialcharsbx($arResult['~QUICK_BUY']);
?>