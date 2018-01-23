<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class UserNotExistException extends CustomException
{
    public function __construct(string $message = "用户不存在", int $code = 10003, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}