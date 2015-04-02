<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arResult["MAP_JSON"] = array(
	"all" => array(
		"center" => array(55.74365, 37.637192),
		"list" => array()
	)
);
$arResult["ITEMS_COUNT"] = 0;
foreach($arResult["SECTIONS"] as $arSection)
{
	$arJSonSection = array();
	$cxs = $cys = $cn = 0;
	$arResult["ITEMS_COUNT"] += count($arSection["ITEMS"]);
	foreach($arSection["ITEMS"] as $arItem)
		if(strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]))
		{
			list($cy, $cx) = explode(",", $arItem["PROPERTIES"]["MAP"]["VALUE"]);
			$cxs += $cx;
			$cys += $cy;
			$cn++;
		}
	if($cn) 
	{
		$arJSonSection["center"] = array($cys/$cn, $cxs/$cn);
		$arResult["MAP_JSON"]["all"]["list"]["location".$arSection["ID"]] = array(
			"coordinates" => array($cys/$cn, $cxs/$cn),
			"data" => array(
				"balloonImageOffset" => array(-200, 0),
				"balloonContentBody" => array(
							'<div class="marker_popup">' .
							'<h4 class="title">'.$arSection["NAME"].'</h4>' .
							'</div>')
			),
			"icon" => array(
				"iconLayout" => 'default#image',
				"iconImageHref" => SITE_TEMPLATE_PATH.'/static/img/marker-cart.png',
				"iconImageSize" => array(95, 119)
			),
			"iconactive" => SITE_TEMPLATE_PATH.'/static/img/marker-cart-a.png'
		);
		foreach($arSection["ITEMS"] as $arItem)
			if(strlen($arItem["PROPERTIES"]["MAP"]["VALUE"]))
			{
				list($data_y, $data_x) = explode(",", $arItem["PROPERTIES"]["MAP"]["VALUE"]);
				$arJSonItem = array(
					"coordinates" => array($data_y, $data_x),
					"data" => array(
						"balloonImageOffset" => array(-200, 0),
						"balloonContentBody" => array(
									'<div class="marker_popup">' .
									'<h4 class="title">'.$arItem["NAME"].'</h4>' .
									'<p>'.$arItem["PROPERTIES"]["ADDRESS"]["VALUE"].'</p>' .
									//'<a class="info">информация о компании</a>' .
									'</div>')
					),
					"icon" => array(
						"iconLayout" => 'default#image',
						"iconImageHref" => SITE_TEMPLATE_PATH.'/static/img/marker-cart.png',
						"iconImageSize" => array(95, 119)
					),
					"iconactive" => SITE_TEMPLATE_PATH.'/static/img/marker-cart-a.png'
				);
				$arJSonSection["list"]["location".$arItem["ID"]] = $arJSonItem;
			}
		$arResult["MAP_JSON"]["city".$arSection["ID"]] = $arJSonSection;
	}
}
$arResult["MAP_JSON"] = json_encode($arResult["MAP_JSON"]);
//print_p($arResult["MAP_JSON"]);
//die();
?>
