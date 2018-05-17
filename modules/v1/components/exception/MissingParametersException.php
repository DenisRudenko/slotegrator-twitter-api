<?php

namespace app\modules\v1\components\exception;

use yii\web\BadRequestHttpException;

class MissingParametersException extends BadRequestHttpException
{
    public function __construct($message = 'missing parameter', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}