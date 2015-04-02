<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (isset($_REQUEST["backurl"]) && strlen($_REQUEST["backurl"])>0) 
	LocalRedirect($backurl);

$APPLICATION->SetTitle("Вход на сайт");
?>
<div class="popup"<?if($_REQUEST["ajax"] != "y"):?> style="width: 100%;"<?endif?>>
	<div class="title"><img src="<?=SITE_TEMPLATE_PATH?>/static/img/icons/unknow.png" alt="unknow"/>вход</div>
<?if($_REQUEST["ajax"] == "y"):?>
	<a href="#" class="btn-close"></a>
<?endif?>

	<p class="p-btm">Вы успешно авторизовались.
	<br />Можете совершать покупки или
	<br />Вернуться на <a href="/">главную страницу</a></p>
<?if($_REQUEST["ajax"] == "y"):?>
	<div class="wrap-btn">
		<a href="#" class="btn-transparent reload_btn small fancybox.ajax">ok</a>
	</div>
<?endif?>
</div>
<?if($_REQUEST["ajax"] == "y"):?>
<script>
	setTimeout(function(){
			location.reload();
		},1500);
</script>
<?endif?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>