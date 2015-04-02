<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form class="menu filters ajax_filter" action="<?echo $arResult["FORM_ACTION"]?>" method="get" >
<?foreach($arResult["HIDDEN"] as $arItem):?>
	<input
		type="hidden"
		name="<?echo $arItem["CONTROL_NAME"]?>"
		id="<?echo $arItem["CONTROL_ID"]?>"
		value="<?echo $arItem["HTML_VALUE"]?>"
	/>
<?endforeach;?>
	<div class="title">фильтры</div>
<?foreach($arResult["PRICES"] as $arItem)
	if($arItem["VALUES"]["MIN"]["VALUE"] != $arItem["VALUES"]["MAX"]["VALUE"]):?>
	<div class="item">
		<a href="#" class="filter-title"><?if(count($arResult["PRICES"]) > 1):?><?=$arItem["NAME"]?><?else:?>Цена<?endif?>: <span></span></a>
		<div class="drop">
			<div class="price">
				<div class="wrap clearfix">
					<input type="text" class="minCost" value="<?=IntVal(strlen($arItem["VALUES"]["MIN"]["HTML_VALUE"]) ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"])?>" name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>">
					<input type="text" class="maxCost" value="<?=IntVal(strlen($arItem["VALUES"]["MAX"]["HTML_VALUE"]) ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"])?>" name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>">
				</div>
				<div class="slider-price" data-max="<?=IntVal($arItem["VALUES"]["MAX"]["VALUE"])?>" data-min="<?=IntVal($arItem["VALUES"]["MIN"]["VALUE"])?>" data-step="1"></div>
			</div>
		</div>
	</div>
	<?endif?>
			<?/*elseif(!empty($arItem["VALUES"])):;?>
			<li class="lvl1"> <a href="#" onclick="BX.toggle(BX('ul_<?echo $arItem["ID"]?>')); return false;" class="showchild"><?=$arItem["NAME"]?></a>
				<ul id="ul_<?echo $arItem["ID"]?>">
					<?foreach($arItem["VALUES"] as $val => $ar):?>
					<li class="lvl2<?echo $ar["DISABLED"]? ' lvl2_disabled': ''?>"><input
						type="checkbox"
						value="<?echo $ar["HTML_VALUE"]?>"
						name="<?echo $ar["CONTROL_NAME"]?>"
						id="<?echo $ar["CONTROL_ID"]?>"
						<?echo $ar["CHECKED"]? 'checked="checked"': ''?>
						onclick="smartFilter.click(this)"
					/><label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"];?></label></li>
					<?endforeach;?>
				</ul>
			</li>
			<?endif;*/?>

<?if(count($arResult["ITEMS"]["IS_NEW"]["VALUES"]) || count($arResult["ITEMS"]["IS_HIT"]["VALUES"])):?>
	<div class="item">
		<a href="#" class="filter-title">Статус:<span></span></a>
		<div class="drop">
			<div class="check-list">
				<?/*<div class="row">
					<input type="checkbox" class="check-input" id="check1"/>
					<label for="check1">Акции
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>
				</div>*/?>
			<?if(count($arResult["ITEMS"]["IS_HIT"]["VALUES"])):?>
				<div class="row">
				<?foreach($arResult["ITEMS"]["IS_HIT"]["VALUES"] as $val => $ar)
				if($ar["VALUE"] == "Y"):?>
					<input type="checkbox" class="check-input" name="<?echo $ar["CONTROL_NAME"]?>" value="<?echo $ar["HTML_VALUE"]?>" id="<?echo $ar["CONTROL_ID"]?>" <?echo $ar["CHECKED"]? 'checked="checked"': ''?> <?echo $ar["DISABLED"]? 'disabled="disabled"': ''?>/>
					<label for="<?echo $ar["CONTROL_ID"]?>">Хиты
						<?/*<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>*/?>
					</label>
				<?endif?>
				</div>
			<?endif?>
			<?if(count($arResult["ITEMS"]["IS_NEW"]["VALUES"])):?>
				<div class="row">
				<?foreach($arResult["ITEMS"]["IS_NEW"]["VALUES"] as $val => $ar)
				if($ar["VALUE"] == "Y"):?>
					<input type="checkbox" class="check-input" name="<?echo $ar["CONTROL_NAME"]?>" value="<?echo $ar["HTML_VALUE"]?>" id="<?echo $ar["CONTROL_ID"]?>" <?echo $ar["CHECKED"]? 'checked="checked"': ''?> <?echo $ar["DISABLED"]? 'disabled="disabled"': ''?>/>
					<label for="<?echo $ar["CONTROL_ID"]?>">Новинки
						<?/*<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>*/?>
					</label>
				<?endif?>
				</div>
			<?endif?>
			</div>
		</div>
	</div>
<?endif?>

<?if(count($arResult["ITEMS"]["OB_EM"]["VALUES"])):?>
	<div class="item">
		<a href="#" class="filter-title">Объем (мл)<span></span></a>
		<div class="drop">
			<div class="check-list">
			<?foreach($arResult["ITEMS"]["OB_EM"]["VALUES"] as $val => $ar):?>
				<div class="row">
					<input type="checkbox" class="check-input" name="<?echo $ar["CONTROL_NAME"]?>" value="<?echo $ar["HTML_VALUE"]?>" id="<?echo $ar["CONTROL_ID"]?>" <?echo $ar["CHECKED"]? 'checked="checked"': ''?> <?echo $ar["DISABLED"]? 'disabled="disabled"': ''?>/>
					<label for="<?echo $ar["CONTROL_ID"]?>"><?echo $ar["VALUE"]?>
						<?/*<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>*/?>
					</label>
				</div>
			<?endforeach?>
			</div>
		</div>
	</div>
<?endif?>
	<?/*<div class="item">
		<a href="#" class="filter-title">Разновидность<span></span></a>

		<div class="drop">
			<div class="check-list">

				<div class="row">

					<input type="checkbox" class="check-input" id="check4"/>

					<label for="check4">Акции
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check5"/>

					<label for="check5">Хиты
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check6"/>

					<label for="check6">Новинки
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>

			</div>
		</div>
	</div>
	<div class="item">
		<a href="#" class="filter-title">Цвет<span></span></a>

		<div class="drop">
			<div class="check-list">

				<div class="row">

					<input type="checkbox" class="check-input" id="check7"/>

					<label for="check7">Акции
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check8"/>

					<label for="check8">Хиты
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check9"/>

					<label for="check9">Новинки
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>

			</div>
		</div>
	</div>
	<div class="item">
		<a href="#" class="filter-title">Состав<span></span></a>

		<div class="drop">
			<div class="check-list">

				<div class="row">

					<input type="checkbox" class="check-input" id="check10"/>

					<label for="check10">Акции
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check11"/>

					<label for="check11">Хиты
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>
				<div class="row">

					<input type="checkbox" class="check-input" id="check12"/>

					<label for="check12">Новинки
						<div class="prompt">Найдено <b>12</b> товаров <a href="#">Показать</a></div>
					</label>


				</div>

			</div>
		</div>
	</div>*/?>
	<input type="submit" id="set_filter" class="btn-red2 ajax_hide" name="set_filter" value="Показать" />

	<a href="<?echo $arResult["FORM_ACTION"]?>" class="remove-filter ajax_refresh"<?if(!strlen($_REQUEST["set_filter"])):?> style="display:none;"<?endif?>>сбросить все фильтры</a>

</form>