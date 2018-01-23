<?php

use SwuOS\Openapi\Library\Config;
use Illuminate\Container\Container;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;

class Dao_Base_Model extends Model
{
    protected $connection = 'default';

    public static function setConnectionResolver(ConnectionResolverInterface $resolver)
    {
        $configs  = Config::get('database.mysql');
        $factory = new ConnectionFactory(Container::getInstance());

        $connections = [];

        /**
         * @var array $config
         */
        foreach ($configs as $connection => $config) {
            $connections[$connection] = $factory->make($config, $connection);
        }

        parent::setConnectionResolver(new ConnectionResolver($connections));
    }

    public static function resolveConnection($connection = null)
    {
        if (null === static::$resolver){
            static::setConnectionResolver(new ConnectionResolver());
        }

        return parent::resolveConnection($connection);
    }
}