<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p>ваш город: <a href="#" class="city city_name"><?=$arResult["USER_CITY_NAME"]?></a></p>

<div class="instruction-city">
	<div class="sub-item">
		<p>Ваш город - <br/> <span class="city_name"><?=$arResult["USER_CITY_NAME"]?></span>?</p>
		<a href="#" class="yes">ДА</a><a href="#" class="no">НЕТ</a>
	</div>
	<div class="sub-item">
		<p><b>Самовывоз</b> от 79 руб. улица Суворова 12</p>

		<p><b>Курьером </b>от 223 руб. Boxberry</p>
		<a href="#" class="more">подробнее</a>
		<a href="#" class="btn-transparent yestono">сменить город</a>
	</div>
	<div class="sub-item">
		<p>Укажите Ваш город</p>
		<div class="wrap-input">
			<input class="dark field autocomplete" data-url="<?=str_replace(array("\\", $_SERVER["DOCUMENT_ROOT"], $this->__name), array("/", "", ".default"), __DIR__)?>/search.php" size="<?=$arParams["SIZE1"]?>" name="<?echo $arParams["CITY_INPUT_NAME"]?>" value="" type="text" autocomplete="off" data-val="" placeholder="Выберите город" />
		</div>
	</div>
</div>