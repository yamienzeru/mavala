<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="header-contacts">
	<div class="breadcrumbs clearfix">
		<a href="/">Главная страница</a>
		<a href="<?=$APPLICATION->GetCurPage()?>" class="active"><?=$APPLICATION->GetTitle(false)?></a>
	</div>

	<h1 class="title-page"><?=$APPLICATION->GetTitle(false)?></h1>

	<div class="office-item">
		<div class="title"><?if($arResult["PREVIEW_PICTURE"]):?><img src="<?=ResizeImage($arResult["PREVIEW_PICTURE"], 61*3, 61)?>" alt="moscowr"/><?endif?><?echo $arResult["NAME"];?></div>
		<?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?><p><?endif?><?echo $arResult["PREVIEW_TEXT"];?><?if($arResult["PREVIEW_TEXT_TYPE"] == "text"):?></p><?endif?>
	</div>
<?if(is_array($arResult["PROPERTIES"]["HOW_TO_GET"]["VALUE"]) && count($arResult["PROPERTIES"]["HOW_TO_GET"]["VALUE"])):?>
	<div class="info">
		<div class="title">Как к нам добраться?</div>
	<?foreach($arResult["PROPERTIES"]["HOW_TO_GET"]["~VALUE"] as $keyItem => $text):
		$name = $arResult["PROPERTIES"]["HOW_TO_GET"]["DESCRIPTION"][$keyItem];?>
		<div class="title-sub"><?=$name?></div>
		<?if($text["TYPE"] == "text"):?><p><?endif?><?echo $text["TEXT"];?><?if($text["TYPE"] == "text"):?></p><?endif?>
	<?endforeach?>
	</div>
<?endif?>
</div>

<?if(strlen($arResult["PROPERTIES"]["MAP"]["VALUE"])):?>
<?list($data_y, $data_x) = explode(",", $arResult["PROPERTIES"]["MAP"]["VALUE"]);?>
<script>
    var contactCoordinates = [<?=$data_y?>,<?=$data_x?>];
    var contactIcon = '<?=SITE_TEMPLATE_PATH?>/static/img/marker-city.png';
</script>
<div class="wrap-map contacts">
	<div id="map"></div>
</div>
<?endif?>