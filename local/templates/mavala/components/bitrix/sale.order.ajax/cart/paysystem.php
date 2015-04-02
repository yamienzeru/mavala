<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="wrap-item">
	<!--remove active class-->
	<div class="item<?if($arResult["PROP_GROUPS"][3]["CHECKED"] == "Y"):?> active<?endif?>">
		<div class="step">4</div>
		<div class="title">Выберите способ оплаты</div>
	<?if($arResult["PROP_GROUPS"][3]["CHECKED"] == "Y"):?>
		<div class="drop middle">
			<div class="item__i">
				<div class="row clearfix">
				<?foreach($arResult["PAY_SYSTEM"] as $arPaySystem):?>
					<div class="wrap-input radio clearfix">
						<input type="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>" <?if ($arPaySystem["CHECKED"]=="Y" && !($arParams["ONLY_FULL_PAY_FROM_ACCOUNT"] == "Y" && $arResult["USER_VALS"]["PAY_CURRENT_ACCOUNT"]=="Y")) echo " checked=\"checked\"";?>/>
						<label for="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>">
							<p><?=$arPaySystem["NAME"];?></p></label>
					</div>
				<?endforeach?>
				</div>
				<?/*<a href="javascript:void(0);" class="btn-red2 submit_step">продолжить</a>*/?>

			</div>

		</div>
	<?endif?>
	</div>
</div>