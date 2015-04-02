<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="<?if(strlen($arParams["BLOCK_CLASSES"])):?><?=$arParams["BLOCK_CLASSES"]?><?else:?>section3<?endif?>">
	<?$APPLICATION->IncludeComponent(
		"bitrix:breadcrumb",
		"",
		Array(
			"START_FROM" => "0", 
			"PATH" => "", 
			"SITE_ID" => "" 
		)
	);?>
	<h1 class="title-page"><?=$APPLICATION->ShowTitle(false)?></h1>
</section>
<?include($arResult["FILE"]);?>