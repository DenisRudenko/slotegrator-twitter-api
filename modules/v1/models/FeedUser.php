<?php

namespace app\modules\v1\models;

use yii\db\ActiveRecord;

/**
 * Class FeedUser
 * @package app\models
 *
 * @property string $user
 */
class FeedUser extends ActiveRecord
{
    public static function tableName()
    {
        return 'feed_users';
    }
}