<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="section3 clearfix">
	<div class="specific-block btm45">
		<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["PREVIEW_TEXT"];?><?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>

	<?if(is_array($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) && count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])):?>
		<div class="slider-specific">
			<ul>
			<?foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $keyItem => $photo):?>
				<li style="background-image:url(<?=ResizeImage($photo)?>)">
					<img src="<?=ResizeImage($photo)?>" alt="img580x512"/>
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
</section>

<section class="section8">

	<div class="title">Контакты учебного центра:</div>
	<?if($arResult["PROPERTIES"]["CONTACTS"]["VALUE"]["TYPE"] == "text"):?><p><?endif?><?echo $arResult["PROPERTIES"]["CONTACTS"]["~VALUE"]["TEXT"];?><?if($arResult["PROPERTIES"]["CONTACTS"]["VALUE"]["TYPE"] == "text"):?></p><?endif?>

</section>