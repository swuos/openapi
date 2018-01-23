<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class DatabaseErrorException extends CustomException
{
    public function __construct(string $message = "数据库错误", int $code = 10006, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}