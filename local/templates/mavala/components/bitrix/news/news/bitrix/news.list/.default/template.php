<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-block">
	<div class="row clearfix">
	<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
		<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
<?if(!($keyItem % 3) && $keyItem):?>
	</div>
	<div class="row clearfix">
<?endif?>
		<div class="item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
			<?if(is_array($arItem["PREVIEW_PICTURE"])):?>
				<img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"], 500, 500, true)?>" alt="news"/>
			<?endif?>
				<span><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
				<div class="title"><?echo $arItem["NAME"]?></div>
				<?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arItem["PREVIEW_TEXT"];?><?if($arItem["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
			</a>
		</div>
	<?endforeach;?>
	</div>
</div>

<?=$arResult["NAV_STRING"]?>