<?php

namespace app\modules\v1\components\exception;

use yii\web\BadRequestHttpException;

class InternalException extends BadRequestHttpException
{
    public function __construct($message = 'internal error', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}