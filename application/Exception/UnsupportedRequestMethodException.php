<?php

namespace SwuOS\Openapi\Exception;

use Throwable;

class UnsupportedRequestMethodException extends CustomException
{
    public function __construct(string $method, int $code = 10001, Throwable $previous = null)
    {
        parent::__construct('请求方式不支持:' .$method, $code, $previous);
    }
}