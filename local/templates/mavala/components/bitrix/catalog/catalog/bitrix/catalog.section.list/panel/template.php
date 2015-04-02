<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult['SECTIONS'])):?>
<div class="menu product">
	<ul>
	<?foreach($arResult['SECTIONS'] as $arSection):?>
		<li<?if($arSection["ID"] == $arParams["CURRENT_SECTION"]):?> class="active"<?endif?>>
			<a href="<?=$arSection['SECTION_PAGE_URL']?>"><?=$arSection['NAME']?></a>
		</li>
	<?endforeach?>
	</ul>
</div>
<?endif?>