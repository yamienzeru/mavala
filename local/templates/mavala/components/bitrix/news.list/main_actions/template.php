<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="item">
	<div class="slider-action text-white">
		<ul data-type="right" class="slider-hide">
	<?foreach($arResult["ITEMS"] as $arItem)
		if(is_array($arItem["PREVIEW_PICTURE"])):?>
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<img class="img-background" src="<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>" alt="<?=$arItem["NAME"]?>"/>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item__i">
					<img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/medal.png" alt="Акции"/>
					<span>Акции</span>
					<?/*<div class="title"><strong>3</strong><span>лака</span><span>по цене</span><strong>2</strong></div>*/?>
				</a>
			</li>
		<?endif?>
		</ul>
		<div class="control">
			<a href="#"></a>
		</div>
	</div>
</div>