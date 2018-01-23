<?php

namespace SwuOS\Openapi\Exception;


use Throwable;

class UserHasExistException extends CustomException
{
    public function __construct(string $message = "用户已存在", int $code = 10003, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}