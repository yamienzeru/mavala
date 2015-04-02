<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(empty($_SESSION["USER_CITY"]["ID"]) && strlen($_SESSION["USER_CITY"]["NAME"]))
{
	$arCities = json_decode(file_get_contents("http://".$_SERVER["SERVER_NAME"].str_replace(array("\\", $_SERVER["DOCUMENT_ROOT"]), array("/", ""), __DIR__)."/search.php?search=".$_SESSION["USER_CITY"]["NAME"]), true);
	if(!empty($arCities["suggestions"][0]["data"]))
		$_SESSION["USER_CITY"]["ID"] = $arCities["suggestions"][0]["data"];
}
$arResult["USER_CITY_NAME"] = $_SESSION["USER_CITY"]["NAME"];
$arResult["USER_CITY_ID"] = $_SESSION["USER_CITY"]["ID"];
$arCity = CSaleLocation::GetByID($arResult["USER_CITY_ID"], LANGUAGE_ID);
$location_string = $arCity["CITY_NAME"].(strlen($arCity["REGION_NAME_LANG"]) ? ", ".$arCity["REGION_NAME_LANG"] : "").(strlen($arCity["COUNTRY_NAME_LANG"]) ? ", ".$arCity["COUNTRY_NAME_LANG"] : "");
if(strlen($location_string)) $arResult["LOCATION_STRING"] = $location_string;
$arResult["CITY_RESULT"] = $arCity;
?>