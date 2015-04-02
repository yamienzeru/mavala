<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<form action="/catalog/" class="form-search">
	<div class="wrap-input">
		<input type="text" name="q" value="<?=$_REQUEST["q"]?>" placeholder="Поиск" />
		<input type="submit" class="btn-search" value="">
	</div>
</form>