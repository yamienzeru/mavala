<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="office-block">
	<div class="inner clearfix">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
		<div class="wrap-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="item">
				<div class="office-item">
					<div class="title"><?if($arItem["PREVIEW_PICTURE"]):?><img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"], 61*3, 61)?>" alt="<?echo $arItem["NAME"];?>"/><?endif?><?echo $arItem["NAME"];?></div>
					<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arItem["PREVIEW_TEXT"];?><?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
				</div>
			</div>
		</div>
	<?endforeach?>
	</div>
</div>