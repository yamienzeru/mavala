<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="wrap-item">
	<div class="item active">
		<div class="step">1</div>
		<div class="title">Пару слов о вас <span>* – поля обязательные для заполнения</span>
		<?if(!$USER->IsAuthorized()):?>
			<div class="enter">Уже покупали <br/>ранее?<a href="/login/" class="btn-red2 popup_btn fancybox.ajax">войдите</a></div>
		<?endif?>
		</div>

		<div class="drop">

			<div class="row clearfix">
				<div class="left">
					<p>Фамилия Имя Отчество: *</p>
					<span>как к Вам обращаться</span>
				</div>
				<div class="right">

					<div class="wrap-input">
						<div class="hide">Отчество будет использованно при
							<br/>оформлении почтового отправления.
						</div>
						<?$prop = "NAME";?>
						<input type="text" class="dark" placeholder="Например, Ургант Николай Петрович" data-rule-required="true" data-msg-required="Ввведите  имя" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>E-mail: *</p>
					<span>на который вы получите <br/>подтверждение о покупке</span>
				</div>
				<div class="right">

					<div class="wrap-input">
						<div class="hide">
							Будьте внимательны, наши клиенты часто опечатываются в своих электронных адресах.
							Е-mail будет использован для отчета о заказе.
						</div>
						<?$prop = "EMAIL";?>
						<input type="text" class="dark" placeholder="Например, pochta@mail.ru" data-rule-required="true" data-rule-email="true" data-msg-required="Ввведите email адрес" data-msg-email="Введите валидный email адрес" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>Контактный телефон (моб): *</p>
					<span>наш менеджер свяжется <br/>с вами для уточнения деталей</span>
				</div>
				<div class="right">

					<div class="wrap-input">
						<?$prop = "PERSONAL_MOBILE";?>
						<input type="text" class="dark phone_number" placeholder="Например, +7 (000) 0000000" data-rule-required="true" data-msg-required="Ввведите  телефон" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>Дополнительный номер: </p>
				</div>
				<div class="right">

					<div class="wrap-input">
						<?$prop = "PERSONAL_PHONE";?>
						<input type="text" class="phone_number" placeholder="Например, +7 (000) 0000000" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
		<?if($arResult["PROP_GROUPS"][1]["CHECKED"] != "Y"):?>
			<div class="row"><a href="javascript:void(0);" class="btn-red2 quick_buy">заказать и уточнить детали</a></div>
		<?endif?>
		</div>


	</div>
</div>
<div class="wrap-item">
	<!--remove active class-->
	<div class="item<?if($arResult["PROP_GROUPS"][1]["CHECKED"] == "Y"):?> active<?endif?>">
		<div class="step">2</div>
		<div class="title">По какому адресу вам доставить заказ?</div>
	<?if($arResult["PROP_GROUPS"][1]["CHECKED"] == "Y"):?>
		<div class="drop">
			<div class="row clearfix">
				<div class="left">
					<p>Населенный пункт: *</p>
				</div>
				<div class="right">

					<div class="wrap-input">
						<?$prop = "PERSONAL_CITY";?>
						<?$GLOBALS["APPLICATION"]->IncludeComponent(
							"bitrix:sale.ajax.locations",
							"",
							array(
								"AJAX_CALL" => "N",
								"COUNTRY_INPUT_NAME" => "",
								"REGION_INPUT_NAME" => "",
								"CITY_INPUT_NAME" => $arResult["ORDER_PROP"][$prop]["FIELD_NAME"],
								"CITY_OUT_LOCATION" => "Y",
								"LOCATION_VALUE" => $arResult["USER_CITY_ID"],
								"ORDER_PROPS_ID" => $arResult["ORDER_PROP"][$prop]["ID"],
								"ONCITYCHANGE" => ($arResult["ORDER_PROP"][$prop]["IS_LOCATION"] == "Y" || $arResult["ORDER_PROP"][$prop]["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
								"SIZE1" => $arResult["ORDER_PROP"][$prop]["SIZE1"],
							),
							null,
							array('HIDE_ICONS' => 'Y')
						);?>
						<?/*<input type="text" class="dark" placeholder="Например, Москва" data-rule-required="true" data-msg-required="Ввведите  населенный пункт" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>*/?>
						<?/*$prop = "PERSONAL_ZIP";?>
						<input type="hidden" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" class="zip" />*/?>
					</div>

				</div>
			</div>
			<div class="row clearfix kladr_zip_block"<?/* style="display:none;"*/?>>
				<div class="left">
					<p>Индекс: *</p>
				</div>
				<div class="right">

					<div class="wrap-input large">
						<?$prop = "PERSONAL_ZIP";?>
						<input type="text" class="dark kladr_zip cart_zip" data-rule-required="true" data-msg-required="Ввведите индекс" placeholder="Например, 123456" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>Улица: *</p>
				</div>
				<div class="right">

					<div class="wrap-input large">
						<?$prop = "PERSONAL_STREET";?>
						<input type="text" class="dark kladr_street" data-rule-required="true" data-kladr-error="Улица не найдена" data-msg-required="Ввведите  улицу" placeholder="Например,Ленина" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>Дом: *</p>
				</div>
				<div class="right clearfix">

					<div class="wrap-input small clearfix">
						<?$prop = "UF_HOUSE";?>
						<input class="dark kladr_building" type="text" data-rule-required="true" data-kladr-error="Дом не найден" data-msg-required="Ввведите  дом" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>

					<div class="wrap-input small clearfix">
						<p>Корпус:</p>
						<?$prop = "UF_HOUSING";?>
						<input class="dark" type="text" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>
					<div class="wrap-input small clearfix">
						<p>Квартира:</p>
						<?$prop = "UF_FLAT";?>
						<input class="dark" type="text" size="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" value="<?=$arResult["ORDER_PROP"][$prop]["VALUE"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"/>
					</div>
				</div>
			</div>
			<div class="row clearfix">
				<div class="left">
					<p>Дополнительная информация:</p>
				</div>
				<div class="right">

					<div class="wrap-input">
						<?$prop = "PERSONAL_NOTES";?>
						<textarea cols="<?=$arResult["ORDER_PROP"][$prop]["SIZE1"]?>" rows="<?=$arResult["ORDER_PROP"][$prop]["SIZE2"]?>" name="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>" id="<?=$arResult["ORDER_PROP"][$prop]["FIELD_NAME"]?>"><?=$arResult["ORDER_PROP"][$prop]["VALUE"]?></textarea>
					</div>

				</div>
			</div>
			<?if($arResult["PROP_GROUPS"][2]["CHECKED"] != "Y"):?>
				<div class="row"><a href="javascript:void(0);" class="btn-red2 submit_step">продолжить</a></div>
			<?endif?>
		</div>
	<?endif?>
	</div>
</div>