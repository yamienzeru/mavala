<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["PAGINATION"] = getNextPrevByID($arResult["ID"], array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"]));
if(strlen($arResult["ACTIVE_TO"])>0)
	$arResult["DISPLAY_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arResult["ACTIVE_TO"], CSite::GetDateFormat()));
else
	$arResult["DISPLAY_ACTIVE_TO"] = "";

if(strlen($arResult["ACTIVE_TO"])>0)
	$arResult["TIME_ACTIVE_TO"] = round((strtotime($arResult["ACTIVE_TO"]) - time()) / 60 / 60 / 24);
?>