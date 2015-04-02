<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form method="post" id="subscribe-form" class="popup_form" action="<?=$arResult["FORM_ACTION"]?>?ajax=y">
	<?=bitrix_sessid_post()?>
<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
	<input type="hidden" name="RUB_ID[]" value="<?=$itemValue["ID"]?>" />
<?endforeach;?>
	<h2 class="title">подписаться <br/>на новости</h2>
	<div class="wrap-input">
		<input type="text" placeholder="... ваш e-mail@mail.ru" name="EMAIL" value="" data-rule-required="true" data-rule-email="true" data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес"/>
	</div>
	<div class="wrap-btn"><input type="submit" class="btn-transparent" name="OK" value="подписаться"/></div>
</form>