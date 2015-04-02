<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="item">
	<div class="slider-action text-white">
		<ul data-type="left" class="slider-hide">
	<?foreach($arResult["ITEMS"] as $arItem)
		if(is_array($arItem["PREVIEW_PICTURE"])):?>
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<img class="img-background" src="<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>" alt="<?=$arItem["NAME"]?>"/>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item__i">
					<img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/nib.png" alt="полезные советы"/>
					<span class="pdng100">полезные советы</span>
					<div class="title"><span><?=$arItem["NAME"]?></span></div>
				</a>
			</li>
		<?endif?>
		</ul>
		<div class="controlright">
			<a href="#"></a>
		</div>
	</div>
</div>