<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="action-banner clearfix">
<?foreach($arResult["ITEMS"] as $keyItem => $arItem):?>
	<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
	<div class="wrap-banner">
		<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="item text-dark" style="background-image: url(<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>);" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"])?>" alt="<?echo $arItem["NAME"]?>"/>
			<div class="item__i">
				<span class="date"><?=$arItem["DISPLAY_ACTIVE_FROM"]?><?if(strlen($arItem["DISPLAY_ACTIVE_TO"])):?><?if(strlen($arItem["DISPLAY_ACTIVE_FROM"])):?> - <?else:?>до <?endif?><?=$arItem["DISPLAY_ACTIVE_TO"]?><?endif?></span>
				<?if(strlen($arItem["DISPLAY_ACTIVE_TO"])):?><div class="number"><?if($arItem["TIME_ACTIVE_TO"] > 0):?> <?=getWord($arItem["TIME_ACTIVE_TO"], array("остался", "осталось", "осталось"))?> <?=$arItem["TIME_ACTIVE_TO"]?> <?=getWord($arItem["TIME_ACTIVE_TO"], array("день", "дня", "дней"))?><?else:?>Акция завершена<?endif?></div><?endif?>
			</div>
		</a>
	</div>
<?endforeach;?>
</div>

<?=$arResult["NAV_STRING"]?>