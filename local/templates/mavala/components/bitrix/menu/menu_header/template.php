<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?foreach($arResult as $arItem) if($arItem["DEPTH_LEVEL"] = 1):?>
<a href="<?=$arItem["LINK"]?>" class="<?if($arItem["SELECTED"]):?>active<?endif?><?if(stripos($arItem["LINK"], "ajax=y") !== false):?> btn-popup2 fancybox.ajax<?endif?>"><?=$arItem["TEXT"]?></a>
<?endif?>
<?endif?>