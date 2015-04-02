<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ваша корзина пуста.");
?><section class="section404">
	<h1 class="title-page"><?=$APPLICATION->GetTitle(false)?></h1>
	<a href="/" class="btn-red2">Перейти на главную</a>
</section>
<?/*<div class="shopping-cart">
	<div class="title-page"><?=$APPLICATION->GetTitle(false)?></div>
	<div class="title-page">Ваша корзина пуста.</span></div>
</div>*/?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>