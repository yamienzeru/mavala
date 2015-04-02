<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<section class="section9">
	<div class="cities">
		<div class="title">выберите ваш город
			<div class="wrap-store">
				<strong class="store"><?=$arResult["ITEMS_COUNT"]?></strong>
				магазинов
			</div>
		</div>

		<div class="wrap-select">
			<select id="city-select">
				<option value="all">Все города</option>
			<?foreach($arResult["SECTIONS"] as $arSection):?>
				<?$this->AddEditAction('section_'.$arSection['ID'], $arSection['ADD_ELEMENT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "ELEMENT_ADD"), array('ICON' => 'bx-context-toolbar-create-icon'));
				$this->AddEditAction('section_'.$arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
				$this->AddDeleteAction('section_'.$arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BPS_SECTION_DELETE_CONFIRM')));?>
				<option value="city<?=$arSection["ID"]?>" id="<?=$this->GetEditAreaId('section_'.$arSection['ID']);?>"><?=$arSection["NAME"]?></option>
			<?endforeach?>
			</select>
		</div>
	</div>

</section>

<div class="wrap-map where-buy">
	<div id="map"></div>
</div>

<script>
	var locations = <?=$arResult["MAP_JSON"]?>;
	console.log(locations);
</script>