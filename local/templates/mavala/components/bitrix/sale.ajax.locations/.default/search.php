<?
define("STOP_STATISTICS", true);
define("PUBLIC_AJAX_MODE", true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$arResult = array();

if(CModule::IncludeModule("sale"))
{
	if(!empty($_REQUEST["search"]) && is_string($_REQUEST["search"]))
	{
		$_REQUEST["search"] = explode(",", $_REQUEST["search"]);
		$_REQUEST["search"] = $search = $APPLICATION->UnJSEscape($_REQUEST["search"][0]);

		$arParams = array();

		$arParams["TOP_COUNT"] = 10;
		$arParams["KLADR_TOKEN"] = "54906b1d7c5239861e8b456f"; //54903ab37c523932148b4567

		$params = explode(",", $_REQUEST["params"]);
		foreach($params as $param)
		{
			list($key, $val) = explode(":", $param);
			$arParams[$key] = $val;
		}

		$rsLocationsList = CSaleLocation::GetList(
			array(
				"CITY_NAME_LANG" => "ASC",
				"COUNTRY_NAME_LANG" => "ASC",
				"SORT" => "ASC",
			),
			array(
				"!CITY_NAME" => false,
				"~CITY_NAME" => $search."%",
				"LID" => LANGUAGE_ID,
			),
			false,
			array("nTopCount" => $arParams["TOP_COUNT"]),
			array(
				"*"
			)
		);

		$set_search = $rsLocationsList->SelectedRowsCount() < $arParams["TOP_COUNT"];

		$abc = "qwertyuiopasdfghjklzxcvbnm";
		for($i = 0; $i < strlen($abc); $i++)
			if(stripos($search, $abc{$i}) !== false)
			{
				$set_search = false;
				break;
			}

		if($set_search)
		{
			$arCities = $arKLADRCities = array();

			$arKLADRResult = array();

			$obCache = new CPHPCache();
			if($obCache->InitCache(30*24*60*60, json_encode($search), "/iblock/kladr"))
			{
				$arKLADRResult = $obCache->GetVars();
				//print_p(2);
			}
			else
			{
				$obCache->StartDataCache();
				//print_p(1);
				$kladr_search = json_decode(file_get_contents("http://kladr-api.ru/api.php?token=".$arParams["KLADR_TOKEN"]."&contentType=city&withParent=1&query=".$search."&limit=".$arParams["TOP_COUNT"]), true);
				if(is_array($kladr_search["result"]) && count($kladr_search["result"]))
					foreach($kladr_search["result"] as $arKLADRCity)
					{
						$arKLADRCity["full_name"] = $arKLADRCity["name"].(strlen($arKLADRCity["name"]) && strlen($arKLADRCity["typeShort"]) ? " " : "").$arKLADRCity["typeShort"];
						$arKLADRCity["parents"][0]["full_name"] = $arKLADRCity["parents"][0]["name"].(strlen($arKLADRCity["parents"][0]["name"]) && strlen($arKLADRCity["parents"][0]["typeShort"]) ? " " : "").$arKLADRCity["parents"][0]["typeShort"];
						$arKLADRResult[] = $arKLADRCity;
					}

				$obCache->EndDataCache($arKLADRResult);
			}

			//print_p($search);print_p($arKLADRResult);die();

			$arRegions = array();
			$dbRegion = CSaleLocation::GetRegionList(array("NAME"=>"ASC"), array(), LANG);
			while ($arRegion = $dbRegion->Fetch())
				$arRegions[] = $arRegion;

			foreach($arKLADRResult as $arKLADRCity)
			{
				if($arCity = CSaleLocation::GetList(array(), array("CITY_NAME" => $arKLADRCity["full_name"], "REGION_NAME" => $arKLADRCity["parents"][0]["full_name"]))->GetNext())
				{
					//print_p($arCity);die();
				}
				else
				{
					$region_id = 0;
					if(strlen($arKLADRCity["parents"][0]["full_name"]))
					{
						foreach($arRegions as $arRegion)
							if($arRegion["NAME_ORIG"] == $arKLADRCity["parents"][0]["full_name"])
							{
								$region_id = $arRegion["ID"];
								break;
							}
						if(!$region_id)
						{
							$arRegionFields = Array(
								"NAME" => $arKLADRCity["parents"][0]["full_name"],
								"SHORT_NAME" => $arKLADRCity["parents"][0]["name"],
								"ru" => Array(
									"LID" => "ru",
									"NAME" => $arKLADRCity["parents"][0]["full_name"],
									"SHORT_NAME" => $arKLADRCity["parents"][0]["name"],
								),
								"en" => Array(
									"LID" => "en",
									"NAME" => $arKLADRCity["parents"][0]["full_name"],
									"SHORT_NAME" => $arKLADRCity["parents"][0]["name"],
								),
							);
							$region_id = CSaleLocation::AddRegion($arRegionFields);
							$arRegions[] = Array(
								"ID" => $region_id,
								"NAME_ORIG" => $arKLADRCity["parents"][0]["full_name"],
								"SHORT_NAME" => $arKLADRCity["parents"][0]["name"],
								"NAME" => "",
								"NAME_LANG" => $arKLADRCity["parents"][0]["full_name"],
							);
						}
					}
					$arFields = array(
						"SORT" => 100,
						"COUNTRY_ID" => "",
						"CHANGE_COUNTRY" => "N",
						"WITHOUT_CITY" => "N",
						"REGION_ID" => $region_id,
						"CITY" => Array(
							"NAME" => $arKLADRCity["full_name"],
							"SHORT_NAME" => $arKLADRCity["name"],
							"REGION_ID" => "",
							"ru" => Array(
								"LID" => "ru",
								"NAME" => $arKLADRCity["full_name"],
								"SHORT_NAME" => $arKLADRCity["name"],
							),
						),
						"LOC_DEFAULT" => "N",
					);
					$ID = CSaleLocation::Add($arFields);
				}
			}

			$rsLocationsList = CSaleLocation::GetList(
				array(
					"CITY_NAME_LANG" => "ASC",
					"COUNTRY_NAME_LANG" => "ASC",
					"SORT" => "ASC",
				),
				array(
					"~CITY_NAME" => $search."%",
					"LID" => LANGUAGE_ID,
				),
				false,
				array("nTopCount" => $arParams["TOP_COUNT"]),
				array(
					"*"
				)
			);
		}

		while ($arCity = $rsLocationsList->GetNext())
			//if($arCity["CITY_LID"] == LANGUAGE_ID && $arCity["REGION_LID"] == LANGUAGE_ID && $arCity["COUNTRY_LID"] == LANGUAGE_ID)
			{
				//print_p($arCity);
				$arResult[] = (object) array(
					"data" => $arCity["ID"],
					"value" => $arCity["CITY_NAME"].(strlen($arCity["REGION_NAME_LANG"]) ? ", ".$arCity["REGION_NAME_LANG"] : "").(strlen($arCity["COUNTRY_NAME_LANG"]) ? ", ".$arCity["COUNTRY_NAME_LANG"] : "")
				);
			}
	}
}

echo json_encode((object) array("query" => $_REQUEST["search"], "suggestions" => $arResult));

require_once($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/include/epilog_after.php");
die();

?>