<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="popup">
	<div class="title">Заказ в 1 клик!</div>
	<a href="<?=$APPLICATION->GetCurPageParam("", array($arParams["ACTION_VARIABLE"], $arParams["PRODUCT_ID_VARIABLE"]))?>" class="btn-close"></a>
<?if($_REQUEST["success"] == "y"):?>
	<p class="p-btm">Спасибо за заказ!<br /> Наши специалисты перезвонят Вам, <br /> сообщат условия доставки, наличие <br /> товара и ответят на все вопросы.</p>
<?else:?>
	<p class="p-btm">Введите свой номер телефона, <br /> и наши специалисты перезвонят Вам, <br /> сообщат условия доставки, наличие <br /> товара и ответят на все вопросы.</p>

	<form method="post" class="popup_form" id="subscribe-two" action="<?=$APPLICATION->GetCurPageParam("", array("quick_order"))?>">
		<div class="wrap-input">
			<input class="phone_number" type="text" placeholder="Ваш мобильный" name="phone" data-rule-required="true" data-msg-required="Ввведите телефон"/>
		</div>
		<div class="wrap-btn">
			<input type="submit" class="btn-transparent mini" value="Заказать" name="quick_order">
		</div>
		<img class="hand" src="<?=SITE_TEMPLATE_PATH?>/static/img/hand-popup.png" alt="hand"/>
	</form>
<?endif?>
</div>