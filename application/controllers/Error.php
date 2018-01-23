<?php

use SwuOS\Openapi\Library\Log;
use Yaf\Controller_Abstract;

class Error_Controller extends Controller_Abstract
{
    public function errorAction()
    {
        $e = $this->getRequest()->getException();
        Log::info($e->getMessage(), $e->getTrace(), 'error');
        echo $e->getMessage();
    }
}