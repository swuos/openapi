<?php

namespace SwuOS\Openapi\Exception;

use Throwable;

class InvalidRequestMethod extends CustomException
{
    public function __construct(string $method, int $code = 10000, Throwable $previous = null)
    {
        parent::__construct('无效的请求方式：' . $method, $code, $previous);
    }
}