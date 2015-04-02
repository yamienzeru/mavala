<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<nav>
<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
	<a href="#<?=$this->GetEditAreaId($arItem['ID']);?>"><?echo $arItem["NAME"]?></a>
<?endforeach;?>
</nav>

<div class="right-side">
<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
	<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
	<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="title"><?echo $arItem["NAME"]?></div>
		<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arItem["PREVIEW_TEXT"];?><?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
	</div>
<?endforeach;?>
</div>