<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
foreach($arResult["SECTIONS"] as $keySection => $arSection)
	if($arSection["ELEMENT_CNT"] <= 0)
		unset($arResult["SECTIONS"][$keySection]);
$arResult["SECTIONS"] = array_values($arResult["SECTIONS"]);

$arResult["SECTIONS_TREE"] = SectionTree($arResult["SECTIONS"]);

$rsElems = CIBlockElement::GetList(Array("SORT" => "ASC"), Array("IBLOCK_ID" => 5, "ACTIVE"=>"Y", "!PROPERTY_CATALOG_SECTION" => false), false, false, array("ID", "NAME", "DETAIL_PAGE_URL", "PROPERTY_CATALOG_SECTION"));
while($arElem = $rsElems->GetNext())
{
	foreach($arResult["SECTIONS_TREE"] as $keySection => $arSection)
	{
		if($arElem["PROPERTY_CATALOG_SECTION_VALUE"] == $arSection["ID"])
		{
			$arResult["SECTIONS_TREE"][$keySection]["ADVICES"][] = $arElem;
			break;
		}
		foreach($arSection["SECTIONS"] as $arSubSection)
		{
			if($arElem["PROPERTY_CATALOG_SECTION_VALUE"] == $arSubSection["ID"])
			{
				$arResult["SECTIONS_TREE"][$keySection]["ADVICES"][] = $arElem;
				break;
			}
		}
	}
}
?>