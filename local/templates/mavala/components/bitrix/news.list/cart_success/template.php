<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="wrap__promo-banner">

	<div class="promo-banner">
		<ul>
	<?foreach($arResult["ITEMS"] as $arItem)
		if(is_array($arItem["PREVIEW_PICTURE"])):?>
			<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
			<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<<?if(strlen($arItem["PROPERTIES"]["URL"]["VALUE"])):?>a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>"<?else:?>div<?endif?> style="background-image:url(<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>);">
					<img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>" alt="<?=$arItem["NAME"]?>"/>
					<span class="text">
						<span><?=$arItem["NAME"]?></span>
					</span>
				</<?if(strlen($arItem["PROPERTIES"]["URL"]["VALUE"])):?>a<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>"<?else:?>div<?endif?>>
			</li>
		<?endif?>
		</ul>
		<div class="control-disk">
			<a href="#"></a>
		</div>
	</div>

</div>