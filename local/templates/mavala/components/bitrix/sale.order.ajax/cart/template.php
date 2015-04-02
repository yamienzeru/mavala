<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<style type="text/css">
.fixed-spinner {
    background: url("<?=SITE_TEMPLATE_PATH?>/static/img/fancybox_loading.gif") no-repeat scroll 50% 50%;
    /*border-radius: 36px;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);*/
    display: none;
    height: 71px;
    left: 50%;
    margin: -35px 0 0 -35px;
    position: fixed;
    top: 50%;
    width: 71px;
    z-index: 500;
}
</style>
<!-- Cart -->
<?if(IntVal($arResult["ORDER_ID"])):?>
<div class="shopping-cart">
	<div class="title-page"><?=$APPLICATION->GetTitle(false)?></div>
	<div class="title-page">Ваша корзина пуста.</span></div>
</div>
<?else:?>
<?if($_POST["is_ajax_post"] != "Y"):?>
<form class="shopping-cart cart" action="<?=$APPLICATION->GetCurPage();?>" method="POST" name="ORDER_FORM" id="user-form">
<?else:
	$APPLICATION->RestartBuffer();?>
<?endif;?>
	<div class="title-page"><?=$APPLICATION->GetTitle(false)?></div>
<?if(is_array($arResult["BASKET_ITEMS"]) && count($arResult["BASKET_ITEMS"])):?>
	<?=bitrix_sessid_post()?>
	<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/cart.php");?>
	<div class="user-form">

		<div class="title-page">оформляем! <span>Это легко и быстро! Занимает в среднем не больше 3 минут</span></div>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/person_type.php");?>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");?>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");?>
		<?include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");?>

		<div class="end">

			<?/*print_p($arResult);?>

			<?if($arResult["ORDER_PRICE_FORMATED"] != $arResult["PRICE_WITHOUT_DISCOUNT"]):?><p>цена без учета скидок: 30 520 р. цена доставки: <?=$arResult["DELIVERY_PRICE_FORMATED"]?> скидка: <?=$arResult["DISCOUNT_PRICE_PERCENT_FORMATED"]?> - <?=$arResult["~DISCOUNT_PRICE"]?> р.</p><?endif*/?>

			<div class="cost">
				<div class="title">итого с учетом доставки:</div>
				<span><?=(strlen($arResult["ORDER_TOTAL_PRICE_FORMATED"]) ? $arResult["ORDER_TOTAL_PRICE_FORMATED"] : $arResult["ORDER_PRICE_FORMATED"])?></span>
			</div>

		<?if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y"):?>
			<div class="wrap">
				<span class="circle">!</span>
			<?foreach($arResult["ERROR"] as $v):?>
				<p> <?=$v?></p>
			<?endforeach?>
			</div>
		<?endif?>
		<?if($arResult["PROP_GROUPS"][3]["CHECKED"] == "Y"):?>
			<input class="btn-red2" type="submit" name="submitbutton" id="confirmorder" value="подтверждаю заказ">
		<?endif?>
			<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
			<input type="hidden" name="profile_change" id="profile_change" value="N">
			<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="N">
		</div>

	</div>
<?endif;?>
<?if($_POST["is_ajax_post"] != "Y"):?>
</form>
<?else:?>
	<?die();
endif;?>

<?endif?>
<!--/Cart -->
