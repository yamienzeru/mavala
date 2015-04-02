<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="section3">
	<div class="specific-block">
		<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["PREVIEW_TEXT"];?><?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
	</div>
</section>

<div class="about-brand">
	<div class="top">

		<div class="top__i clearfix">

			<div class="side-l">
			<?if($arResult["PROPERTIES"]["CREATER_PHOTO"]["VALUE"]):?>
				<img src="<?=ResizeImage($arResult["PROPERTIES"]["CREATER_PHOTO"]["VALUE"], 132, 132, true)?>" alt="photo"/>
			<?endif?>

				<p><?=$arResult["PROPERTIES"]["CREATER_NAME"]["VALUE"]?></p>
				<span><?=$arResult["PROPERTIES"]["CREATER_TITLE"]["VALUE"]?></span>
			</div>

			<div class="side-r">
				<?if($arResult["PROPERTIES"]["CREATER_TEXT"]["VALUE"]["TYPE"] == "text"):?><p><?endif?><?echo $arResult["PROPERTIES"]["CREATER_TEXT"]["~VALUE"]["TEXT"];?><?if($arResult["PROPERTIES"]["CREATER_TEXT"]["VALUE"]["TYPE"] == "text"):?></p><?endif?>
			</div>
		</div>
	</div>
<?if(is_array($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) && count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])):?>
	<div class="slider">
		<ul class="slider-hide">
			<li>
			<?foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $keyItem => $photo):?>
		<?if($keyItem && !($keyItem % 3)):?>
			</li>
			<li>
		<?endif?>
				<div class="item" style="background-image: url(<?=ResizeImage($photo)?>);">
					<img src="<?=ResizeImage($photo)?>" alt=""/>
				</div>
			<?endforeach?>
			</li>
		</ul>
	<?if(count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) > 3):?>
		<div class="inner">
			<a href="#" class="btn-left"></a>
			<a href="#" class="btn-right"></a>
		</div>

		<div class="control-disk">
			<a href="#"></a>
		</div>
	<?endif?>
	</div>
<?endif?>
</div>

<section class="section3">
	<div class="specific-block btm45">
		<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["DETAIL_TEXT"];?><?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?></p><?endif?>
	</div>
</section>