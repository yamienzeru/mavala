<?
function print_p($val, $name, $die = false, $all = false)
{
	global $USER;
	if ($USER->IsAdmin() || $all)
	{
		echo '<pre>'.(!empty($name) ? $name.': ' : '');print_r($val);echo '</pre>';
	}
	if($die) die;
}
function PriceFormat($price, $count = 0, $currency = "RUB")
{
	if(!$count) return CurrencyFormat($price, $currency);
	else return number_format($val, $count, ",", " ");
}
function getWord($number, $suffix)	//getWord(5, array('[1]минута', '[2]минуты', '[5]минут'));
{
	$keys = array(2, 0, 1, 1, 1, 2);
	$mod = $number % 100;
	$suffix_key = ($mod > 7 && $mod < 20) ? 2: $keys[min($mod % 10, 5)];
	return $suffix[$suffix_key];
}
function ResizeImage($photo, $wi, $hi, $mode, &$arPhoto)	//ResizeImage($arPhoto, 640, 480, true[обрезать]);
{
	if(is_array($photo)) $photo = $photo["ID"];
	if($wi > 0 && $hi > 0)
	{
		$arPhoto = CFile::ResizeImageGet($photo, Array("width" => $wi, "height" => $hi), ($mode ? BX_RESIZE_IMAGE_EXACT : BX_RESIZE_IMAGE_PROPORTIONAL), false, false, false, 85);
		$src = $arPhoto["src"];
	}
	else 
	{
		$arPhoto = CFile::GetFileArray($photo);
		//print_p($arPhoto);
		$src = $arPhoto["SRC"];
	}
	if(!strlen($src)) $src = "/images/noimage.png";
	return $src;
}
function SectionTree($arSections, $SECTION_ID = "", $PARENT_NAME = "IBLOCK_SECTION_ID")
{
	$arTreeList = array();
	foreach($arSections as $arSection)
		if($arSection[$PARENT_NAME] == $SECTION_ID)
		{
			$arSection["SECTIONS"] = SectionTree($arSections, $arSection["ID"]);
			if(!count($arSection["SECTIONS"])) unset($arSection["SECTIONS"]);
			$arTreeList[] = $arSection;
		}
	return $arTreeList;
}
AddEventHandler("main", "OnBuildGlobalMenu", "HideIblock");
function HideIblock(&$aGlobalMenu, &$aModuleMenu)
{
	$arHide = array();
	if(is_array($arHide) && count($arHide) && CModule::IncludeModule("iblock"))
	{
		$res = CIBlock::GetList(Array(), Array("ID" => $arHide));
		$arHide = array();
		while($ar_res = $res->Fetch()) $arHide[$ar_res["ID"]] = $ar_res["IBLOCK_TYPE_ID"];
	}
	if(count($arHide))
		foreach($aModuleMenu as $key1 => $arMenu)
			if($ib = array_search(str_ireplace("menu_iblock_/", "", $arMenu["items_id"]), $arHide))
				foreach($arMenu["items"] as $key2 => $arItem)
					if(in_array(str_ireplace("menu_iblock_/".$arHide[$ib]."/", "", $arItem["items_id"]), array_keys($arHide)))
						unset($aModuleMenu[$key1]["items"][$key2]);
}
AddEventHandler("main", "OnBuildGlobalMenu", "OnceIBlock");
function OnceIBlock(&$aGlobalMenu, &$aModuleMenu)
{
	//print_p($aModuleMenu);die();
	foreach($aModuleMenu as $keyMenu => &$arMenu)
	{
		if($arMenu["module_id"] == "iblock" && is_array($arMenu["items"]) && count($arMenu["items"]) == 1)
		{
			reset($arMenu["items"]);
			$arIblock = current($arMenu["items"]);
			if($arMenu["text"] != $arIblock["text"]) $arIblock["text"] = $arMenu["text"]." (".$arIblock["text"].")";
			if($arMenu["title"] != $arIblock["title"]) $arIblock["title"] = $arMenu["title"]." (".$arIblock["title"].")";
			$arIblock["more_url"] = array_merge($arMenu["more_url"], $arIblock["more_url"]);
			$arIblock["parent_menu"] = $arMenu["parent_menu"];
			$arIblock["sort"] = $arMenu["sort"];
			$arMenu = $arIblock;
		}

	}
}
AddEventHandler("main", "OnBuildGlobalMenu", "QuickOrder");
function QuickOrder(&$aGlobalMenu, &$aModuleMenu)
{
	foreach($aModuleMenu as $key1 => $arMenu)
		if(stripos($arMenu["items_id"], "menu_iblock_/catalog") !== false)
			foreach($arMenu["items"] as $key2 => $arItem)
				if(stripos($arItem["items_id"], "menu_iblock_/catalog/13") !== false)
				{
					$arItem["parent_menu"] = "global_menu_store";
					$arItem["icon"] = "sale_menu_icon_orders";
					$arItem["page_icon"] = "sale_page_icon_orders";
					$arItem["section"] = "catalog_list";
					$arItem["sort"] = 101;
					$arItem["module_id"] = "catalog";
					unset($arItem["skip_chain"]);
					unset($arItem["dynamic"]);
					unset($arItem["items"]);
					$aModuleMenu[] = $arItem;
					//print_p($aModuleMenu[$key1]["items"][$key2]);
					unset($aModuleMenu[$key1]["items"][$key2]);
				}
	//print_p($aModuleMenu);die();
}
function getNextPrevByID($id, $arrSort, $arrFilter) // get the values for the Next and Previous links
{
	$arrSort = is_array($arrSort) && count($arrSort) ? $arrSort : array();
	foreach($arrSort as $sort_by => $sort_order)
		$arrSort[$sort_by] = strtoupper($sort_order) == "ASC" ? "DESC" : "ASC";
	$arrFilter = is_array($arrFilter) && count($arrFilter) ? $arrFilter : array();
	$arReturn = array();
	$res = CIBlockElement::GetByID($id);
	$arResult = $res->GetNext();
	if(isset($arResult["ID"]))
	{
		//WHERE
		$arFilter = array(
			"IBLOCK_ID" => $arResult["IBLOCK_ID"],
			"SECTION_ID" => $arResult["IBLOCK_SECTION_ID"],
			//"ACTIVE_DATE" => "Y",
			"ACTIVE" => "Y",
			"CHECK_PERMISSIONS" => "Y",
		);
		//ORDER BY
		$arSort = array(
			"ID" => "DESC",
		);
		//EXECUTE
		$arReturn["NEXT"] = array();
		$arReturn["PREV"] = array();
		$rsElement = CIBlockElement::GetList(array_merge($arrSort, $arSort), array_merge($arrFilter, $arFilter), false, array("nElementID" => $arResult["ID"], "nPageSize" => 2));
		$end = false;

		while($sElement = $rsElement->GetNextElement())
		{
			$arElement = $sElement->GetFields();
			$arElement["PROPERTIES"] = $sElement->GetProperties();
			if($arElement["ID"]==$arResult["ID"])
			{
				$end = true;
				//$arReturn["CURRENT"]["NO"] = $arElement["RANK"];//???
			}
			elseif($end)
			{
				$arReturn["NEXT"][] = $arElement;
			}
			else
			{
				array_unshift($arReturn["PREV"], $arElement);
			}
		}
	}
	return $arReturn;
}
AddEventHandler("main", "OnEndBufferContent", "ChangeMyContent");
function ChangeMyContent(&$content)
{
	GLOBAL $APPLICATION;
	if($APPLICATION->GetCurPage() == "/bitrix/admin/iblock_list_admin.php" && CModule::IncludeModule("iblock") && $_REQUEST["IBLOCK_ID"] && !$_REQUEST["find_section_section"])
	{
		$arIblockFields = CIBlock::GetFields($_REQUEST["IBLOCK_ID"]);
		if($arIblockFields["IBLOCK_SECTION"]["IS_REQUIRED"] == "Y") $content = str_ireplace("id=\"btn_new\"", "id=\"btn_new\" style=\"display:none;\"", $content);
	}
}
/*AddEventHandler("main", "OnProlog", "OnProlog");
function OnProlog()
{
	$page_404 = "/404.php";
	GLOBAL $APPLICATION;
	if(strpos($APPLICATION->GetCurPage(), $page_404) === false && $_REQUEST["get_status"] != "y")
	{
		$headers = get_headers("http://".$_SERVER["HTTP_HOST"].$APPLICATION->GetCurPageParam("get_status=y", array("get_status")), 1);
		if(strpos($headers[0], "404") !== false)
		{
			$APPLICATION->RestartBuffer();
			CHTTP::SetStatus("404 Not Found");
			include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
			include($_SERVER["DOCUMENT_ROOT"].$page_404);
			//include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");
			die();
		}
	}
}*/
AddEventHandler("main", "OnEpilog", "error_page");
function error_page() {
	$page_404 = "/404.php";
	GLOBAL $APPLICATION;
    if(strpos($APPLICATION->GetCurPage(), $page_404) === false && defined("ERROR_404") ) {
        $APPLICATION->RestartBuffer();
		CHTTP::SetStatus("404 Not Found");
		include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/header.php");
		include($_SERVER["DOCUMENT_ROOT"].$page_404);
		include($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");
		die();
    }
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "addCode");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "addCode");
AddEventHandler("iblock", "OnBeforeIBlockSectionAdd", "addCode");
AddEventHandler("iblock", "OnBeforeIBlockSectionUpdate", "addCode");
function addCode(&$arFields)
{
    if(!strlen($arFields["CODE"]))
		$arFields["CODE"] = Cutil::translit($arFields["NAME"], "ru", array("replace_space"=>"-","replace_other"=>"-"));
}

function GetVideoUrl($url)
{
	$video_url = "";
	if(stripos($url, "vimeo") !== false)
	{
		$video_id = 0;
		$arQuery = explode("/", parse_url($url, PHP_URL_PATH));
		if(is_array($arQuery) && count($arQuery) > 1) $video_id = (int) $arQuery[1];
		if(!$video_id) $video_id = (int) $url;
		$video_url = "http://player.vimeo.com/video/".$video_id."?title=0&amp;byline=0&amp;portrait=0&amp;color=acbe00";
	}
	elseif(stripos($url, "youtube") !== false)
	{
		$v = '';
		parse_str(parse_url($url, PHP_URL_QUERY));
		if(strlen($v)) $video_url = "http://www.youtube.com/embed/".$v;
	}
	if(strlen($video_url)) return $video_url;
	else return false;
}

function SetRequest($field = "", $value = "")
{
	if(strlen($field))
	{
		$_POST[$field] = $_GET[$field] = $_REQUEST[$field] = $value;
	}
}

AddEventHandler('iblock', 'OnAfterIBlockElementAdd', array('ElemSectConnect', 'ESUElementUpdate'));
AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', array('ElemSectConnect', 'ESUElementUpdate'));
AddEventHandler('iblock', 'OnBeforeIBlockElementDelete', array('ElemSectConnect', 'ESUElementDelete'));
AddEventHandler('iblock', 'OnAfterIBlockSectionAdd', array('ElemSectConnect', 'ESUSectionUpdate'));
AddEventHandler('iblock', 'OnAfterIBlockSectionUpdate', array('ElemSectConnect', 'ESUSectionUpdate'));
AddEventHandler('iblock', 'OnBeforeIBlockSectionDelete', array('ElemSectConnect', 'ESUSectionDelete'));
Class ElemSectConnect 
{
	//связь элемента и раздела по xml_id
	function ElemSectUnion($ID, $is_element = true, $is_deleted = false)
	{
		if($ID > 0)
		{
			$arESUnionTmp = $arESUnion = array();
			//$arESUnionTmp[4] = 12;
			//$arESUnionTmp[COption::GetOptionString($MODULE_ID, "STROYKA_OBJECT")] = COption::GetOptionString($MODULE_ID, "STROYKA_ROOMS");
			foreach($arESUnionTmp as $element => $section)
				if(IntVal($element) > 0 && IntVal($section) > 0)
					$arESUnion[$element] = $section;
			$obElement = new CIBlockElement;
			$obSection = new CIBlockSection;
			global $NO_EDIT;
			if($NO_EDIT != "Y")
			{
				$NO_EDIT = "N";
				$name = $arElement["NAME"];
				if($arElement["IBLOCK_SECTION_ID"])
				{
					$arPath = array();
					$nav = CIBlockSection::GetNavChain(false, $arElement["IBLOCK_SECTION_ID"]);
					while($arSectionPath = $nav->GetNext())
						$arPath[] = $arSectionPath["NAME"];
					$arPath[] = $name;
					$name = implode("/", $arPath);
				}
				if($is_element)
				{
					$arElement = $obElement->GetByID($ID)->Fetch();
					if($arElement && in_array($arElement["IBLOCK_ID"], array_keys($arESUnion)))
					{
						$NO_EDIT = "Y";
						$dbSection = $obSection->GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $arESUnion[$arElement["IBLOCK_ID"]], "XML_ID" => $arElement["ID"], "SECTION_ID" => false));
						if($dbSection->SelectedRowsCount() > 0)
						{
		  					$first = true;
		  					while($arSection = $dbSection->GetNext())
		  						if($first && !$is_deleted)
		  						{
		  							$first = false;
									$obSection->Update($arSection["ID"], array("NAME" => $name, "CODE" => $arElement["CODE"], "XML_ID" => $arElement["ID"]));
		  						}
		  						else $obSection->Delete($arSection["ID"]);
						}
		  				else
		  				{
							$obSection->Add(
								Array(
									"ACTIVE" => "Y",
									"IBLOCK_SECTION_ID" => false,
									"IBLOCK_ID" => $arESUnion[$arElement["IBLOCK_ID"]],
									"NAME" => $name,
									"CODE" => $arElement["CODE"],
									"XML_ID" => $arElement["ID"],
								)
							);
		  				}
					}
				}
				else
				{
					$arSection = $obSection->GetByID($ID)->Fetch();
					$arESUnion = array_flip($arESUnion);
					if($arSection && !$arSection["IBLOCK_SECTION_ID"] && in_array($arSection["IBLOCK_ID"], array_keys($arESUnion)))
					{
						$NO_EDIT = "Y";
						$name = end(explode("/", $arSection["NAME"]));
						$dbElement = $obElement->GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $arESUnion[$arSection["IBLOCK_ID"]], "ID" => $arSection["XML_ID"] > 0 ? $arSection["XML_ID"] : false));
						if($dbElement->SelectedRowsCount() > 0)
						{
		  					if(($arElement = $dbElement->GetNext()) && !$is_deleted)
								$obElement->Update($arElement["ID"], array("NAME" => $name, "CODE" => $arSection["CODE"]));
		  					elseif($arSection["XML_ID"] > 0)
		  						$obElement->Delete($arSection["XML_ID"]);
						}
		  				else
		  				{
		  					$arSections = array();
		  					$dbSection = $obSection->GetList(Array("ID" => "ASC"), Array("IBLOCK_ID" => $arSection["IBLOCK_ID"], "SECTION_ID" => false));
		  					while($arSectionTmp = $dbSection->GetNext())
		  						$arSections[] = $arSectionTmp["ID"];
							if($elementID = $obElement->Add(
									Array(
										"ACTIVE" => "Y",
										"IBLOCK_SECTION" => $arSections,
										"IBLOCK_ID" => $arESUnion[$arSection["IBLOCK_ID"]],
										"NAME" => $name,
										"CODE" => $arSection["CODE"],
									)
								)
							)
								$obSection->Update($arSection["ID"], array("XML_ID" => $elementID, "CODE" => $arSection["CODE"]));

		  				}
					}
				}
			}
		}
	}
	
	//OnAfterIBlockElementAdd
	//OnAfterIBlockElementUpdate
	function ESUElementUpdate($arFields)
	{
		self::ElemSectUnion($arFields["ID"]);
	}
	//OnBeforeIBlockElementDelete
	function ESUElementDelete($ID)
	{
		self::ElemSectUnion($ID, true, true);
	}
	//OnAfterIBlockSectionAdd
	//OnAfterIBlockSectionUpdate
	function ESUSectionUpdate($arFields)
	{
		self::ElemSectUnion($arFields["ID"], false);
	}
	//OnBeforeIBlockSectionDelete
	function ESUSectionDelete($ID)
	{
		self::ElemSectUnion($ID, false, true);
	}
	//!связь элемента и раздела по xml_id
}

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("CloseIblock", "OnBeforeIBlockElementAddHandler"));
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", Array("CloseIblock", "OnBeforeIBlockElementDeleteHandler"));
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("CloseIblock", "OnBeforeIBlockElementUpdateHandler"));
AddEventHandler("main", "OnBuildGlobalMenu", Array("CloseIblock", "OnBuildGlobalMenuHandler"));

class CloseIblock
{
	public static $iblocks = array(4, 7, 8, 11);

	function getElementById($id)
	{
		CModule::IncludeModule("iblock");
		return CIBlockElement::GetByID($id)->GetNext();
	}

	function setElementToMenu(&$arMenu)
	{
		CModule::IncludeModule("iblock");
		$arFind = explode("/", $arMenu["items_id"]);
		if($arFind[2] && in_array($arFind[2], self::$iblocks))
		{

			$rsElements = CIBlockElement::GetList(Array(), Array("IBLOCK_ID" => $arFind[2]), false, false, array("ID"));
			if(intval($rsElements->SelectedRowsCount()) == 1)
				foreach($arMenu["more_url"] as $url)
					if(stripos($url, "iblock_element_edit.php") !== false && ($arElement = $rsElements->GetNext()))
						$arMenu["url"] = $url."&WF=Y&find_section_section=0&ID=".$arElement["ID"];
		}
	}

	function OnBeforeIBlockElementAddHandler(&$arFields)
	{
		if(in_array($arFields["IBLOCK_ID"], self::$iblocks))
		{
			global $APPLICATION;
			$APPLICATION->throwException("Инфоблок защищен от редактирования");
			return false;
		}
	}

	function OnBeforeIBlockElementUpdateHandler(&$arFields)
	{
		$arElement = self::getElementById($arFields["ID"]);
		if(in_array($arElement["IBLOCK_ID"], self::$iblocks))
			$arFields["CODE"] = $arElement["CODE"];
	}

	function OnBeforeIBlockElementDeleteHandler($ID)
	{
		$arElement = self::getElementById($ID);
		if(in_array($arElement["IBLOCK_ID"], self::$iblocks))
		{
			global $APPLICATION;
			$APPLICATION->throwException("Инфоблок защищен от редактирования");
			return false;
		}
	}

	function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu)
	{
		foreach($aModuleMenu as &$arMenu)
		{
			if($arMenu["module_id"] == "iblock")
			{
				
				if(self::setElementToMenu($arMenu))
					continue;
				elseif(is_array($arMenu["items"]) && count($arMenu["items"]))
				{
					foreach($arMenu["items"] as &$arIBlock)
					{
						self::setElementToMenu($arIBlock);
					}
				}
			}
		}
	}
}

AddEventHandler("main", "OnProlog", "setFilters");
function setFilters()
{
	global $arrHitFilter;
	$arrHitFilter = array("PROPERTY_IS_HIT_VALUE" => "Y");
}

AddEventHandler("iblock", "OnAfterIBlockElementAdd", "set_ton_img");
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "set_ton_img");

function set_ton_img($arFields)
{
	if($arFields["IBLOCK_ID"] == 12 && $arFields["ID"] > 0)
	{
		CModule::IncludeModule("iblock");
		$arProperties = CIBlockElement::GetByID($arFields["ID"])->GetNextElement()->GetProperties();
		if(!strlen($arProperties["PICT_TONA"]["VALUE"]) && strlen($arProperties["NOMER_TONA"]["VALUE"]) && file_exists($_SERVER['DOCUMENT_ROOT'].'/images/ton/'.intval($arProperties["NOMER_TONA"]["VALUE"]).'.png'))
			CIBlockElement::SetPropertyValuesEx($arFields["ID"], $arFields["IBLOCK_ID"], array("PICT_TONA" => CFile::MakeFileArray($_SERVER['DOCUMENT_ROOT'].'/images/ton/'.intval($arProperties["NOMER_TONA"]["VALUE"]).'.png')));
	}
}

AddEventHandler("main", "OnProlog", "cart_quantity");
function cart_quantity()
{
	global $APPLICATION, $USER;
	if(stripos($APPLICATION->GetCurPage(), "/cart/") !== false && $_SERVER["REQUEST_METHOD"] == "POST")
	{
		CModule::IncludeModule("sale");
		CModule::IncludeModule("catalog");
		foreach($_POST as $id => $quantity)
			if(stripos($id, "QUANTITY_") !== false)
			{
				if($quantity) CSaleBasket::Update((int)(str_ireplace("QUANTITY_", "", $id)), array("QUANTITY" => $quantity));
				else CSaleBasket::Delete((int)(str_ireplace("QUANTITY_", "", $id)));
			}
		$COUPON = Trim($_REQUEST["COUPON"]);
		if (strlen($COUPON) > 0)
			CCatalogDiscount::SetCoupon($COUPON);
		else
			CCatalogDiscount::ClearCoupon();
	}
}

AddEventHandler("main", "OnProlog", "user_props");
function user_props()
{
	global $APPLICATION, $USER;
	if(stripos($APPLICATION->GetCurPage(), "/cart/") !== false)
	{
		CModule::IncludeModule("sale");
		$arOrderProps = array();
		$dbResultList = CSaleOrderProps::GetList(array("SORT" => "ASC"));
		while ($arOrderProp = $dbResultList->Fetch())
			$arOrderProps[$arOrderProp["CODE"]][$arOrderProp["PERSON_TYPE_ID"]] = $arOrderProp["ID"];
		if($_SERVER["REQUEST_METHOD"] != "POST")
		{
			$_SERVER["REQUEST_METHOD"] = "POST";
			SetRequest("confirmorder", "N");
			SetRequest("sessid", bitrix_sessid());
			if($USER->IsAuthorized())
			{
				$arUser = $USER->GetById($USER->GetId())->Fetch();
				if(!IntVal($arUser["PERSONAL_CITY"]) && array_key_exists("PERSONAL_CITY", $arOrderProps))
				{
					$arUser["PERSONAL_CITY"] = 337; //337 - Москва, 348 - Ростов-на-Дону
				}
				foreach($arOrderProps as $user_prop => $arOrderProp)
						foreach($arOrderProp as $person_type => $prop)
							if((($_REQUEST["PERSON_TYPE"] > 0 && $person_type == $_REQUEST["PERSON_TYPE"]) || $_REQUEST["PERSON_TYPE"] <= 0) && !(isset($_REQUEST["ORDER_PROP_".$prop]) || isset($_POST["ORDER_PROP_".$prop])) && isset($arUser[$user_prop]))
									SetRequest("ORDER_PROP_".$prop, $arUser[$user_prop]);
			}
		}
	}
}

AddEventHandler("main", "OnProlog", "del_filter");
function del_filter()
{
	global $APPLICATION;
	if(stripos($APPLICATION->GetCurPage(), "/personal/history/") !== false)
	{
		$_REQUEST["del_filter"] = "Y";
		$_REQUEST["show_all"] = "Y";
	}
}

AddEventHandler("main", "OnBeforeUserRegister", "OnBeforeUserRegisterHandler");
AddEventHandler("main", "OnBeforeUserSimpleRegister", "OnBeforeUserRegisterHandler");
AddEventHandler("main", "OnBeforeUserAdd", "OnBeforeUserRegisterHandler");
AddEventHandler("main", "OnBeforeUserUpdate", "OnBeforeUserRegisterHandler");
function OnBeforeUserRegisterHandler(&$arFields)
{
	if(strlen($arFields["EMAIL"]) && $arFields["ID"] != "1" && $arFields["LOGIN"] != "admin" && $arFields["LOGIN"] != "1c-exchange") $arFields["LOGIN"] = $arFields["EMAIL"];
}

AddEventHandler("main", "OnProlog", "SetUserCity");
function SetUserCity()
{
	if(empty($_SESSION["USER_CITY"]))
	{
		if(CModule::IncludeModule("altasib.geoip"))
		{
			CModule::IncludeModule("sale");
			$currentCity = ALX_GeoIP::GetAddr();
			//$currentCity["city"] = "Владивосток"; //надо убрать
			$_SESSION["USER_CITY"]["NAME"] = $currentCity["city"];
			$rsCityList = CSaleLocation::GetList(
				array(
					"CITY_NAME_LANG" => "ASC",
					"COUNTRY_NAME_LANG" => "ASC",
					"SORT" => "ASC",
				),
				array(
					"!CITY_NAME" => false,
					"~CITY_SHORT_NAME" => $currentCity["city"],
					"LID" => LANGUAGE_ID,
				),
				false,
				array("nTopCount" => 1),
				array(
					"*"
				)
			);
			if($arCity = $rsCityList->GetNext())
				$_SESSION["USER_CITY"]["ID"] = $arCity["ID"];
		}
	}
	elseif(!empty($_REQUEST["USER_CITY_ID"]))
	{
		CModule::IncludeModule("sale");
		if($arCity = CSaleLocation::GetByID($_REQUEST["USER_CITY_ID"], LANGUAGE_ID))
		{
			$_SESSION["USER_CITY"]["ID"] = $arCity["ID"];
			$_SESSION["USER_CITY"]["NAME"] = $arCity["CITY_SHORT_NAME"];
		}
	}
}

AddEventHandler("main", "OnBeforeEventSend", "SetUserPassword");
function SetUserPassword(&$arFields, $arMessage)
{
	if($arMessage["EVENT_NAME"] == "USER_INFO")
	{
		$arFields["PASSWORD"] = randString(8, array(
			"abcdefghijklnmopqrstuvwxyz",
			"ABCDEFGHIJKLNMOPQRSTUVWXYZ",
			"0123456789",
			",.<>/?;:[]{}\\|~!@#\$%^&*()-_+=",
		));
		$user = new CUser;
		$user->Update($arFields["USER_ID"], array("PASSWORD" => $arFields["PASSWORD"], "CONFIRM_PASSWORD" => $arFields["PASSWORD"]));
	}
}
?>