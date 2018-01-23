<?php

class Service_Base_Model
{
    public static function __callStatic($name, $arguments)
    {
        $instance = new static();

        return call_user_func([$instance, $name], $arguments);
    }
}