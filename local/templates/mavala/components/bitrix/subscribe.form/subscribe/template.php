<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="popup"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title">Хотите дешевле!</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>
<?if($arResult["ID"] > 0):?>
	<p>На введенный электронный адрес <?=$_REQUEST["EMAIL"]?> <br/> оформлена подписка.</p>
<?elseif(strlen($arResult["ERROR"])):?>
	<p><?=$arResult["ERROR"]?></p>
<?else:?>
	<p class="p-btm">Подпишитесь на уведомления <br/> о снижении цен и акции на товары <br/> из вашей корзины.</p>

	<form method="post"<?/* id="subscribe-two"*/?> class="popup_form" action="<?=$arResult["FORM_ACTION"]?>">
	<?=bitrix_sessid_post()?>
	<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
		<input type="hidden" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" />
	<?endforeach;?>
		<div class="wrap-input">
			<input type="text" placeholder="Ваш e-mail" name="EMAIL" value="" data-rule-required="true" data-rule-email="true" data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес"/>
		</div>
		<div class="wrap-btn">
			<input type="submit" class="btn-transparent mini" name="OK" value="подписаться">
		</div>
		<img class="hand" src="<?=SITE_TEMPLATE_PATH?>/static/img/hand-popup.png" alt="hand"/>
	</form>
<?endif?>
</div>