<?php

namespace SwuOS\Openapi\Library;

use Yaf\Config\Ini;

final class Config
{
    public static function get(string $key)
    {
        $splits = explode('.', $key, 2);

        if (count($splits) == 1) {
            $file = current($splits);
        } else {
            list($file, $key) = explode('.', $key, 2);
        }

        $config = new Ini(ROOT_PATH . '/config/' . $file . '.ini', Env::get());

        if (null === $key) {
            return $config->toArray();
        }

        return $config->get($key)->toArray();
    }
}