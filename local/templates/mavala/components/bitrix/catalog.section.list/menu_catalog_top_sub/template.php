<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="sub-menu-list">
	<a href="#" class="btn-close"></a>
	<ul>
	<?foreach($arResult["SECTIONS_TREE"] as $arSection):?>
		<?$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);?>
		<li class="item" id="<?=$this->GetEditAreaId($arSection['ID'])?>">
		<?if(is_array($arSection["SECTIONS"]) && count($arSection["SECTIONS"])):?>
			<div class="inner clearfix">
				<div class="left">
					<h2 class="title">красота <br/>на кончиках <br/>пальцев</h2>
					<?if($arSection["PICTURE"]):?><img src="<?=ResizeImage($arSection["PICTURE"], 275, 258)?>" alt=""/><?endif?>
				</div>
				<div class="right">
					<div class="sub-menu clearfix">
						<ul>
							<li class="title"><?=$arSection["NAME"]?>:</li>
						<?foreach($arSection["SECTIONS"] as $arSubSection):?>
							<?$this->AddEditAction($arSubSection['ID'], $arSubSection['EDIT_LINK'], $arSubSection);?>
							<li><a href="<?=$arSubSection["SECTION_PAGE_URL"]?>"<?if(stripos($arParams["CURRENT_SECTION"], $arSubSection["SECTION_PAGE_URL"]) !== false):?> class="active"<?endif?>><?=$arSubSection["NAME"]?></a></li>
						<?endforeach?>
						</ul>
					<?if(is_array($arSection["ADVICES"]) && count($arSection["ADVICES"])):?>
						<ul>
							<li class="title">советы дженни:</li>
						<?foreach($arSection["ADVICES"] as $arItem):?>
							<li><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></li>
						<?endforeach?>
						</ul>
					<?endif?>
					</div>
				</div>
			</div>
		<?endif?>
		</li>
	<?endforeach?>
	</ul>
</div>