<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="slider-main">
	<ul class="slider-hide">
<?foreach($arResult["ITEMS"] as $arItem)
	if(is_array($arItem["PREVIEW_PICTURE"])):?>
		<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
		<li style="background-image:url(<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>);" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

			<img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>" alt="<?=$arItem["NAME"]?>"/>

			<div class="text">
				<div class="title">
				<?if(strlen($arItem["PROPERTIES"]["NAME_1"]["VALUE"].$arItem["PROPERTIES"]["NAME_2"]["VALUE"].$arItem["PROPERTIES"]["NAME_3"]["VALUE"])):?>
					<?if(strlen($arItem["PROPERTIES"]["NAME_1"]["VALUE"])):?><span><?=$arItem["PROPERTIES"]["NAME_1"]["VALUE"]?></span><?endif?>
					<?if(strlen($arItem["PROPERTIES"]["NAME_2"]["VALUE"])):?><strong><?=$arItem["PROPERTIES"]["NAME_2"]["VALUE"]?></strong><?endif?>
					<?if(strlen($arItem["PROPERTIES"]["NAME_3"]["VALUE"])):?><span><?=$arItem["PROPERTIES"]["NAME_3"]["VALUE"]?></span><?endif?>
				<?else:?>
					<span><?=$arItem["NAME"]?></span>
				<?endif?>
				</div>
			<?if(strlen($arItem["PROPERTIES"]["URL"]["VALUE"])):?>
				<div class="wrap-btn">
					<a class="btn_red" href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>">
					<span class="btn_i">
						<span class="btn_ii">Узнать больше</span>
						Узнать больше
					</span>
					</a>
				</div>
			<?endif?>
			</div>
		</li>
	<?endif?>
	</ul>
	<div class="left-line"></div>
	<div class="right-line"></div>
	<div class="top-line"></div>
	<div class="bottom-line"></div>
	<a href="#" class="btn-left"></a>
	<a href="#" class="btn-right"></a>

	<div class="control">
		<a href="#"><span></span></a>
	</div>
</div>