<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
foreach($arResult["ITEMS"] as $keyItem => $arItem)
{
	if(strlen($arItem["ACTIVE_TO"])>0)
		$arResult["ITEMS"][$keyItem]["DISPLAY_ACTIVE_TO"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_TO"], CSite::GetDateFormat()));
	else
		$arResult["ITEMS"][$keyItem]["DISPLAY_ACTIVE_TO"] = "";
	
	if(strlen($arItem["ACTIVE_TO"])>0)
		$arResult["ITEMS"][$keyItem]["TIME_ACTIVE_TO"] = round((strtotime($arItem["ACTIVE_TO"]) - time()) / 60 / 60 / 24);
}
?>