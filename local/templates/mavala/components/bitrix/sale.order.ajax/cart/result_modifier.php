<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$ORDER_PROP = array();
foreach($arResult["ORDER_PROP"] as $propType => $arProps)
	foreach($arProps as $arProp)
		$ORDER_PROP[$arProp["CODE"]] = $arProp;
$arResult["ORDER_PROP"] = $ORDER_PROP;

if(IntVal($arResult["ORDER_ID"]))
{
	foreach($arResult["ORDER_PROP"] as $arProp)
		if(strlen($arProp["CODE"]))
			$arFields[$arProp["CODE"]] = $arProp["TYPE"] != "CHECKBOX" ? $arProp["VALUE"] : ($arProp["CHECKED"] != "Y" ? 0 : 1);
	if(count($arFields))
	{
		global $USER;
		$obUser = new CUser;
		$obUser->Update($USER->GetId(), $arFields);
	}
	
	foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		if($arPaySystem["CHECKED"] == "Y")
		{

			if(stripos($arPaySystem["PSA_NAME"], "onPay") !== false)
			{

				include_once($_SERVER["DOCUMENT_ROOT"] . $arPaySystem["PSA_ACTION_FILE"] . "/payment_link.php");
				LocalRedirect(OnPayLink($arResult["ORDER_ID"], $arResult["ORDER_PRICE"]));
			}
			else
			{
				LocalRedirect("/cart/success.php?ORDER_ID=".$arResult["ORDER_ID"]);
			}
			break;
		}
}
else
{
	$arProperties = array();
	$rsProperties = CIBlockProperty::GetList(Array(), Array("ACTIVE" => "Y", "CODE" => "%BREND%"));
	while ($arProperty = $rsProperties->GetNext())
		$arProperties[$arProperty["CODE"]] = $arProperty;
	foreach($arResult["BASKET_ITEMS"] as $keyBasketItems => $arBasketItems)
	{
		$ar_res = CCatalogProduct::GetByID($arBasketItems["PRODUCT_ID"]);
		$arResult["BASKET_ITEMS"][$keyBasketItems]["PRODUCT_QUANTITY"] = $ar_res["QUANTITY"];
		$arResult["BASKET_ITEMS"][$keyBasketItems]["PROPERTY_BREND_URL"] = "/catalog/?brand=".$arBasketItems["PROPERTY_BREND_ENUM_ID"];
		$arResult["BASKET_ITEMS"][$keyBasketItems]["PROPERTY_LINIYA_BRENDA_URL"] = "/catalog/?brand=".$arBasketItems["PROPERTY_BREND_ENUM_ID"]."&set_filter=y&".htmlspecialcharsbx("arrFilter_".$arProperties["BREND"]["ID"]."_".abs(crc32($arBasketItems["PROPERTY_BREND_ENUM_ID"])))."=Y&".htmlspecialcharsbx("arrFilter_".$arProperties["LINIYA_BRENDA"]["ID"]."_".abs(crc32($arBasketItems["PROPERTY_LINIYA_BRENDA_ENUM_ID"])))."=Y";
		
	}

	if(is_array($arResult["DELIVERY"]))
	{
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
			if ($delivery_id !== 0 && intval($delivery_id) <= 0)
			{
				$arDeliveryProfiles = array();
				foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
				{
					$result = CSaleDeliveryHandler::CalculateFull(
						$delivery_id,
						$profile_id,
						array(
							"PRICE" => $arResult["ORDER_PRICE"],
							"WEIGHT" => $arResult["ORDER_WEIGHT"],
							"LOCATION_FROM" => COption::GetOptionInt('sale', 'location'),
							"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
							"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
							"ITEMS" => $arResult["BASKET_ITEMS"]
						),
						$arResult["BASE_LANG_CURRENCY"]
					);
					if (is_array($result))
					{
						if ($result["RESULT"] == "OK" && CModule::IncludeModule('currency'))
						{
							$arDeliveryProfiles[$delivery_id.":".$profile_id] = array(
								"ID" => $delivery_id.":".$profile_id,
								"NAME" => $arProfile["TITLE"],
								"LID" => "s1",
								"ORDER_CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
								"ACTIVE" => "Y",
								"PRICE" => $result["VALUE"],
								"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
								"SORT" => "100",
								"DESCRIPTION" => $arProfile["DESCRIPTION"],
								"LOGOTIP" => "",
								"FIELD_NAME" => "DELIVERY_ID",
								"PRICE_FORMATED" => CurrencyFormat($result["VALUE"], $arResult["BASE_LANG_CURRENCY"]),
								"CHECKED" => $arProfile["CHECKED"],
								"INFO" => $result["INFO"]
							);
						}
						elseif ($result["RESULT"] == "NEXT_STEP" && strlen($result["TEMP"]) > 0)
						{
							$result["TEMP"] = CUtil::JSEscape($result["TEMP"]);
						}
					}
				}
				unset($arResult["DELIVERY"][$delivery_id]);
				$arResult["DELIVERY"] = array_merge($arResult["DELIVERY"], $arDeliveryProfiles);
			}
		}
	}
}

if(!empty($arResult["ERROR"]))
	$arResult["ERROR"] = array_unique($arResult["ERROR"]);

$arResult["PROP_GROUPS"] = array(

	1 => array(
		"CHECKED" => "N",
		"ITEMS" => array(),
	),
	2 => array(
		"CHECKED" => "N",
		"ITEMS" => array(),
	),
	3 => array(
		"CHECKED" => "N",
		"ITEMS" => array(
			"DELIVERY_ID",
		),
	),
	4 => array(
		"CHECKED" => "N",
		"ITEMS" => array(
			"PAY_SYSTEM_ID",
		),
	),

);
foreach(array("NAME", "EMAIL", "PERSONAL_MOBILE", "PERSONAL_PHONE") as $prop)
	if($arResult["ORDER_PROP"][$prop]["REQUIED"] == "Y")
		$arResult["PROP_GROUPS"][1]["ITEMS"][] = $arResult["ORDER_PROP"][$prop]["FIELD_NAME"];

foreach(array("PERSONAL_CITY", "PERSONAL_ZIP", "PERSONAL_STREET", "UF_HOUSE", "UF_HOUSING", "UF_FLAT", "PERSONAL_NOTES") as $prop)
	if($arResult["ORDER_PROP"][$prop]["REQUIED"] == "Y")
		$arResult["PROP_GROUPS"][2]["ITEMS"][] = $arResult["ORDER_PROP"][$prop]["FIELD_NAME"];
foreach($arResult["PROP_GROUPS"] as $group => $arProps)
{
	$arResult["PROP_GROUPS"][$group]["CHECKED"] = "Y";
	foreach($arProps["ITEMS"] as $prop)
		if(empty($_REQUEST[$prop]))
		{
			$arResult["PROP_GROUPS"][$group]["CHECKED"] = "N";
			break;
		}
	if($arResult["PROP_GROUPS"][$group]["CHECKED"] == "N") break;
}
if(empty($arResult["DELIVERY"])) $arResult["PROP_GROUPS"][3]["CHECKED"] = "N";



if($_REQUEST["quick_buy"] == "Y" && $arResult["PROP_GROUPS"][1]["CHECKED"] == "Y")
{
	$arUserInfo = array();
	foreach(array("NAME", "EMAIL", "PERSONAL_MOBILE", "PERSONAL_PHONE") as $prop)
		if(strlen($arResult["ORDER_PROP"][$prop]["VALUE"]))
			$arUserInfo[] = $arResult["ORDER_PROP"][$prop]["NAME"].": ".$arResult["ORDER_PROP"][$prop]["VALUE"];

	$arOrderInfo = array();
	foreach($arResult["BASKET_ITEMS"] as $arBasketItem)
		$arOrderInfo[] = $arBasketItem["NAME"]." (".$arBasketItem["PROPERTY_CML2_ARTICLE_VALUE"].") ".$arBasketItem["QUANTITY"]." шт.";

	$arFields = array(
		"USER_INFO" => implode("
", $arUserInfo),
		"ORDER_INFO" => implode("
", $arOrderInfo),
	);

	$ORDER_CACHE = serialize($arFields);

	if(is_array($_SESSION["QUICK_ORDER_CACHE"]) && !in_array($ORDER_CACHE, $_SESSION["QUICK_ORDER_CACHE"]))
	{
		$_SESSION["QUICK_ORDER_CACHE"][] = $ORDER_CACHE;
		
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
	}
}

$value = 0;
if($_SESSION["USER_CITY"]["ID"]) $value = $_SESSION["USER_CITY"]["ID"];

$prop = "PERSONAL_CITY";
if (is_array($arResult["ORDER_PROP"][$prop]["VARIANTS"]) && count($arResult["ORDER_PROP"][$prop]["VARIANTS"]) > 0)
	foreach ($arResult["ORDER_PROP"][$prop]["VARIANTS"] as $arVariant)
		if ($arVariant["SELECTED"] == "Y")
		{
			$value = $arVariant["ID"];
			break;
		}

$arResult["USER_CITY_ID"] = $value;
//print_p($arResult["PROP_GROUPS"]);
?>
