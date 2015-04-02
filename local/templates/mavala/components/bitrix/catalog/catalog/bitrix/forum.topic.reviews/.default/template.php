<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="inner">
<?if (empty($arResult["ERROR_MESSAGE"]) && !empty($arResult["OK_MESSAGE"])):?>
	<p><?=$arResult["OK_MESSAGE"]?></p>
<?endif;?>
<?if (!empty($arResult["ERROR_MESSAGE"])):?>
	<p><?=$arResult["ERROR_MESSAGE"]?></p>
<?endif;?>
	<div class="comment-list">
	<?if(empty($arResult["MESSAGES"])):?>
		<p>Комментариев пока никто не оставлял</p>
	<?else:?>
	<?foreach ($arResult["MESSAGES"] as $res):?>
		<div class="row clearfix" id="message<?=$res['ID']?>">
			<div class="left">
				<div class="info">
					<span class="photo"></span>
					<span class="name"><?=$res["AUTHOR_NAME"]?></span>
					<span class="date"><?=$res["POST_DATE"]?></span>
				</div>
				<?/*<p class="rating"><i class="star active"></i><i class="star active"></i><i class="star active"></i><i class="star"></i><i class="star"></i>
					<span class="number">(3.5)</span>
				</p>*/?>
			</div>
			<div class="right">
				<p>
					<?=$res["POST_MESSAGE_TEXT"]?>
				</p>
			</div>
		</div>
	<?endforeach;?>
		<?=$arResult["NAV_STRING"]?>
		<?/*<div class="amount"><b>28</b> отзывов</div>
		<a href="#" class="btn-more">загрузить больше отзывов</a>*/?>
	<?endif?>
		<a href="#" class="btn-beige">написать отзыв</a>
	</div>
</div>

<form class="comment-form" name="REPLIER<?=$arParams["form_index"]?>" id="REPLIER<?=$arParams["form_index"]?>" action="<?=POST_FORM_ACTION_URI?>#comments" method="POST">
	<input type="hidden" name="back_page" value="<?=$arResult["CURRENT_PAGE"]?>" />
	<input type="hidden" name="ELEMENT_ID" value="<?=$arParams["ELEMENT_ID"]?>" />
	<input type="hidden" name="SECTION_ID" value="<?=$arResult["ELEMENT_REAL"]["IBLOCK_SECTION_ID"]?>" />
	<input type="hidden" name="save_product_review" value="Y" />
	<input type="hidden" name="preview_comment" value="N" />
	<?=bitrix_sessid_post()?>
	<div class="comment-form__i">
		<div class="title-page">Ваш отзыв</div>
		<a href="#" class="close"></a>
		<?if (!$arResult["IS_AUTHORIZED"]):?>
		<div class="row">
			<input type="text" placeholder="Имя" name="REVIEW_AUTHOR" id="REVIEW_AUTHOR<?=$arParams["form_index"]?>" value="<?=$arResult["REVIEW_AUTHOR"]?>" />
			<div class="title">ВАШЕ МНЕНИЕ <br/>ОЧЕНЬ ВАЖНО ДЛЯ НАС</div>
		</div>
		<?else:?>
			<div class="title">ВАШЕ МНЕНИЕ <br/>ОЧЕНЬ ВАЖНО ДЛЯ НАС</div>
		<?endif;?>
	<?if(strLen($arResult["CAPTCHA_CODE"]) > 0):?>
		<div class="row">
			<input class="f-field" type="text" size="15" placeholder="Код с картинки" name="captcha_word" maxlength="50" value="" autocomplete="off" />
			<input type="hidden" name="captcha_code" value="<?=$arResult["CAPTCHA_CODE"]?>" />
			<img class="b-captcha__image" src="/bitrix/tools/captcha.php?captcha_code=<?=$arResult["CAPTCHA_CODE"]?>" alt="" />
		</p>
	<?endif?>
		<?/*<div class="row">
			<input type="text" placeholder="Ваш e-mail"/>
		</div>*/?>
		<div class="row">
			<textarea placeholder="Ваш отзыв" name="REVIEW_TEXT" id="REVIEW_TEXT<?=$arParams["form_index"]?>"><?=$arResult["REVIEW_TEXT"]?></textarea>
		</div>
		<?/*<p>Оцените качество продукта</p>
		<p class="rating">
			<i class="star-large active"></i><i class="star-large active"></i><i class="star-large  active"></i><i class="star-large "></i><i class="star-large "></i>
			<span class="number">(4.8)</span>
		</p>*/?>
		<input type="submit" name="send_button" class="btn-send" value="отправить" />
	</div>
</form>