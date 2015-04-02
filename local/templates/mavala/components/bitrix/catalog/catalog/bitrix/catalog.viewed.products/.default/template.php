<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();?>
<?if (!empty($arResult['ITEMS'])):?>
<div class="slider-catalog">
	<div class="title">вы смотрели</div>
	<ul class="slider-hide">
	<?foreach($arResult['ITEMS'] as $key => $arItem):?>
		<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));?>
		<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="product-shadow">
		<div class="product" id="<?=$this->GetEditAreaId($arItem['ID']);?>">

			<div class="wrap-img">
				<div class="icon-list">
					<?/*<div class="icon-action">акции</div>*/?>
					<?if($arItem["PROPERTIES"]["IS_NEW"]["VALUE"] == "Y"):?><div class="icon-new">new</div><?endif?>
					<?if($arItem["PROPERTIES"]["IS_HIT"]["VALUE"] == "Y"):?><div class="icon-hit">hit</div><?endif?>
				</div>
				<div class="img-shadow"></div>
				<img src="<?=ResizeImage($arItem["PREVIEW_PICTURE"], 246, 294)?>" alt="<?=$arItem["NAME"]?>"/>
			</div>

			<div class="product-info">
				<div class="wrap">
					<?if(strlen($arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?><span>Арт: <?=$arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span><?endif?>
					<?if(strlen($arItem["PROPERTIES"]["OB_EM"]["VALUE"])):?><span class="volume"><?=$arItem["PROPERTIES"]["OB_EM"]["VALUE"]?> мл</span><?endif?>
				</div>

				<div class="text"><?=$arItem["NAME"]?></div>
			<?if (!empty($arItem['MIN_PRICE'])):?>
				<p class="price"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?> <a href="<? echo $arItem['ADD_URL']; ?>" class="btn-red2">купить</a></p>
			<?endif?>
			</div>

			<div class="product-info__hidden">
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="product-link">
					<div class="wrap">
						<?if(strlen($arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?><span>Арт: <?=$arItem["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span><?endif?>
						<?if(strlen($arItem["PROPERTIES"]["OB_EM"]["VALUE"])):?><span class="volume"><?=$arItem["PROPERTIES"]["OB_EM"]["VALUE"]?> мл</span><?endif?>
					</div>

					<div class="text"><?=$arItem["NAME"]?></div>
				<?if(!empty($arItem['MIN_PRICE'])):?>
					<div class="price"><?=$arItem['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
				<?endif?>
				</a>
	<?if(!isset($arItem['OFFERS']) || empty($arItem['OFFERS'])): // Simple Product?>
		<?if(!empty($arItem['MIN_PRICE'])):?>
			<?if('Y' == $arParams['USE_PRODUCT_QUANTITY']):?>
				<form class="addtobasket">
					<div class="wrap-property clearfix">
						<?/*<div class="property volume-block">
							<div class="title">Объем, мл.</div>
							<select class="volume">

								<option value="5">5</option>
								<option value="10">10</option>
								<option value="15">15</option>
								<option value="20">20</option>
							</select>
						</div>*/?>
						<div class="property amount-block">
							<div class="title">Кол-во, шт</div>
							<input type="text" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arItem['CATALOG_MEASURE_RATIO']; ?>"/>
							<a href="#" class="btn-min"></a>
							<a href="#" class="btn-max"></a>
						</div>
					</div>

					<input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"]; ?>" value="ADD2BASKET" />
					<input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"]; ?>" value="<? echo $arItem['ID']; ?>" />
					<input type="submit" class="btn-red2" value="купить" />
				</form>
			<?else:?>
				<a href="<? echo $arItem['ADD_URL']; ?>" class="btn-red2">купить</a>
			<?endif?>
		<?endif?>
	<?endif?>
			</div>

		</div>
			</div>
		</li>
	<?endforeach?>
	</ul>
<?if(count($arResult['ITEMS']) > 4):?>
	<a href="#" class="btn-prev"></a>
	<a href="#" class="btn-next"></a>
	<div class="control-disk">
		<a href="#"></a>
	</div>
<?endif?>
</div>
<?endif?>