<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<input type="hidden" name="PROFILE_ID" value="<?=$arResult["USER_VALS"]["PROFILE_ID"]?>" />
<?if(count($arResult["PERSON_TYPE"]) > 1):?>
<div class="wrap-item">
	<!--remove active class-->
	<div class="item active">
		<div class="step">0</div>
		<div class="title">Тип платильщика</div>

		<div class="drop middle">
			<div class="item__i">
				<div class="row clearfix">
				<?foreach($arResult["PERSON_TYPE"] as $v):?>
					<div class="wrap-input radio clearfix">
						<input type="radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if($v["CHECKED"]=="Y"):?> checked<?endif?>/>
						<label for="PERSON_TYPE_<?=$v["ID"]?>">
							<p><?=$v["NAME"]?></p></label>
					</div>
				<?endforeach;?>
					<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
				</div>
				<a href="#" class="btn-red2 submit_step">продолжить</a>

			</div>

		</div>

	</div>
</div>
<?else:
	if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0):?>
		<span style="display:none;">
		<input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		<input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
		</span>
	<?else:
		foreach($arResult["PERSON_TYPE"] as $v):?>
			<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
			<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
		<?endforeach;
	endif;
endif;?>