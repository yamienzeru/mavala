<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//кол-во элементов
if($arParams["PAGE_ELEMENT_COUNT"] <= 0) $arParams["PAGE_ELEMENT_COUNT"] = 8;
$current_count = $default_count = IntVal($arParams["PAGE_ELEMENT_COUNT"]);
$arElementCounts = array(1, 2, 3, 4, 5);
$arResult["ELEMENT_COUNTS"] = array();
foreach($arElementCounts as $koef)
	$arResult["ELEMENT_COUNTS"][$default_count * $koef] = str_replace($APPLICATION->GetCurPage()."?", "", $APPLICATION->GetCurPageParam("page_count=".$default_count * $koef, array("page_count", "PAGEN_1")));
if(array_key_exists($_REQUEST["page_count"], $arResult["ELEMENT_COUNTS"]))
	$current_count = $_SESSION["CURRENT_COUNT"] = $_REQUEST["page_count"];
elseif(array_key_exists($_SESSION["CURRENT_COUNT"], $arResult["ELEMENT_COUNTS"]))
	$current_count = $_SESSION["CURRENT_COUNT"];
$arParams["PAGE_ELEMENT_COUNT"] = $arResult["CURRENT_COUNT"] = $current_count;

//сортировка
$arParams["ELEMENT_SORT_FIELD"] = trim($arParams["ELEMENT_SORT_FIELD"]);
if(strlen($arParams["ELEMENT_SORT_FIELD"])<=0)
	$arParams["ELEMENT_SORT_FIELD"] = "shows";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["ELEMENT_SORT_ORDER"]))
	$arParams["ELEMENT_SORT_ORDER"]="desc";
	
$default_by = $arParams["ELEMENT_SORT_FIELD"];
$default_order = $arParams["ELEMENT_SORT_ORDER"];
$current_sort = 0;
$arResult["ELEMENT_SORT"] = array(
	array(
		"NAME" => "популярности",
		"SORT_FIELD" => "shows",
		"SORT_ORDER" => "desc",
		"BY" => "show",
		"ORDER" => "desc",
	),
	array(
		"NAME" => "дате (с новых)",
		"SORT_FIELD" => "created",
		"SORT_ORDER" => "desc",
		"BY" => "date",
		"ORDER" => "desc",
	),
	array(
		"NAME" => "цене (с дешевых)",
		"SORT_FIELD" => "CATALOG_PRICE_1",
		"SORT_ORDER" => "asc",
		"BY" => "price",
		"ORDER" => "asc",
	),
	array(
		"NAME" => "названию",
		"SORT_FIELD" => "name",
		"SORT_ORDER" => "asc",
		"BY" => "name",
		"ORDER" => "asc",
	),
	/*array(
		"NAME" => "По наличию",
		"SORT_FIELD" => "catalog_quantity",
		"SORT_ORDER" => "desc",
		"BY" => "quantity",
		"ORDER" => "desc",
	),*/
);
foreach($arResult["ELEMENT_SORT"] as $keySort => $arSort)
	$arResult["ELEMENT_SORT"][$keySort]["LINK"] = str_replace($APPLICATION->GetCurPage()."?", "", $APPLICATION->GetCurPageParam("by=".$arSort["BY"]."&order=".$arSort["ORDER"], array("by", "order")));
	//$arResult["ELEMENT_SORT"][$keySort]["LINK"] = $APPLICATION->GetCurPageParam("by=".$arSort["BY"]."&order=".$arSort["ORDER"], array("by", "order"));
	

if(strlen($_REQUEST["by"]) && strlen($_REQUEST["order"]))
{
	foreach($arResult["ELEMENT_SORT"] as $keySort => $arSort)
		if($_REQUEST["by"] == $arSort["BY"] && $_REQUEST["order"] == $arSort["ORDER"])
		{
			$current_sort = $keySort;
			$_SESSION["SORT_FIELD"] = $arSort["SORT_FIELD"];
			$_SESSION["SORT_ORDER"] = $arSort["SORT_ORDER"];
			break;
		}
}
elseif(strlen($_SESSION["SORT_FIELD"]) && strlen($_SESSION["SORT_ORDER"]))
{
	foreach($arResult["ELEMENT_SORT"] as $keySort => $arSort)
		if($_SESSION["SORT_FIELD"] == $arSort["SORT_FIELD"] && $_SESSION["SORT_ORDER"] == $arSort["SORT_ORDER"])
		{
			$current_sort = $keySort;
			break;
		}
}
$arResult["ELEMENT_SORT"][$current_sort]["SELECTED"] = "Y";
$arParams["ELEMENT_SORT_FIELD"] = $arResult["ELEMENT_SORT"][$current_sort]["SORT_FIELD"];
$arParams["ELEMENT_SORT_ORDER"] = $arResult["ELEMENT_SORT"][$current_sort]["SORT_ORDER"];

if(strlen($_REQUEST["q"]))
{
	$arResult["SEARCH_ELEMENTS"] = $APPLICATION->IncludeComponent(
		"bitrix:search.page",
		".default",
		Array(
			"RESTART" => "N",
			"NO_WORD_LOGIC" => $arParams["NO_WORD_LOGIC"],
			"USE_LANGUAGE_GUESS" => "Y",
			"CHECK_DATES" => "Y",
			"arrFILTER" => array("iblock_".$arParams["IBLOCK_TYPE"]),
			"arrFILTER_iblock_".$arParams["IBLOCK_TYPE"] => array($arParams["IBLOCK_ID"]),
			"USE_TITLE_RANK" => "N",
			"DEFAULT_SORT" => "rank",
			"FILTER_NAME" => "",
			"SHOW_WHERE" => "N",
			"arrWHERE" => array(),
			"SHOW_WHEN" => "N",
			"PAGE_RESULT_COUNT" => 50,
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "N",
			"PAGER_TITLE" => "",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "N",
		),
		$this->__component
	);
}

if($_REQUEST[$arParams["ACTION_VARIABLE"]] == "QUICKBUY" && IntVal($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]) > 0)
{
	$rsProduct = CIBlockElement::GetByID($_REQUEST[$arParams["PRODUCT_ID_VARIABLE"]]);
	if($obProduct = $rsProduct->GetNextElement())
	{
		$arProduct = $obProduct->GetFields();
		$arProduct["PROPERTIES"] = $obProduct->GetProperties();
		$this->__page = "quickbuy";
		$this->__file = "/bitrix/templates/mavala/components/bitrix/catalog/catalog/quickbuy.php";
		if(strlen($_REQUEST["quick_order"]))
		{
			if(strlen($_REQUEST["phone"]))
			{
				$arFields = array(
					"USER_INFO" => "Телефон: ".$_REQUEST["phone"],
					"ORDER_INFO" => $arProduct["NAME"]." (".$arProduct["PROPERTIES"]["CML2_ARTICLE"]["VALUE"].")",
				);
				CEvent::Send("QUICK_ORDER", SITE_ID, $arFields);
				$el = new CIBlockElement;

				$arLoadProductArray = Array(
					"MODIFIED_BY"    => 1,
					"IBLOCK_SECTION_ID" => false,
					"IBLOCK_ID"      => 13,
					"NAME"           => "Заказ в 1 клик",
					"ACTIVE"         => "Y",
					"PREVIEW_TEXT"   => $arFields["USER_INFO"],
					"DETAIL_TEXT"    => $arFields["ORDER_INFO"]
				);

				$el->Add($arLoadProductArray);

				LocalRedirect($APPLICATION->GetCurPageParam("success=y", array("quick_order")));
			}
		}
	}
}
?>
