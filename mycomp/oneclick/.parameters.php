<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentParameters = array(
    "PARAMETERS" => array(
        "PLACE_COMP" => array(
            "PARENT" => "BASE",
            "NAME" => GetMessage("MY_COMP_ONE_CLICK_PARAM_PLACE"),
            "TYPE" => "LIST",
            "VALUES" => array("DETAIL" => GetMessage("MY_COMP_ONE_CLICK_PARAM_DETAIL"), "BASKET" => GetMessage("MY_COMP_ONE_CLICK_PARAM_BASKET")),
            "DEFAULT" => "BASKET",
            "REFRESH" => "Y",
        ),
    ),
);
if ($arCurrentValues["PLACE_COMP"] == "DETAIL")
{
    $arComponentParameters["PARAMETERS"]["PRODUCT_ID"] = array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("MY_COMP_ONE_CLICK_PARAM_PRODUCT_ID"),
        "TYPE" => "STRING",
        "DEFAULT" => '={empty($arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["ID"]) ? $arResult["ID"] : $arResult["OFFERS"][$arResult["OFFERS_SELECTED"]]["ID"]}',
    );
    $arComponentParameters['PARAMETERS']['QUANTITY_NAME'] = array(
        "PARENT" => "BASE",
        "NAME" => GetMessage("MY_COMP_ONE_CLICK_PARAM_PRODUCT_QUANTITY"),
        "TYPE" => "STRING",
        "DEFAULT" => "product-item-amount-field",
    );
}
?>