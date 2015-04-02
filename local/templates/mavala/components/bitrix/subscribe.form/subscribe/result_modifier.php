<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($_SERVER["REQUEST_METHOD"] == "POST" && check_bitrix_sessid())
{
	//print_p($_REQUEST);
	$arFields = Array(
        "USER_ID" => ($USER->IsAuthorized() ? $USER->GetID() : false),
        "FORMAT" => "html",
        "EMAIL" => $_REQUEST["EMAIL"],
        "ACTIVE" => "Y",
        "RUB_ID" => $_REQUEST["RUB_ID"],
        "SEND_CONFIRM" => "N"
    );
    $obSubscription = new CSubscription;
    $arResult["ID"] = $obSubscription->Add($arFields);
    if($arResult["ID"] <= 0)
    	$arResult["ERROR"] = $obSubscription->LAST_ERROR;
}
?>