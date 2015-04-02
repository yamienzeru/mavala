<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_p($arResult);?>
<section class="section6">

	<div class="current__tab">
		<div class="inner">
			<ul class="clearfix">
				<li class="active"><a href="/personal/history/">История покупок</a></li>
				<li><a href="/personal/">личные данные</a></li>
			</ul>
		</div>
	</div>
<?if(!is_array($arResult["ORDERS"]) || !count($arResult["ORDERS"])):?>
	<div class="shopping-cart">
		<div class="title-page">Здесь будет список ваших покупок.</span></div>
	</div>
<?else:?>
	<div class="tab-info">

		<ul>
			<li class="active">
				<div class="order-table__head">
					<div class="order-table__head__i clearfix">
						<div class="item date">дата</div>
						<div class="item order">№ заказа</div>
						<?/*<div class="item track">трекинг №</div>*/?>
						<div class="item status">статус заказа</div>
						<div class="item sum">сумма</div>
					</div>
				</div>

				<div class="order-table">
					<div class="order-table__i">
					<?foreach($arResult["ORDERS"] as $val):?>
						<div class="row clearfix">
							<div class="item date"><?=$val["ORDER"]["DATE_INSERT_FORMATED"]?></div>
							<div class="item order">заказ №<?=$val["ORDER"]["ID"]?></div>
							<?/*<div class="item track">трекинг номер №12757</div>*/?>
							<div class="item status" style="width: 380px;">
							<?if($val["ORDER"]["CANCELED"] != "Y"):?>
								<?=$arResult["INFO"]["STATUS"][$val["ORDER"]["STATUS_ID"]]["NAME"]?> <?=$val["ORDER"]["DATE_STATUS"]?>
							<?else:?>
								Отменен <?=$val["ORDER"]["DATE_CANCELED"]?>
							<?endif?>
							</div>
							<div class="item sum"><?=$val["ORDER"]["FORMATED_PRICE"]?> <div class="btn-more"></div></div>
							<div class="drop-list">
							<?foreach($val["BASKET_ITEMS"] as $vval):?>
								<div class="sub-row clearfix">
									<div class="sub-item img"><img src="<?=ResizeImage($vval["PREVIEW_PICTURE"], 70, 87)?>" width="87" alt="<?=$vval["NAME"]?>"/></div>
									<div class="sub-item name"><?=$vval["NAME"]?></div>
									<div class="sub-item price"><span><?/*2 100 руб.*/?></span><span><?=PriceFormat($vval["PRICE"])?></span></div>
									<div class="sub-item number"><?=$vval["QUANTITY"]?> шт.</div>
									<div class="sub-item sum"><?=PriceFormat($vval["PRICE"] * $vval["QUANTITY"])?></div>
								</div>
							<?endforeach;?>
								<div class="sub-row clearfix">
									<div class="sub-item" style="float: right;">
									<?if($val["ORDER"]["CANCELED"] != "Y" && $val["ORDER"]["PAYED"] != "Y" && strlen($val["ORDER"]["URL_TO_PAY"])):?>
										<?//=$val["ORDER"]["PAY_BUTTON"]?>
										<a class="btn-red2" href="<?=$val["ORDER"]["URL_TO_PAY"]?>" target="_blank">Оплатить</a>
									<?endif;?>
									<?if($val["ORDER"]["CAN_CANCEL"] == "Y"):?>
										<a href="<?=$val["ORDER"]["URL_TO_CANCEL"]?>" class="btn-red2">Отмена</a>
									<?endif;?>
									</div>
								</div>
							</div>
						</div>
					<?endforeach;?>
					</div>
				</div>
			</li>
			<li>
			</li>

		</ul>

	</div>
<?endif?>
</section>