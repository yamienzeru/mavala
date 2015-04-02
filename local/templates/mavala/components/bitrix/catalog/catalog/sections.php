<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$arFilter = array(
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"ACTIVE" => "Y",
	"GLOBAL_ACTIVE" => "Y",
);

if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
{
	$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
}
elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
{
	$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
}

$obCache = new CPHPCache();
if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
{
	$arCurSection = $obCache->GetVars();
}
elseif ($obCache->StartDataCache())
{
	$arCurSection = array();
	if (CModule::IncludeModule("iblock") && (0 < intval($arResult["VARIABLES"]["SECTION_ID"]) || '' != $arResult["VARIABLES"]["SECTION_CODE"]))
	{
		$dbRes = CIBlockSection::GetList(array(), $arFilter);

		if(defined("BX_COMP_MANAGED_CACHE"))
		{
			global $CACHE_MANAGER;
			$CACHE_MANAGER->StartTagCache("/iblock/catalog");

			if ($arCurSection = $dbRes->Fetch())
			{
				$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
			}
			$CACHE_MANAGER->EndTagCache();
		}
		else
		{
			if(!$arCurSection = $dbRes->Fetch())
				$arCurSection = array();
		}

		if($arCurSection["ID"] || !strlen($arCurSection["CODE"]))
		{
			$arCurSection["SUBSECTIONS"] = array();
			$arCurSection["ELEMENTS_CNT"] = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arCurSection["ID"], "CATALOG_AVAILABLE" => "Y", "SECTION_ACTIVE" => "Y", "ACTIVE" => "Y"))->SelectedRowsCount();
			$arCurSection["SUB_ELEMENTS_CNT"] = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arCurSection["ID"], "CATALOG_AVAILABLE" => "Y", "SECTION_ACTIVE" => "Y", "ACTIVE" => "Y", "INCLUDE_SUBSECTIONS" => "Y"))->SelectedRowsCount();
			CIBlockSection::GetSectionElementsCount($arCurSection["ID"], array("CNT_ACTIVE" => "Y", ""));
			$rsSections = CIBlockSection::GetList(array("SORT" => "ASC"), array("IBLOCK_ID" => $arParams["IBLOCK_ID"], "SECTION_ID" => $arCurSection["ID"]));
			while($arSections = $rsSections->Fetch())
				$arCurSection["SUBSECTIONS"][] = $arSections;

			if($arCurSection["ID"] && $obSectionInfo = CIBlockElement::GetList(Array(), array("IBLOCK_ID" => 16, "ACTIVE" => "Y", "PROPERTY_CATALOG_SECTION" => $arCurSection["ID"]))->GetNextElement())
			{
				$arCurSection["PREVIEW_INFO"] = $obSectionInfo->GetFields();
				$arCurSection["PREVIEW_INFO"]["PHOTOS"] = $obSectionInfo->GetProperty("PHOTOS");
			}
		}
	}
	$obCache->EndDataCache($arCurSection);
}
$APPLICATION->SetTitle($arCurSection["NAME"]);
?>
<div class="header-catalog<?if(strlen($_REQUEST["q"])):?> header-search<?else:?> clearfix<?endif?>">
	<?$APPLICATION->IncludeComponent(
		"bitrix:breadcrumb",
		"",
		Array(
			"START_FROM" => "0", 
			"PATH" => "", 
			"SITE_ID" => "" 
		)
	);?>
	<h1 class="title-page"><?=$APPLICATION->ShowTitle(false)?></h1>
<?if(strlen($_REQUEST["q"])):
	$APPLICATION->AddChainItem("Поиск \"".$_REQUEST["q"]."\"", $APPLICATION->GetCurPageParam("", array()));?>
	<form class="search-box clearfix">
		<p>Вы искали</p>
		<input type="text" name="q" value="<?=$_REQUEST["q"]?>" placeholder="Поиск"/>
		<a href="#" class="btn-red2 btn-send">Найти</a>
	</form>
<?else:?>
	<?//print_p($arCurSection["PREVIEW_INFO"]);?>
<?if(strlen($arCurSection["PREVIEW_INFO"]["PREVIEW_TEXT"]) || strlen($arCurSection["PREVIEW_INFO"]["DETAIL_TEXT"])):?>
	<div class="text-block">
		<?if($arCurSection["PREVIEW_INFO"]["PREVIEW_TEXT_TYPE"] != "html"):?><p><?endif?><?=$arCurSection["PREVIEW_INFO"]["PREVIEW_TEXT"]?><?if($arCurSection["PREVIEW_INFO"]["PREVIEW_TEXT_TYPE"] != "html"):?></p><?endif?>
	<?if(strlen($arCurSection["PREVIEW_INFO"]["DETAIL_TEXT"])):?>
		<div class="drop">
			<?if($arCurSection["PREVIEW_INFO"]["DETAIL_TEXT_TYPE"] != "html"):?><p><?endif?><?=$arCurSection["PREVIEW_INFO"]["DETAIL_TEXT"]?><?if($arCurSection["PREVIEW_INFO"]["DETAIL_TEXT_TYPE"] != "html"):?></p><?endif?>
		</div>
		<a href="#" class="btn-more2"><span>Показать полностью</span><span>Свернуть</span></a>
	<?endif?>
	</div>
<?endif?>
<?if(is_array($arCurSection["PREVIEW_INFO"]["PHOTOS"]["VALUE"]) && count($arCurSection["PREVIEW_INFO"]["PHOTOS"]["VALUE"])):?>
	<div class="promo-banner">
		<div class="promo-title">промо</div>
		<ul class="slider-hide">
		<?foreach($arCurSection["PREVIEW_INFO"]["PHOTOS"]["VALUE"] as $keyPhoto => $photo):?>
			<li>
				<<?if(strlen($arCurSection["PREVIEW_INFO"]["PHOTOS"]["DESCRIPTION"][$keyPhoto])):?>a href="<?=$arCurSection["PREVIEW_INFO"]["PHOTOS"]["DESCRIPTION"][$keyPhoto]?>"<?else:?>span<?endif?> style="background-image:url(<?=ResizeImage($photo)?>);">
					<img src="<?=ResizeImage($photo, 515, 187, true)?>" alt=""/>
					<?/*<span class="text">
						<span>косметика</span>
						<strong>с научным</strong><span>подходом</span>
					</span>*/?>
				</<?if(strlen($arCurSection["PREVIEW_INFO"]["PHOTOS"]["DESCRIPTION"][$keyPhoto])):?>a<?else:?>span<?endif?>>
			</li>
		<?endforeach?>
		</ul>
		<div class="control-disk">
			<a href="#"></a>
		</div>
	</div>
<?endif?>
<?endif?>
</div>
<?if (strlen($_REQUEST["q"]) && (empty($arResult["SEARCH_ELEMENTS"]) || !is_array($arResult["SEARCH_ELEMENTS"]))):?>
<section class="section-noresults">
	<div class="title-page">По Вашему запросу ничего не найдено, <br/>попробуйте точнее указать запрос</div>
</section>
<?else:?>
<section class="section4">

	<div class="section__i clearfix">

		<div class="catalog-sidebar">
		<?if(!strlen($_REQUEST["q"])):?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"panel",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => !empty($arCurSection["SUBSECTIONS"]) ? $arResult["VARIABLES"]["SECTION_ID"] : $arCurSection["IBLOCK_SECTION_ID"],
					"SECTION_CODE" => !empty($arCurSection["SUBSECTIONS"]) ? $arResult["VARIABLES"]["SECTION_CODE"] : "",
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
					"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
					"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
					"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
					"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : ''),
					"CURRENT_SECTION" => $arCurSection["ID"]
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);?>
		<?endif?>
	<?if($APPLICATION->GetCurPage() != $arResult["FOLDER"] && (empty($arCurSection["SUBSECTIONS"]) || $arCurSection["ELEMENTS_CNT"] > 0) || strlen($_REQUEST["q"])):?>
		<?if($_REQUEST["ajax"] == "y")	$_REQUEST["ajax"] = "y_filter";?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"",
				Array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arCurSection["ID"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"CACHE_TYPE" => "A",
					"CACHE_TIME" => "36000000",
					"CACHE_NOTES" => "",
					"CACHE_GROUPS" => "Y",
					"SAVE_IN_SESSION" => "N",
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					//"BRAND" => $arResult["BRANDS"] ? $arResult["BRANDS"] : "",
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);?>
		<?if($_REQUEST["ajax"] == "y_filter")	$_REQUEST["ajax"] == "y";?>
	<?endif?>

		</div>
	<?if(!strlen($_REQUEST["q"])):?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.section.list",
			"",
			array(
				"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
				"IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"SECTION_ID" => !empty($arCurSection["SUBSECTIONS"]) || $arCurSection["ELEMENTS_CNT"] > 0 ? $arResult["VARIABLES"]["SECTION_ID"] : $arCurSection["IBLOCK_SECTION_ID"],
				"SECTION_CODE" => !empty($arCurSection["SUBSECTIONS"]) || $arCurSection["ELEMENTS_CNT"] > 0 ? $arResult["VARIABLES"]["SECTION_CODE"] : "",
				"CACHE_TYPE" => $arParams["CACHE_TYPE"],
				"CACHE_TIME" => $arParams["CACHE_TIME"],
				"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
				"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
				"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
				"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
				"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
				"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
				"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
				"ADD_SECTIONS_CHAIN" => "N"
			),
			$component,
			array("HIDE_ICONS" => "Y")
		);?>
	<?endif?>
	<?if(strlen($_REQUEST["q"]))
	{
		global ${$arParams["FILTER_NAME"]};
		${$arParams["FILTER_NAME"]}["=ID"] = $arResult["SEARCH_ELEMENTS"];
		
	}?>
	<?if($APPLICATION->GetCurPage() != $arResult["FOLDER"] && (empty($arCurSection["SUBSECTIONS"]) || $arCurSection["ELEMENTS_CNT"] > 0) || strlen($_REQUEST["q"])):?>
		<div class="product-table">

			<div class="product-list-top clearfix ajax_sort">

				<div class="wrap">
					<span>Сортировать по</span>
					<select class="sort" onchange="location.href='?'+this.options[this.selectedIndex].value" data-placeholder="<?foreach($arResult["ELEMENT_SORT"] as $arSort)if($arSort["SELECTED"] == "Y"):?><?=$arSort["NAME"]?><?endif?>">
						<option></option>
					<?foreach($arResult["ELEMENT_SORT"] as $arSort):?>
						<option value="<?=$arSort["LINK"]?>"<?if($arSort["SELECTED"] == "Y"):?> selected<?endif?>><?=$arSort["NAME"]?></option>
					<?endforeach?>
					</select>

				</div>

				<div class="wrap">
					<span>Показать</span>
					<select class="sort number" onchange="location.href='?'+this.options[this.selectedIndex].value" data-placeholder="<?=$arParams["PAGE_ELEMENT_COUNT"]?>">
						<option></option>
					<?foreach($arResult["ELEMENT_COUNTS"] as $count => $link):?>
						<option value="<?=$link?>"<?if($count == $arParams["PAGE_ELEMENT_COUNT"]):?> selected<?endif?>><?=$count?></option>
					<?endforeach?>
					</select>
				</div>
			</div>

			<?$intSectionID = $APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

					"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

					'LABEL_PROP' => $arParams['LABEL_PROP'],
					'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
					'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
					'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
					'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
					'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
					'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

					'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"ADD_SECTIONS_CHAIN" => "N",
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],

					"SHOW_ALL_WO_SECTION" => "Y",
				),
				$component
			);?>
		</div>
	<?endif?>
	</div>
</section>
<?endif?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.viewed.products",
	"",
	Array(
		"LINE_ELEMENT_COUNT" => 4,
		"TEMPLATE_THEME" => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"SHOW_OLD_PRICE" => $arParams['SHOW_OLD_PRICE'],
		"SHOW_DISCOUNT_PERCENT" => $arParams['SHOW_DISCOUNT_PERCENT'],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
		"PRODUCT_SUBSCRIPTION" => $arParams['PRODUCT_SUBSCRIPTION'],
		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"SHOW_NAME" => "Y",
		"SHOW_IMAGE" => "Y",
		"MESS_BTN_BUY" => $arParams['MESS_BTN_BUY'],
		"MESS_BTN_DETAIL" => $arParams['MESS_BTN_DETAIL'],
		"MESS_BTN_SUBSCRIBE" => $arParams['MESS_BTN_SUBSCRIBE'],
		"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
		"SHOW_FROM_SECTION" => "Y",
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ELEMENT_CODE" => "",
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SHOW_PRODUCTS_12" => "Y",
		"PROPERTY_CODE_12" => array(),
		"CART_PROPERTIES_12" => array(),
		"ADDITIONAL_PICT_PROP_12" => "MORE_PHOTO",
		"LABEL_PROP_12" => "-",
		"HIDE_NOT_AVAILABLE" => $arParams["HIDE_NOT_AVAILABLE"],
		"CONVERT_CURRENCY" => $arParams["CONVERT_CURRENCY"],
		"CURRENCY_ID" => $arParams["CURRENCY_ID"],
	),
	$component
);?>