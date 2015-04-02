<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="header-catalog current clearfix">

	<div class="breadcrumbs clearfix">
		<a href="/">Главная страница</a>
		<a href="<?=$arResult["SECTION"]["LIST_PAGE_URL"]?>">Каталог</a>
	<?foreach($arResult["SECTION"]["PATH"] as $arPath):?>
		<a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
	<?endforeach?>
		<a href="<?=$arResult["DETAIL_PAGE_URL"]?>" class="active"><?=$arResult["NAME"]?></a>
	</div>

	<h1 class="title-page" style="width: 75%;">
		<?=$arResult["NAME"]?>
		<?if(strlen($arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"])):?><span>Артикул: <?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></span><?endif?>
	</h1>
	<div class="aside clearfix">
	<?if($arResult["PAGER"]["PREV"][0]):?>
		<div class="item">
			<a href="<?=$arResult["PAGER"]["PREV"][0]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["PAGER"]["PREV"][0]["NAME"]?>">Предыдущий</a>
			<div class="drop"><img src="<?=ResizeImage($arResult["PAGER"]["PREV"][0]["PREVIEW_PICTURE"], 33, 72, true)?>" alt="<?=$arResult["PAGER"]["PREV"][0]["NAME"]?>"/></div>
		</div>
	<?elseif($arResult["PAGER"]["NEXT"][1]):?>
		<div class="item">
			<a href="<?=$arResult["PAGER"]["NEXT"][1]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["PAGER"]["NEXT"][1]["NAME"]?>">Предыдущий</a>
			<div class="drop"><img src="<?=ResizeImage($arResult["PAGER"]["NEXT"][1]["PREVIEW_PICTURE"], 33, 72, true)?>" alt="<?=$arResult["PAGER"]["NEXT"][1]["NAME"]?>"/></div>
		</div>
	<?endif?>
	<?if($arResult["PAGER"]["NEXT"][0]):?>
		<div class="item">
			<a href="<?=$arResult["PAGER"]["NEXT"][0]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["PAGER"]["NEXT"][0]["NAME"]?>">Следующий</a>
			<div class="drop"><img src="<?=ResizeImage($arResult["PAGER"]["NEXT"][0]["PREVIEW_PICTURE"], 33, 72, true)?>" alt="<?=$arResult["PAGER"]["NEXT"][0]["NAME"]?>"/></div>
		</div>
	<?elseif($arResult["PAGER"]["PREV"][1]):?>
		<div class="item">
			<a href="<?=$arResult["PAGER"]["PREV"][1]["DETAIL_PAGE_URL"]?>" title="<?=$arResult["PAGER"]["PREV"][1]["NAME"]?>">Следующий</a>
			<div class="drop"><img src="<?=ResizeImage($arResult["PAGER"]["PREV"][1]["PREVIEW_PICTURE"], 33, 72, true)?>" alt="<?=$arResult["PAGER"]["PREV"][1]["NAME"]?>"/></div>
		</div>
	<?endif?>
		<a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>" class="btn-transparent">Вернуться к списку товаров</a>
	</div>

</div>
<?if(!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])): // Simple Product?>
<?if(!empty($arResult['MIN_PRICE'])):?>
<section class="section5">

	<div class="section__i clearfix">
		<form class="addtobasket">
			<?/*<div class="property color-block">
				<div class="title">Цвет</div>
				<select class="color">
					<option value="ff5555">ff5555</option>
					<option value="000000">000000</option>
					<option value="ff5555">ff5555</option>
					<option value="000000">000000</option>
				</select>
			</div>
			<div class="property volume-block">
				<div class="title">Объем, мл.</div>
				<select class="volume" >
					<option value="5"></option>
					<option value="5">5</option>
					<option value="10">10</option>
					<option value="15">15</option>
					<option value="20">20</option>
				</select>
			</div>*/?>
		<?if('Y' == $arParams['USE_PRODUCT_QUANTITY']):?>
			<div class="property amount-block">
				<div class="title">Кол-во, шт</div>
				<input type="text" value="1"/>
				<a href="#" class="btn-min"></a>
				<a href="#" class="btn-max"></a>
			</div>
		<?endif?>

		<?if($arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE'] != $arResult['MIN_PRICE']['PRINT_VALUE']):?>
			<div class="old price">
				<span>Старая цена</span>
				<div class="price-i" data-price="<?=$arResult['MIN_PRICE']['VALUE']?>"><?=$arResult['MIN_PRICE']['PRINT_VALUE']?></div>
			</div>
			<div class="new price">
				<span>Новая цена</span>
				<div class="price-i" data-price="<?=$arResult['MIN_PRICE']['VALUE']?>"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
			</div>
		<?else:?>
			<div class="new price">
				<span>Цена</span>
				<div class="price-i" data-price="<?=$arResult['MIN_PRICE']['VALUE']?>"><?=$arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></div>
			</div>
		<?endif?>
		<?if('Y' == $arParams['USE_PRODUCT_QUANTITY']):?>
			<input type="hidden" name="<? echo $arParams["ACTION_VARIABLE"]; ?>" value="ADD2BASKET" />
			<input type="hidden" name="<? echo $arParams["PRODUCT_ID_VARIABLE"]; ?>" value="<? echo $arResult['ID']; ?>" />
			<input type="submit" class="btn-red2" value="купить" />
		<?else:?>
			<a href="<? echo $arResult['ADD_URL']; ?>" class="btn-red2 addtobasket">купить</a>
		<?endif?>
			<a href="<?=$arResult["QUICK_BUY"]?>&ajax=y" class="btn-beige popup_btn fancybox.ajax">заказать в 1 клик</a>
		</form>
	</div>
</section>
<?endif?>
<?endif?>
<?//print_p($arResult);?>
<section class="section6">

	<div class="current__tab js_tab">
		<div class="inner">
			<ul class="clearfix">
				<li class="active"><a href="#">обзор</a></li>
			<?if(strlen($arResult["DETAIL_TEXT"].$arResult["PROPERTIES"]["SPOSOB_PRIMENENIYA"]["VALUE"].$arResult["PROPERTIES"]["SOSTAV"]["VALUE"])):?>
				<li><a href="#">описание</a></li>
			<?endif?>
			<?if(count($arResult["COLOR_ITEMS"])):?>
				<li><a href="#">цвета</a></li>
			<?endif?>
				<li><a href="#" class="comments">отзывы</a></li>
			</ul>
		</div>

	</div>

	<div class="tab-info">

		<ul>
			<li class="active">
				<div class="inner clearfix">
					<div class="inner-left">
						<div class="product-zoom">
							<div class="icon-list">
								<?/*<div class="icon-action">акции</div>*/?>
								<?if($arResult["PROPERTIES"]["IS_NEW"]["VALUE"] == "Y"):?><div class="icon-new">new</div><?endif?>
								<?if($arResult["PROPERTIES"]["IS_HIT"]["VALUE"] == "Y"):?><div class="icon-hit">hit</div><?endif?>
							</div>
						<?if(!empty($arResult["DETAIL_PICTURE"])):?>
							<img class="zoom" src="<?=ResizeImage($arResult["DETAIL_PICTURE"], 410, 470)?>" data-zoom-image="<?=ResizeImage($arResult["DETAIL_PICTURE"], 670, 768)?>"/>
						<?elseif(is_array($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) && count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])):?>
							<img class="zoom" src="<?=ResizeImage($arResult["PROPERTIES"]["PHOTOS"]["VALUE"][0], 410, 470)?>" data-zoom-image="<?=ResizeImage($arResult["PROPERTIES"]["PHOTOS"]["VALUE"][0], 670, 768)?>"/>
						<?endif?>
						</div>
					<?if(is_array($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) && (!empty($arResult["DETAIL_PICTURE"]) && count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) || (count($arResult["PROPERTIES"]["PHOTOS"]["VALUE"]) > 1))):?>
						<div class="gallery clearfix" id="gallery-zoom-product">
						<?if(!empty($arResult["DETAIL_PICTURE"])):?>
							<a href="#" data-image="<?=ResizeImage($arResult["DETAIL_PICTURE"], 410, 470)?>" data-zoom-image="<?=ResizeImage($arResult["DETAIL_PICTURE"], 670, 768)?>">
								<span></span>
								<img src="<?=ResizeImage($arResult["DETAIL_PICTURE"], 71, 71, true)?>" />
							</a>
						<?endif?>
						<?foreach($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $arPhoto):?>
							<a href="#" data-image="<?=ResizeImage($arPhoto, 410, 470)?>" data-zoom-image="<?=ResizeImage($arPhoto, 670, 768)?>">
								<span></span>
								<img src="<?=ResizeImage($arPhoto, 71, 71, true)?>" />
							</a>
						<?endforeach?>
						</div>
					<?endif?>
					</div>
					<div class="inner-right">

						<div class="title"><?=$arResult["PROPERTIES"]["NAME_PROIZVODITELYA"]["VALUE"]?>  <?if(strlen($arResult["PROPERTIES"]["OB_EM"]["VALUE"])):?><span>Объем - <?=$arResult["PROPERTIES"]["OB_EM"]["VALUE"]?> мл</span><?endif?></div>
						<p><?=$arResult["PREVIEW_TEXT"]?></p>
						<!--#VOTE#-->
						<div class="row ">
							<div class="social-likes">

								<div class="widget vkontakte" ></div>

								<div class="widget facebook"></div>

							</div>
						</div>
					<?if(!isset($arResult['OFFERS']) || empty($arResult['OFFERS'])): // Simple Product?>
						<?if(!empty($arResult['MIN_PRICE'])):?>
						<div class="row clearfix">
							<a href="<? echo $arResult['ADD_URL']; ?>" class="btn-red2 addtobasket">купить</a>
							<a href="<?=$arResult["QUICK_BUY"]?>&ajax=y" class="btn-beige popup_btn fancybox.ajax">заказать в 1 клик</a>
						</div>
						<?endif?>
					<?endif?>
					
						<div class="row clearfix">
							<div class="info">
								<div class="title">доставка</div>
								<!--#DELIVERY#-->
								<a href="/delivery_and_pay/?ajax=y" class="btn-other btn-popup2 fancybox.ajax">подробнее</a>
							</div>
							<div class="info">
								<div class="title">оплата</div>
								<p>
									<a class="money" href="#" style="background-image:url(<?=SITE_TEMPLATE_PATH?>/static/img/icons/money-ya.png);width:55px;height:27px;"></a>
									<a class="money" href="#" style="background-image:url(<?=SITE_TEMPLATE_PATH?>/static/img/icons/money-mc.png);width:50px;height:29px;"></a>
									<a class="money" href="#" style="background-image:url(<?=SITE_TEMPLATE_PATH?>/static/img/icons/money-visa.png);width:62px;height:20px;"></a>
								</p>
								<a href="/delivery_and_pay/?ajax=y" class="btn-other btn-popup2 fancybox.ajax">другие способы</a>
							</div>
						</div>
					
					</div>
				</div>
			</li>
		<?if(strlen($arResult["DETAIL_TEXT"].$arResult["PROPERTIES"]["SPOSOB_PRIMENENIYA"]["VALUE"].$arResult["PROPERTIES"]["SOSTAV"]["VALUE"])):?>
			<li>
				<div class="inner clearfix">
					<div class="inner-left">
						<div class="title-sub">Описание</div>
						<?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["DETAIL_TEXT"];?><?if($arResult["DETAIL_TEXT_TYPE"] == "text"):?></p><?endif?>
					<?if(strlen($arResult["PROPERTIES"]["SPOSOB_PRIMENENIYA"]["VALUE"])):?>
						<div class="title-sub">Способ приминения</div>
						<p><?=$arResult["PROPERTIES"]["SPOSOB_PRIMENENIYA"]["~VALUE"]?></p>
					<?endif?>
					</div>
				<?if(strlen($arResult["PROPERTIES"]["SOSTAV"]["VALUE"])):?>
					<div class="inner-right consist">
						<div class="title-sub">Состав</div>
						<p><?=$arResult["PROPERTIES"]["SOSTAV"]["~VALUE"]?></p>
					</div>
				<?endif?>
				</div>
			</li>
		<?endif?>
		<?if(count($arResult["COLOR_ITEMS"])):?>
			<li>
				<div class="inner">
					<div class="title-sub">Выберите цвет</div>
					<p>Для выбора нескольких цветов вам необходимо несколько раз добавлять товар в корзину.</p>
					<div class="color-block clearfix">
					<?foreach($arResult["COLOR_ITEMS"] as $arColor):?>
						<a href="<?=$arColor["DETAIL_PAGE_URL"]?>" class="item" title="<?=$arColor["NAME"]?>" style="background: url('<?=ResizeImage($arColor["PROPERTY_PICT_TONA_VALUE"], 62, 62)?>') no-repeat; background-size: cover;"></a>
					<?endforeach?>
					</div>
				</div>
			</li>
		<?endif?>
			<li>
				<!--#REVIEWS#-->
			</li>
		</ul>
	</div>
</section>