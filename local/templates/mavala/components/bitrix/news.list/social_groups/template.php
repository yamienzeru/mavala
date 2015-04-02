<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="soc-links">
	<h2 class="title">мы в соцсетях</h2>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
	<a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>" class="<?=$arItem["PROPERTIES"]["SOCIAL"]["VALUE_XML_ID"]?>" target="_blank" title="<?=$arItem["NAME"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>"></a>
<?endforeach?>
</div>