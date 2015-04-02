<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><section class="section cart-order">
	<div class="order-list">
		<div class="row-title clearfix">
			<div class="item img">фото</div>
			<div class="item name">наименование и цена за 1 шт</div>
			<div class="item number">количество, шт</div>
			<div class="item sum">итоговая сумма</div>
		</div>
	<?foreach($arResult["BASKET_ITEMS"] as $arBasketItem):?>
		<div class="row clearfix">
			<div class="item img"><a href="<?=$arBasketItem["DETAIL_PAGE_URL"]?>" target="_blank"><img src="<?=ResizeImage($arBasketItem["PREVIEW_PICTURE"], 169, 132)?>" alt="<?=$arBasketItem["NAME"]?>"/></a></div>
			<div class="item name">
				<p><a href="<?=$arBasketItem["DETAIL_PAGE_URL"]?>" target="_blank"><?=$arBasketItem["NAME"]?></a> <?if($arBasketItem["PROPERTY_CML2_ARTICLE_VALUE"]):?><span>Артикул: <?=$arBasketItem["PROPERTY_CML2_ARTICLE_VALUE"]?></span><?endif?></p>
				<?/*<div class="old price">15 950 р.</div>*/?>
				<div class="price"><?=$arBasketItem["PRICE_FORMATED"]?></div>
			</div>
			<div class="item number">
				<div class="property amount-block">
					<input type="text" name="QUANTITY_<?=$arBasketItem["ID"]?>" value="<?=$arBasketItem["QUANTITY"]?>"/>
					<a href="javascript:void(0);" class="btn-min submit"></a>
					<a href="javascript:void(0);" class="btn-max submit"></a>
				</div>
			</div>
			<div class="item sum">
				<?/*<p><span>!</span>в резрве 5 часов 20 мин</p>*/?>
				<p>&nbsp;</p>
				<div class="price"><?=$arBasketItem["SUM"]?><a href="#" class="remove submit"></a></div>
			</div>
		</div>
	<?endforeach;?>
		<div class="payment clearfix">
			<div class="left clearfix">
				<p>введите промо код:
				<span class="info">?
					<span class="hide">У Вас есть промо код <br/> и у Вас возник вопрос куда <br/> его ввести, это поле именно для этого.</span>
				</span>
				</p>

				<div class="wrap-input" style="width: 146px;">
					<input type="text" name="COUPON" value="<?=$_REQUEST["COUPON"]?>" id="COUPON"/>
					<?if(strlen($_REQUEST["COUPON"]) && $arResult["ORDER_PRICE_FORMATED"] == $arResult["PRICE_WITHOUT_DISCOUNT"]):?><label id="COUPON-error" class="error" for="COUPON">Скидка по купону отсутствует.</label><?endif?>
				</div>
				<a href="javascript:void(0);" class="btn-red2 submit">пересчитать</a>

			</div>
			<div class="right clearfix">

				<p>стоимость без учета доставки:</p>

				<div class="price">
					<?if($arResult["ORDER_PRICE_FORMATED"] != $arResult["PRICE_WITHOUT_DISCOUNT"]):?><div class="old"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></div><?endif?>
					<?=$arResult["ORDER_PRICE_FORMATED"]?>
				</div>

			</div>
		</div>


	</div>