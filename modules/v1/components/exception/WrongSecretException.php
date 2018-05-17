<?php

namespace app\modules\v1\components\exception;

use yii\web\BadRequestHttpException;

class WrongSecretException extends BadRequestHttpException
{
    public function __construct($message = 'access denied', $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}