<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="popup-product">

	<div class="title-page">вы положили в корзину</div>
	<a href="#" class="btn-close"></a>

	<div class="row clearfix">
	<?if(!empty($arResult["PREVIEW_PICTURE"])):?>
		<img src="<?=ResizeImage($arResult["PREVIEW_PICTURE"], 189, 189)?>" alt="<?=$arResult["NAME"]?>"/>
	<?endif?>
		<div class="info">
			<div class="title-product"><?=$arResult["NAME"]?><?if(strlen($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?><span>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span><?endif?></div>

			<?/*<div class="property amount-block">
				<div class="title">Кол-во, шт</div>
				<input type="text" value="20"/>
				<a href="#" class="btn-min"></a>
				<a href="#" class="btn-max"></a>
			</div>*/?>
			<div class="price"><span>Цена</span>

				<div class="price-i"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
			</div>
		</div>
	</div>

	<div class="row">
		<a href="#" class="btn-transparent just-close">продолжить покупки</a>
		<a href="/cart/" class="btn-red2">перейти в корзину</a>
	</div>


	<p>Запутались в нашем сайте? Позвоните по телефону +7 499 704 55 75 <br/>
		(многоканальный, с 10:00 до 18:00) и наши менеджеры сделают все за вас!</p>
</div>