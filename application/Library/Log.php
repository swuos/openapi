<?php

namespace SwuOS\Openapi\Library;

use Psr\Log\LoggerInterface;

class Log
{
    /**
     * @var array<string, LoggerInterface>
     */
    protected static $loggerPool;

    public static function setLogger(LoggerInterface $logger, string $channel)
    {
        self::$loggerPool[$channel] = $logger;
    }

    public static function getLogger(string $channel)
    {
        return self::$loggerPool[$channel] ?? null;
    }

    public static function info(string $message, array $context = [], string $channel = 'request')
    {
        self::getLogger($channel)->info($message, $context);
    }

    public static function error(string $message, array $context = [], string $channel = 'error')
    {
        self::getLogger($channel)->error($message, $context);
    }
}