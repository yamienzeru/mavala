<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams["AUTH_RESULT"]["MESSAGE"] && $arParams["AUTH_RESULT"]["TYPE"] == "ERROR" || $arResult['ERROR_MESSAGE']["MESSAGE"]):?>
<div class="popup error-account"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/aim.png" alt="aim"/>о-оу</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<?if($arParams["AUTH_RESULT"]["MESSAGE"]):?><p class="p-btm"><?=$arParams["~AUTH_RESULT"]["MESSAGE"];?></p><?endif?>
	<?if($arResult['ERROR_MESSAGE']["MESSAGE"]):?><p class="p-btm"><?=$arParams["ERROR_MESSAGE"]["MESSAGE"];?></p><?endif?>

	<div class="wrap-btn">
		<a href="<?=$arResult["AUTH_URL"]?>" class="btn-transparent popup_btn small fancybox.ajax">попробовать ещё раз</a>
	</div>
</div>
<?elseif($arParams["AUTH_RESULT"]["MESSAGE"] && $arParams["AUTH_RESULT"]["TYPE"] != "ERROR"):?>
<div class="popup"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/unknow.png" alt="unknow"/>Забыли пароль</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p class="p-btm"><?=$arParams["~AUTH_RESULT"]["MESSAGE"];?></p>

	<div class="wrap-btn">
		<a href="#" class="btn-transparent reload_btn small fancybox.ajax">ok</a>
	</div>
</div>
<script>
	setTimeout(function(){
			location.reload();
		},1500);
</script>
<?else:?>
<div class="popup"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/unknow.png" alt="unknow"/>Забыли пароль</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p>Укажите электронный адрес который Вы <br/>использовали при регистрации</p>

	<form<?/* id="email-repair"*/?> class="popup_form" method="post" action="<?=$arResult["AUTH_URL"]?>">
	<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
		<input type="hidden" name="AUTH_FORM" value="Y">
		<input type="hidden" name="TYPE" value="SEND_PWD">
	<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
		<div class="wrap-input">
			<input type="text" placeholder="Ваш e-mail" name="USER_LOGIN" maxlength="50" value="<?=$arResult["LAST_LOGIN"]?>" data-rule-required="true"<?/* data-rule-email="true"*/?> data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес"/>
		</div>
		<div class="wrap-btn">
			<input type="submit" name="send_account_info" class="btn-transparent small" value="восстановить пароль"/>
		</div>
	</form>
</div>
<?endif?>