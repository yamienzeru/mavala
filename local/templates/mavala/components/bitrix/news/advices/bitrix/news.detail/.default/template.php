<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="specific-block">
	<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["PREVIEW_TEXT"];?><?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>

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

	<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["DETAIL_TEXT"];?><?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?></p><?endif?>
</div>
<div class="term">
	<p><?=$arResult["DISPLAY_ACTIVE_FROM"]?></p>
</div>

<div class="page-control">
	<?if(!empty($arResult["PAGINATION"]["PREV"])):?><a href="<?=$arResult["PAGINATION"]["PREV"][0]["DETAIL_PAGE_URL"]?>" class="btn-left btn-more2"><?=$arResult["PAGINATION"]["PREV"][0]["NAME"]?></a><?endif?>
	<a href="<?=$arResult["LIST_PAGE_URL"]?>" class="btn-other">другие советы</a>
	<?if(!empty($arResult["PAGINATION"]["NEXT"])):?><a href="<?=$arResult["PAGINATION"]["NEXT"][0]["DETAIL_PAGE_URL"]?>" class="btn-right btn-more2"><?=$arResult["PAGINATION"]["NEXT"][0]["NAME"]?></a><?endif?>
</div>