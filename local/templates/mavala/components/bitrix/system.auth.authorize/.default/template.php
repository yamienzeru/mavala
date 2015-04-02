<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams['AUTH_RESULT']["ERROR_TYPE"] == "LOGIN"):?>
<div class="popup error-account"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/aim.png" alt="aim"/>о-оу</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p class="p-btm">неверно введен пароль или аккаунта <br/>зарегистрированного на этот адрес не <br/>существует</p>

	<div class="wrap-btn">
		<a href="/login/" class="btn-transparent popup_btn small fancybox.ajax">попробовать ещё раз</a>
	</div>
</div>
<?elseif($arParams["AUTH_RESULT"]["MESSAGE"] && $arParams["AUTH_RESULT"]["TYPE"] == "ERROR" || $arResult['ERROR_MESSAGE']["MESSAGE"]):?>
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
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/unknow.png" alt="unknow"/>вход</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p class="p-btm"><?=$arParams["~AUTH_RESULT"]["MESSAGE"];?></p>

	<div class="wrap-btn">
		<a href="#" class="btn-transparent reload_btn small fancybox.ajax">ok</a>
	</div>
</div>
<?else:?>
<div class="popup" id="popup-enter"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/lock2.png" alt="lock"/>вход </div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>
	<p>Заполните поле «E-mail» используя свой <br/> адрес электронной почты</p>

	<form<?/* id="loginform"*/?> class="popup_form" name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
		<?/*if(is_array($arParams["AUTH_RESULT"]) && strlen($arParams["AUTH_RESULT"]["MESSAGE"])):?><div class="form-message<?if($arParams["AUTH_RESULT"]["TYPE"] == "ERROR"):?> form-message_error<?endif?>"><?=$arParams["~AUTH_RESULT"]["MESSAGE"];?></div><?endif?>
		<?if(!is_array($arParams["AUTH_RESULT"]) && strlen($arParams["AUTH_RESULT"])):?><div class="form-message"><?=$arParams["~AUTH_RESULT"];?></div><?endif?>
		<?if(is_array($arResult['ERROR_MESSAGE']) && strlen($arResult['ERROR_MESSAGE']["MESSAGE"])):?><div class="form-message form-message_error"><?=$arResult['ERROR_MESSAGE']["MESSAGE"];?></div><?endif*/?>
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="AUTH" />
	<?if (strlen($arResult["BACKURL"]) > 0):?>
		<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
	<?endif?>
	<?foreach ($arResult["POST"] as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
	<?endforeach?>
		<div class="wrap-input">
			<input type="text" placeholder="Ваш e-mail" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>"  data-rule-required="true"<?/* data-rule-email="true"*/?> data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес"/>
		</div>
		<div class="wrap-input">
			<input type="password" placeholder="Пароль" name="USER_PASSWORD"  data-rule-required="true" data-msg-required="Ввведите  пароль"/>
			<a href="/login/?forgot_password=yes" class="popup_btn fancybox.ajax">Забыли пароль?</a>
		</div>
	<?if($arResult["CAPTCHA_CODE"]):?>
		<div class="wrap-input">
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<input type="text"  name="captcha_word" maxlength="50" value="" size="15" placeholder="Код с картинки" data-rule-required="true" data-msg-required="Ввведите код с картинки"/>
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
		</div>
	<?endif;?>
		<div class="wrap-input">
			<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y"/><label for="USER_REMEMBER">Запомнить меня</label>
		</div>
		<div class="wrap-btn">
			<input type="submit" name="Login" class="btn-transparent " value="вход"/>
			<?/*<a href="#" class="btn-transparent invers">регистрация</a>*/?>
		</div>
	</form>
</div>
<?endif?>