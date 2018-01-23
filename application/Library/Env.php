<?php

namespace SwuOS\Openapi\Library;

final class Env
{
    public static function get()
    {
        return ini_get('yaf.environ');
    }

    public static function is(string $env)
    {
        return $env === static::get();
    }

    public static function isProduct()
    {
        return static::is('product');
    }

    public static function isPreline()
    {
        return static::is('preline');
    }

    public static function isDevelop()
    {
        return static::is('develop');
    }

    public static function isTest()
    {
        return static::is('test');
    }
}