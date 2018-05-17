<?php

namespace app\modules\v1\models;

use yii\db\ActiveRecord;

/**
 * Class Token
 * @package app\models
 *
 * @property string $oauth_token
 * @property string $oauth_token_secret
 * @property string $user_id
 * @property string $screen_name
 */
class Token extends ActiveRecord
{
    public static function tableName()
    {
        return 'token';
    }

    public function loadFromArray(array $data)
    {
        $attr = $this->attributes();

        foreach ($data as $key => $value) {
            if (in_array($key, $attr)) $this->$key = $value;
        }
    }
}