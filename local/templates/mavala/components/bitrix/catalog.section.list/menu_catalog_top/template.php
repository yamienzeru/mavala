<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="menu">
	<ul class="clearfix">
	<?foreach($arResult["SECTIONS_TREE"] as $arSection):?>
		<li><a href="<?=$arSection["SECTION_PAGE_URL"]?>"<?if(stripos($arParams["CURRENT_SECTION"], $arSection["SECTION_PAGE_URL"]) !== false):?> class="active"<?endif?>><?=$arSection["NAME"]?></a></li>
	<?endforeach?>
	</ul>
</div>