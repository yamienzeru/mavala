<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arCity = CSaleLocation::GetByID($arParams["LOCATION_VALUE"], LANGUAGE_ID);
$location_string = $arCity["CITY_NAME"].(strlen($arCity["REGION_NAME_LANG"]) ? ", ".$arCity["REGION_NAME_LANG"] : "").(strlen($arCity["COUNTRY_NAME_LANG"]) ? ", ".$arCity["COUNTRY_NAME_LANG"] : "");
if(strlen($location_string)) $arResult["LOCATION_STRING"] = $location_string;
$arResult["CITY_RESULT"] = $arCity;
?>