<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="section2">
	<div class="section__i">
		<div class="years"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/years.png" alt="50years"/></div>
		<div class="post">
			<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["PREVIEW_TEXT"];?><?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
		<?if(strlen($arResult["DETAIL_TEXT"])):?>
			<div class="drop">
				<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["DETAIL_TEXT"];?><?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?></p><?endif?>
			</div>
			<a href="#" class="btn-more2"><span>показать полностью</span><span>Свернуть</span></a>
		<?endif?>
		</div>
	</div>
</section>