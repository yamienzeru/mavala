<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="footer-middle clearfix">
	<div class="column">
	<?foreach($arResult["SECTIONS_TREE"] as $keySection => $arSection):?>
<?if($keySection && !($keySection % 2)):?>
	</div>
	<div class="column">
<?endif?>
		<h2 class="title"><a href="<?=$arSection["SECTION_PAGE_URL"]?>"<?if(stripos($arParams["CURRENT_SECTION"], $arSection["SECTION_PAGE_URL"]) !== false):?> class="active"<?endif?>><?=$arSection["NAME"]?></a></h2>
		<ul>
			<li></li>
		<?foreach($arSection["SECTIONS"] as $arSubSection):?>
			<li><a href="<?=$arSubSection["SECTION_PAGE_URL"]?>"<?if(stripos($arParams["CURRENT_SECTION"], $arSubSection["SECTION_PAGE_URL"]) !== false):?> class="active"<?endif?>><?=$arSubSection["NAME"]?></a></li>
		<?endforeach?>
		</ul>
	<?endforeach?>
	</div>
</div>