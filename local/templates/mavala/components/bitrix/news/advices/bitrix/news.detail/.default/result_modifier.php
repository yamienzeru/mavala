<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["PAGINATION"] = getNextPrevByID($arResult["ID"], array($arParams["SORT_BY1"] => $arParams["SORT_ORDER1"]));
?>