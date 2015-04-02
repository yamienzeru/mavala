<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="section7" style="background-image: url(<?=SITE_TEMPLATE_PATH?>/static/img/demo/img1346x721.png);">

	<div class="section__i clearfix">

		<h1 class="title-page">Спасибо за покупку</h1>

		<div class="title">Вы успешно совершили заказ на сумму <?=$arResult["PRICE_FORMATED"]?> <br/>Номер вашего заказа №<?=$arResult["ACCOUNT_NUMBER"]?></div>
		<div class="item">
			<p>
				<span><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/mail-popup.png" alt="mail"/></span>
				Вам на почту отправленно письмо <br/>
				с информацией о заказе и его статусе. <br/> Сохраните его, оно может пригодится
				<br/> в случае возникновения
				каких-либо <br/> недоразумений.
			</p>
		</div>
		<div class="item">
			<p>
				<span><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/phone.png" alt="phone"/></span>
				Проверить состояние заказа <br/>
				Вы можете позвонив <br/>
				по телефону: +7 <?$APPLICATION->IncludeFile($APPLICATION->GetTemplatePath("include_areas/phone.php"), Array(), Array("MODE"=>"text", "NAME" => "телефон"));?> <br/>
				или в разделе <a href="<?=$arParams["PATH_TO_LIST"]?>">«Личный кабинет»</a>
			</p>
		</div>
	</div>

</section>