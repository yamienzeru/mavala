<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!CModule::IncludeModule("sale")) return;

$rsCountryList = CSaleLocation::GetCountryList(array("SORT" => "ASC"));
$arCountries = array();
while ($arCountry = $rsCountryList->Fetch())
{
	$arCountries[$arCountry["ID"]] = $arCountry["NAME_LANG"];
}

$arComponentParameters = Array(
	"GROUPS" => array(
		"INPUTS" => array(
			"NAME" => GetMessage("INPUTS_GROUP_NAME"),
		),
		"HIDDEN_INPUTS" => array(
			"NAME" => GetMessage("HIDDEN_INPUTS_GROUP_NAME"),
		),
		"OPTIONS" => array(
			"NAME" => GetMessage("OPTIONS_GROUP_NAME"),
		),
		"SETTINGS" => array(
			"NAME" => GetMessage("SETTINGS_GROUP_NAME"),
		),

	),
	"PARAMETERS" => Array(
		"CITY_OUT_LOCATION" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_CITY_OUT_LOCATION"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"ADDITIONAL_VALUES" => "N",
			"MULTIPLE" => "N",
			"PARENT" => "BASE",
		),
		"ALLOW_EMPTY_CITY" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_ALLOW_EMPTY_CITY"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
			"ADDITIONAL_VALUES" => "N",
			"MULTIPLE" => "N",
			"PARENT" => "BASE",
		),
		"COUNTRY_INPUT_NAME" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_COUNTRY_INPUT_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "COUNTRY",
			"PARENT" => "BASE",
		),
		"REGION_INPUT_NAME" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_REGION_INPUT_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "REGION",
			"PARENT" => "BASE",
		),
		"CITY_INPUT_NAME" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_CITY_INPUT_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "LOCATION",
			"PARENT" => "BASE",
		),

		"COUNTRY" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_COUNTRY"),
			"TYPE" => "LIST",
			"VALUES" => $arCountries,
			"ADDITIONAL_VALUES" => "N",
			"MULTIPLE" => "N",
			"PARENT" => "BASE",
		),

		"ONCITYCHANGE" => array(
			"NAME" => GetMessage("SALE_SAL_PARAM_ONCITYCHANGE"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
			"PARENT" => "BASE",
		),

		"NAME" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("CP_BSSI_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "q",
		),



		"TOKEN" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("TOKEN_PARAMETR_NAME"),
			"TYPE" => "STRING",
			"DEFAULT" => "",
		),
		"REGION_INPUT" => array(
			"PARENT" => "INPUTS",
			"NAME" => GetMessage("REGION_INPUT_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"DISTRICT_INPUT" => array(
			"PARENT" => "INPUTS",
			"NAME" => GetMessage("DISTRICT_INPUT_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"LOCATION_INPUT" => array(
			"PARENT" => "INPUTS",
			"NAME" => GetMessage("LOCATION_INPUT_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"STREET_INPUT" => array(
			"PARENT" => "INPUTS",
			"NAME" => GetMessage("STREET_INPUT_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"BUILDING_INPUT" => array(
			"PARENT" => "INPUTS",
			"NAME" => GetMessage("BUILDING_INPUT_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
		"HIDDEN_KLADR_ID" => array(
			"PARENT" => "HIDDEN_INPUTS",
			"NAME" => GetMessage("HIDDEN_KLADR_ID_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"HIDDEN_Z_INDEX" => array(
			"PARENT" => "HIDDEN_INPUTS",
			"NAME" => GetMessage("HIDDEN_Z_INDEX_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"HIDDEN_LABEL" => array(
			"PARENT" => "HIDDEN_INPUTS",
			"NAME" => GetMessage("HIDDEN_LABEL_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"HIDDEN_LABEL_MIN" => array(
			"PARENT" => "HIDDEN_INPUTS",
			"NAME" => GetMessage("HIDDEN_LABEL_MIN_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"UPDATE_LABELS" => array(
			"PARENT" => "OPTIONS",
			"NAME" => GetMessage("UPDATE_LABELS_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"DELETE_NOT_IN_KLADR_VALUES" => array(
			"PARENT" => "OPTIONS",
			"NAME" => GetMessage("DELETE_NOT_IN_KLADR_VALUES_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),

		"INCLUDE_JQUERY" => array(
			"PARENT" => "SETTINGS",
			"NAME" => GetMessage("INCLUDE_JQUERY_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"INCLUDE_JQUERY_UI" => array(
			"PARENT" => "SETTINGS",
			"NAME" => GetMessage("INCLUDE_JQUERY_UI_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),
		"INCLUDE_JQUERY_UI_THEME" => array(
			"PARENT" => "SETTINGS",
			"NAME" => GetMessage("INCLUDE_JQUERY_UI_THEME_PARAMETR_NAME"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "N",
		),

	)
);
?>