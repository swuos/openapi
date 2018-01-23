<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class NeedLoginException extends CustomException
{
    public function __construct(string $message = "需要登录才可以访问", int $code = 10007, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}