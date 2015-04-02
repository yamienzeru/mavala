<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$dbPaySystem = CSalePaySystem::GetList(Array("SORT"=>"ASC", "PSA_NAME" => "ASC"), Array("ACTIVE"=>"Y", "PSA_HAVE_PAYMENT"=>"Y"), false, false, array("*"));
while($arPaySystem = $dbPaySystem->Fetch())
	$arResult["INFO"]["PAY_SYSTEM"][$arPaySystem["ID"]] = $arPaySystem;
foreach($arResult["ORDERS"] as $keyOrder => $arOrder)
{
	$pl_file = $_SERVER["DOCUMENT_ROOT"].$arResult["INFO"]["PAY_SYSTEM"][$arOrder["ORDER"]["PAY_SYSTEM_ID"]]["PSA_ACTION_FILE"]."/payment_link.php";
	$arResult["ORDERS"][$keyOrder]["ORDER"]["URL_TO_PAY"] = "";
	if(file_exists($pl_file))
	{
		
		include_once($pl_file);
		if(stripos($pl_file, "onPay") !== false)
			$arResult["ORDERS"][$keyOrder]["ORDER"]["URL_TO_PAY"] = OnPayLink($arOrder["ORDER"]["ID"], $arOrder["ORDER"]["PRICE"] - $arOrder["ORDER"]["SUM_PAID"]);
	}
}

$arItemsID = array();
$arElements = array();
foreach($arResult["ORDERS"] as $arOrder)
	foreach($arOrder["BASKET_ITEMS"] as $arItem)
		$arItemsID[] = $arItem["PRODUCT_ID"];
if(count($arItemsID))
{
	$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM");
	$arFilter = Array("IBLOCK_ID"=>IntVal($yvalue), "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
	$rsResult = CIBlockElement::GetList(Array(), Array("ID" => $arItemsID));
	while($rsElement = $rsResult->GetNextElement())
	{
		$arElement = $rsElement->GetFields();
		$arElement["PROPERTIES"] = $rsElement->GetProperties();
		$arElements[$arElement["ID"]] = $arElement;
	}
}
foreach($arResult["ORDERS"] as $keyOrder => $arOrder)
	foreach($arOrder["BASKET_ITEMS"] as $keyItem => $arItem)
		if(isset($arElements[$arItem["PRODUCT_ID"]]) && is_array($arElements[$arItem["PRODUCT_ID"]]))
			$arResult["ORDERS"][$keyOrder]["BASKET_ITEMS"][$keyItem] = array_merge($arElements[$arItem["PRODUCT_ID"]], $arItem);
?>
<?/*
	use Bitrix\Main\Localization\Loc;

	Loc::loadMessages(__FILE__);

	// we dont trust input params, so validation is required
	$legalColors = array(
		'green' => true,
		'yellow' => true,
		'red' => true,
		'gray' => true
	);
	// default colors in case parameters unset
	$defaultColors = array(
		'N' => 'green',
		'P' => 'yellow',
		'F' => 'gray',
		'PSEUDO_CANCELLED' => 'red'
	);

	foreach ($arParams as $key => $val)
		if(strpos($key, "STATUS_COLOR_") !== false && !$legalColors[$val])
			unset($arParams[$key]);

	// to make orders follow in right status order
	if(is_array($arResult['INFO']) && !empty($arResult['INFO']))
	{
		foreach($arResult['INFO']['STATUS'] as $id => $stat)
		{
			$arResult['INFO']['STATUS'][$id]["COLOR"] = $arParams['STATUS_COLOR_'.$id] ? $arParams['STATUS_COLOR_'.$id] : (isset($defaultColors[$id]) ? $defaultColors[$id] : 'gray');
			$arResult["ORDER_BY_STATUS"][$id] = array();
		}
	}
	$arResult["ORDER_BY_STATUS"]["PSEUDO_CANCELLED"] = array();

	$arResult["INFO"]["STATUS"]["PSEUDO_CANCELLED"] = array(
		"NAME" => Loc::getMessage('SPOL_PSEUDO_CANCELLED'),
		"COLOR" => $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] ? $arParams['STATUS_COLOR_PSEUDO_CANCELLED'] : (isset($defaultColors['PSEUDO_CANCELLED']) ? $defaultColors['PSEUDO_CANCELLED'] : 'gray')
	);

	if(is_array($arResult["ORDERS"]) && !empty($arResult["ORDERS"]))
	{
		foreach ($arResult["ORDERS"] as $order)
		{
			$order['HAS_DELIVERY'] = intval($order["ORDER"]["DELIVERY_ID"]) || strpos($order["ORDER"]["DELIVERY_ID"], ":") !== false;

			$stat = $order['ORDER']['CANCELED'] == 'Y' ? 'PSEUDO_CANCELLED' : $order["ORDER"]["STATUS_ID"];
			$color = $arParams['STATUS_COLOR_'.$stat];
			$order['STATUS_COLOR_CLASS'] = empty($color) ? 'gray' : $color;

			$arResult["ORDER_BY_STATUS"][$stat][] = $order;
		}
	}
*/?>