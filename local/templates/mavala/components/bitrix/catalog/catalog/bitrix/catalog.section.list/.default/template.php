<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!empty($arResult['SECTIONS'])):?>
<div class="catalog__product-menu clearfix">
<?foreach($arResult['SECTIONS'] as $arSection):?>
	<div class="item">
		<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="item__i">
			<?if($arSection['DETAIL_PICTURE']):?><img src="<?=ResizeImage($arSection['DETAIL_PICTURE'], 271, 263)?>" alt="<?=$arSection['NAME']?>"/><?endif?>
			<div class="title"><span><?=$arSection['NAME']?></span></div>
			<span class="number"><?=$arSection['ELEMENT_CNT']?></span>
		</a>
	</div>
<?endforeach?>
</div>
<?endif?>