<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if(!$arResult["NavShowAlways"])
{
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
		return;
}

//echo "<pre>"; print_r($arResult);echo "</pre>";

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");

?>

<?if($arResult["NavPageCount"] > 1):?>
<div class="control-round">
	<?if($arResult["nStartPage"] > 1):?>
		<a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
		<span>&#8230</span>
	<?endif?>
	<?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
		<a href="<?if($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?><?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?><?else:?><?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?><?endif?>"<?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?> class="active"<?endif?>><?=$arResult["nStartPage"]?></a>
		<?$arResult["nStartPage"]++?>
	<?endwhile?>
	<?if($arResult["nEndPage"] < $arResult["NavPageCount"]):?>
		<span>&#8230</span>
		<a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
	<?endif?>
</div>
<?endif;?>