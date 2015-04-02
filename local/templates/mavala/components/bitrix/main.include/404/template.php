<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["FILE"] <> ''):?>
<section class="section404">
	<span>404</span>
	<h1 class="title-page"><?include($arResult["FILE"]);?></h1>
	<a href="/" class="btn-red2">Перейти на главную</a>
</section>
<?endif?>