<?php


namespace Middleware;


class Helper
{
    public static function getCustomer()
    {
        if (!empty($_SESSION['customer_id'])) {
            return self::getModel('User')->initCollection()
                ->where('customer_id', $_SESSION['customer_id'])
                ->getCollection()
                ->selectFirst();
        } else {
            return null;
        }
    }

    public static function getModel($name)
    {
        $name = '\\Models\\' . ucfirst($name);
        return new $name();
    }

}