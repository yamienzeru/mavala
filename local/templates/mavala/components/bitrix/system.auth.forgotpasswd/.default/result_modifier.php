<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$arParamsToDelete = array(
	"login",
	"logout",
	"register",
	"forgot_password",
	"change_password",
	"confirm_registration",
	"confirm_code",
	"confirm_user_id",
	"logout_butt",
	"auth_service_id",
);

$currentUrl = $APPLICATION->GetCurPageParam("", $arParamsToDelete);

$arResult["BACKURL"] = $currentUrl;

if(!$USER->IsAuthorized())
{
	if(defined("AUTH_404"))
		$arResult["AUTH_URL"] = htmlspecialcharsback(POST_FORM_ACTION_URI);
	else
		$arResult["AUTH_URL"] = $APPLICATION->GetCurPageParam("forgot_password=yes", array_merge($arParamsToDelete, array("logout_butt", "backurl")));
}
else //if(!$USER->IsAuthorized())
{
	$arResult["AUTH_URL"] = $currentUrl;
}
?>