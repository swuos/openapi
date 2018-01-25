<?php

use SwuOS\Openapi\Library\Config;
use SwuOS\Openapi\Library\Log;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Yaf\Dispatcher;
use Yaf\Bootstrap_Abstract;
use Yaf\Loader;

class Bootstrap extends Bootstrap_Abstract
{
    /**
     * 当路由以非/api开头的时候，禁用掉自动渲染view
     *
     * @param Dispatcher $dispatcher
     */
    public function _initView(Dispatcher $dispatcher)
    {
        $uri = $dispatcher->getRequest()->getRequestUri();

        if (substr($uri, 0, 4) === '/api') {
            Dispatcher::getInstance()->disableView();
            echo '666';
        }
    }

    public function _initAutoload(Dispatcher $dispatcher)
    {
        Loader::import(ROOT_PATH . '/vendor/autoload.php');
    }

    public function _initSession()
    {
        session_start();
    }

    public function _initLogger()
    {
        $logConfig = Config::get('application.log');

        if (null === $logConfig) {
            return;
        }

        foreach ($logConfig as $channel => $config) {
            $file = str_replace('{date}', date('Y-m-d'), $config['file']);

            $handler = new StreamHandler($file, Logger::INFO);

            $logger = new Logger($channel);
            $logger->pushHandler($handler);

            Log::setLogger($logger, $channel);
        }
    }
}
