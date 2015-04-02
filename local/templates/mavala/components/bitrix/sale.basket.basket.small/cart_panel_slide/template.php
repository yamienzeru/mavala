<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["NUM_PRODUCTS"]):?>
<a href="<?=$arParams["PATH_TO_BASKET"]?>" class="bag"><span><?=$arResult["NUM_PRODUCTS"]?></span>корзина</a>
<?else:?>
<div class="status">Ваша корзина пока пуста</div>
<a href="/catalog/">перейти в каталог</a>
<?endif?>