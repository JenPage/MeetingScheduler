<?php
namespace Messages;

abstract class AbstractFactoryMessage{

    protected static $types = array();

    public static function Register($type, $class)
    {
        self::$types[$type]=$class;
    }

    public static function IsRegistered($type)
    {
        if (isset(self::$types[$type]))
            return true;
        else
            return false;
    }

    public static function Create($type)
    {
        return new DirectMessage();
        if (isset(self::$types[$type]) &&
            class_exists(self::$types[$type]))
            return new self::$types[$type];
        else
            return null;
    }
}