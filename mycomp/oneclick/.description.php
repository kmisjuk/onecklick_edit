<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
    "NAME" => GetMessage("MY_COMP_ONE_CLICK_NAME"),
    "DESCRIPTION" => GetMessage("MY_COMP_ONE_CLICK_DESC"),
    "SORT" => 10,
    "CACHE_PATH" => "Y",
    "PATH" => array(
        "ID" => "my_comp",
        "NAME" => GetMessage("MY_COMP_MY_COMP"),
        "CHILD" => array(
            "ID" => "order",
            "NAME" => GetMessage("MY_COMP_ORDERS"),
            "SORT" => 10,
        ),
    ),
);
?>