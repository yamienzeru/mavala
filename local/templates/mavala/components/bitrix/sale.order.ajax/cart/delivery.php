<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//if(!empty($arResult["DELIVERY"])):?>
<?//print_p($arResult);?>
<div class="wrap-item">
	<!--remove active class-->
	<div class="item<?if($arResult["PROP_GROUPS"][2]["CHECKED"] == "Y"):?> active<?endif?>">
		<div class="step">3</div>
		<div class="title">Выберите способ доставки <?if($arResult["PROP_GROUPS"][2]["CHECKED"] == "Y" && empty($arResult["DELIVERY"])):?><span>для заданного населенного пункта нет доставки, попробуйте заказать в ближайший для Вас город</span><?endif?></div>
	<?if($arResult["PROP_GROUPS"][2]["CHECKED"] == "Y" && !empty($arResult["DELIVERY"])):?>
		<div class="drop middle">
			<div class="item__i">
				<div class="row clearfix">
				<?foreach($arResult["DELIVERY"] as $arDelivery):?>
					<div class="wrap-input radio clearfix">
						<input class="checked_submit" type="radio"<?if($arDelivery["CHECKED"] == "Y"):?> checked="checked"<?endif?> value="<?=$arDelivery["ID"]?>" name="DELIVERY_ID" id="ID_DELIVERY_<?=str_replace(":", "_", $arDelivery["ID"])?>">
						<label for="ID_DELIVERY_<?=str_replace(":", "_", $arDelivery["ID"])?>"><p style="width: 625px;">Служба доставки: <?=$arDelivery["NAME"]?><?if(strlen($arDelivery["DESCRIPTION"])):?>, <?=$arDelivery["DESCRIPTION"]?><?endif?></p>
						</label>

						<div class="price"><b>+ <?=$arDelivery["PRICE_FORMATED"]?></b></div>
				<?if(!empty($arDelivery["INFO"])):?>
					<?if(!empty($arDelivery["INFO"][0]))
						foreach($arDelivery["INFO"] as $arDeliveryInfo):?>
						<table style="width: 100%;padding: 0;margin: 0;" class="delivery-params">
							<tbody>
								<tr>
									<td><b>Время доставки, дн</b></td>
									<td><b><?=$arDeliveryInfo["TIMEDELIVERY"]?></b></td>
								</tr>
								<tr>
									<td style="width:150px;">Адрес пункта доставки</td>
									<td><?=$arDeliveryInfo["ADRES"]?></td> 
								</tr>
								<tr>
									<td>Время работы</td>
									<td><?=$arDeliveryInfo["TIMEWORK"]?></td>
								</tr>
								<tr>
									<td>Телефон</td>
									<td><?=$arDeliveryInfo["TEL"]?></td>
								</tr>
								<tr>
									<td>Схема проезда</td>
									<td><?=$arDeliveryInfo["DESCRDElIVERY"]?></td>
								</tr>
							</tbody>
						</table>
					<?endforeach?>
				<?endif?>
					</div>
				<?endforeach?>
				</div>
			<?if($arResult["PROP_GROUPS"][3]["CHECKED"] != "Y"):?>
				<a href="javascript:void(0);" class="btn-red2 submit_step">продолжить</a>
			<?endif?>
			</div>

		</div>
	<?endif?>
	</div>
</div>
<?//endif?>