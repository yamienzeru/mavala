<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<a href="/about/" class="item article">
	<div class="item__i">
		<div class="article__i">
			<div class="title">История <br/> бренда</div>
			<div class="name">
			<?if($arResult["PROPERTIES"]["CREATER_PHOTO"]["VALUE"]):?>
				<img src="<?=ResizeImage($arResult["PROPERTIES"]["CREATER_PHOTO"]["VALUE"], 132, 132, true)?>" alt="Madlen"/>
			<?endif?>
				<?=$arResult["PROPERTIES"]["CREATER_NAME"]["VALUE"]?>
				<span><?=$arResult["PROPERTIES"]["CREATER_TITLE"]["VALUE"]?></span>
			</div>
			<?if($arResult["PROPERTIES"]["PREV_TEXT"]["VALUE"]["TYPE"] == "text"):?><p><?endif?><?echo $arResult["PROPERTIES"]["PREV_TEXT"]["~VALUE"]["TEXT"];?><?if($arResult["PROPERTIES"]["PREV_TEXT"]["VALUE"]["TYPE"] == "text"):?></p><?endif?>
			<span class="btn-more2">узнать больше</span>
		</div>
	</div>
</a>