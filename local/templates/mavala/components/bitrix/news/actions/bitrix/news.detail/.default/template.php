<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="term">
	<p>Срок действия: <?=$arResult["DISPLAY_ACTIVE_FROM"]?><?if(strlen($arResult["DISPLAY_ACTIVE_TO"])):?><?if(strlen($arResult["DISPLAY_ACTIVE_FROM"])):?> - <?else:?>до <?endif?><?=$arResult["DISPLAY_ACTIVE_TO"]?><?endif?><?if(strlen($arResult["DISPLAY_ACTIVE_TO"])):?> ( <?if($arResult["TIME_ACTIVE_TO"] > 0):?> <?=getWord($arResult["TIME_ACTIVE_TO"], array("остался", "осталось", "осталось"))?> <b><?=$arResult["TIME_ACTIVE_TO"]?> <?=getWord($arResult["TIME_ACTIVE_TO"], array("день", "дня", "дней"))?></b><?else:?>Акция завершена<?endif?> )<?endif?></p>
</div>
<div class="specific-block">
	<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["DETAIL_TEXT"];?><?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?></p><?endif?>
<?if(is_array($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) && count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])):?>
	<div class="slider-specific">
		<ul>
		<?foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $photo):?>
			<li style="background-image:url(<?=ResizeImage($photo)?>)">
				<img src="<?=ResizeImage($photo)?>" alt=""/>
				<div class="item">
				</div>
			</li>
		<?endforeach?>
		</ul>
	<?if(count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) > 1):?>
		<a href="#" class="btn-prev"></a>
		<a href="#" class="btn-next"></a>

		<div class="control-disk">
			<a href="#"></a>
		</div>
	<?endif?>
	</div>
<?endif?>
	<?if($arResult["PROPERTIES"]["SUBSLIDER_TEXT"]["VALUE"]["TYPE"] == "text"):?><p><?endif?><?echo $arResult["PROPERTIES"]["SUBSLIDER_TEXT"]["~VALUE"]["TEXT"];?><?if($arResult["PROPERTIES"]["SUBSLIDER_TEXT"]["VALUE"]["TYPE"] == "text"):?></p><?endif?>
<?if(strlen($arResult["PROPERTIES"]["VIDEO"]["VALUE"])):?>
	<div class="player">
		<iframe src="<?=GetVideoUrl($arResult["PROPERTIES"]["VIDEO"]["VALUE"])?>" width="840" height="510"></iframe>
	</div>
<?endif?>
	<?if($arResult["PROPERTIES"]["SUBVIDEO_TEXT"]["VALUE"]["TYPE"] == "text"):?><p><?endif?><?echo $arResult["PROPERTIES"]["SUBVIDEO_TEXT"]["~VALUE"]["TEXT"];?><?if($arResult["PROPERTIES"]["SUBVIDEO_TEXT"]["VALUE"]["TYPE"] == "text"):?></p><?endif?>

</div>

<div class="page-control">
	<?if(!empty($arResult["PAGINATION"]["PREV"])):?><a href="<?=$arResult["PAGINATION"]["PREV"][0]["DETAIL_PAGE_URL"]?>" class="btn-left btn-more2"><?=$arResult["PAGINATION"]["PREV"][0]["NAME"]?></a><?endif?>
	<a href="<?=$arResult["LIST_PAGE_URL"]?>" class="btn-other">другие акции</a>
	<?if(!empty($arResult["PAGINATION"]["NEXT"])):?><a href="<?=$arResult["PAGINATION"]["NEXT"][0]["DETAIL_PAGE_URL"]?>" class="btn-right btn-more2"><?=$arResult["PAGINATION"]["NEXT"][0]["NAME"]?></a><?endif?>
</div>