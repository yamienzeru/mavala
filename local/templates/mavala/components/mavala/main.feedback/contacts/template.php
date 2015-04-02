<?if(!defined("B_PROLOG_INCLUDED")||B_PROLOG_INCLUDED!==true)die();?>
<?if($_REQUEST["ajax"] == "y") $APPLICATION->RestartBuffer();?>
<?if(strlen($arResult["OK_MESSAGE"]) > 0):?>
<div class="popup"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/unknow.png" alt="unknow"/>Сообщение отправлено</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p class="p-btm"><?=$arParams["~AUTH_RESULT"]["MESSAGE"];?></p>

	<div class="wrap-btn">
		<a href="#" class="btn-transparent reload_btn small fancybox.ajax">ok</a>
	</div>
</div>
<?elseif(!empty($arResult["ERROR_MESSAGE"])):?>
<div class="popup error-account"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/aim.png" alt="aim"/>о-оу</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>
<?foreach($arResult["ERROR_MESSAGE"] as $v):?>
	<p class="p-btm"><?=$v?></p>
<?endforeach?>
</div>
<?else:?>
<form method="post" novalidate="novalidate" id="message-form" action="<?=POST_FORM_ACTION_URI?>?ajax=y" method="POST" class="popup_form">
	<div class="popup form">
	<?=bitrix_sessid_post()?>
	<?/*if(!empty($arResult["ERROR_MESSAGE"]))
	{
		foreach($arResult["ERROR_MESSAGE"] as $v)
			ShowError($v);
	}
	if(strlen($arResult["OK_MESSAGE"]) > 0)
	{
		?><div class="mf-ok-text"><?=$arResult["OK_MESSAGE"]?></div><?
	}*/?>
		<div class="inner">
			<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/mail-popup.png" alt="mail"/>Отправить сообщение</div>
			<div class="row clearfix">
				<p>Ваше имя:</p>
				<div class="wrap-input">
					<input type="text" placeholder="... Татьяна Анатольевна" name="user_name" value="<?=$arResult["AUTHOR_NAME"]?>" data-rule-required="true" data-msg-required="Ввведите  имя" />
				</div>
			</div>
			<div class="row clearfix">
				<p>E-mail:</p>
				<div class="wrap-input">
					<input type="text" placeholder="... kostya@mail.ru" name="user_email" value="<?=$arResult["AUTHOR_EMAIL"]?>" data-rule-required="true" data-rule-email="true" data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес" />
				</div>
			</div>
			<div class="row clearfix">
				<p>Сообщение:</p>
				<div class="wrap-input">
					<textarea placeholder="... Хотел бы сделать заказ мой тел. +7 (903) 777-77-77" name="MESSAGE" data-rule-required="true" data-msg-required="Ввведите сообщение"><?=$arResult["MESSAGE"]?></textarea>
				</div>
			</div>

		<?if($arParams["USE_CAPTCHA"] == "Y"):?>
			<?if($arParams["CAPTCHA"] == "C"):?>
			<div class="row clearfix">
				<p>Код с картинки:</p>
				<div class="wrap-input">
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["capCode"]?>" width="180" height="40" alt="CAPTCHA">
					<input type="hidden" name="captcha_sid" value="<?=$arResult["capCode"]?>">
					<input type="text" name="captcha_word" size="30" maxlength="50" value="">
				</div>
			</div>
			<?elseif($arParams["CAPTCHA"] == "H"):?>
			<div class="mf-hname" style="display:none;">
				<input type="text" name="name" value="">
			</div>
			<?endif;?>
		<?endif;?>

			<div class="wrap-btn">
				<input type="hidden" name="PARAMS_HASH" value="<?=$arResult["PARAMS_HASH"]?>">
				<input type="submit" class="btn-transparent" name="submit" value="отправить" />
			</div>
		</div>
	</div>
</form>
<?endif?>
<?if($_REQUEST["ajax"] == "y") die();?>