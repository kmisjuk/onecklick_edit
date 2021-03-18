<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Currency\CurrencyManager;
use Bitrix\Main\Context;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\Loader;
use Bitrix\Sale\Basket;
use Bitrix\Sale\Fuser;
use Bitrix\Sale\Order;

class OneclickComponent extends CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable
{
    public function configureActions(): array
    {
        return array(
            "addDetail" => array(
                "-prefilters" => array(
                    ActionFilter\Authentication::class,
                ),
            ),
            "addBasket" => array(
                "-prefilters" => array(
                    ActionFilter\Authentication::class,
                ),
            ),
            "loadModal" => array(
                "-prefilters" => array(
                    ActionFilter\Authentication::class,
                ),
            ),
        );
    }

    public function loadModalAction($templateFolder)
    {
        return include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/modal.php");
    }

    public function addDetailAction($productID, $productQuantity, $phoneNumber)
    {
        Loader::includeModule("sale");
        Loader::includeModule("catalog");
        $basket = Basket::create(SITE_ID);
        $item = $basket->createItem("catalog", $productID);
        $item->setFields(
            array(
                "QUANTITY" => $productQuantity,
                "CURRENCY" => CurrencyManager::getBaseCurrency(),
                "LID" => Context::getCurrent()->getSite(),
                "PRODUCT_PROVIDER_CLASS" => "CCatalogProductProvider",
            )
        );
        return $this->createOrder($basket, $phoneNumber);
    }

    public function addBasketAction($phoneNumber)
    {
        Loader::includeModule("sale");
        $basket = Basket::loadItemsForFUser(Fuser::getId(),SITE_ID);
        return $this->createOrder($basket, $phoneNumber);
    }

    public function createOrder($basket, $phoneNumber): array
    {
        $order = Order::create(SITE_ID, $this->getUserId());
        $order->setPersonTypeId(1);
        $order->setBasket($basket);
        $propertyCollection = $order->getPropertyCollection();
        $phonePropValue = $propertyCollection->getPhone();
        $phonePropValue->setValue($phoneNumber);
        $propertyValue = $propertyCollection->createItem(
            array(
                "NAME" => GetMessage("MY_COMP_ONE_CLICK_STORE_1_CLICK"),
                "TYPE" => "STRING",
                "CODE" => "ONECLICK",
            )
        );
        $propertyValue->setField("VALUE", GetMessage("MY_COMP_ONE_CLICK_YES"));
        $result = $order->save();
        if($result->isSuccess())
        {
            return array(
                "text" => GetMessage("MY_COMP_ONE_CLICK_ORDER_TRUE"),
                "class" => ""
            );
        }
        else
        {
            return array(
                "text" => GetMessage("MY_COMP_ONE_CLICK_ORDER_FALSE"),
                "class" => "error"
            );
        }
    }

    public function getUserId()
    {
        global $USER;
        if($USER->isAuthorized())
        {
            $ID = $USER->GetID();
        }
        else
        {
            $filter = array(
                "=EMAIL" => "oneclick@component.guest",
            );
            $rsUsers = CUser::GetList(
                $by = "id",
                $order = "desc",
                $filter,
                Array(
                    "FIELDS" => array("ID")
                )
            );
            if($arUser = $rsUsers->GetNext())
            {
                $ID = $arUser["ID"];
            }
            else
            {
                $password = $this->getPassword();
                $user = new CUser;
                $arFields = array(
                    "NAME" => "Guest",
                    "EMAIL" => "oneclick@component.guest",
                    "LOGIN" => "oneclick@component.guest",
                    "ACTIVE" => "Y",
                    "PASSWORD" => $password,
                    "CONFIRM_PASSWORD" => $password,
                );
                $ID = $user->Add($arFields);
            }
        }
        return $ID;
    }

    public function getPassword($length = 20): string
    {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $size = strlen($chars) - 1;
        $password = "";
        while($length--)
        {
            $password .= $chars[random_int(0, $size)];
        }
        return $password;
    }

    public function executeComponent()
    {
        if($this->startResultCache())
        {
            $this->includeComponentTemplate();
        }
    }
}